<!-- Add the email section with loader, refresh button, and fetch emails button -->
<style>
    .contentdisplaytwo {
        background-color: #fff !important;
        border: none !important;
        padding: 0 20px;
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
    document.addEventListener('DOMContentLoaded', function() {
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
        showMoreBtn.addEventListener("click", function() {
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
// Render Emails function to use server-rendered HTML
function renderEmails(emails) {
    if (!emails || emails.length === 0) {
        return '<p class="text-muted">No emails found.</p>';
    }
    return emails.join(''); // Join the array of HTML strings
}

// Fetch Emails function (updated to handle HTML response)
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

            // Control Show More visibility
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
        refreshButton.addEventListener('click', function() {
            currentPage = 1;
            fetchEmails(false); // reload first page
        });

        // fetch new emails
        fetchButton.addEventListener('click', function() {
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

 


        //Toggle Listeners

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
            tab.addEventListener('click', function(e) {
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
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle activity minimize/maximize
        document.querySelectorAll(".toggle-activity").forEach(btn => {
            btn.addEventListener("click", function() {
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
