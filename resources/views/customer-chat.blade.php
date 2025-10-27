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
            --bs-primary: #2d3e50;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            padding: 0;
            /* Remove padding */
            margin: 0;
            height: 100vh;
            /* Add viewport height */
        }

        .container-fluid {
            height: 100vh;
            /* Full viewport height */
            padding: 20px;
            /* Move padding here */
        }

        .row {
            height: 100%;
            /* Full height of container */
        }

        .chat-container {
            border-radius: 3px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 100%;
            /* This will now work */
            display: flex;
            flex-direction: column;
        }

        .chat-sidebar {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 10px;
            height: 100%;
            /* Full height of column */
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background-color: var(--bs-primary);
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
            background-color: var(--light-color);
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
            border: 1px solid var(--bs-primary);
            border-bottom-left-radius: 5px;
        }

        .sent .message-bubble {
            background-color: var(--bs-primary);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message-sender {
            font-weight: 600;
            font-size: 0.85rem;
        }

        .received .message-sender {
            color: var(--bs-primary);
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
            /* background-color: white; */
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
            color: var(--bs-primary);
        }

        .message-textarea {
            width: 100%;
            border: none;
            padding: 12px 15px;
            resize: none;
            min-height: 60px;
            max-height: 120px;
            /* Optional: set max height */
            outline: none;
            font-family: inherit;
            overflow-y: auto;
            /* Show scrollbar when needed */
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
            color: var(--bs-primary);
        }

        .send-btn {
            background-color: var(--bs-primary);
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
            background-color: var(--bs-card-color);
            ;
            border-top: 1px solid var(--light-gray);
        }

        .attachment-item {
            display: flex;
            align-items: center;
            background-color: white;
            border: 1px solid var(--bs-primary);
            ;
            border-radius: 3px;
            padding: 5px 10px;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        .attachment-item i {
            margin-right: 5px;
            color: var(--bs-primary);
        }

        .remove-attachment {
            margin-left: 8px;
            color: var(--gray-color);
            cursor: pointer;
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
            color: var(--bs-primary);
            ;
            font-weight: 600;
            margin-right: 12px;
        }

        .message-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--bs-primary);
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

        .sidebar-header {
            /* margin-bottom: 20px; */
            /* padding-bottom: 15px; */
            border-bottom: 1px solid var(--light-gray);
        }

        .search-container {
            position: relative;
            margin-bottom: 15px;
        }

        .search-input {
            width: 100%;
            padding: 8px 35px 8px 12px;
            border: 1px solid var(--light-gray);
            border-radius: 6px;
            font-size: 0.6rem;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--bs-primary);
        }

        .search-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-color);
        }

        .contacts-list {
            flex: 1;
            overflow-y: auto;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .contact-item:hover {
            background-color: #f8f9fa;
            border-color: var(--light-gray);
        }

        .contact-item.active {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
            color: white;
        }

        .contact-item.active .contact-last-message,
        .contact-item.active .contact-time {
            color: rgba(255, 255, 255, 0.8);
        }

        .contact-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 12px;
            flex-shrink: 0;
        }

        .contact-info {
            flex: 1;
            min-width: 0;
        }

        .contact-name {
            font-weight: 600;
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .contact-last-message {
            font-size: 0.8rem;
            color: var(--gray-color);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .contact-time {
            font-size: 0.7rem;
            color: var(--gray-color);
            white-space: nowrap;
        }

        .unread-badge {
            background-color: var(--success-color);
            color: white;
            border-radius: 10px;
            padding: 2px 8px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .no-contacts {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray-color);
        }

        /* Scrollbar for sidebar */
        .chat-sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .chat-sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-sidebar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 2px;
        }

        /* Attachment bubble styles */
        .attachment-bubble {
            border-radius: 12px;
            background: #f4f6f8;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            transition: background 0.2s ease;
        }

        .attachment-bubble:hover {
            background: #e9ecef;
        }

        .sent-attach {
            background: #d1e7ff;
        }

        .received-attach {
            background: #f1f3f4;
        }

        .attachment-bubble i {
            color: #6c757d;
        }

        /* ADD these CSS classes */
        .project-bg {
            background-color: #3b82f6 !important;
        }

        .task-bg {
            background-color: #10b981 !important;
        }

        .invoice-bg {
            background-color: #f59e0b !important;
        }

        .general-bg {
            background-color: #6b7280 !important;
        }
    </style>
</head>
@php

    // Add this function at the top of your Blade template
    function getContextInfo($conversation)
    {
        $contextType = $conversation->context_type;
        $contextId = $conversation->context_id;

        $contextConfig = [
            'App\Models\Project' => [
                'icon' => '<i class="fas fa-project-diagram text-primary"></i>',
                'title' => "Project #{$contextId}",
            ],
            'App\Models\Task' => [
                'icon' => '<i class="fas fa-tasks text-success"></i>',
                'title' => "Task #{$contextId}",
            ],
            'App\Models\Invoice' => [
                'icon' => '<i class="fas fa-file-invoice text-warning"></i>',
                'title' => "Invoice #{$contextId}",
            ],
            'App\Models\CustomerContact' => [
                'icon' => '<i class="fas fa-comments text-info"></i>',
                'title' => 'General Support',
            ],
        ];

        return $contextConfig[$contextType] ?? [
            'icon' => '<i class="fas fa-comment-dots text-secondary"></i>',
            'title' => 'Conversation',
        ];
    }
@endphp

<body>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar for Conversations -->
            <div class="col-md-3">
                <div class="chat-sidebar">
                    <div class="sidebar-header">
                        <h5 class="mb-3">Your Conversations</h5>
                    </div>

                    <div class="contacts-list" id="contactsList">
                        @foreach ($conversations as $conv)
                            @php
                                $contextInfo = getContextInfo($conv);
                                $isActive = $conv->id === ($conversation->id ?? null);
                            @endphp
                            <div class="contact-item {{ $isActive ? 'active' : '' }}"
                                data-conversation-id="{{ $conv->id }}"
                                onclick="selectConversation({{ $conv->id }})">
                                <div class="contact-info">
                                    <div class="contact-name">
                                        {{ $contextInfo['title'] }}
                                    </div>
                                    <div class="contact-last-message">
                                        {{ $conv->lastMessage->content ?? 'No messages yet' }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="col-md-9">
                @if ($error)
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
                        <div class="attachment-preview d-none" id="attachmentPreview"></div>

                        <!-- Chat Input -->
                        <div class="chat-input-container">
                            <div class="message-editor">
                                <textarea class="message-textarea" id="messageTextarea" placeholder="Type your message here..."></textarea>

                                <div class="editor-actions">
                                    <div class="attachment-options">
                                        <!-- Attachment buttons can be added here -->
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
        // Context info helper function
        function getContextInfo(conversation) {
            const contextType = conversation.context_type;
            const contextId = conversation.context_id;

            const contextConfig = {
                'App\\Models\\Project': {
                    icon: '<i class="fas fa-project-diagram text-primary"></i>',
                    title: `Project #${contextId}`,
                },
                'App\\Models\\Task': {
                    icon: '<i class="fas fa-tasks text-success"></i>',
                    title: `Task #${contextId}`,
                },
                'App\\Models\\Invoice': {
                    icon: '<i class="fas fa-file-invoice text-warning"></i>',
                    title: `Invoice #${contextId}`,
                },
                'App\\Models\\CustomerContact': {
                    icon: '<i class="fas fa-comments text-info"></i>',
                    title: 'General Support',
                }
            };

            return contextConfig[contextType] || {
                icon: '<i class="fas fa-comment-dots text-secondary"></i>',
                title: 'Conversation',
            };
        }

        @if (!$error && $conversation)
            // Global variables
            let currentConversationId = {{ $conversation->id }};
            const customer = @json($customer);
            const customerSpecialKey = '{{ $customer->special_key }}';

            // Socket.io configuration
            const socket = io('{{ config('socketio.url') }}');

            // Join current conversation room
            socket.emit('join_conversation', currentConversationId);

            document.addEventListener('DOMContentLoaded', function() {
                loadMessages(currentConversationId);
                initializeChat();
            });

            // Load messages for specific conversation
            function loadMessages(conversationId) {
                fetch(`/customer/chat/${customerSpecialKey}/conversations/${conversationId}/messages`)
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

            // Select different conversation
            function selectConversation(conversationId) {
                // Update active state
                document.querySelectorAll('.contact-item').forEach(item => {
                    item.classList.toggle('active', item.dataset.conversationId == conversationId);
                });

                // Leave previous conversation room
                socket.emit('leave_conversation', currentConversationId);

                // Update current conversation
                currentConversationId = conversationId;

                // Join new conversation room
                socket.emit('join_conversation', currentConversationId);

                // Show loading and load messages
                document.getElementById('chatMessages').innerHTML = `
                <div class="text-center py-4 text-muted" id="loadingMessages">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading messages...</span>
                    </div>
                    Loading messages...
                </div>`;

                loadMessages(conversationId);
            }

            // Add message to chat
            function addMessageToChat(content, isSent = true, messageData = null) {
                const chatMessages = document.getElementById('chatMessages');
                const messageDiv = document.createElement('div');
                messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;

                // Avatar
                const avatar = document.createElement('div');
                avatar.className = 'message-avatar';
                avatar.textContent = isSent ? 'ME' : 'SP';
                avatar.setAttribute('title', isSent ? 'You' : 'Support Team');

                // Always append avatar first for consistency
                if (!isSent) messageDiv.appendChild(avatar);

                // Message bubble (text)
                if (content && content.trim() !== '') {
                    const messageBubble = document.createElement('div');
                    messageBubble.className = 'message-bubble';

                    const messageContent = document.createElement('div');
                    messageContent.className = 'message-content';
                    messageContent.innerHTML = content.replace(/\n/g, '<br>');
                    messageBubble.appendChild(messageContent);

                    const footer = document.createElement('div');
                    footer.className = 'message-footer mt-1';
                    footer.innerHTML = `
                    <div class="message-time small">
                        ${(messageData ? new Date(messageData.created_at) : new Date()).toLocaleTimeString([], {
                            hour: '2-digit',
                            minute: '2-digit'
                        })}
                    </div>`;
                    messageBubble.appendChild(footer);

                    messageDiv.appendChild(messageBubble);
                }

                // Attachments
                if (messageData && messageData.attachments && messageData.attachments.length > 0) {
                    const attachmentsWrap = document.createElement('div');
                    attachmentsWrap.className = `message-attachments mt-2 ${isSent ? 'ms-auto text-end' : ''}`;
                    attachmentsWrap.style.maxWidth = '80%';

                    messageData.attachments.forEach(att => {
                        const icon = att.file_type.startsWith('image/') ?
                            'fa-file-image' :
                            att.file_type.startsWith('video/') ?
                            'fa-file-video' :
                            att.file_type.startsWith('audio/') ?
                            'fa-file-audio' :
                            'fa-file';

                        const attachmentDiv = document.createElement('div');
                        attachmentDiv.className =
                            `attachment-bubble d-inline-flex align-items-center justify-content-between gap-2 px-3 py-2 mb-1 ${isSent ? 'sent-attach' : 'received-attach'}`;
                        attachmentDiv.innerHTML = `
                        <div class="d-flex align-items-center gap-2 text-truncate" style="max-width: 250px;">
                            <i class="fas ${icon}"></i>
                            <a href="${att.file_url}" target="_blank"
                                class="text-decoration-none text-dark small text-truncate">
                                ${att.original_name || att.file_name || 'File'}
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <small class="text-muted">${formatFileSize(att.file_size)}</small>
                            <a href="${att.file_url}" download="${att.original_name || att.file_name}" class="text-muted ms-1" title="Download">
                                <i class="fas fa-download small"></i>
                            </a>
                        </div>`;

                        attachmentsWrap.appendChild(attachmentDiv);
                    });

                    // Timestamp under attachments
                    const timeDiv = document.createElement('div');
                    timeDiv.className = `small text-muted mt-1 ${isSent ? 'text-end' : 'text-start'}`;
                    timeDiv.textContent = (messageData ? new Date(messageData.created_at) : new Date()).toLocaleTimeString(
                    [], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                    attachmentsWrap.appendChild(timeDiv);

                    messageDiv.appendChild(attachmentsWrap);
                }

                // Always append avatar last for sent messages
                if (isSent) messageDiv.appendChild(avatar);

                chatMessages.appendChild(messageDiv);
                new bootstrap.Tooltip(avatar);
                scrollToBottom();
            }

            // Helper function to format file size
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
            }

            // Initialize chat functionality
            function initializeChat() {
                const messageTextarea = document.getElementById('messageTextarea');
                const sendButton = document.getElementById('sendButton');

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
                                    message_type: 'text',
                                    conversation_id: currentConversationId
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    messageTextarea.value = '';
                                    messageTextarea.style.height = '60px';

                                    // Send via Socket.io for real-time
                                    socket.emit('send_message', {
                                        content: message,
                                        conversation_id: currentConversationId,
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

                sendButton.addEventListener('click', sendMessage);

                messageTextarea.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' && !e.shiftKey) {
                        e.preventDefault();
                        sendMessage();
                    }
                });

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
                // Only add message if it's for the current conversation and from support
                if (data.conversation_id === currentConversationId && data.sender_type !==
                    'App\\Models\\CustomerContact') {
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
