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

    .chat-container {
        /* background-color: white; */
        border-radius: 3px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        height: 400px;
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
        /* background-color: var(--bs-card-color); */
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
        /* border: 1px solid var(--bs-primary); */
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
</style>
<div class="chat-container">
    <!-- Chat Header -->
    <div class="chat-header d-none">
        <!-- Your header content -->
    </div>
    <!-- Chat Messages -->
<div class="chat-messages" id="chatMessages">
    @if(isset($conversation) && $conversation->id)
        <!-- Messages will be loaded dynamically via AJAX -->
        <div class="text-center py-4 text-muted" id="loadingMessages">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading messages...</span>
            </div>
            Loading messages...
        </div>

        <!-- Hidden no messages state -->
        <div class="d-none" id="noMessagesState">
            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center p-4">
                <div class="mb-3">
                    <i class="fas fa-comment-slash fa-3x text-muted"></i>
                </div>
                <h5 class="text-muted mb-3">No Messages Yet</h5>
                <p class="text-muted mb-4">Send a message to start the conversation</p>
            </div>
        </div>
    @else
        <!-- No conversation state -->
        <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center p-4" id="noConversationState">
            <div class="mb-3">
                <i class="fas fa-comments fa-3x text-muted"></i>
            </div>
            <h5 class="text-muted mb-3">No Conversation Started</h5>
            <p class="text-muted mb-4">Start a new conversation to begin chatting</p>
            <button class="btn btn-primary" id="startConversationBtn">
                <i class="fas fa-plus me-2"></i>Start Chatting
            </button>
        </div>
    @endif
</div>

    <!-- Attachment Preview -->
    <div class="attachment-preview d-none" id="attachmentPreview">
        <!-- Attachment preview will be shown here -->
    </div>

    <!-- Chat Input -->
    <div class="chat-input-container" id="chatInputContainer" style="{{ !isset($conversation) || !$conversation->id ? 'display: none;' : '' }}">
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
<script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>

<script>
    // Global variables
    //todo need to handle customer id
    const conversationId = {{ $conversation->id ?? 'null' }};
    const currentUser = {
        id: {{ auth()->id() }},
        type: '{{ addslashes(get_class(auth()->user())) }}',
        name: '{{ addslashes(auth()->user()->name) }}'
    };

    let socket = null;

    // Initialize based on conversation existence
    document.addEventListener('DOMContentLoaded', function() {
        if (conversationId) {
            initializeChatWithConversation();
        } else {
            initializeNoConversationState();
        }
    });

    function initializeChatWithConversation() {
        socket = io('{{ config('socketio.url') }}');

        socket.emit('join_conversation', conversationId);

        loadMessages(conversationId);
        initializeChatFunctionality();

        socket.on('new_message', (data) => {
            if (data.sender_id !== currentUser.id || data.sender_type !== currentUser.type) {
                addNewMessage(data.content, false, data);
            }
        });
    }

    // When no conversation exists
    function initializeNoConversationState() {
        document.getElementById('startConversationBtn').addEventListener('click', function() {
            startNewConversation();
        });
    }

    // Start new conversation
    function startNewConversation() {
        const btn = document.getElementById('startConversationBtn');
        const originalText = btn.innerHTML;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';

        fetch('{{ route("admin.customer.contact.conversations.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                receiver_type: 'App\\Models\\CustomerContact',
                receiver_id: {{ $customer_contact->id ?? 'null' }}
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('noConversationState').style.display = 'none';

                document.getElementById('chatInputContainer').style.display = 'block';

                document.getElementById('chatMessages').innerHTML = `
                    <div class="text-center py-4 text-muted" id="loadingMessages">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="visually-hidden">Loading messages...</span>
                        </div>
                        Loading messages...
                    </div>
                `;

                window.location.reload();
            } else {
                throw new Error(data.message || 'Failed to create conversation');
            }
        })
        .catch(error => {
            console.error('Error creating conversation:', error);
            alert('Failed to start conversation: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = originalText;
        });
    }

    // Load messages via AJAX and render using partial
    function loadMessages(conversationId) {
        const route = `{{ route('admin.customer.contact.conversation.message', ':conversation_id') }}`.replace(':conversation_id', conversationId);
        fetch(route)
            .then(response => response.json())
            .then(data => {
                document.getElementById('loadingMessages').style.display = 'none';

                if (data.messages && data.messages.length > 0) {
                    // Show messages
                    document.getElementById('chatMessages').innerHTML = data.html;
                    initializeTooltips();
                    scrollToBottom();
                } else {
                    // Show no messages state
                    document.getElementById('noMessagesState').classList.remove('d-none');
                }
            })
            .catch(error => {
                console.error('Error loading messages:', error);
                document.getElementById('loadingMessages').innerHTML =
                    '<div class="text-danger">Failed to load messages</div>';
            });
    }

    // Initialize Bootstrap tooltips for all avatars
    function initializeTooltips() {
        const avatars = document.querySelectorAll('.message-avatar');
        avatars.forEach(avatar => {
            new bootstrap.Tooltip(avatar);
        });
    }

    // Add new message (for real-time and manual sending)
    function addNewMessage(content, isSent = true, messageData = null) {
        const chatMessages = document.getElementById('chatMessages');

        // Hide no messages state if it's visible
        const noMessagesState = document.getElementById('noMessagesState');
        if (noMessagesState && !noMessagesState.classList.contains('d-none')) {
            noMessagesState.classList.add('d-none');
        }

        // Remove loading state if it's still there
        const loadingMessages = document.getElementById('loadingMessages');
        if (loadingMessages) {
            loadingMessages.style.display = 'none';
        }

        // Create message element similar to Blade structure
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;

        // Avatar setup
        const avatarText = isSent ? 'ME' : (messageData?.sender?.name?.substring(0, 2) || 'U');
        const avatarTitle = isSent ? 'You' : (messageData?.sender?.name || 'User');

        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.textContent = avatarText;
        avatar.setAttribute('data-bs-toggle', 'tooltip');
        avatar.setAttribute('data-bs-placement', 'top');
        avatar.setAttribute('title', avatarTitle);

        // Message bubble
        const messageBubble = document.createElement('div');
        messageBubble.className = 'message-bubble';

        // Content section
        const contentDiv = document.createElement('div');
        contentDiv.className = 'message-content';
        contentDiv.textContent = content;

        // Footer section (time, status, etc.)
        const messageFooter = document.createElement('div');
        messageFooter.className = 'message-footer';

        const timeDiv = document.createElement('div');
        timeDiv.className = 'message-time';
        const messageTime = messageData ? new Date(messageData.created_at) : new Date();
        timeDiv.textContent = messageTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        messageFooter.appendChild(timeDiv);

        // Append content first, then footer
        messageBubble.appendChild(contentDiv);
        messageBubble.appendChild(messageFooter);

        // Add attachments if any
        if (messageData?.attachments && messageData.attachments.length > 0) {
            const attachmentsDiv = document.createElement('div');
            attachmentsDiv.className = 'message-attachments mt-2';

            messageData.attachments.forEach(att => {
                const attachmentItem = document.createElement('div');
                attachmentItem.className = 'attachment-item small';
                attachmentItem.innerHTML = `<i class="fas fa-file me-1"></i><span>${att.file_name}</span>`;
                attachmentsDiv.appendChild(attachmentItem);
            });

            messageBubble.appendChild(attachmentsDiv);
        }

        // Arrange message structure (based on direction)
        if (isSent) {
            messageDiv.appendChild(messageBubble);
            messageDiv.appendChild(avatar);
        } else {
            messageDiv.appendChild(avatar);
            messageDiv.appendChild(messageBubble);
        }

        chatMessages.appendChild(messageDiv);

        // Tooltip for avatars
        new bootstrap.Tooltip(avatar);

        scrollToBottom();
    }

    // Initialize chat functionality
    function initializeChatFunctionality() {
        const messageTextarea = document.getElementById('messageTextarea');
        const sendButton = document.getElementById('sendButton');

        // Send message function
        function sendMessage() {
            const message = messageTextarea.value.trim();
            if (message) {
                // Add message locally immediately
                addNewMessage(message, true);

                // Send to Laravel backend via AJAX
                fetch('/admin/customer/contact/messages', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            content: message,
                            conversation_id: conversationId,
                            message_type: 'text'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Message sent:', data);
                        if (data.success) {
                            // Message sent successfully
                            messageTextarea.value = '';
                            messageTextarea.style.height = '60px';

                            // Also send via Socket.io for real-time
                            if (socket) {
                                socket.emit('send_message', {
                                    content: message,
                                    conversation_id: conversationId,
                                    sender_type: currentUser.type,
                                    sender_id: currentUser.id,
                                    message_type: 'text'
                                });
                            }
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

    // Scroll to bottom of chat
    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
</script>
