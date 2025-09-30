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
<div class="email-threading-row" style="margin-bottom: 15px;">
    <p class="activities-seprater d-none"> Thread email replies </p>

    <button class="threading-email-btn-one d-none">
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
            <ul class="nav nav-tabs d-none" id="email-folders" style="margin-bottom: 15px;">
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
                @if (empty($emails) || count($emails) == 0)
                    <p class="text-muted">No emails found.</p>
                @else
                    @include('admin.customers.contacts.timeline.static-content.email')

                    @foreach ($emails as $email)
                        @include('admin.customers.contacts.timeline.partials.card-box.email')
                    @endforeach
                @endif
            </div>

            <!-- Show More Button -->
            <div id="show-more-container" class="text-center mt-3">
                <button id="show-more-btn" class="btn btn-outline-primary btn-sm">
                    Show More
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailSection = document.getElementById('email-content');
        const emailLoader = document.getElementById('email-loader');
        const refreshButton = document.getElementById('refresh-emails');
        const fetchButton = document.getElementById('fetch-emails');
        const showMoreContainer = document.getElementById('show-more-container');
        const showMoreBtn = document.getElementById('show-more-btn');
        const customerEmail = "{{ $customer_contact->email }}";
        let folder = 'all';
        let currentPage = {{ $page }};
        const limit = 100;

        // ✅ Show More click handler
        showMoreBtn.addEventListener("click", function () {
            currentPage++;
            fetchEmails(true); // append
        });

        // ✅ Visibility toggle
        function toggleShowMoreVisibility(data) {
            if (!data.emails || data.emails.length < data.limit) {
                showMoreContainer.style.display = "none";
            } else {
                showMoreContainer.style.display = "block";
            }
        }

      
        //fetch emails
        function fetchEmails(append = false) {
            console.log("📩 Fetching emails page:", currentPage);

            emailLoader.style.display = 'block';

            fetch("{{ route('admin.customer.contact.emails.fetch') }}" +
                "?customer_email=" + encodeURIComponent(customerEmail) +
                "&folder=" + encodeURIComponent(folder) +
                "&page=" + currentPage +
                "&limit=" + limit, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    emailLoader.style.display = 'none';

                    if (data.error) {
                        emailSection.insertAdjacentHTML('beforeend',
                            `<p class="text-danger">${data.error}</p>`);
                        return;
                    }

                    if (!data.emails || data.emails.length === 0) {
                        if (currentPage === 1) {
                            emailSection.innerHTML = '<p class="text-muted">No emails found.</p>';
                        }
                        showMoreContainer.style.display = 'none';
                        return;
                    }

                    const html = renderEmails(data.emails);
                    if (append) {
                        emailSection.insertAdjacentHTML('beforeend', html);
                    } else {
                        emailSection.innerHTML = html;
                    }

                    attachActivityToggleListeners();

                    // 👇 control Show More visibility
                    toggleShowMoreVisibility(data);
                })
                .catch(error => {
                    emailLoader.style.display = 'none';
                    console.error("❌ Error fetching emails:", error);
                    emailSection.insertAdjacentHTML('beforeend',
                        '<p class="text-danger">Failed to fetch emails.</p>');
                });
        }

        // Refresh button: reset to first page & reload
        refreshButton.addEventListener('click', function () {
            currentPage = 1;
            fetchEmails(false); // reload first page
        });

        // fetch new emails
        fetchButton.addEventListener('click', function () {
            console.log("📩 Fetching NEW emails for:", customerEmail);
            emailLoader.style.display = 'block';

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
                    emailLoader.style.display = 'none';

                    if (data.error) {
                        emailSection.insertAdjacentHTML('afterbegin',
                            `<p class="text-danger">Error: ${data.error}</p>`);
                        return;
                    }

                    if (data.emails && data.emails.length > 0) {
                        const html = renderEmails(data.emails);
                        emailSection.insertAdjacentHTML('afterbegin', html);
                        attachActivityToggleListeners();
                    } else {
                        emailSection.insertAdjacentHTML('afterbegin',
                            '<p class="text-muted">No new emails.</p>');
                    }
                })
                .catch(error => {
                    emailLoader.style.display = 'none';
                    console.error("❌ Error fetching new emails:", error);
                    emailSection.insertAdjacentHTML('afterbegin',
                        '<p class="text-muted">Failed to fetch new emails. Please try again later.</p>'
                    );
                });
        });

        //Render Emails
    function renderEmails(emails) {
    if (!emails || emails.length === 0) {
        return '<p class="text-muted">No emails found.</p>';
    }

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

    const formatRecipients = (recipients) => {
        let data = recipients;
        if (typeof data === 'string') {
            try {
                data = JSON.parse(data);
            } catch {
                return data;
            }
        }
        if (Array.isArray(data)) {
            return data.map(r => r.email || r.name || 'Unknown').join(', ');
        }
        return data || 'Unknown';
    };

    return emails.map(email => {
        const isHtmlEmpty = !email.body?.html || !email.body.html.trim().replace(/<[^>]*>/g, '');
        const previewContent = isHtmlEmpty
            ? (email.body?.text || 'No body content available.').substring(0, 100)
            : email.body.html.replace(/<[^>]*>/g, '').substring(0, 100) + '...';

        const avatarLetters = email.from?.name?.slice(0, 2) || email.from?.email?.slice(0, 2) || '??';

        return `
        <div class="email-box-container mb-4 border rounded bg-white p-3" style="margin:0; border-radius:0;">
            <!-- Header -->
            <div class="toggle-btnss" data-target=".content-${email.uuid}" style="cursor:pointer;">
                <div class="activ_head d-flex justify-content-between">
                    <div class="email-child-wrapper d-flex align-items-start">
                        <i class="fa fa-caret-right me-2 text-primary"></i>
                        <div>
                            <h2 class="mb-0 fs-6 fw-semibold text-dark">
                                ${email.subject || '(No Subject)'}
                                <span class="user_cont">from ${email.from?.name || email.from?.email || 'Unknown'}</span>
                            </h2>
                            <p class="user_cont mb-1">from: ${email.from?.email || 'Unknown'}</p>
                            <p class="user_cont mb-0">to: ${formatRecipients(email.to)}</p>
                            ${email.open_count > 0 && email.type === 'outgoing' && email.folder === 'sent' ? `
                                <p class="mb-0 text-primary small">
                                    Opens: ${email.open_count} | Clicks: ${email.click_count || 0}
                                </p>
                            ` : ''}
                        </div>
                    </div>
                    <p class="mb-0 small text-muted">${formatDate(email.date)}</p>
                </div>
            </div>

            <!-- Preview (hidden short body) -->
            <div class="user-cont-hide">
                <div class="user_cont user-cont-hide text-muted small">
                    ${previewContent}
                </div>
            </div>

            <!-- Expanded content -->
            <div class="contentdisplaytwo content-${email.uuid}" style="display:none;">
                <div class="new-profile-parent-wrapper">
                    <div class="new-profile-email-wrapper d-flex mb-2">
                        <div class="user_profile_img me-2">
                            <div class="avatarr">${avatarLetters.toUpperCase()}</div>
                        </div>
                        <div class="user_profile_text">
                            <p class="mb-1 fw-bold">${email.from?.name || email.from?.email || 'Unknown'}</p>
                            <p class="mb-0">to: ${formatRecipients(email.to)}</p>
                        </div>
                    </div>

                    <div class="new-profile-email-wrapper d-flex mb-2">
                        <div class="activities-seprater reply-btn me-2"
                            data-from="${email.from?.email || ''}"
                            data-subject="${email.subject || ''}"
                            data-date="${formatDate(email.date)}"
                            data-body='${JSON.stringify(email.body?.html || email.body?.text || '')}'
                            data-thread-id="${email.thread_id || ''}"
                            data-in-reply-to="${email.message_id || ''}"
                            data-references='${JSON.stringify(email.references || null)}'>
                            Reply
                        </div>
                        <div class="activities-seprater open-form-btn me-2">Forward</div>
                        <div class="activities-seprater open-form-btn">Delete</div>
                    </div>
                </div>

                <!-- Email Body -->
                <div class="user_cont user-email-template mt-3">
                    ${!isHtmlEmpty
                        ? email.body.html
                        : (email.body?.text || 'No body content available.').replace(/\n/g, '<br>')}
                </div>

                <!-- Attachments -->
                ${email.attachments?.length ? `
                    <div class="attachments-section mb-4 mt-3">
                        <h6><i class="fa fa-paperclip"></i> Attachments (${email.attachments.length})</h6>
                        <div class="attachments-list">
                            ${email.attachments.map(att => `
                                <div class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                                    <div class="me-2 text-muted fs-5"><i class="fa fa-file-o"></i></div>
                                    <div class="flex-grow-1">
                                        <div class="fw-medium">${att.filename || 'Unknown File'}</div>
                                        <div class="text-muted small">
                                            Type: ${(att.type || 'unknown').toUpperCase()}
                                            ${att.size ? ` | Size: ${(att.size / 1024).toFixed(1)} KB` : ''}
                                        </div>
                                    </div>
                                    <div>
                                        <a href="${att.download_url || '#'}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa fa-download"></i> Download
                                        </a>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>` : ''}
            </div>
        </div>
        `;
    }).join('');
}


        //Toggle Listeners

        function attachActivityToggleListeners() {
            document.querySelectorAll('.toggle-activity').forEach(button => {
                button.addEventListener('click', function () {
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

        //Tabs
        function setActiveTab(folder) {
            document.querySelectorAll('#email-folders .nav-link').forEach(tab => {
                tab.classList.remove('active');
                if (tab.getAttribute('data-folder') === folder) {
                    tab.classList.add('active');
                }
            });
        }

        document.querySelectorAll('#email-folders .nav-link').forEach(tab => {
            tab.addEventListener('click', function (e) {
                e.preventDefault();
                folder = this.getAttribute('data-folder');
                currentPage = 1;
                setActiveTab(folder);
                fetchEmails();
            });
        });

        setActiveTab(folder);
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Toggle activity minimize/maximize
        document.querySelectorAll(".toggle-activity").forEach(btn => {
            btn.addEventListener("click", function () {
                const target = document.querySelector(this.dataset.target);
                if (target.style.display == "none") {
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
