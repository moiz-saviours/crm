<!-- Add the email section with loader, refresh button, and fetch emails button -->
<div id="email-section">
    <div style="margin-bottom: 15px; display: flex; justify-content: flex-end;">
        <button id="refresh-emails" class="btn btn-primary" style="padding: 8px; font-size: 14px; margin-right: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-refresh" aria-hidden="true"></i>
        </button>
        <button id="fetch-emails" class="btn btn-success" style="padding: 8px; font-size: 14px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
            <i class="fa fa-download" aria-hidden="true"></i>
        </button>
    </div>
    <div id="email-loader" style="display: none; text-align: center; padding: 20px;">
        <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i> Loading emails...
    </div>
    <div id="email-content">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailSection = document.getElementById('email-content');
        const emailLoader = document.getElementById('email-loader');
        const refreshButton = document.getElementById('refresh-emails');
        const fetchButton = document.getElementById('fetch-emails');
        const customerEmail = "{{ $customer_contact->email }}";
        let folder = "{{ $folder }}"; // Make folder mutable for dynamic updates
        let currentPage = {{ $page }}; // Make page mutable for pagination
        const limit = 100;

        // Function to fetch emails
        function fetchEmails() {
            // Show loader
            emailLoader.style.display = 'block';
            emailSection.innerHTML = ''; // Clear existing content

            // Make AJAX request to fetch emails
            fetch('/admin/customer/contact/emails/fetch?customer_email=' + encodeURIComponent(customerEmail) + '&folder=' + encodeURIComponent(folder) + '&page=' + currentPage + '&limit=' + limit, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Hide loader
                emailLoader.style.display = 'none';

                if (data.error) {
                    emailSection.innerHTML = '<p class="text-muted">Error: ' + data.error + '</p>';
                    return;
                }

                // Update email content
                emailSection.innerHTML = renderEmails(data.emails);

                // Re-attach toggle event listeners
                attachToggleListeners();
            })
            .catch(error => {
                // Hide loader
                emailLoader.style.display = 'none';
                emailSection.innerHTML = '<p class="text-muted">Failed to load emails. Please try again later.</p>';
                console.error('Error fetching emails:', error);
            });
        }

        // Initial fetch
        fetchEmails();

        // Refresh button click
        refreshButton.addEventListener('click', function () {
            fetchEmails();
        });

        // Fetch emails button click
        fetchButton.addEventListener('click', function () {
            // Show loader
            emailLoader.style.display = 'block';
            emailSection.innerHTML = ''; // Clear existing content

            // Make AJAX request to run Artisan command
            fetch('/admin/customer/contact/emails/fetch-new?customer_email=' + encodeURIComponent(customerEmail), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    emailLoader.style.display = 'none';
                    emailSection.innerHTML = '<p class="text-muted">Error: ' + data.error + '</p>';
                    return;
                }

                // After fetching new emails, refresh the email list
                fetchEmails();
            })
            .catch(error => {
                // Hide loader
                emailLoader.style.display = 'none';
                emailSection.innerHTML = '<p class="text-muted">Failed to fetch new emails. Please try again later.</p>';
                console.error('Error fetching new emails:', error);
            });
        });

        // Function to render emails
        function renderEmails(emails) {
            if (!emails || emails.length === 0) {
                return '<p class="text-muted">No emails found.</p>';
            }

            return emails.map(email => `
                <div class="email-box-container" style="margin: 0; border-radius: 0; margin-top: 15px;">
                    <div class="toggle-btnss" data-target="#${email.uuid}">
                        <div class="activ_head">
                            <div class="email-child-wrapper">
                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                <div>
                                    <h2>${email.from[0].name || 'Unknown Sender'} - ${email.subject || '(No Subject)'}</h2>
                                    <p class="user_cont">from: ${email.from[0].email || 'Unknown'}</p>
                                    <p class="user_cont">to: ${email.to[0]?.email || 'Unknown'}</p>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <p>${email.date ? new Date(email.date).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true }) : 'Unknown Date'}</p>
                                ${email.attachments && email.attachments.length > 0 ? `
                                    <p class="attachment-count" style="font-size: 12px; color: #666; margin: 2px 0;">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                        ${email.attachments.length} attachment${email.attachments.length > 1 ? 's' : ''}
                                    </p>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                    <div id="${email.uuid}" class="contentdisplaytwo" style="display: none;">
                        <div class="user_cont user-email-template">
                            <div class="email-preview">
                                ${email.body.html || (email.body.text ? email.body.text.replace(/\n/g, '<br>') : '')}
                            </div>
                            ${email.attachments && email.attachments.length > 0 ? `
                                <div class="attachments-section" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                                    <h4 style="margin-bottom: 10px; color: #333;">
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                        Attachments (${email.attachments.length})
                                    </h4>
                                    <div class="attachments-list">
                                        ${email.attachments.map(attachment => `
                                            <div class="attachment-item" style="display: flex; align-items: center; padding: 8px 12px; background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 4px; margin-bottom: 8px;">
                                                <div class="attachment-icon" style="margin-right: 10px; font-size: 16px; color: #6c757d;">
                                                    <i class="fa ${getAttachmentIcon(attachment.type)}" aria-hidden="true"></i>
                                                </div>
                                                <div class="attachment-info" style="flex: 1;">
                                                    <div class="attachment-name" style="font-weight: 500; color: #212529;">
                                                        ${attachment.filename || 'Unknown File'}
                                                    </div>
                                                    <div class="attachment-details" style="font-size: 12px; color: #6c757d;">
                                                        Type: ${attachment.type.toUpperCase() || 'unknown'}
                                                        ${attachment.size ? ` | Size: ${(attachment.size / 1024).toFixed(1)} KB` : ''}
                                                    </div>
                                                </div>
                                                <div class="attachment-actions">
                                                    ${attachment.download_url ? `
                                                        <a href="${attachment.download_url}" 
                                                           download="${attachment.filename || 'attachment'}" 
                                                           class="btn btn-sm btn-outline-primary" 
                                                           style="text-decoration: none; padding: 4px 8px; border: 1px solid #007bff; color: #007bff; border-radius: 3px; font-size: 12px;">
                                                            <i class="fa fa-download" aria-hidden="true"></i> Download
                                                        </a>
                                                    ` : `
                                                        <span class="text-muted" style="font-size: 12px;">
                                                            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                                            No download link
                                                        </span>
                                                    `}
                                                </div>
                                            </div>
                                        `).join('')}
                                    </div>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Function to determine attachment icon based on MIME type
        function getAttachmentIcon(type) {
            const fileType = type.toLowerCase();
            if (fileType.includes('pdf')) return 'fa-file-pdf-o';
            if (fileType.includes('word')) return 'fa-file-word-o';
            if (fileType.includes('excel')) return 'fa-file-excel-o';
            if (fileType.includes('powerpoint')) return 'fa-file-powerpoint-o';
            if (fileType.includes('image')) return 'fa-file-image-o';
            if (fileType.includes('text')) return 'fa-file-text-o';
            if (fileType.includes('zip') || fileType.includes('rar') || fileType.includes('7z')) return 'fa-file-archive-o';
            return 'fa-file-o';
        }

        // Function to attach toggle listeners
        function attachToggleListeners() {
            document.querySelectorAll('.toggle-btnss').forEach(button => {
                button.addEventListener('click', function () {
                    const targetId = this.getAttribute('data-target');
                    const content = document.querySelector(targetId);
                    if (content.style.display === 'none') {
                        content.style.display = 'block';
                        this.querySelector('i.fa').classList.replace('fa-caret-right', 'fa-caret-down');
                    } else {
                        content.style.display = 'none';
                        this.querySelector('i.fa').classList.replace('fa-caret-down', 'fa-caret-right');
                    }
                });
            });
        }
    });
</script>