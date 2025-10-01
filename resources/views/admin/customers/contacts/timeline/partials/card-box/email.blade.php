<div class="email-box-container mb-4 border rounded bg-white p-3" style="margin: 0; border-radius: 0;">
    <div class="toggle-btnss" data-target=".content-{{ $email['uuid'] }}">
        <div class="activ_head">
            <div class="email-child-wrapper">
                <i class="fa fa-caret-right" aria-hidden="true"></i>
                <div>
                    <h2>
                        Email - {{ $email['subject'] ?? '(No Subject)' }}
                        <span class="user_cont">
                            from {{ $email['from']['name'] ?? $email['from']['email'] ?? 'Unknown' }}
                        </span>
                    </h2>
                    <div class="user_toggle">
                        <p class="user_cont">
                            from: {{ $email['from']['email'] ?? 'Unknown' }}
                        </p>
                        <p class="user_cont">
                            to:
                            {{ collect(is_string($email['to']) ? json_decode($email['to'], true) ?? [$email['to']] : $email['to'])
                                ->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)
                                ->implode(', ') }}
                        </p>
                    </div>
                    @if (!empty($email['open_count']) && $email['open_count'] > 0 && $email['type'] === 'outgoing' && $email['folder'] === 'sent')
                        <p class="mb-0 text-primary small">
                            Opens: {{ $email['open_count'] ?? 0 }} |
                            Clicks: {{ $email['click_count'] ?? 0 }}
                        </p>
                    @endif
                </div>
            </div>
            <p>
                {{ !empty($email['date'])
                    ? \Carbon\Carbon::parse($email['date'])->format('M d, Y h:i A')
                    : 'Unknown Date' }}
            </p>
        </div>
    </div>

    {{-- ================= Expanded Content ================= --}}
    <div>
    <div class="contentdisplaytwo {{ $email['uuid'] }}" style="display: none;">
        <div class="new-profile-parent-wrapper">
            <div class="new-profile-email-wrapper">
                <div class="user_profile_img">
                    <div class="avatarr">
                        {{ $email['from']['name']
                            ? strtoupper(substr($email['from']['name'], 0, 2))
                            : strtoupper(substr($email['from']['email'], 0, 2)) }}
                    </div>
                </div>
                <div class="user_profile_text">
                    <p>{{ $email['from']['name'] ?? ($email['from']['email'] ?? 'Unknown') }}</p>
                    <p style="font-weight: 500">
                        to:
                        {{ collect(is_string($email['to']) ? json_decode($email['to'], true) ?? [$email['to']] : $email['to'])
                            ->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)
                            ->implode(', ') }}
                    </p>
                </div>
            </div>

            <div class="new-profile-email-wrapper">
                <div class="activities-seprater reply-btn"
                     data-from="{{ $email['from']['email'] ?? '' }}"
                     data-subject="{{ $email['subject'] ?? '' }}"
                     data-date="{{ $email['date']->format('M d, Y H:i') ?? '' }}"
                     data-body='@json($email['body']['html'] ?? $email['body']['text'])'
                     data-thread-id="{{ $email['thread_id'] ?? '' }}"
                     data-in-reply-to="{{ $email['message_id'] ?? '' }}"
                     data-references='@json($email['references'] ?? null)'>
                    Reply
                </div>
                <div class="activities-seprater open-form-btn">Forward</div>
                <div class="activities-seprater open-form-btn">Delete</div>
            </div>
        </div>
    </div>

    {{-- ================= Preview (Hidden Short Body) ================= --}}
    <div class="user-cont-hide">
        <div class="user_cont user-cont-hide">
            @php
                $htmlContent = $email['body']['html'] ?? '';
                $isHtmlEmpty = empty(trim(strip_tags($htmlContent)));
                $previewContent = $isHtmlEmpty
                    ? ($email['body']['text'] ?? 'No body content available.')
                    : strip_tags($htmlContent);
                $previewContent = Str::limit($previewContent, 100, '...');
            @endphp
            {{-- <p>{!! nl2br(e($previewContent)) !!}</p> --}}
        </div>
    </div>

    {{-- ================= Full Body ================= --}}
    <div class="contentdisplaytwo {{ $email['uuid'] }}" style="display: none;">
        <div class="user_cont user-email-template">
            {!! $isHtmlEmpty
                ? nl2br($email['body']['text'] ?? 'No body content available.')
                : $htmlContent !!}
        </div>

        @if (!empty($email['attachments']))
            <div class="attachments-section mb-4">
                <h6>
                    <i class="fa fa-paperclip"></i> Attachments ({{ count($email['attachments']) }})
                </h6>
                <div class="attachments-list">
                    @foreach ($email['attachments'] as $attachment)
                        <div class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                            <div class="me-2 text-muted fs-5"><i class="fa fa-file-o"></i></div>
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
</div>
