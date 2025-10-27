import { createServer } from 'http';
import { Server } from 'socket.io';

const ENV = process.env.APP_ENV || 'local';
const PORT = process.env.SOCKETIO_PORT || 6001;

// Dynamic configuration based on environment
const config = {
    local: {
        origin: ["http://localhost:8000", "http://127.0.0.1:8000", "http://localhost:3000"],
        path: '/socket.io'
    },
    development: {
        origin: ["https://payusinginvoice.com"],
        path: '/crm-development/socket.io'
    },
    production: {
        origin: ["https://payusinginvoice.com"],
        path: '/socket.io'
    }
};

const currentConfig = config[ENV] || config.local;

const server = createServer();
const io = new Server(server, {
    cors: {
        origin: currentConfig.origin,
        methods: ["GET", "POST"],
        credentials: true
    },
    path: currentConfig.path,
    transports: ['websocket', 'polling']
});

// Store active conversations
const activeConversations = new Map();

io.on('connection', (socket) => {
    console.log('User connected:', socket.id);

    // Join conversation room
    socket.on('join_conversation', (conversationId) => {
        socket.join(`conversation_${conversationId}`);
        activeConversations.set(socket.id, conversationId);
        console.log(`User ${socket.id} joined conversation ${conversationId}`);
    });

    // Handle new message
    socket.on('send_message', (data) => {
        try {
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
        } catch (error) {
            console.error('Error sending message:', error);
            socket.emit('message_error', { error: 'Failed to send message' });
        }
    });

    socket.on('disconnect', () => {
        console.log('User disconnected:', socket.id);
        activeConversations.delete(socket.id);
    });
});

server.listen(PORT, () => {
    console.log(`✅ Socket.IO server running on port ${PORT}`);
    console.log(`📍 Environment: ${ENV}`);
    console.log(`📍 CORS Origins: ${currentConfig.origin.join(', ')}`);
    console.log(`📍 Socket Path: ${currentConfig.path}`);
});