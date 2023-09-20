const express = require('express');
const http = require('http');
const socketIO = require('socket.io');
const mysql = require('mysql');
const cors = require('cors');

const users = {};

const app = express();
app.use(cors()); 

const server = http.createServer(app);
const io = socketIO(server, {
    cors: {
        origin: ["http://localhost", "http://localhost:3000"],
        methods: ["GET", "POST"],
        credentials: true,
    },
});
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: 'rootPass',
    database: 'vcr'
});

const pool = mysql.createPool({
    connectionLimit: 50,
    host: 'localhost',
    user: 'root',
    password: 'rootPass',
    database: 'vcr'
});

db.connect((err) => {
    if (err) throw err;
    console.log('Connected to the MySQL database.');
});

io.on('connection', (socket) => {
    console.log('A user connected');

    socket.on('joinRoom', (roomName, username) => {
        users[socket.id] = { username, roomName };
        socket.join(roomName);
        socket.emit('message', {
            user: 'admin',
            text: `Welcome to the room, ${username}!`,
            timestamp: new Date().getTime(),
        });
        socket.to(roomName).emit('message', {
            user: 'admin',
            text: `${username} has joined the room`,
            timestamp: new Date().getTime(),
        });
        const updateRoomSQL = "update users set room = ? where username = ?";
        db.query(updateRoomSQL, [roomName, username], (err, result) => {
            if (err) {
                console.error('Error updating user room:', err);
            } else {
                console.log(`User ${username} joined room ${roomName}`);
            }
        })
    });

    socket.on('sendMessage', async (message) => {
        try {
            console.log("Socket.on send message block start")
            const { username, roomName } = users[socket.id];
            const timestamp = new Date().toISOString();
            await pool.query(
                'INSERT INTO messages (rName, sender, dt, content) VALUES (?, ?, ?, ?)',
                [roomName, username, timestamp, message]
            );

            io.to(roomName).emit('message', {
                user: username,
                text: message,
                timestamp: timestamp,
            });
        } catch (error) {
            console.error('Error saving message to the database:', error);
        }
    });

    socket.on('disconnect', () => {
        console.log('A user disconnected');

        if (users[socket.id]) {
            const { username, roomName } = users[socket.id];
            delete users[socket.id];

            io.to(roomName).emit('message', {
                user: 'admin',
                text: `${username} has left the room`,
                timestamp: new Date().getTime(),
            });
            const noRoomSQL = "update users set room = '0' where username = ?";
            db.query(noRoomSQL, [username], (err, result) => {
                if (err) {
                    console.error('Error setting user room to 0:', err);
                } else {
                    console.log(`User ${username} left room ${roomName}`);
                }
            })
        }
    });
});

const port = process.env.PORT || 3000;
server.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});
