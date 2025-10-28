@include('admin.customers.contacts.timeline.partials.chat.partials.style')
<div class="row">
    <div class="col-md-4">
        <div class="chat-sidebar">
            <div class="sidebar-header text-center">
                <h5 class="mb-3">Conversations</h5>
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search Conversations..." id="contactSearch">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>

            <div class="contacts-list" id="contactsList">
                <!-- ADD THIS LOADING ELEMENT -->
                <div class="text-center py-4 text-muted" id="loadingContacts">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading Conversations...</span>
                    </div>
                    Loading Conversations...
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-8">
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
            <div class="attachment-preview d-none" id="ChatAttachmentPreview"></div>



            <!-- Chat Input -->
            <div class="chat-input-container" id="chatInputContainer"
                style="{{ !isset($conversation) || !$conversation->id ? 'display: none;' : '' }}">
                <div class="message-editor">
                    {{-- <div class="editor-toolbar">
                                <button title="Bold"><i class="fas fa-bold"></i></button>
                                <button title="Italic"><i class="fas fa-italic"></i></button>
                                <button title="Underline"><i class="fas fa-underline"></i></button>
                                <button title="Bullet List"><i class="fas fa-list-ul"></i></button>
                                <button title="Numbered List"><i class="fas fa-list-ol"></i></button>
                                <button title="Insert Link"><i class="fas fa-link"></i></button>
                                <button title="Insert Emoji"><i class="far fa-smile"></i></button>
                            </div> --}}

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
                            <button class="customer-chat-link" id="copyChatLinkBtn" title="Copy Chat Link">
                                <i class="fas fa-link"></i> Copy Chat Link
                            </button>
                        </div>

                        <button class="send-btn" id="sendButton">
                            Send <i class="fas fa-paper-plane ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.socket.io/4.5.0/socket.io.min.js"></script>

