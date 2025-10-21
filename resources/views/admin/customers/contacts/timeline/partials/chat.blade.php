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
</style>
<div class="chat-container">
    <!-- Chat Header -->
    <div class="chat-header d-none">
        <!-- Your header content -->
    </div>
    <!-- Chat Messages -->
    <div class="chat-messages" id="chatMessages">
        @if (isset($conversation) && $conversation->id)
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
            <div class="d-flex flex-column align-items-center justify-content-center h-100 text-center p-4"
                id="noConversationState">
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
    <div class="attachment-preview d-none" id="attachmentPreview"></div>



    <!-- Chat Input -->
    <div class="chat-input-container" id="chatInputContainer"
        style="{{ !isset($conversation) || !$conversation->id ? 'display: none;' : '' }}">
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

            <input type="file" id="fileInput" multiple hidden>
            <input type="file" id="imageInput" accept="image/*" multiple hidden>

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

        loadMessages();
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

        fetch('{{ route('admin.customer.contact.conversations.store') }}', {
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
                toastr.error('Failed to start conversation: ' + error.message);
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    }

    // Load messages via AJAX and render using partial
    function loadMessages() {
        fetch(`/admin/customer/contact/conversations/${conversationId}/messages`)
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

    function addNewMessage(content, isSent = true, messageData = null) {
        const chatMessages = document.getElementById('chatMessages');

        // Hide empty states
        const noMessagesState = document.getElementById('noMessagesState');
        if (noMessagesState && !noMessagesState.classList.contains('d-none')) {
            noMessagesState.classList.add('d-none');
        }

        // Hide loading spinner
        const loadingMessages = document.getElementById('loadingMessages');
        if (loadingMessages) loadingMessages.style.display = 'none';

        const message = messageData || {};

        const isAttachment = message.attachments && message.attachments.length > 0;
        const createdAt = message.created_at
            ? new Date(message.created_at)
            : new Date();

        const timeStr = createdAt.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const avatarText = isSent ? 'ME' : (message.sender?.name?.substring(0, 2) || 'U');
        const avatarTitle = isSent ? 'You' : (message.sender?.name || 'User');

        //  Build message HTML identical to Blade
        let html = `<div class="message ${isSent ? 'sent' : 'received'}">`;

        // Left avatar
        if (!isSent) {
            html += `
                <div class="message-avatar" data-bs-toggle="tooltip" title="${avatarTitle}">
                    ${avatarText}
                </div>
            `;
        }

        // Message bubble (only for text)
        if (content && content.trim() !== '') {
            html += `
                <div class="message-bubble">
                    <div class="message-content">${content.replace(/\n/g, '<br>')}</div>
                    <div class="message-footer mt-1">
                        <div class="message-time small">${timeStr}</div>
                    </div>
                </div>
            `;
        }

        // Attachments
        if (isAttachment) {
            html += `
                <div class="message-attachments mt-2 ${isSent ? 'ms-auto text-end' : ''}" style="max-width: 80%;">
            `;

            message.attachments.forEach(att => {
                const filePath = att.file_path
                    ? `/storage/${att.file_path}`
                    : '#';
                const fileType = att.file_type || '';
                const icon = fileType.startsWith('image/')
                    ? 'fa-file-image'
                    : fileType.startsWith('video/')
                    ? 'fa-file-video'
                    : fileType.startsWith('audio/')
                    ? 'fa-file-audio'
                    : 'fa-file';

                const size = att.file_size ? formatFileSize(att.file_size) : '';

                html += `
                    <div class="attachment-bubble d-inline-flex align-items-center justify-content-between gap-2 px-3 py-2 mb-1 ${isSent ? 'sent-attach' : 'received-attach'}">
                        <div class="d-flex align-items-center gap-2 text-truncate" style="max-width: 250px;">
                            <i class="fas ${icon}"></i>
                            <a href="${filePath}" target="_blank" class="text-decoration-none text-dark small text-truncate">
                                ${att.file_name || 'Attachment'}
                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <small class="text-muted">${size}</small>
                            <a href="${filePath}" download="${att.file_name || ''}" class="text-muted ms-1" title="Download">
                                <i class="fas fa-download small"></i>
                            </a>
                        </div>
                    </div>
                `;
            });

            html += `
                <div class="small text-muted mt-1 ${isSent ? 'text-end' : 'text-start'}">${timeStr}</div>
                </div>
            `;
        }

        // Right avatar
        if (isSent) {
            html += `
                <div class="message-avatar" data-bs-toggle="tooltip" title="${avatarTitle}">
                    ${avatarText}
                </div>
            `;
        }

        html += `</div>`;

        // Append to chat container
        chatMessages.insertAdjacentHTML('beforeend', html);

        // Re-init Bootstrap tooltips
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        scrollToBottom();
    }

    // Helper function for file size formatting (same as PHP)
    function formatFileSize(bytes) {
        if (!bytes || bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return (bytes / Math.pow(k, i)).toFixed(1) + ' ' + sizes[i];
    }



    // Initialize chat functionality
    function initializeChatFunctionality() {
        const messageTextarea = document.getElementById('messageTextarea');
        const sendButton = document.getElementById('sendButton');
        const attachFileBtn = document.getElementById('attachFileBtn');
        const attachImageBtn = document.getElementById('attachImageBtn');
        const fileInput = document.getElementById('fileInput');
        const imageInput = document.getElementById('imageInput');
        const attachmentPreview = document.getElementById('attachmentPreview');
        let selectedFiles = [];

        // --- Disable inputs dynamically ---
        function updateInputStates() {
            const hasText = messageTextarea.value.trim().length > 0;
            const hasFiles = selectedFiles.length > 0;

            // Hide attach buttons when user types text
            if (hasText) {
                attachFileBtn.classList.add('d-none');
                attachImageBtn.classList.add('d-none');
            } else {
                attachFileBtn.classList.remove('d-none');
                attachImageBtn.classList.remove('d-none');
            }

            // Hide message box when attachments exist
            if (hasFiles) {
                messageTextarea.classList.add('d-none');
            } else {
                messageTextarea.classList.remove('d-none');
            }
        }


        // --- File selection handler ---
        function handleFileSelect(event) {
            const files = Array.from(event.target.files);

            // Validation: max 3 files
            if (selectedFiles.length + files.length > 3) {
                toastr.warning('You can only attach up to 3 files.');
                return;
            }

            // Validation: each file ≤ 3 MB
            for (const file of files) {
                if (file.size > 3 * 1024 * 1024) {
                    toastr.warning(`"${file.name}" exceeds 3 MB limit.`);
                    return;
                }
            }

            selectedFiles.push(...files);
            renderAttachmentPreview();
            updateInputStates();
        }

        // --- Render preview ---
        function renderAttachmentPreview() {
            attachmentPreview.innerHTML = '';
            if (selectedFiles.length > 0) {
                attachmentPreview.classList.remove('d-none');
                selectedFiles.forEach((file, index) => {
                    const isImage = file.type.startsWith('image/');
                    const icon = isImage ? 'fa-file-image' : 'fa-file';
                    const item = document.createElement('div');
                    item.className = 'attachment-item';
                    item.innerHTML = `
                        <i class="fas ${icon}"></i> ${file.name}
                        <span class="remove-attachment" data-index="${index}">
                            <i class="fas fa-times"></i>
                        </span>
                    `;
                    attachmentPreview.appendChild(item);
                    updateInputStates();

                });
            } else {
                attachmentPreview.classList.add('d-none');
            }
        }

        // --- Remove attachment ---
        attachmentPreview.addEventListener('click', e => {
            if (e.target.closest('.remove-attachment')) {
                const index = e.target.closest('.remove-attachment').dataset.index;
                selectedFiles.splice(index, 1);
                renderAttachmentPreview();
                updateInputStates();
            }
        });

        // --- Listeners ---
        attachFileBtn.addEventListener('click', () => fileInput.click());
        attachImageBtn.addEventListener('click', () => imageInput.click());
        fileInput.addEventListener('change', handleFileSelect);
        imageInput.addEventListener('change', handleFileSelect);
        messageTextarea.addEventListener('input', updateInputStates);

        // --- Send Message ---
        function sendMessage() {
            const message = messageTextarea.value.trim();

            if (!message && selectedFiles.length === 0) {
                toastr.warning('Please type a message or attach a file.');
                return;
            }

            const formData = new FormData();
            formData.append('conversation_id', conversationId);
            formData.append('message_type', selectedFiles.length > 0 ? 'file' : 'text');
            formData.append('content', message);

            selectedFiles.forEach(file => formData.append('attachments[]', file));

            fetch('/admin/customer/contact/messages', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.message) {
                    addNewMessage(data.message.content, true, data.message);
                    if (socket) socket.emit('send_message', data.message);

                    messageTextarea.value = '';
                    selectedFiles = [];
                    renderAttachmentPreview();
                    fileInput.value = '';
                    imageInput.value = '';
                    updateInputStates();
                } else {
                    toastr.error('Failed to send message');
                }
            })
            .catch(() => toastr.error('Send failed'));
        }

        sendButton.addEventListener('click', sendMessage);
    }



    // Scroll to bottom of chat
    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
</script>
