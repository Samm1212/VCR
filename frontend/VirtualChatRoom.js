const socket = io('http://localhost:3000');

const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');
const chatMessages = document.getElementById('chat-messages');
const selectElement = document.getElementById('room');

var un = '';

function getUsername() {
    return new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../backend/get_username.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                resolve(response.username);
            } else {
                reject(new Error('Failed to retrieve username.'));
            }
        };

        xhr.onerror = function () {
            reject(new Error('Failed to make the request.'));
        };

        xhr.send();
    });
}

getUsername()
    .then((username) => {
        un = username;
        console.log('Logged in as:', un);
    });

function appendMessage(message) {
    const messageElement = document.createElement('div');
    messageElement.innerHTML = `<strong>${message.user}</strong>: ${message.text}`;
    chatMessages.appendChild(messageElement);
}

socket.on('message', (message) => {
    appendMessage(message);
});

function sendMessage() {
    const message = messageInput.value;

    socket.emit('sendMessage', message);

    messageInput.value = '';
}

messageForm.addEventListener('submit', (event) => {
    event.preventDefault();
    sendMessage();
});

selectElement.addEventListener('change', (event) => {
    const selectedRoomName = event.target.value;
    updateChatMessages(selectedRoomName);
    updateOnlineUsers(selectedRoomName);
    socket.emit('joinRoom', selectedRoomName, un);
});

function updateChatMessages(roomName) {

    chatMessages.innerHTML = '';
    fetch(`../backend/api.php?roomName=${encodeURIComponent(roomName)}`)
        .then(response => response.text())
        .then(responseText => {
            const messages = JSON.parse(responseText);
            messages.forEach(message => {
                appendMessageToChat(message);
            });
        })
        .catch(error => console.error('Error fetching messages:', error));
}

function appendMessageToChat(message) {
    const messageElement = document.createElement('div');
    messageElement.innerHTML = `<strong>${message.sender}</strong>: ${message.content}`;
    chatMessages.appendChild(messageElement);
}

function updateOnlineUsers(roomName) {
    fetch(`../backend/getOnlineUsers.php?roomName=${encodeURIComponent(roomName)}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then((onlineUsers) => {
            if (!Array.isArray(onlineUsers)) {
                console.error('Online users data is not an array:', onlineUsers);
                return;
            }
            const userlist = document.getElementById('user-list');
            userlist.innerHTML = '';

            onlineUsers.forEach((user) => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = user;
                userlist.appendChild(listItem);
            });
        })
        .catch((error) => {
            console.error('Error fetching online users:', error);
        });
}
