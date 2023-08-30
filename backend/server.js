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

db.connect((err) => {
    if (err) throw err;
    console.log('Connected to the MySQL database.');
});

io.on('connection', (socket) => {
    console.log('A user connected');

    socket.on('joinRoom', (roomID, username) => {
        users[socket.id] = { username, roomID };
        socket.join(roomID);
        socket.emit('message', {
            user: 'admin',
            text: `Welcome to the room, ${username}!`,
            timestamp: new Date().getTime(),
        });
        socket.to(roomID).emit('message', {
            user: 'admin',
            text: `${username} has joined the room`,
            timestamp: new Date().getTime(),
        });
    });

    socket.on('sendMessage', async (message) => {
        try {
            const { username, roomID } = users[socket.id];
            const timestamp = new Date().toISOString();
            await pool.query(
                'INSERT INTO messages (rID, sender, dt, content) VALUES (?, ?, ?, ?)',
                [roomID, username, timestamp, message]
            );

            io.to(roomID).emit('message', {
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
            const { username, roomID } = users[socket.id];
            delete users[socket.id];

            io.to(roomID).emit('message', {
                user: 'admin',
                text: `${username} has left the room`,
                timestamp: new Date().getTime(),
            });
        }
    });
});

const port = process.env.PORT || 3000;
server.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});