<script>
    // Dynamic configuration from Laravel
    const socketConfig = {
        url: '{{ config('socketio.url', 'http://localhost:6001') }}',
        path: '{{ config('socketio.path', '/socket.io') }}',
        environment: '{{ config('app.env', 'local') }}'
    };


    // Global variables
    //todo need to handle customer id
    window.conversationId = {{ $conversation->id ?? 'null' }}; // Make it globally accessible
    window.previousConversationId = null; // For socket management
    const currentUser = {
        id: {{ auth()->id() }},
        type: '{{ addslashes(get_class(auth()->user())) }}',
        name: '{{ addslashes(auth()->user()->name) }}'
    };

    let socket = null;

    let currentContext = {
        type: '{{ addslashes(get_class($customer_contact ?? null)) }}',
        id: {{ $customer_contact->id ?? 'null' }}
    };
    // ADD this global variable at the top:
    let isSocketInitialized = false;
    // Initialize based on conversation existence
    document.addEventListener('DOMContentLoaded', function() {
        
        // Get conversation_id from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const urlConversationId = urlParams.get('conversation_id');
        
        // Initialize socket first
        initializeSocket();
        
        if (urlConversationId) {
            // Set the global conversationId from URL
            window.conversationId = urlConversationId;
            loadSelectedConversation(urlConversationId);
        } else if (window.conversationId) {
            // Use the existing conversationId from PHP
            initializeChatWithConversation();
        } else {
            initializeNoConversationState();
        }
        
        loadConversationsAsContacts(); // Load conversations list
    });



    // UPDATE the loadConversationsAsContacts function:
        function loadConversationsAsContacts() {
            const loadingElement = document.getElementById('loadingContacts');
            const contactsList = document.getElementById('contactsList');
            
            if (loadingElement) loadingElement.style.display = 'block';
            
            // Get context-based conversations for this customer contact
            fetch(`{{ route('admin.customer.contact.conversations.context') }}?customer_contact_id=${currentContext.id}`)
                .then(response => response.json())
                .then(data => {
                    if (loadingElement) loadingElement.style.display = 'none';
                    renderContextConversations(data.conversations || []);
                })
                .catch(error => {
                    console.error('Error loading conversations:', error);
                    if (loadingElement) {
                        loadingElement.innerHTML = '<div class="text-danger">Failed to load conversations</div>';
                    }
                });
        }

        // UPDATE the render function for context conversations:
        function renderContextConversations(conversations) {
            const contactsList = document.getElementById('contactsList');
            
            if (!conversations || conversations.length === 0) {
                contactsList.innerHTML = `
                    <div class="no-contacts">
                        <i class="fas fa-comments fa-2x mb-3"></i>
                        <p>No conversations yet</p>
                        <small class="text-muted">Start a new conversation about a project, task, or invoice</small>
                    </div>
                `;
                return;
            }

            let html = '';
            conversations.forEach(conversation => {
                const isActive = conversation.id == conversationId;
                const contextInfo = getContextInfo(conversation);
                const lastMessage = getLastMessagePreview(conversation);
                const unreadCount = getUnreadCount(conversation);

                html += `
                    <div class="contact-item ${isActive ? 'active' : ''}" data-conversation-id="${conversation.id}">
                        <div class="contact-info">
                            <div class="contact-name">
                                ${contextInfo.title}
                                ${unreadCount > 0 ? `<span class="unread-badge">${unreadCount}</span>` : ''}
                            </div>
                            <div class="contact-last-message">${lastMessage}</div>
                        </div>
                        </div>
                        `;
                    });
            
            contactsList.innerHTML = html;
            
            // Add click event listeners
            document.querySelectorAll('.contact-item').forEach(item => {
                item.addEventListener('click', function() {
                    const conversationId = this.dataset.conversationId;
                    selectConversation(conversationId);
                });
            });
        }

        // ADD this function to get context information:
        function getContextInfo(conversation) {
            const contextType = conversation.context_type;
            const contextId = conversation.context_id;

            const contextConfig = {
                'App\\Models\\Project': {
                    icon: '<i class="fas fa-project-diagram text-primary"></i>',
                    color: 'project-bg',
                    title: `Project #${contextId}`,
                    prefix: 'Project'
                },
                'App\\Models\\Task': {
                    icon: '<i class="fas fa-tasks text-success"></i>',
                    color: 'task-bg',
                    title: `Task #${contextId}`,
                    prefix: 'Task'
                },
                'App\\Models\\Invoice': {
                    icon: '<i class="fas fa-file-invoice text-warning"></i>',
                    color: 'invoice-bg',
                    title: `Invoice #${contextId}`,
                    prefix: 'Invoice'
                },
                'App\\Models\\CustomerContact': {
                    icon: '<i class="fas fa-comments text-info"></i>',
                    color: 'general-bg',
                    title: conversation.receiver.name ?? 'Not Provided',
                    prefix: 'General'
                }
            };

            return contextConfig[contextType] || {
                icon: '<i class="fas fa-comment-dots text-secondary"></i>',
                color: 'general-bg',
                title: 'Conversation',
                prefix: 'General'
            };
        }



    // Render conversations as contact list
    function renderConversationsAsContacts(conversations) {
        const contactsList = document.getElementById('contactsList');

        if (!conversations || conversations.length === 0) {
            contactsList.innerHTML = `
                <div class="no-contacts">
                    <i class="fas fa-comments fa-2x mb-3"></i>
                    <p>No conversations yet</p>
                    <small class="text-muted">Start a new conversation to begin chatting</small>
                </div>
            `;
            return;
        }

        let html = '';
        conversations.forEach(conversation => {
            const isActive = conversation.id == conversationId;
            const otherParty = getOtherParty(conversation);
            const avatarText = getAvatarText(otherParty);
            const lastMessage = getLastMessagePreview(conversation);
            const unreadCount = getUnreadCount(conversation);

            html += `
                <div class="contact-item ${isActive ? 'active' : ''}" data-conversation-id="${conversation.id}">
                    <div class="contact-info">
                        <div class="contact-name">
                            ${otherParty.name || 'Unknown'}
                            ${unreadCount > 0 ? `<span class="unread-badge">${unreadCount}</span>` : ''}
                        </div>
                        <div class="contact-last-message">${lastMessage}</div>
                    </div>
                    </div>
                    `;
                });

        contactsList.innerHTML = html;

        // Add click event listeners to conversation items
        document.querySelectorAll('.contact-item').forEach(item => {
            item.addEventListener('click', function() {
                const conversationId = this.dataset.conversationId;
                selectConversation(conversationId);
            });
        });
    }

    // Get the other party in conversation (not current user)
    function getOtherParty(conversation) {
        const currentUserType = '{{ addslashes(get_class(auth()->user())) }}';
        const customerContactType = '{{ addslashes(get_class($customer_contact)) }}';

        if (conversation.sender_type === currentUserType && conversation.sender_id === currentUser.id) {
            // Current user is sender, so receiver is the customer contact
            return {
                type: conversation.receiver_type,
                id: conversation.receiver_id,
                name: conversation.receiver?.name || conversation.receiver?.email || 'Customer Contact'
            };
        } else {
            // Current user is receiver, so sender is the customer contact
            return {
                type: conversation.sender_type,
                id: conversation.sender_id,
                name: conversation.sender?.name || conversation.sender?.email || 'Customer Contact'
            };
        }
    }

    // Get avatar text from name
    function getAvatarText(party) {
        if (!party.name) return 'CC';

        // For customer contacts, use first letters of name or fallback to 'CC'
        const nameParts = party.name.split(' ');
        if (nameParts.length >= 2) {
            return (nameParts[0].charAt(0) + nameParts[1].charAt(0)).toUpperCase();
        }
        return party.name.substring(0, 2).toUpperCase();
    }

    // Get last message preview
    function getLastMessagePreview(conversation) {
        if (conversation.last_message) {
            const content = conversation.last_message.content;
            return content.length > 30 ? content.substring(0, 30) + '...' : content;
        }
        return 'No messages yet';
    }

    // Get unread message count
    function getUnreadCount(conversation) {
        return conversation.unread_count || 0;
    }

    // Format time for display
    function formatTime(timestamp) {
        if (!timestamp) return '';

        const date = new Date(timestamp);
        const now = new Date();
        const diffMs = now - date;
        const diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));

        if (diffDays === 0) {
            return date.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit'
            });
        } else if (diffDays === 1) {
            return 'Yesterday';
        } else if (diffDays < 7) {
            return date.toLocaleDateString([], {
                weekday: 'short'
            });
        } else {
            return date.toLocaleDateString([], {
                month: 'short',
                day: 'numeric'
            });
        }
    }

    // ADD THIS FUNCTION after selectConversation:
    function loadSelectedConversation(conversationId) {
        
        // Update global conversationId
        window.conversationId = conversationId;
        
        // Get DOM elements safely
        const chatMessages = document.getElementById('chatMessages');
        const chatInputContainer = document.getElementById('chatInputContainer');
        const noConversationState = document.getElementById('noConversationState');
        const noMessagesState = document.getElementById('noMessagesState');
        
        if (!chatMessages) {
            console.error('❌ chatMessages element not found');
            return;
        }
        
        // Show loading state
        chatMessages.innerHTML = `
            <div class="text-center py-4 text-muted" id="loadingMessages">
                <div class="spinner-border spinner-border-sm" role="status">
                    <span class="visually-hidden">Loading messages...</span>
                </div>
                Loading messages...
            </div>
        `;
        
        // Show chat input if element exists
        if (chatInputContainer) {
            chatInputContainer.style.display = 'block';
        }
        
        // Hide no conversation state if it exists
        if (noConversationState) {
            noConversationState.style.display = 'none';
        }
        
        // Hide no messages state if it exists
        if (noMessagesState) {
            noMessagesState.classList.add('d-none');
        }
        
        // Load messages for the selected conversation
        loadMessages();
        
        // Update active state in sidebar safely
        const contactItems = document.querySelectorAll('.contact-item');
        contactItems.forEach(item => {
            if (item && item.dataset && item.dataset.conversationId == conversationId) {
                item.classList.add('active');
            } else if (item && item.classList) {
                item.classList.remove('active');
            }
        });
        
        // Reinitialize socket for new conversation
        if (socket) {
            if (window.previousConversationId) {
                socket.emit('leave_conversation', window.previousConversationId);
            }
            socket.emit('join_conversation', conversationId);
            window.previousConversationId = conversationId;
        } else {
            initializeSocket();
        }
        
        // Reinitialize chat functionality for new conversation
        initializeChatFunctionality();
    }

    // ADD this function to safely initialize socket:
    function initializeSocket() {

        if (!isSocketInitialized) {

            socket = io(socketConfig.url, {
                path: socketConfig.path,
                transports: ['websocket', 'polling']
            });
            isSocketInitialized = true;

            console.log(socket);
            console.log('Socket connected with ID:', socket.id);
            console.log('🔄 Connecting to Socket.IO...');
            console.log('URL:', socketConfig.url);
            console.log('Path:', socketConfig.path);
            console.log('Environment:', socketConfig.environment);
            
            // Add socket event listeners
            socket.on('connect', () => {
                // Join current conversation after connection
                if (window.conversationId) {
                    socket.emit('join_conversation', window.conversationId);
                }
            });
            
            socket.on('new_message', (data) => {
                if (data.sender_id !== currentUser.id || data.sender_type !== currentUser.type) {
                    addNewMessage(data.content, false, data);
                    updateConversationList();
                }
            });
            
            socket.on('disconnect', (reason) => {
            });
            
            socket.on('connect_error', (error) => {
                console.error('❌ Socket connection error:', error);
            });
        }
    }


    // Handle conversation selection
