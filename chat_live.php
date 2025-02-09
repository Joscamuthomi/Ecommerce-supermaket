const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const path = require('path');

const app = express();
const server = http.createServer(app);
const io = socketIo(server);

// Store users in an object (you can replace this with a DB in production)
let users = {};

app.use(express.static(path.join(__dirname, 'public'))); // Serve static files

// Endpoint to simulate authentication (this can be replaced with real authentication)
app.get('/auth', (req, res) => {
  const userId = Date.now(); // Simulate unique user ID
  res.json({ userId });
});

// Handle WebSocket connections
io.on('connection', (socket) => {
  console.log('A user connected');
  
  // When a user joins, store their socket ID and userId
  socket.on('join', (userId) => {
    users[userId] = socket.id;
    console.log(`User ${userId} connected with socket ID: ${socket.id}`);
  });

  // Handle sending messages
  socket.on('sendMessage', (message) => {
    const { senderId, recipientId, content } = message;
    if (users[recipientId]) {
      // Send the message to the recipient
      io.to(users[recipientId]).emit('receiveMessage', { senderId, content });
    } else {
      console.log('Recipient not online');
    }
  });

  // Handle disconnections
  socket.on('disconnect', () => {
    console.log('User disconnected');
    // Remove the user from the users list
    for (const userId in users) {
      if (users[userId] === socket.id) {
        delete users[userId];
      }
    }
  });
});

// Serve the chat HTML, CSS, and JS from the "public" folder
app.get('/', (req, res) => {
  res.send(`
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Live Chat</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #f4f4f9;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
        }
        #chat-container {
          width: 400px;
          background-color: white;
          padding: 20px;
          border-radius: 8px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        #chat-history {
          height: 300px;
          overflow-y: auto;
          border: 1px solid #ddd;
          margin-bottom: 20px;
          padding: 10px;
        }
        textarea {
          width: 100%;
          height: 60px;
          padding: 10px;
          font-size: 16px;
          border: 1px solid #ddd;
          border-radius: 4px;
          margin-bottom: 10px;
        }
        button {
          padding: 10px 20px;
          background-color: #4CAF50;
          color: white;
          border: none;
          border-radius: 4px;
          cursor: pointer;
        }
        button:hover {
          background-color: #45a049;
        }
      </style>
    </head>
    <body>
      <div id="chat-container">
        <div id="chat-history"></div>
        <textarea id="message-input" placeholder="Type your message..."></textarea>
        <button id="send-message-btn">Send</button>
      </div>

      <script src="/socket.io/socket.io.js"></script>
      <script>
        const socket = io();
        let userId = null;

        // Simulate user login (replace with real authentication)
        fetch('/auth')
          .then(response => response.json())
          .then(data => {
            userId = data.userId;
            socket.emit('join', userId); // Notify the server about the user connection
          });

        // Handle sending messages
        document.getElementById('send-message-btn').addEventListener('click', () => {
          const messageInput = document.getElementById('message-input');
          const messageContent = messageInput.value.trim();

          if (messageContent !== "") {
            const recipientId = prompt('Enter the recipient ID (staff ID):');
            socket.emit('sendMessage', {
              senderId: userId,
              recipientId: recipientId,
              content: messageContent
            });
            messageInput.value = ''; // Clear the message input field
          }
        });

        // Handle receiving messages
        socket.on('receiveMessage', (message) => {
          const { senderId, content } = message;
          const chatHistory = document.getElementById('chat-history');
          const messageElement = document.createElement('div');
          messageElement.textContent = `User ${senderId}: ${content}`;
          chatHistory.appendChild(messageElement);
          chatHistory.scrollTop = chatHistory.scrollHeight; // Auto-scroll to the latest message
        });
      </script>
    </body>
    </html>
  `);
});

// Start the server
server.listen(3000, () => {
  console.log('Server running on http://localhost:3000');
});
