<!-- Add the email section with loader, refresh button, and fetch emails button -->
<style>
    .contentdisplaytwo {
        background: linear-gradient(135deg, #e0f7fa, #ffffff) !important;
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
    left: -27px;
    top: 0px;
    width: 12px;
    height: 12px;
    background-color: #506E91;
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
        <div>
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


            <!-- Email Content -->

            <div class="card-box" id="email-content-section">
                @php
                    $emails = collect($timeline)->where('type', 'email');
                @endphp

                @if ($emails->isEmpty())
                    <div class="text-center py-4 no-emails-placeholder">
                        <i class="fa fa-envelope-open text-muted" style="font-size: 32px;"></i>
                        <p class="mt-2 text-muted">No emails available yet.</p>
                        <small class="text-secondary">
                            Once you send or receive emails, they’ll appear here.
                        </small>
                    </div>
                @else
                    {{-- Static header --}}
                    @include('admin.customers.contacts.timeline.static-content.email')
                    <div id="emails-section">
                        {{-- Render emails with same `$item` structure --}}
                        @foreach ($timeline as $item)
                            @if ($item['type'] === 'email')
                                @include('admin.customers.contacts.timeline.partials.card-box.email')
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>


        </div>
    </div>
</div>
