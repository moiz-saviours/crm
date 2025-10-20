<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1f2832;
            --secondary-color: #1f2832;
            --light-color: #fff;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --gray-color: #6c757d;
            --light-gray: #e9ecef;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            padding: 20px;
        }

        .chat-container {
            background-color: white;
            border-radius: 3px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 600px;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-header h5 {
            margin: 0;
            font-weight: 600;
            color: var(--light-color)
        }

        .chat-status {
            font-size: 0.8rem;
            display: flex;
            align-items: center;
        }

        .status-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #4ade80;
            margin-right: 5px;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: #f8fafc;
        }

        .message {
            margin-bottom: 15px;
            display: flex;
        }

        .message.received {
            justify-content: flex-start;
        }

        .message.sent {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 5px 15px;
            border-radius: 3px;
            position: relative;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }

        .received .message-bubble {
            background-color: white;
            /* border: 1px solid var(--primary-color); */
            border-bottom-left-radius: 5px;
        }

        .sent .message-bubble {
            background-color: var(--primary-color);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message-sender {
            font-weight: 600;
            font-size: 0.85rem;
        }

        .received .message-sender {
            color: var(--primary-color);
        }

        .sent .message-sender {
            color: rgba(255, 255, 255, 0.9);
        }

        .message-time {
            font-size: 0.7rem;
            opacity: 0.7;
        }

        .chat-input-container {
            border-top: 1px solid var(--light-gray);
            padding: 4px;
            background-color: white;
        }

        .message-editor {
            border: 1px solid var(--light-gray);
            border-radius: 3px;
            overflow: hidden;
        }

        .editor-toolbar {
            display: flex;
            padding: 2px 10px;
            border-bottom: 1px solid var(--light-gray);
            background-color: #f8f9fa;
        }

        .editor-toolbar button {
            background: none;
            border: none;
            color: var(--gray-color);
            margin-right: 10px;
            font-size: 0.6rem;
            cursor: pointer;
            transition: color 0.2s;
        }

        .editor-toolbar button:hover {
            color: var(--primary-color);
        }

        .message-textarea {
            width: 100%;
            border: none;
            padding: 12px 15px;
            resize: none;
            min-height: 60px;
            max-height: 120px;
            outline: none;
            font-family: inherit;
            overflow-y: auto;
        }

        .editor-actions {
            display: flex;
            justify-content: space-between;
            padding: 2px 15px;
            background-color: #f8f9fa;
        }

        .attachment-options {
            display: flex;
        }

        .attachment-btn {
            background: none;
            border: none;
            color: var(--gray-color);
            margin-right: 15px;
            cursor: pointer;
            font-size: 0.6rem;
        }

        .attachment-btn:hover {
            color: var(--primary-color);
        }

        .send-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 3px;
            padding: 3px 15px;
            font-weight: 500;
            transition: background-color 0.2s;
        }

        .send-btn:hover {
            background-color: var(--secondary-color);
        }

        .attachment-preview {
            display: flex;
            padding: 10px 15px;
            background-color: #f0f4f8;
            border-top: 1px solid var(--light-gray);
        }

        .attachment-item {
            display: flex;
            align-items: center;
            background-color: white;
            border: 1px solid var(--primary-color);
            border-radius: 3px;
            padding: 5px 10px;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        .attachment-item i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        .remove-attachment {
            margin-left: 8px;
            color: var(--gray-color);
            cursor: pointer;
        }

        .customer-info {
            display: flex;
            align-items: center;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
            margin-right: 12px;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
            margin: 0 8px;
            flex-shrink: 0;
            cursor: pointer;
            position: relative;
        }

        .received {
            align-items: flex-start;
        }

        .sent {
            align-items: flex-end;
        }

        /* Scrollbar styling */
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .error-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($error)
                    <div class="error-container">
                        <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                        <h3 class="text-danger">Chat Not Available</h3>
                        <p class="text-muted">{{ $error }}</p>
                        <a href="/" class="btn btn-primary mt-3">Return Home</a>
                    </div>
                @else
                    <div class="chat-container">
                        <!-- Chat Header -->
                        <div class="chat-header">
                            <div class="customer-info">
                                <div class="customer-avatar">
                                    {{ substr($customer->name ?? 'Customer', 0, 2) }}
                                </div>
                                <div>
                                    <h5>{{ $customer->name ?? 'Customer' }}</h5>
                                    <div class="chat-status">
                                        <span class="status-indicator"></span>
                                        <span>Support Team Online</span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="text-light">ID: {{ $customer->special_key ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div class="chat-messages" id="chatMessages">
                            <div class="text-center py-4 text-muted" id="loadingMessages">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading messages...</span>
                                </div>
                                Loading messages...
                            </div>
                        </div>

                        <!-- Attachment Preview -->
                        <div class="attachment-preview d-none" id="attachmentPreview">
                            <!-- Attachment preview will be shown here -->
                        </div>

                        <!-- Chat Input -->
                        <div class="chat-input-container">
                            <div class="message-editor">
                                <div class="editor-toolbar">
                                    <button title="Bold"><i class="fas fa-bold"></i></button>
                                    <button title="Italic"><i class="fas fa-italic"></i></button>
                                    <button title="Underline"><i class="fas fa-underline"></i></button>
                                    <button title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                    <button title="Numbered List"><i class="fas fa-list-ol"></i></button>
                                    <button title="Insert Link"><i class="fas fa-link"></i></button>
                                    <button title="Insert Emoji"><i class="far fa-smile"></i></button>
                                </div>

                                <textarea class="message-textarea" id="messageTextarea" placeholder="Type your message here..."></textarea>

                                <div class="editor-actions">
                                    <div class="attachment-options">
                                        <button class="attachment-btn" id="attachFileBtn" title="Attach File">
                                            <i class="fas fa-paperclip"></i> Attach File
                                        </button>
                                        <button class="attachment-btn" id="attachImageBtn" title="Insert Image">
                                            <i class="fas fa-image"></i> Image
                                        </button>
                                    </div>

                                    <button class="send-btn" id="sendButton">
                                        Send <i class="fas fa-paper-plane ms-1"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>

<script>
    @if(!$error && $conversation)
    // Global variables
    const conversationId = {{ $conversation->id }};
    const customer = @json($customer);
    const customerSpecialKey = '{{ $customer->special_key }}';

    // Socket.io configuration
    const socket = io('{{ config('socketio.url') }}');;
    
    // Join conversation room
    socket.emit('join_conversation', conversationId);

    // Load messages on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadMessages();
        initializeChat();
    });

    // Load messages via AJAX
    function loadMessages() {
        fetch(`/customer/chat/${customerSpecialKey}/messages`)
            .then(response => response.json())
            .then(messages => {
                document.getElementById('loadingMessages').style.display = 'none';
                renderMessages(messages);
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                document.getElementById('loadingMessages').innerHTML = 
                    '<div class="text-danger">Failed to load messages</div>';
            });
    }

    // Render messages to the chat
    function renderMessages(messages) {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.innerHTML = '';

        messages.forEach(message => {
            const isSent = message.sender_type === 'App\\Models\\CustomerContact';
            addMessageToChat(message.content, isSent, message);
        });

        scrollToBottom();
    }

    // Add message to chat
    function addMessageToChat(content, isSent = true, messageData = null) {
        const chatMessages = document.getElementById('chatMessages');
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
        
        // Create avatar
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        
        if (isSent) {
            avatar.textContent = customer?.name?.substring(0, 2) || 'ME';
            avatar.setAttribute('title', customer?.name || 'You');
        } else {
            avatar.textContent = 'SP';
            avatar.setAttribute('title', 'Support Team');
        }
        
        avatar.setAttribute('data-bs-toggle', 'tooltip');
        avatar.setAttribute('data-bs-placement', 'top');
        
        // Create message bubble
        const messageBubble = document.createElement('div');
        messageBubble.className = 'message-bubble';

        const messageHeader = document.createElement('div');
        messageHeader.className = 'message-header';

        const timeDiv = document.createElement('div');
        timeDiv.className = 'message-time';
        const messageTime = messageData ? new Date(messageData.created_at) : new Date();
        timeDiv.textContent = messageTime.toLocaleTimeString([], {
            hour: '2-digit',
            minute: '2-digit'
        });

        messageHeader.appendChild(timeDiv);

        const contentDiv = document.createElement('div');
        contentDiv.textContent = content;

        messageBubble.appendChild(messageHeader);
        messageBubble.appendChild(contentDiv);

        // Arrange elements based on sent/received
        if (isSent) {
            messageDiv.appendChild(messageBubble);
            messageDiv.appendChild(avatar);
        } else {
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(messageBubble);
        }
        
        chatMessages.appendChild(messageDiv);
        
        // Initialize Bootstrap tooltip
        new bootstrap.Tooltip(avatar);
        
        scrollToBottom();
    }

    // Initialize chat functionality
    function initializeChat() {
        const messageTextarea = document.getElementById('messageTextarea');
        const sendButton = document.getElementById('sendButton');

        // Send message function
        function sendMessage() {
            const message = messageTextarea.value.trim();
            if (message) {
                // Add message locally immediately
                addMessageToChat(message, true);

                // Send to backend via AJAX
                fetch(`/customer/chat/${customerSpecialKey}/message`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        content: message,
                        message_type: 'text'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Message sent successfully
                        messageTextarea.value = '';
                        messageTextarea.style.height = '60px';

                        // Also send via Socket.io for real-time
                        socket.emit('send_message', {
                            content: message,
                            conversation_id: conversationId,
                            sender_type: 'App\\Models\\CustomerContact',
                            sender_id: customer.id,
                            message_type: 'text'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    alert('Failed to send message');
                });
            }
        }

        // Send message on button click
        sendButton.addEventListener('click', sendMessage);

        // Send message on Enter key
        messageTextarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Auto-expand textarea
        messageTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            
            if (this.scrollHeight > 120) {
                this.style.height = '120px';
                this.style.overflowY = 'auto';
            } else {
                this.style.overflowY = 'hidden';
            }
        });
    }

    // Socket.io event listeners
    socket.on('new_message', (data) => {
        // Check if message is from support team (not customer)
        if (data.sender_type !== 'App\\Models\\CustomerContact') {
            addMessageToChat(data.content, false, data);
        }
    });

    // Scroll to bottom of chat
    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
    @endif
</script>
</body>
</html>