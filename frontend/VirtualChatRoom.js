const socket = io('http://localhost:3000');

const messageForm = document.getElementById('message-form');
const messageInput = document.getElementById('message-input');
const chatMessages = document.getElementById('chat-messages');
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
