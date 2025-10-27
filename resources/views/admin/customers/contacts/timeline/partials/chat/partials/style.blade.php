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

    .customer-chat-link {
        background: none;
        border: none;
        color: var(--gray-color);
        margin-right: 15px;
        cursor: pointer;
        font-size: 0.6rem;
    }

    .customer-chat-link:hover {
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

    .chat-sidebar {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 10px;
        height: 400px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
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