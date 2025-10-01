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
            <div class="card-box">
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