function selectConversation(conversationId) {
    
    // Don't do anything if already on this conversation
    if (window.conversationId == conversationId) {
        return;
    }
    
    // Update URL without reloading page
    const url = new URL(window.location.href);
    url.searchParams.set('conversation_id', conversationId);
    window.history.pushState({}, '', url.toString());
    
    // Load the selected conversation
    loadSelectedConversation(conversationId);
}

    // Update conversation list when new messages arrive
    function updateConversationList() {
        loadConversationsAsContacts();
    }



    // UPDATE the initializeChatWithConversation function:
    function initializeChatWithConversation() {
        
        // Make sure socket is initialized
        if (!socket || !isSocketInitialized) {
            initializeSocket();
        }
        
        // Join conversation via socket
        socket.emit('join_conversation', window.conversationId);
        window.previousConversationId = window.conversationId;

        loadMessages();
        initializeChatFunctionality();
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
                    receiver_id: currentContext.id
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Use the new conversation loading function instead of reload
                    loadSelectedConversation(data.conversation.id);
                    
                    // Refresh the conversations list
                    updateConversationList();
                } else {
                    throw new Error(data.message || 'Failed to create conversation');
                }
            })
            .catch(error => {
                console.error('Error creating conversation:', error);
                
                if (error.response && error.response.data && error.response.data.errors) {
                    // Validation errors
                    const validationErrors = Object.values(error.response.data.errors).flat();
                    toastr.error('Validation error: ' + validationErrors.join(', '));
                } else if (error.response && error.response.data && error.response.data.message) {
                    // Server error with message
                    toastr.error('Error: ' + error.response.data.message);
                } else {
                    // Network or other error
                    toastr.error('Failed to start conversation: ' + error.message);
                }
                
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
    }

    // Load messages via AJAX and render using partial
    function loadMessages() {
        // Use the global conversationId which gets updated when switching
        const currentConvId = window.conversationId;
        
        
        if (!currentConvId) {
            const noMessagesState = document.getElementById('noMessagesState');
            if (noMessagesState) noMessagesState.classList.remove('d-none');
            return;
        }

        fetch(`{{ route('admin.customer.contact.conversations.messages', ':conversationId') }}`.replace(':conversationId', currentConvId))
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                
                const loadingMessages = document.getElementById('loadingMessages');
                const chatMessages = document.getElementById('chatMessages');
                const noMessagesState = document.getElementById('noMessagesState');
                
                if (loadingMessages) loadingMessages.style.display = 'none';

                if (data.messages && data.messages.length > 0 && data.html) {
                    chatMessages.innerHTML = data.html;
                    initializeTooltips();
                    scrollToBottom();
                    
                    // Hide no messages state
                    if (noMessagesState) noMessagesState.classList.add('d-none');
                } else {
                    // Show no messages state
                    if (noMessagesState) noMessagesState.classList.remove('d-none');
                    if (chatMessages) chatMessages.innerHTML = ''; // Clear loading
                }
            })
            .catch(error => {
                console.error('❌ Error loading messages:', error);
                const loadingMessages = document.getElementById('loadingMessages');
                if (loadingMessages) {
                    loadingMessages.innerHTML = '<div class="text-danger">Failed to load messages</div>';
                }
            });
    }

    // Initialize Bootstrap tooltips for all avatars
    function initializeTooltips() {
        const avatars = document.querySelectorAll('.message-avatar');
        avatars.forEach(avatar => {
            new bootstrap.Tooltip(avatar);
        });
    }

