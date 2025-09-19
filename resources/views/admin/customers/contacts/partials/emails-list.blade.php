@if (empty($emails) || count($emails) === 0)
    <p class="text-muted">No emails found.</p>
@else
    @foreach ($emails['emails'] as $email)
        <!-- Email Container -->
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
                            <!-- Counts under TO -->
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
            <div class="contentdisplaytwo {{ $email['uuid'] }} mt-3 p-3 rounded border bg-light" style="display: none;">
    <!-- Activity Timeline -->
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
                        <p class="mb-0 small"><i class="fa fa-info-circle"></i> No activity recorded</p>
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
                <i class="fa fa-paperclip"></i> Attachments ({{ count($email['attachments']) }})
            </h6>
            <div class="attachments-list">
                @foreach ($email['attachments'] as $attachment)
                    <div class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                        <div class="me-2 text-muted fs-5">
                            <i class="fa fa-file-o"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium">{{ $attachment['filename'] ?? 'Unknown File' }}</div>
                            <div class="text-muted small">
                                Type: {{ strtoupper($attachment['type'] ?? 'unknown') }}
                                @if (!empty($attachment['size']))
                                    | Size: {{ number_format($attachment['size'] / 1024, 1) }} KB
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

<!-- Styles -->
<style>
    .contentdisplaytwo{
        background-color: #fff !important;
        border:none !important;
    }
    .timeline-content {
        border: none !important;
        box-shadow: none !important;    
    }
    .activity-section{
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
  box-shadow: 0 1px 2px rgba(0,0,0,0.05);
  margin: -11px -3px -15px -28px
}

</style>

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
