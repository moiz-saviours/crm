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
        background-color: white;
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
        background-color: var(--bs-card-color);
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
        border: 1px solid var(--bs-primary);;
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
        color: var(--bs-primary);
    }

    .message-textarea {
        width: 100%;
        border: none;
        padding: 12px 15px;
        resize: none;
        min-height: 60px;
        max-height: 120px; /* Optional: set max height */
        outline: none;
        font-family: inherit;
        overflow-y: auto; /* Show scrollbar when needed */
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
        background-color: var(--bs-card-color);;
        border-top: 1px solid var(--light-gray);
    }

    .attachment-item {
        display: flex;
        align-items: center;
        background-color: white;
        border: 1px solid var(--bs-primary);;
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
    color: var(--bs-primary);;
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
        <div class="customer-info">
            <div class="customer-avatar">JD</div>
            <div>
                <h5>John Doe</h5>
                <div class="chat-status">
                    <span class="status-indicator"></span>
                    <span>Online</span>
                </div>
            </div>
        </div>
        <div>
            <span class="text-light">Customer ID: CUST-12345</span>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="chat-messages">
        <div class="message received">
            <div class="message-avatar" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="JD">JD</div>
            <div class="message-bubble">
                <div>Hi there! I wanted to follow up on my order #ORD-789. Has it shipped yet?</div>
                <div class="message-time">10:15 AM</div>
            </div>
        </div>

        <div class="message sent">
            <div class="message-bubble">
                <div>Hello John! I've checked your order and it was shipped yesterday. You should receive a
                    tracking number soon.</div>
                <div class="message-time">10:18 AM</div>
            </div>
            <div class="message-avatar" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="ME">ME</div>
        </div>

        <div class="message received">
            <div class="message-avatar" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="JD">JD</div>
            <div class="message-bubble">
                <div>That's great to hear! I've also attached the screenshot of the issue I mentioned in my
                    last email.</div>
                <div class="message-time">10:22 AM</div>
            </div>
        </div>

        <div class="message sent">
            <div class="message-bubble">
                <div>Thanks for sending that over. I can see the issue now. Our team is working on a fix and
                    we'll update you by tomorrow.</div>
                <div class="message-time">10:25 AM</div>
            </div>
            <div class="message-avatar" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="ME">ME</div>
        </div>

        <div class="message received">
            <div class="message-avatar" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="JD">JD</div>
            <div class="message-bubble">
                <div>Perfect! Also, I wanted to ask about the warranty on the product I purchased.</div>
                <div class="message-time">10:30 AM</div>
            </div>
        </div>
    </div>

    <!-- Attachment Preview -->
    <div class="attachment-preview d-none">
        <div class="attachment-item">
            <i class="fas fa-file-pdf"></i>
            warranty-info.pdf
            <span class="remove-attachment"><i class="fas fa-times"></i></span>
        </div>
        <div class="attachment-item">
            <i class="fas fa-file-image"></i>
            issue-screenshot.png
            <span class="remove-attachment"><i class="fas fa-times"></i></span>
        </div>
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

            <textarea class="message-textarea" placeholder="Type your message here..."></textarea>

            <div class="editor-actions">
                <div class="attachment-options">
                    <button class="attachment-btn" title="Attach File">
                        <i class="fas fa-paperclip"></i> Attach File
                    </button>
                    <button class="attachment-btn" title="Insert Image">
                        <i class="fas fa-image"></i> Image
                    </button>
                </div>

                <button class="send-btn">
                    Send <i class="fas fa-paper-plane ms-1"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    // Basic chat functionality
    document.addEventListener('DOMContentLoaded', function() {
        const messageTextarea = document.querySelector('.message-textarea');
        const sendButton = document.querySelector('.send-btn');
        const chatMessages = document.querySelector('.chat-messages');
        const attachmentPreview = document.querySelector('.attachment-preview');
        const removeAttachmentButtons = document.querySelectorAll('.remove-attachment');
        const attachFileBtn = document.querySelector('.attachment-btn:nth-child(1)');
        const attachImageBtn = document.querySelector('.attachment-btn:nth-child(2)');

        // Function to add a new message
function addMessage(content, isSent = true) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${isSent ? 'sent' : 'received'}`;
    
    // Add avatar with Bootstrap tooltip
    const avatar = document.createElement('div');
    avatar.className = 'message-avatar';
    avatar.textContent = isSent ? 'ME' : 'JD';
    avatar.setAttribute('data-bs-toggle', 'tooltip');
    avatar.setAttribute('data-bs-placement', 'top');
    avatar.setAttribute('title', isSent ? 'You' : 'John Doe');
    
    const messageBubble = document.createElement('div');
    messageBubble.className = 'message-bubble';

    // Create header with time only (no username)
    const messageHeader = document.createElement('div');
    messageHeader.className = 'message-header';

    const timeDiv = document.createElement('div');
    timeDiv.className = 'message-time';
    const now = new Date();
    timeDiv.textContent = now.toLocaleTimeString([], {
        hour: '2-digit',
        minute: '2-digit'
    });

    // Add time to header
    messageHeader.appendChild(timeDiv);

    const contentDiv = document.createElement('div');
    contentDiv.textContent = content;

    // Add header and content to bubble
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

    // Initialize Bootstrap tooltip for the new avatar
    new bootstrap.Tooltip(avatar);

    // Scroll to bottom
    chatMessages.scrollTop = chatMessages.scrollHeight;

    // Clear textarea
    messageTextarea.value = '';
}

        // Send message on button click
        sendButton.addEventListener('click', function() {
            const message = messageTextarea.value.trim();
            if (message) {
                addMessage(message, true);

                // Simulate a reply after a short delay
                setTimeout(() => {
                    const replies = [
                        "Thanks for your message!",
                        "I'll check on that and get back to you.",
                        "That sounds good to me.",
                        "Let me verify that information.",
                        "I appreciate you reaching out."
                    ];
                    const randomReply = replies[Math.floor(Math.random() * replies.length)];
                    addMessage(randomReply, false);
                }, 1000);
            }
        });

        // Send message on Enter key (but allow Shift+Enter for new line)
        messageTextarea.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendButton.click();
            }
        });

        // Remove attachment
        removeAttachmentButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.attachment-item').remove();

                // Hide attachment preview if no attachments left
                if (attachmentPreview.children.length === 0) {
                    attachmentPreview.style.display = 'none';
                }
            });
        });

        // Formatting buttons (basic implementation)
        const formattingButtons = document.querySelectorAll('.editor-toolbar button');
        formattingButtons.forEach(button => {
            button.addEventListener('click', function() {
                // In a real implementation, this would apply formatting to selected text
                alert('Formatting feature would be implemented in a full version');
            });
        });

        // Attachment functionality
        attachFileBtn.addEventListener('click', function() {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = '.pdf,.doc,.docx,.txt';
            fileInput.style.display = 'none';
            document.body.appendChild(fileInput);

            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    addAttachment(file.name, 'file');
                }
                document.body.removeChild(fileInput);
            });

            fileInput.click();
        });

        attachImageBtn.addEventListener('click', function() {
            const imageInput = document.createElement('input');
            imageInput.type = 'file';
            imageInput.accept = 'image/*';
            imageInput.style.display = 'none';
            document.body.appendChild(imageInput);

            imageInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    const file = this.files[0];
                    addAttachment(file.name, 'image');
                }
                document.body.removeChild(imageInput);
            });

            imageInput.click();
        });

        function addAttachment(filename, type) {
            // Show attachment preview if hidden
            if (attachmentPreview.style.display === 'none') {
                attachmentPreview.style.display = 'flex';
            }

            const attachmentItem = document.createElement('div');
            attachmentItem.className = 'attachment-item';

            const icon = document.createElement('i');
            icon.className = type === 'image' ? 'fas fa-file-image' : 'fas fa-file-pdf';

            const nameSpan = document.createElement('span');
            nameSpan.textContent = filename;

            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-attachment';
            removeBtn.innerHTML = '<i class="fas fa-times"></i>';

            attachmentItem.appendChild(icon);
            attachmentItem.appendChild(nameSpan);
            attachmentItem.appendChild(removeBtn);

            attachmentPreview.appendChild(attachmentItem);

            // Add event listener to the new remove button
            removeBtn.addEventListener('click', function() {
                attachmentItem.remove();

                // Hide attachment preview if no attachments left
                if (attachmentPreview.children.length === 0) {
                    attachmentPreview.style.display = 'none';
                }
            });
        }

        // Auto-expand textarea based on content
        messageTextarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
            
            // Optional: Limit max height and show scrollbar
            if (this.scrollHeight > 120) {
                this.style.height = '120px';
                this.style.overflowY = 'auto';
            } else {
                this.style.overflowY = 'hidden';
            }
        });

        // Reset height when message is sent
        sendButton.addEventListener('click', function() {
            messageTextarea.style.height = '60px';
            messageTextarea.style.overflowY = 'hidden';
        });
    });
</script>
