
    <div class="email-box-container mb-4 border rounded bg-white p-3" style="margin: 0; border-radius: 0;">
        <div class="toggle-btnss" data-target=".content-{{ $item['data']['uuid'] }}">
            <div class="activ_head">
                <div class="email-child-wrapper">
                    <i class="fa fa-caret-right" aria-hidden="true"></i>
                    <div>
                        <h2 class="email-tooltip-wrapper">
                            Email - {{ \Illuminate\Support\Str::limit($item['data']['subject'] ?? '(No Subject)', 30) }}
                            <span class="user_cont">
                                from
                                {{ $item['data']['from']['name'] ?? ($item['data']['from']['email'] ?? 'Unknown') }}
                            </span>

                            <div class="email-tooltip-card">
                                <p><strong>Subject:</strong> {{ $item['data']['subject'] ?? '(No Subject)' }}</p>
                                <p><strong>From:</strong> {{ $item['data']['from']['name'] ?? '' }}
                                    ({{ $item['data']['from']['email'] ?? '' }})
                                </p>
                                <p><strong>To:</strong>
                                    {{ collect(
                                        is_string($item['data']['to'])
                                            ? json_decode($item['data']['to'], true) ?? [$item['data']['to']]
                                            : $item['data']['to'],
                                    )->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', ') }}
                                </p>
                                <p><strong>Date:</strong>
                                    {{ !empty($item['data']['date'])
                                        ? \Carbon\Carbon::parse($item['data']['date'])->format('M d, Y h:i A')
                                        : 'Unknown Date' }}
                                </p>
                            </div>
                        </h2>



                        <div class="user_toggle">
                            {{-- <p class="user_cont">from: {{ $item['data']['from']['email'] ?? 'Unknown' }}</p> --}}
                            <p class="user_cont">
                                to:
                                {{ collect(
                                    is_string($item['data']['to'])
                                        ? json_decode($item['data']['to'], true) ?? [$item['data']['to']]
                                        : $item['data']['to'],
                                )->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', ') }}
                            </p>
                            <span class="folder-dot" style="color: #28a745;">&bull;</span>
                            <span class="folder-name">{{ ucfirst($item['data']['folder'] ?? 'Unknown') }}</span>
                        </div>
                        @if (
                            !empty($item['data']['open_count']) &&
                                $item['data']['open_count'] > 0 &&
                                $item['data']['type'] === 'outgoing' &&
                                $item['data']['folder'] === 'sent')
                            <p class="mb-0 text-primary small">
                                Opens: {{ $item['data']['open_count'] ?? 0 }} |
                                Clicks: {{ $item['data']['click_count'] ?? 0 }}
                            </p>
                        @endif
                    </div>
                </div>
                <p>{{ !empty($item['data']['date']) ? \Carbon\Carbon::parse($item['data']['date'])->format('M d, Y h:i A') : 'Unknown Date' }}
                </p>
            </div>
        </div>

        <div>
            <div class="contentdisplaytwo {{ $item['data']['uuid'] }}" style="display: none;">
                

               @if (($item['data']['type'] ?? '') === 'outgoing' && ($item['data']['folder'] ?? '') === 'sent' && (($item['data']['open_count'] ?? 0) > 0 || ($item['data']['click_count'] ?? 0) > 0 ))

                    <div class="activity-section mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="fw-semibold text-dark mb-0">
                                <i class="fa fa-clock-o"></i> Activity
                            </h6>
                            <button class="btn btn-sm btn-link toggle-activity"
                                data-target="#timeline-{{ $item['data']['uuid'] }}">
                                Minimize
                            </button>
                        </div>
                        <div id="timeline-{{ $item['data']['uuid'] }}" class="timeline">
                            @forelse ($item['data']['events'] ?? [] as $event)
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-content">
                                        <p class="mb-0 small">
                                            {{-- <i class="fa {{ $event['icon'] }}"></i> --}}
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
                                        <p class="mb-0 small">
                                            <i class="fa fa-info-circle"></i> No activity recorded
                                        </p>
                                        <small class="text-muted">N/A</small>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                @endif
                <div class="new-profile-parent-wrapper">
                    <div class="new-profile-email-wrapper">
                        <div class="user_profile_img">
                            <div class="avatarr">
                                {{ $item['data']['from']['name'] ? strtoupper(substr($item['data']['from']['name'], 0, 2)) : strtoupper(substr($item['data']['from']['email'], 0, 2)) }}
                            </div>
                        </div>
                        <div class="user_profile_text">
                            <p>{{ $item['data']['from']['name'] ?? 'Unknown' }}
                            </p>
                            <p style="font-weight: 500">
                                to:
                                {{ collect(
                                    is_string($item['data']['to'])
                                        ? json_decode($item['data']['to'], true) ?? [$item['data']['to']]
                                        : $item['data']['to'],
                                )->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', ') }}
                            </p>
                                                        <span class="folder-dot" style="color: #28a745;">&bull;</span>
                            <span class="folder-name">{{ ucfirst($item['data']['folder'] ?? 'Unknown') }}</span>
                        </div>
                    </div>

                    <div class="new-profile-email-wrapper">
                        <div class="activities-seprater reply-btn"
                            data-from="{{ $item['data']['from']['email'] ?? '' }}"
                            data-subject="{{ $item['data']['subject'] ?? '' }}"
                            data-date="{{ $item['data']['date']->format('M d, Y H:i') ?? '' }}"
                            data-body='@json($item['data']['body']['html'] ?? $item['data']['body']['text'])'
                            data-thread-id="{{ $item['data']['thread_id'] ?? '' }}"
                            data-in-reply-to="{{ $item['data']['message_id'] ?? '' }}"
                            data-references='@json($item['data']['references'] ?? null)'>
                            Reply
                        </div>
                            <div class="activities-seprater forward-btn"
                                data-from="{{ $item['data']['from']['email'] ?? '' }}"
                                data-subject="{{ $item['data']['subject'] ?? '' }}"
                                data-date="{{ $item['data']['date']->format('M d, Y H:i') ?? '' }}"
                                data-body='@json($item['data']['body']['html'] ?? $item['data']['body']['text'])'
                                data-message-id="{{ $item['data']['message_id'] ?? '' }}">
                                Forward
                            </div>
                        {{-- <div class="activities-seprater open-form-btn">Delete</div> --}}
                    </div>
                </div>
            </div>
        </div>


        <div class="user-cont-hide">
            <div class="user_cont user-cont-hide">
                @php
                    $htmlContent = $item['data']['body']['html'] ?? '';
                    $isHtmlEmpty = empty(trim(strip_tags($htmlContent)));
                    $previewContent = $isHtmlEmpty
                        ? $item['data']['body']['text'] ?? 'No body content available.'
                        : strip_tags($htmlContent);
                    $previewContent = Str::limit($previewContent, 100, '...');
                @endphp
                {{-- <p>{!! nl2br(e($previewContent)) !!}</p> --}}
            </div>
        </div>

        <div class="contentdisplaytwo {{ $item['data']['uuid'] }}" style="display: none;">
            <div class="user_cont user-email-template">
                {!! $isHtmlEmpty ? nl2br($item['data']['body']['text'] ?? 'No body content available.') : $htmlContent !!}
            </div>

            @if (!empty($item['data']['attachments']))
                <div class="attachments-section mb-4">
                    <h6><i class="fa fa-paperclip"></i> Attachments ({{ count($item['data']['attachments']) }})
                    </h6>
                    <div class="attachments-list">

                        @foreach ($item['data']['attachments'] as $attachment)
                            <div class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                                <div class="me-2 text-muted fs-5"><i class="fa fa-file-o"></i></div>
                                <div class="flex-grow-1">
                                    <div class="fw-medium">{{ $attachment['original_name'] ?? 'Unknown File' }}
                                    </div>
                                    <div class="text-muted small">
                                        Type: {{ strtoupper($attachment['mime_type'] ?? 'unknown') }}
                                        @if (!empty($attachment['size']))
                                            | Size: {{ number_format($attachment['size'] / 1024, 1) }} KB
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('admin.customer.contact.attachments.download', $attachment['id']) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-download"></i> Download
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="comment-active_head">
                <div>
                    <div>
                        <div class="email-child-wrapper">
                            <span class="activities-addition-links toggle-thread-btn"
                                data-target="thread-{{ $item['data']['uuid'] }}">
                                View Thread ({{ count($item['data']['thread_emails'] ?? []) }})
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="thread-emails" id="thread-{{ $item['data']['uuid'] }}" style="display: none;">
                @if (!empty($item['data']['thread_emails']))
                    @foreach ($item['data']['thread_emails'] as $threadItem)
                        <div class="thread-email-item border-top pt-3 mt-3">
                            <div class="new-profile-email-wrapper">
                                <div class="user_profile_img">
                                    <div class="avatarr">
                                        {{ $threadItem['from']['name'] ? strtoupper(substr($threadItem['from']['name'], 0, 2)) : strtoupper(substr($threadItem['from']['email'], 0, 2)) }}
                                    </div>
                                </div>
                                <div class="user_profile_text">
                                    <p>{{ $threadItem['from']['name'] ?? ($threadItem['from']['email'] ?? 'Unknown') }}
                                    </p>
                                    <p style="font-weight: 500">
                                        to:
                                        {{ collect(
                                            is_string($threadItem['to']) ? json_decode($threadItem['to'], true) ?? [$threadItem['to']] : $threadItem['to'],
                                        )->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', ') }}
                                    </p>
                                    <p class="text-muted small">
                                        {{ !empty($threadItem['date']) ? \Carbon\Carbon::parse($threadItem['date'])->format('M d, Y h:i A') : 'Unknown Date' }}
                                    </p>
                                </div>
                            </div>
                            <div class="user_cont user-email-template">
                                @php
                                    $threadHtmlContent = $threadItem['body']['html'] ?? '';
                                    $threadIsHtmlEmpty = empty(trim(strip_tags($threadHtmlContent)));
                                @endphp
                                {!! $threadIsHtmlEmpty ? nl2br($threadItem['body']['text'] ?? 'No body content available.') : $threadHtmlContent !!}
                            </div>
                            @if (!empty($threadItem['attachments']))
                                <div class="attachments-section mb-4">
                                    <h6><i class="fa fa-paperclip"></i> Attachments
                                        ({{ count($threadItem['attachments']) }})
                                    </h6>
                                    <div class="attachments-list">
                                        @foreach ($threadItem['attachments'] as $attachment)
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
                    @endforeach
                @else
                    <p class="text-muted">No thread emails available.</p>
                @endif
            </div>
        </div>

    </div>
