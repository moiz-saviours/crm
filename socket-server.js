import { createServer } from 'http';
import { Server } from 'socket.io';

// Environment variables for subdomain
const ENV = process.env.APP_ENV || 'production';
const PORT = process.env.SOCKETIO_PORT || 3000;
const SOCKET_PATH = process.env.SOCKETIO_PATH || '/socket.io';
const ALLOWED_ORIGINS = process.env.SOCKETIO_ORIGINS || 'https://payusinginvoice.com';

const server = createServer();
const io = new Server(server, {
    cors: {
        origin: ALLOWED_ORIGINS,
        methods: ["GET", "POST"],
        credentials: false
    },
    path: SOCKET_PATH,
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

    // Handle typing indicators
    socket.on('typing_start', (data) => {
        socket.to(`conversation_${data.conversation_id}`).emit('user_typing', {
            user_id: data.user_id,
            user_name: data.user_name
        });
    });

    socket.on('typing_stop', (data) => {
        socket.to(`conversation_${data.conversation_id}`).emit('user_stop_typing', {
            user_id: data.user_id
        });
    });

    socket.on('disconnect', () => {
        console.log('User disconnected:', socket.id);
        activeConversations.delete(socket.id);
    });
});

server.listen(PORT, '0.0.0.0', () => {
    console.log(`🚀 Socket.IO Server Running on Subdomain`);
    console.log(`📍 Port: ${PORT}`);
    console.log(`🌐 Allowed Origin: ${ALLOWED_ORIGINS}`);
    console.log(`🛣️ Path: ${SOCKET_PATH}`);
    console.log(`💻 Subdomain: socket-io-server.payusinginvoice.com`);
});