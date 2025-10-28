import express from 'express';
import { createServer } from 'http';
import { Server } from 'socket.io';

const app = express();
const server = createServer(app);
const PORT = process.env.PORT || 443; // Use same port as your web server

const io = new Server(server, {
    cors: {
        origin: ["https://payusinginvoice.com"],
        methods: ["GET", "POST"],
        credentials: false
    },
    path: '/crm-development/socket.io',
    transports: ['polling'], // Only use polling, no websocket
    allowEIO3: true
});

// Your existing Socket.IO event handlers
io.on('connection', (socket) => {
    console.log('User connected:', socket.id);

    socket.on('join_conversation', (conversationId) => {
        socket.join(`conversation_${conversationId}`);
        console.log(`User ${socket.id} joined conversation ${conversationId}`);
    });

    socket.on('send_message', (data) => {
        const messageData = {
            id: Date.now(),
            content: data.content,
            sender_type: data.sender_type,
            sender_id: data.sender_id,
            conversation_id: data.conversation_id,
            message_type: data.message_type || 'text',
            status: 'sent',
            created_at: new Date().toISOString(),
            attachments: data.attachments || []
        };
        io.to(`conversation_${data.conversation_id}`).emit('new_message', messageData);
        console.log('Message sent to conversation:', data.conversation_id);
    });

    socket.on('disconnect', () => {
        console.log('User disconnected:', socket.id);
    });
});


server.listen(PORT, '0.0.0.0', () => {
    console.log(`Socket.IO server running on port ${PORT}`);
});