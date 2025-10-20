import { createServer } from 'http';
import { Server } from 'socket.io';

const ENV = process.env.APP_ENV || 'local';
const PORT = process.env.SOCKETIO_PORT || 6001;

const getSocketConfig = () => {
    const appUrl = process.env.APP_URL;
    let allowedOrigins = [];

    if (appUrl) {
        allowedOrigins.push(appUrl);
        try {
            const url = new URL(appUrl);

            if (ENV === 'development' && url.pathname.includes('/crm-development')) {
                const baseOrigin = `${url.protocol}//${url.hostname}${url.port ? ':' + url.port : ''}`;
                allowedOrigins.push(
                    baseOrigin,
                    `${baseOrigin}/`,
                    appUrl,
                    `${appUrl}/`
                );
            }
            else if (ENV === 'production') {
                allowedOrigins.push(
                    `${url.protocol}//${url.hostname}${url.port ? ':' + url.port : ''}`,
                    `${url.protocol}//${url.hostname}${url.port ? ':' + url.port : ''}/`,
                    appUrl.endsWith('/') ? appUrl.slice(0, -1) : appUrl + '/'
                );

                if (!url.hostname.startsWith('www.')) {
                    const wwwUrl = `${url.protocol}//www.${url.hostname}${url.port ? ':' + url.port : ''}`;
                    allowedOrigins.push(wwwUrl, `${wwwUrl}/`);
                }
            }
        } catch (error) {
            console.warn('Invalid APP_URL:', appUrl);
        }
    }
    switch (ENV) {
        case 'local':
            allowedOrigins = [
                'http://localhost:8000',
                'http://127.0.0.1:8000',
                'http://localhost:3000',
                'http://127.0.0.1:3000'
            ];
            break;

        case 'development':
            allowedOrigins.push(
                'http://localhost:8000',
                'http://127.0.0.1:8000',
                'http://localhost:3000',
                'http://127.0.0.1:3000'
            );
            break;
    }

    allowedOrigins = [...new Set(allowedOrigins.filter(origin => origin && origin.trim()))];

    console.log('🔧 Socket.IO Configuration:');
    console.log('📍 Environment:', ENV);
    console.log('📍 APP_URL:', appUrl);
    console.log('📍 Allowed origins:', allowedOrigins);

    let socketPath = '/socket.io/';
    if (ENV === 'development' && appUrl && appUrl.includes('/crm-development')) {
        socketPath = '/crm-development/socket.io/';
    }

    return {
        cors: {
            origin: allowedOrigins.length > 0 ? allowedOrigins : true,
            methods: ["GET", "POST"],
            credentials: true,
            allowedHeaders: ["Content-Type", "Authorization"]
        },
        path: socketPath
    };
};
const server = createServer();
const io = new Server(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"]
    },
    path: socketPath,
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
            console.log('New message:', messageData);
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
