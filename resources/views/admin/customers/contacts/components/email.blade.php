<!-- Add the email section with loader, refresh button, and fetch emails button -->
<div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">


    <div class="email-threading-row" style="margin-bottom: 15px;">
        <p class="activities-seprater d-none"> Thread email replies </p>
        <div style="margin-right: 10px; display: flex; justify-content: flex-end;">

            <button id="refresh-emails" class="btn btn-primary"
                style="padding: 8px; font-size: 14px; margin-right: 10px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-refresh" aria-hidden="true"></i>
            </button>
            <button id="fetch-emails" class="btn btn-success"
                style="padding: 8px; font-size: 14px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-download" aria-hidden="true"></i>
            </button>
        </div>
        <button class="threading-email-btn-one">
            Log Email
        </button>
        <button class="threading-email-btn-two open-email-form">
            Create Email
        </button>
    </div>



    <div>

        <div class="recent-activities">
            <div id="email-section">
                <ul class="nav nav-tabs" id="email-folders" style="margin-bottom: 15px;">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" data-folder="all">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-folder="inbox">Inbox</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-folder="sent">Sent</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-folder="drafts">Drafts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-folder="spam">Spam</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-folder="trash">Trash</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-folder="archive">Archive</a>
                    </li>
                </ul>

                <p class="date-by-order">{{ now()->format('F Y') }}</p>

                <div id="email-loader" style="display: none; text-align: center; padding: 20px;">
                    <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i> Loading emails...
                </div>
                <div id="email-content">
                    @include('admin.customers.contacts.partials.emails-list')
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const emailSection = document.getElementById('email-content');
        const emailLoader = document.getElementById('email-loader');
        const refreshButton = document.getElementById('refresh-emails');
        const fetchButton = document.getElementById('fetch-emails');
        const customerEmail = "{{ $customer_contact->email }}";
        let folder = 'all'; // Default to 'all' tab
        let currentPage = {{ $page }}; // Make page mutable for pagination
        const limit = 100;

        // Function to fetch emails
        function fetchEmails() {
            const folder = document.querySelector('#folder-select')?.value || 'inbox';
            const page = new URLSearchParams(window.location.search).get('page') || 1;
            const customerEmail = encodeURIComponent("{{ $customer_contact->email }}");
            console.log("{{$customer_contact->email}}");
            console.log(customerEmail);
    let url = "{{ route('admin.customer.contact.emails.fetch') }}" 
                + `?customer_email=${encodeURIComponent(customerEmail)}&folder=${folder}&page=${page}`;

    fetch(url, {
        method: "GET",
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        credentials: "same-origin" // 👈 ensures session cookie is sent
    })
                .then(response => response.json())
                .then(data => {
                    console.log(data);  
                    emailLoader.style.display = 'none';
                    emailSection.innerHTML = renderEmails(data.emails);
                    attachToggleListeners();
                    attachActivityToggleListeners();
                })
                .catch(error => {
                    emailLoader.style.display = 'none';
                    emailSection.innerHTML =
                        '<p class="text-muted">Failed to load emails. Please try again later.</p>';
                    console.error('Error fetching emails:', error);
                });
        }


        // Initial fetch
        // fetchEmails();

        // Refresh button click
        refreshButton.addEventListener('click', function() {
            fetchEmails();
        });

        // Fetch emails button click
        fetchButton.addEventListener('click', function() {
            // Show loader
            emailLoader.style.display = 'block';
            emailSection.innerHTML = ''; // Clear existing content

            // Make AJAX request to run Artisan command
            fetch(
                    "{{ route('admin.customer.contact.emails.fetch-new') }}" +
                    "?customer_email=" + encodeURIComponent(customerEmail), {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }
                )

                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        emailLoader.style.display = 'none';
                        emailSection.innerHTML = '<p class="text-muted">Error: ' + data.error +
                            '</p>';
                        return;
                    }

                    // After fetching new emails, refresh the email list
                    fetchEmails();
                })
                .catch(error => {
                    // Hide loader
                    emailLoader.style.display = 'none';
                    emailSection.innerHTML =
                        '<p class="text-muted">Failed to fetch new emails. Please try again later.</p>';
                    console.error('Error fetching new emails:', error);
                });
        });

        // Function to render emails
        function renderEmails(emails) {
            if (!emails || emails.length === 0) {
                return '<p class="text-muted">No emails found.</p>';
            }

            return emails.map(email => `
        <div class="email-box-container" style="margin: 0; border-radius: 0; margin-top: 15px; border: 1px solid #dee2e6; background: #fff; padding: 15px;">
            <div class="toggle-btnss" data-target=".${email.uuid}" style="cursor: pointer;">
                <div class="activ_head" style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="email-child-wrapper" style="display: flex; align-items: center;">
                        <i class="fa fa-caret-right" aria-hidden="true" style="margin-right: 10px; color: #007bff;"></i>
                        <div>
                            <h2 style="margin: 0; font-size: 16px; font-weight: 600; color: #212529;">
                                ${email.from[0].name || 'Unknown Sender'} - ${email.subject || '(No Subject)'}
                            </h2>
                            <p class="user_cont" style="margin: 2px 0; color: #6c757d; font-size: 12px;">
                                from: ${email.from[0].email || 'Unknown'}
                            </p>
                            <p class="user_cont" style="margin: 2px 0; color: #6c757d; font-size: 12px;">
                                to: ${email.to[0]?.email || 'Unknown'}
                            </p>
                            <p style="margin: 2px 0; color: #007bff; font-size: 12px;">
                                Opens: ${email.open_count || 0} | Clicks: ${email.click_count || 0}
                            </p>
                        </div>
                    </div>
                    <div style="text-align: right; min-width: 160px;">
                        <p style="margin: 2px 0; color: #6c757d; font-size: 12px;">
                            ${email.date ? new Date(email.date).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true }) : 'Unknown Date'}
                        </p>
                        ${email.attachments && email.attachments.length > 0 ? `
                            <p class="attachment-count" style="font-size: 12px; color: #6c757d; margin: 2px 0;">
                                <i class="fa fa-paperclip" aria-hidden="true"></i>
                                ${email.attachments.length} attachment${email.attachments.length > 1 ? 's' : ''}
                            </p>
                        ` : ''}
                    </div>
                </div>
            </div>
            <div class="contentdisplaytwo ${email.uuid}" style="display: none; margin-top: 15px; padding: 15px; border: 1px solid #eee; border-radius: 4px;">
                <!-- Activity Timeline -->
                <div class="activity-section" style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <h6 style="font-weight: 600; color: #212529; margin: 0;">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> Activity
                        </h6>
                        <button class="btn btn-sm btn-link toggle-activity" data-target="#timeline-${email.uuid}" style="text-decoration: none; color: #007bff; font-size: 12px;">
                            Minimize
                        </button>
                    </div>
                    <div id="timeline-${email.uuid}" class="timeline" style="position: relative; padding-left: 15px; border-left: 2px solid #dee2e6;">
                        ${email.events && email.events.length > 0 ? email.events.map(event => `
                            <div class="timeline-item" style="position: relative; margin-bottom: 15px;">
                                <div class="timeline-dot" style="position: absolute; left: -10px; top: 3px; width: 10px; height: 10px; background: #007bff; border-radius: 50%;"></div>
                                <div class="timeline-content" style="margin-left: 10px;">
                                    <p style="margin: 0; font-size: 12px; color: #212529;">
                                        <i class="fa ${event.icon}" aria-hidden="true"></i>
                                        ${event.type.charAt(0).toUpperCase() + event.type.slice(1)}
                                    </p>
                                    <small style="color: #6c757d; font-size: 11px;">
                                        ${new Date(event.timestamp).toLocaleString('en-US', { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true })}
                                    </small>
                                </div>
                            </div>
                        `).join('') : `
                            <div class="timeline-item" style="position: relative; margin-bottom: 15px;">
                                <div class="timeline-dot" style="position: absolute; left: -10px; top: 3px; width: 10px; height: 10px; background: #007bff; border-radius: 50%;"></div>
                                <div class="timeline-content" style="margin-left: 10px;">
                                    <p style="margin: 0; font-size: 12px; color: #212529;">
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        No activity recorded
                                    </p>
                                    <small style="color: #6c757d; font-size: 11px;">N/A</small>
                                </div>
                            </div>
                        `}
                    </div>
                </div>
                <!-- Email Body -->
                <div class="user_cont user-email-template" style="margin-bottom: 20px;">
                    <div class="email-preview" style="color: #212529; font-size: 14px;">
                        ${email.body.html || (email.body.text ? email.body.text.replace(/\n/g, '<br>') : 'No body content available.')}
                    </div>
                </div>
                <!-- Attachments -->
                ${email.attachments && email.attachments.length > 0 ? `
                    <div class="attachments-section" style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #eee;">
                        <h4 style="margin-bottom: 10px; color: #333; font-size: 16px; font-weight: 600;">
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
            if (fileType.includes('zip') || fileType.includes('rar') || fileType.includes('7z'))
                return 'fa-file-archive-o';
            return 'fa-file-o';
        }

        // Function to attach toggle listeners
        // Function to attach toggle listeners for activity section
        function attachActivityToggleListeners() {
            document.querySelectorAll('.toggle-activity').forEach(button => {
                button.addEventListener('click', function() {
                    const target = document.querySelector(this.dataset.target);
                    if (target.style.display === 'none' || target.style.display === '') {
                        target.style.display = 'block';
                        this.textContent = 'Minimize';
                    } else {
                        target.style.display = 'none';
                        this.textContent = 'Maximize';
                    }
                });
            });
        }

        // Existing attachToggleListeners function (unchanged)
        function attachToggleListeners() {
            document.querySelectorAll('.toggle-btnss').forEach(button => {
                button.addEventListener('click', function() {
                    const targetClass = this.getAttribute('data-target');
                    const content = this.parentElement.querySelector(targetClass);
                    if (content.style.display === 'none' || content.style.display === '') {
                        content.style.display = 'block';
                        this.querySelector('i.fa').classList.replace('fa-caret-right',
                            'fa-caret-down');
                    } else {
                        content.style.display = 'none';
                        this.querySelector('i.fa').classList.replace('fa-caret-down',
                            'fa-caret-right');
                    }
                });
            });
        }

        // Function to set active tab
        function setActiveTab(folder) {
            document.querySelectorAll('#email-folders .nav-link').forEach(tab => {
                tab.classList.remove('active');
                if (tab.getAttribute('data-folder') === folder) {
                    tab.classList.add('active');
                }
            });
        }


        // Attach tab click event listeners
        document.querySelectorAll('#email-folders .nav-link').forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();


                folder = this.getAttribute('data-folder');
                currentPage = 1; // Reset to first page
                setActiveTab(folder);

         fetchEmails();
            });
        });
        // Set initial active tab
        setActiveTab(folder);
    });
</script>
