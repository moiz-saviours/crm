import { createServer } from 'http';
import { Server } from 'socket.io';

const ENV = process.env.APP_ENV || 'local';
const PORT = process.env.SOCKETIO_PORT || 6001;

let allowedOrigins = [];
let socketPath = '/socket.io';
switch (ENV) {
    case 'production':
        allowedOrigins = ['*'];
        socketPath = '/socket.io';
        break;

    case 'development':
        allowedOrigins = ['*'];
        socketPath = '/crm-development/socket.io';
        break;

    default: // local
        allowedOrigins = ['*'];
        socketPath = '/socket.io';
        break;
}
const server = createServer();
const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    },
    path: socketPath,
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
            // Broadcast to all users in the conversation
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
server.listen(PORT, () => {
    console.log(`✅ Socket.IO server running on port ${PORT}`);
    console.log(`📍 http://localhost:${PORT}`);
});
