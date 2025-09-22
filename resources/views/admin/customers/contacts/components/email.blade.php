<!-- Add the email section with loader, refresh button, and fetch emails button -->
<style>
    .contentdisplaytwo {
        background-color: #fff !important;
        border: none !important;
    }

    .timeline-content {
        border: none !important;
        box-shadow: none !important;
    }

    .activity-section {
        background-color: #fff
    }

    .timeline {
        position: relative;
        padding-left: 20px;
        margin-top: 10px;
        border-left: 2px solid #97a5b3;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1rem;
        padding-left: 15px;
    }

    .timeline-dot {
        position: absolute;
        left: -26px;
        top: 3px;
        width: 12px;
        height: 12px;
        background-color: #0d6;
        border-radius: 50%;
    }

    .timeline-content {
        background: #fff;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        border-radius: .5rem;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        margin: -11px -3px -15px -28px
    }
</style>
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
                <!-- Folders Tabs -->
                <ul class="nav nav-tabs" id="email-folders" style="margin-bottom: 15px;">
                    <li class="nav-item"><a class="nav-link active" href="#" data-folder="all">All</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-folder="inbox">Inbox</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-folder="sent">Sent</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-folder="drafts">Drafts</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-folder="spam">Spam</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-folder="trash">Trash</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" data-folder="archive">Archive</a></li>
                </ul>

                <p class="date-by-order">{{ now()->format('F Y') }}</p>

                <!-- Loader -->
                <div id="email-loader" style="display: none; text-align: center; padding: 20px;">
                    <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i> Loading emails...
                </div>

                <!-- Email Content -->
                <div id="email-content">
                    @if (empty($emails) || count($emails) === 0)
                        <p class="text-muted">No emails found.</p>
                    @else
                        @foreach ($emails as $email)
                            <!-- Email Box -->
                            <div class="email-box-container mb-4 border rounded bg-white p-3">
                                <!-- Header -->
                                <div class="toggle-btnss" data-target=".{{ $email['uuid'] }}" style="cursor: pointer;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Sender + Subject -->
                                        <div class="d-flex align-items-center">
                                            <i class="fa fa-caret-right me-2 text-primary"></i>
                                            <div>
                                                <h2 class="mb-0 fs-6 fw-semibold text-dark">
                                                    {{ $email['from'][0]['name'] ?? 'Unknown Sender' }} -
                                                    {{ $email['subject'] ?? '(No Subject)' }}
                                                </h2>
                                                <p class="mb-1 text-muted small">
                                                    from: {{ $email['from'][0]['email'] ?? 'Unknown' }}
                                                </p>
                                                <p class="mb-0 text-muted small">
                                                    to: {{ $email['to'][0]['email'] ?? 'Unknown' }}
                                                </p>
                                                <p class="mb-0 text-primary small">
                                                    Opens: {{ $email['open_count'] ?? 0 }} |
                                                    Clicks: {{ $email['click_count'] ?? 0 }}
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Date + Attachments -->
                                        <div class="text-end" style="min-width: 160px;">
                                            <p class="mb-1 text-muted small">
                                                {{ !empty($email['date']) ? \Carbon\Carbon::parse($email['date'])->format('M d, Y h:i A') : 'Unknown Date' }}
                                            </p>
                                            @if (!empty($email['attachments']) && count($email['attachments']) > 0)
                                                <p class="mt-1 mb-0 text-muted small">
                                                    <i class="fa fa-paperclip"></i>
                                                    {{ count($email['attachments']) }}
                                                    attachment{{ count($email['attachments']) > 1 ? 's' : '' }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Collapsible Content -->
                                <div class="contentdisplaytwo {{ $email['uuid'] }} mt-3 p-3 rounded border bg-light"
                                    style="display: none;">
                                    <!-- Activity -->
                                    <div class="activity-section">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="fw-semibold text-dark mb-0">
                                                <i class="fa fa-clock-o"></i> Activity
                                            </h6>
                                            <button class="btn btn-sm btn-link toggle-activity"
                                                data-target="#timeline-{{ $email['uuid'] }}">
                                                Minimize
                                            </button>
                                        </div>
                                        <div id="timeline-{{ $email['uuid'] }}" class="timeline">
                                            @forelse ($email['events'] ?? [] as $event)
                                                <div class="timeline-item">
                                                    <div class="timeline-dot"></div>
                                                    <div class="timeline-content">
                                                        <p class="mb-0 small">
                                                            <i class="fa {{ $event['icon'] }}"></i>
                                                            {{ ucfirst($event['type']) }}
                                                        </p>
                                                        <small class="text-muted">
                                                            {{ \Carbon\Carbon::parse($event['timestamp'])->format('M d, Y h:i A') }}
                                                        </small>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="timeline-item">
                                                    <div class="timeline-dot"></div>
                                                    <div class="timeline-content">
                                                        <p class="mb-0 small"><i class="fa fa-info-circle"></i> No
                                                            activity recorded</p>
                                                        <small class="text-muted">N/A</small>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    <!-- Email Body -->
                                    <div class="email-preview mb-4 text-dark small">
                                        {!! $email['body']['html'] ?? nl2br($email['body']['text'] ?? 'No body content available.') !!}
                                    </div>

                                    <!-- Attachments -->
                                    @if (!empty($email['attachments']) && count($email['attachments']) > 0)
                                        <div class="attachments-section mb-4">
                                            <h6 class="fw-semibold text-dark mb-2">
                                                <i class="fa fa-paperclip"></i> Attachments
                                                ({{ count($email['attachments']) }})
                                            </h6>
                                            <div class="attachments-list">
                                                @foreach ($email['attachments'] as $attachment)
                                                    <div
                                                        class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                                                        <div class="me-2 text-muted fs-5"><i class="fa fa-file-o"></i>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="fw-medium">
                                                                {{ $attachment['filename'] ?? 'Unknown File' }}</div>
                                                            <div class="text-muted small">
                                                                Type:
                                                                {{ strtoupper($attachment['type'] ?? 'unknown') }}
                                                                @if (!empty($attachment['size']))
                                                                    | Size:
                                                                    {{ number_format($attachment['size'] / 1024, 1) }}
                                                                    KB
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <a href="{{ $attachment['download_url'] ?? '#' }}"
                                                                class="btn btn-sm btn-outline-primary">
                                                                <i class="fa fa-download"></i> Download
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
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
    console.log("🔄 Fetching emails...");
    console.log("📂 Folder:", folder, "📧 Customer Email:", customerEmail);

    let url = "{{ route('admin.customer.contact.emails.fetch') }}" +
        `?customer_email=${encodeURIComponent(customerEmail)}&folder=${folder}&page=${currentPage}`;

    console.log("➡️ API URL:", url);

    emailLoader.style.display = 'block';
    emailSection.innerHTML = '';

    fetch(url, {
        method: "GET",
        headers: {
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest"
        },
        credentials: "same-origin"
    })
    .then(response => response.json())
    .then(data => {
        console.log("✅ Emails fetched:", data);

        emailLoader.style.display = 'none';

        if (!data.emails) {
            console.warn("⚠️ No 'emails' key in response:", data);
            emailSection.innerHTML = '<p class="text-muted">No emails key found in response</p>';
            return;
        }

        emailSection.innerHTML = renderEmails(data.emails);
        attachToggleListeners();
        attachActivityToggleListeners();
    })
    .catch(error => {
        emailLoader.style.display = 'none';
        emailSection.innerHTML = '<p class="text-muted">Failed to load emails. Please try again later.</p>';
        console.error("❌ Error fetching emails:", error);
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
    console.log("📩 Fetching NEW emails for:", customerEmail);

    emailLoader.style.display = 'block';
    emailSection.innerHTML = '';

    fetch("{{ route('admin.customer.contact.emails.fetch-new') }}" +
        "?customer_email=" + encodeURIComponent(customerEmail), {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("✅ Fetch-new response:", data);

        if (data.error) {
            emailLoader.style.display = 'none';
            emailSection.innerHTML = '<p class="text-muted">Error: ' + data.error + '</p>';
            return;
        }

        fetchEmails(); // refresh emails
    })
    .catch(error => {
        emailLoader.style.display = 'none';
        console.error("❌ Error fetching new emails:", error);
        emailSection.innerHTML = '<p class="text-muted">Failed to fetch new emails. Please try again later.</p>';
    });
});


function renderEmails(emails) {
    console.log("🖼 Rendering emails:", emails);

    if (!emails || emails.length === 0) {
        return '<p class="text-muted">No emails found.</p>';
    }

    // helper for date formatting
    const formatDate = (dateStr) => {
        if (!dateStr) return 'Unknown Date';
        return new Date(dateStr).toLocaleString('en-US', {
            month: 'short',
            day: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        });
    };

    return emails.map(email => `
        <!-- Email Box -->
        <div class="email-box-container mb-4 border rounded bg-white p-3">
            <!-- Header -->
            <div class="toggle-btnss" data-target=".${email.uuid}" style="cursor: pointer;">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Sender + Subject -->
                    <div class="d-flex align-items-center">
                        <i class="fa fa-caret-right me-2 text-primary"></i>
                        <div>
                            <h2 class="mb-0 fs-6 fw-semibold text-dark">
                                ${(email.from?.[0]?.name) || 'Unknown Sender'} - ${(email.subject) || '(No Subject)'}
                            </h2>
                            <p class="mb-1 text-muted small">from: ${(email.from?.[0]?.email) || 'Unknown'}</p>
                            <p class="mb-0 text-muted small">to: ${(email.to?.[0]?.email) || 'Unknown'}</p>
                            <p class="mb-0 text-primary small">
                                Opens: ${email.open_count ?? 0} | Clicks: ${email.click_count ?? 0}
                            </p>
                        </div>
                    </div>

                    <!-- Date + Attachments -->
                    <div class="text-end" style="min-width: 160px;">
                        <p class="mb-1 text-muted small">
                            ${formatDate(email.date)}
                        </p>
                        ${email.attachments && email.attachments.length > 0 ? `
                            <p class="mt-1 mb-0 text-muted small">
                                <i class="fa fa-paperclip"></i> ${email.attachments.length} 
                                attachment${email.attachments.length > 1 ? 's' : ''}
                            </p>` : ''}
                    </div>
                </div>
            </div>

            <!-- Collapsible Content -->
            <div class="contentdisplaytwo ${email.uuid} mt-3 p-3 rounded border bg-light" style="display: none;">
                <!-- Activity -->
                <div class="activity-section">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h6 class="fw-semibold text-dark mb-0">
                            <i class="fa fa-clock-o"></i> Activity
                        </h6>
                        <button class="btn btn-sm btn-link toggle-activity" data-target="#timeline-${email.uuid}">
                            Minimize
                        </button>
                    </div>
                    <div id="timeline-${email.uuid}" class="timeline">
                        ${(email.events && email.events.length > 0)
                            ? email.events.map(event => `
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <p class="mb-0 small">
                                            <i class="fa ${event.icon}"></i> ${event.type.charAt(0).toUpperCase() + event.type.slice(1)}
                                        </p>
                                        <small class="text-muted">
                                            ${formatDate(event.timestamp)}
                                        </small>
                                    </div>
                                </div>`).join('')
                            : `
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <p class="mb-0 small"><i class="fa fa-info-circle"></i> No activity recorded</p>
                                        <small class="text-muted">N/A</small>
                                    </div>
                                </div>`
                        }
                    </div>
                </div>

                <!-- Email Body -->
                <div class="email-preview mb-4 text-dark small">
                    ${email.body?.html || (email.body?.text ? email.body.text.replace(/\n/g, '<br>') : 'No body content available.')}
                </div>

                <!-- Attachments -->
                ${email.attachments && email.attachments.length > 0 ? `
                    <div class="attachments-section mb-4">
                        <h6 class="fw-semibold text-dark mb-2">
                            <i class="fa fa-paperclip"></i> Attachments (${email.attachments.length})
                        </h6>
                        <div class="attachments-list">
                            ${email.attachments.map(attachment => `
                                <div class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                                    <div class="me-2 text-muted fs-5"><i class="fa fa-file-o"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">${attachment.filename || 'Unknown File'}</div>
                                        <div class="text-muted small">
                                            Type: ${(attachment.type || 'unknown').toUpperCase()}
                                            ${attachment.size ? ` | Size: ${(attachment.size / 1024).toFixed(1)} KB` : ''}
                                        </div>
                                    </div>
                                    <div>
                                        <a href="${attachment.download_url || '#'}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>` : ''}
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
<!-- Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle activity minimize/maximize
        document.querySelectorAll(".toggle-activity").forEach(btn => {
            btn.addEventListener("click", function() {
                const target = document.querySelector(this.dataset.target);
                if (target.style.display === "none") {
                    target.style.display = "block";
                    this.textContent = "Minimize";
                } else {
                    target.style.display = "none";
                    this.textContent = "Maximize";
                }
            });
        });
    });
</script>
