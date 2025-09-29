<div class="email-box-container mb-4 border rounded bg-white p-3">
    <!-- Header -->
    <div class="toggle-btnss" data-target=".content-{{ $email['uuid'] }}">
        <div class="d-flex justify-content-between align-items-center">
            <!-- Sender + Subject -->
            <div class="d-flex align-items-center">
                <i class="fa fa-caret-right me-2 text-primary"></i>
                <div>
                    <h2 class="mb-0 fs-6 fw-semibold text-dark">
                        {{ $email['from']['name'] ?? $email['from']['email'] }} -
                        {{ $email['subject'] ?? '(No Subject)' }}
                    </h2>
                    <p class="mb-1 text-muted small">
                        from:
                        {{ $email['from']['email'] ?: ($email['from']['name'] ?: 'Unknown') }}
                    </p>
                    <p class="mb-0 text-muted small">
                        to:
                        <span class="truncate-recipients"
                              title="{{ collect(is_string($email['to']) ? json_decode($email['to'], true) ?? [$email['to']] : $email['to'])->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', ') }}">
                                                    {{ Str::limit(collect(is_string($email['to']) ? json_decode($email['to'], true) ?? [$email['to']] : $email['to'])->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', '),50) }}
                                                </span>
                    </p>
                    {{--                                                <p class="mb-0 text-muted small"> --}}
                    {{--                                                    cc: --}}
                    {{--                                                    <span class="truncate-recipients" --}}
                    {{--                                                          title="{{ collect(is_string($email['cc']) ? json_decode($email['cc'], true) ?? [$email['cc']] : $email['cc'])->map(fn($r) => is_array($r) ? ($r['email'] ?? $r['name'] ?? 'Unknown') : $r)->implode(', ') }}"> --}}
                    {{--                                                        {{ Str::limit(collect(is_string($email['cc']) ? json_decode($email['cc'], true) ?? [$email['cc']] : $email['cc'])->map(fn($r) => is_array($r) ? ($r['email'] ?? $r['name'] ?? 'Unknown') : $r)->implode(', '), 50) }} --}}
                    {{--                                                    </span> --}}
                    {{--                                                </p> --}}
                    {{--                                                <p class="mb-0 text-muted small"> --}}
                    {{--                                                    bcc: --}}
                    {{--                                                    <span class="truncate-recipients" --}}
                    {{--                                                          title="{{ collect(is_string($email['bcc']) ? json_decode($email['bcc'], true) ?? [$email['bcc']] : $email['bcc'])->map(fn($r) => is_array($r) ? ($r['email'] ?? $r['name'] ?? 'Unknown') : $r)->implode(', ') }}"> --}}
                    {{--                                                        {{ Str::limit(collect(is_string($email['bcc']) ? json_decode($email['bcc'], true) ?? [$email['bcc']] : $email['bcc'])->map(fn($r) => is_array($r) ? ($r['email'] ?? $r['name'] ?? 'Unknown') : $r)->implode(', '), 50) }} --}}
                    {{--                                                    </span> --}}
                    {{--                                                </p> --}}
                    @if ($email['open_count'] > 0 && $email['type'] == 'outgoing' && $email['folder'] == 'sent')
                        <p class="mb-0 text-primary small">
                            Opens: {{ $email['open_count'] ?? 0 }} |
                            Clicks: {{ $email['click_count'] ?? 0 }}
                        </p>
                    @endif

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
    <div class="contentdisplay content-{{ $email['uuid'] }}" style="display:none;">
        <!-- Activity -->
        @if ($email['open_count'] > 0 && $email['type'] == 'outgoing' && $email['folder'] == 'sent')
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
                                    {{ ucfirst($event['event_type']) }}
                                </p>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($event['created_at'])->format('M d, Y h:i A') }}
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
        @endif

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