// UPDATE the addNewMessage function:
function addNewMessage(content, isSent = true, messageData = null) {
    const chatMessages = document.getElementById('chatMessages');
    if (!chatMessages) return;

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
    const createdAt = message.created_at ?
        new Date(message.created_at) :
        new Date();

    const timeStr = createdAt.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
    });
    const avatarText = isSent ? 'ME' : (message.sender?.name?.substring(0, 2) || 'U');
    const avatarTitle = isSent ? 'You' : (message.sender?.name || 'User');

    // Build message HTML identical to Blade
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
                const filePath = att.file_path ?
                    `/storage/${att.file_path}` :
                    '#';
                const fileType = att.file_type || '';
                const icon = fileType.startsWith('image/') ?
                    'fa-file-image' :
                    fileType.startsWith('video/') ?
                    'fa-file-video' :
                    fileType.startsWith('audio/') ?
                    'fa-file-audio' :
                    'fa-file';

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
        updateConversationList();
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
// UPDATE the initializeChatFunctionality function:
function initializeChatFunctionality() {
    // Remove existing event listeners first to prevent duplicates
    const sendButton = document.getElementById('sendButton');
    const newSendButton = sendButton.cloneNode(true);
    sendButton.parentNode.replaceChild(newSendButton, sendButton);

    const attachFileBtn = document.getElementById('attachFileBtn');
    const newAttachFileBtn = attachFileBtn.cloneNode(true);
    attachFileBtn.parentNode.replaceChild(newAttachFileBtn, attachFileBtn);

    const attachImageBtn = document.getElementById('attachImageBtn');
    const newAttachImageBtn = attachImageBtn.cloneNode(true);
    attachImageBtn.parentNode.replaceChild(newAttachImageBtn, attachImageBtn);

    const messageTextarea = document.getElementById('messageTextarea');
    const fileInput = document.getElementById('fileInput');
    const imageInput = document.getElementById('imageInput');
    const ChatAttachmentPreview = document.getElementById('ChatAttachmentPreview');
    
    let selectedFiles = [];

    // --- Disable inputs dynamically ---
    function updateInputStates() {
        const hasText = messageTextarea.value.trim().length > 0;
        const hasFiles = selectedFiles.length > 0;

        // Hide attach buttons when user types text
        if (hasText) {
            newAttachFileBtn.classList.add('d-none');
            newAttachImageBtn.classList.add('d-none');
        } else {
            newAttachFileBtn.classList.remove('d-none');
            newAttachImageBtn.classList.remove('d-none');
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
        ChatAttachmentPreview.innerHTML = '';
        if (selectedFiles.length > 0) {
            ChatAttachmentPreview.classList.remove('d-none');
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
                ChatAttachmentPreview.appendChild(item);
                updateInputStates();
            });
        } else {
            ChatAttachmentPreview.classList.add('d-none');
        }
    }

    // --- Remove attachment ---
    ChatAttachmentPreview.addEventListener('click', e => {
        if (e.target.closest('.remove-attachment')) {
            const index = e.target.closest('.remove-attachment').dataset.index;
            selectedFiles.splice(index, 1);
            renderAttachmentPreview();
            updateInputStates();
        }
    });

    // --- Add event listeners ---
    newAttachFileBtn.addEventListener('click', () => fileInput.click());
    newAttachImageBtn.addEventListener('click', () => imageInput.click());
    fileInput.addEventListener('change', handleFileSelect);
    imageInput.addEventListener('change', handleFileSelect);
    messageTextarea.addEventListener('input', updateInputStates);

    // --- Send Message ---
    function sendMessage() {
        const message = messageTextarea.value.trim();
        const currentConvId = window.conversationId;

        if (!message && selectedFiles.length === 0) {
            toastr.warning('Please type a message or attach a file.');
            return;
        }

        const formData = new FormData();
        formData.append('conversation_id', currentConvId);
        formData.append('message_type', selectedFiles.length > 0 ? 'file' : 'text');
        formData.append('content', message);

        selectedFiles.forEach(file => formData.append('attachments[]', file));

        fetch('{{ route("admin.customer.contact.messages.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
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

    newSendButton.addEventListener('click', sendMessage);
    
    // Initialize input states
    updateInputStates();
}

    // Scroll to bottom of chat
    function scrollToBottom() {
        const chatMessages = document.getElementById('chatMessages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // SEARCH FUNCTIONALITY:
    document.getElementById('contactSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const contactItems = document.querySelectorAll('.contact-item');

        contactItems.forEach(item => {
            const contactName = item.querySelector('.contact-name').textContent.toLowerCase();
            const lastMessage = item.querySelector('.contact-last-message').textContent.toLowerCase();

            if (contactName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });

    // ADD this at the end of your JavaScript:
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function(event) {
        const urlParams = new URLSearchParams(window.location.search);
        const urlConversationId = urlParams.get('conversation_id');
        
        if (urlConversationId) {
            loadSelectedConversation(urlConversationId);
        } else {
            // No conversation in URL, show no conversation state
            document.getElementById('noConversationState').style.display = 'flex';
            document.getElementById('chatInputContainer').style.display = 'none';
            document.getElementById('chatMessages').innerHTML = '';
            
            // Remove active state from all contacts
            document.querySelectorAll('.contact-item').forEach(item => {
                item.classList.remove('active');
            });
        }
    });
</script>

<script>
    //todo its temporary script need to move to proper place
    // Copy chat link to clipboard
    document.addEventListener('DOMContentLoaded', function() {
        const copyChatLinkBtn = document.getElementById('copyChatLinkBtn');
        
        if (copyChatLinkBtn) {
            copyChatLinkBtn.addEventListener('click', function() {
                const customerSpecialKey = '{{ $customer_contact->special_key }}';
                const chatUrl = `{{ url('/customer/chat') }}/${customerSpecialKey}`;
                
                // Copy to clipboard
                navigator.clipboard.writeText(chatUrl)
                    .then(() => {
                        // Show success feedback
                        const originalText = copyChatLinkBtn.innerHTML;
                        copyChatLinkBtn.innerHTML = '<i class="fas fa-check"></i> Copied!';
                        copyChatLinkBtn.disabled = true;
                        
                        // Revert after 2 seconds
                        setTimeout(() => {
                            copyChatLinkBtn.innerHTML = originalText;
                            copyChatLinkBtn.disabled = false;
                        }, 2000);
                        
                        // Optional: Show toast notification
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Chat link copied to clipboard!');
                        } else {
                            alert('Chat link copied to clipboard!');
                        }
                    })
                    .catch(err => {
                        console.error('Failed to copy: ', err);
                        alert('Failed to copy chat link. Please copy manually: ' + chatUrl);
                    });
            });
        }
    });
</script>
