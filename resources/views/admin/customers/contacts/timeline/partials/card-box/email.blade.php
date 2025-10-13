<div class="email-box-container mb-4 border rounded bg-white p-3" style="margin: 0; border-radius: 0;">
    <div class="toggle-btnss" data-target=".content-{{ $item['data']['uuid'] }}">
        <div class="activ_head">
            <div class="email-child-wrapper">
                <i class="fa fa-caret-right toggle-email-caret" aria-hidden="true" style="cursor:pointer;"></i>
                <div>
@php
    // Prepare recipient lists safely
    $fromName = $item['data']['from']['name'] ?? '';
    $fromEmail = $item['data']['from']['email'] ?? '';

    $parseEmails = function ($field) {
        return collect(
            is_string($field)
                ? json_decode($field, true) ?? [$field]
                : $field
        )
        ->map(fn($r) => is_array($r) ? ($r['email'] ?? ($r['name'] ?? '')) : $r)
        ->filter()
        ->implode(', ');
    };

    $toList = $parseEmails($item['data']['to'] ?? []);
    $ccList = $parseEmails($item['data']['cc'] ?? []);
    $bccList = $parseEmails($item['data']['bcc'] ?? []);
@endphp

<h2 class="toggle-email-header"
    style="cursor:pointer;"
    data-bs-toggle="tooltip" 
    data-bs-html="true"
    data-bs-placement="top"
    data-bs-custom-class="custom-tooltip"
    title="
        <div class='custom-tooltip-content'>
            <p>Subject: {{ $item['data']['subject'] ?? '(No Subject)' }}</p>
            <p>From: {{ $fromName ?: '(No Name)' }} ({{ $fromEmail ?: 'Unknown Email' }})</p>
            @if(!empty($toList))<p>To: {{ $toList }}</p>@endif
            @if(!empty($ccList))<p>CC: {{ $ccList }}</p>@endif
            @if(!empty($bccList))<p>BCC: {{ $bccList }}</p>@endif
            <p>Date: {{ !empty($item['data']['date']) ? \Carbon\Carbon::parse($item['data']['date'])->setTimezone('Asia/Karachi')->format('M d, Y h:i A') : 'Unknown Date' }}</p>
        </div>
    ">
    {{-- Subject --}}
    Email - <strong>{{ \Illuminate\Support\Str::limit($item['data']['subject'] ?? '(No Subject)', 30) }}</strong>

    {{-- From (inline) --}}
    <span class="user_cont">
        from {{ $fromName ?: $fromEmail ?: '' }}
    </span>
</h2><br>







<div class="user_toggle">
    <div class="d-flex align-items-center gap-1">
        {{-- Inline Short Display --}}
        <p class="user_cont mb-0 to-inline">
            to:
            {{
                \Illuminate\Support\Str::limit(
                    collect(
                        is_string($item['data']['to'])
                            ? json_decode($item['data']['to'], true) ?? [$item['data']['to']]
                            : $item['data']['to'],
                    )
                    ->map(fn($r) => is_array($r)
                        ? ($r['email'] ?? ($r['name'] ?? ''))
                        : $r
                    )
                    ->implode(', '),
                    50, // show ~1.5 addresses
                    '...'
                )
            }}
        </p>

        {{-- <i class="fa fa-caret-down toggle-tooltip-icon"
           style="cursor: pointer; font-size: 14px; color: #6c757d;"
           data-bs-toggle="tooltip" 
           data-bs-html="true"
           data-bs-placement="top"
           data-bs-trigger="click"
           data-bs-custom-class="custom-tooltip"
           title="
            <div class='custom-tooltip-content'>
                <p>From: {{ $item['data']['from']['email'] ?? '' }}</p>
                <p>To: {{
                    collect(
                        is_string($item['data']['to'])
                            ? json_decode($item['data']['to'], true) ?? [$item['data']['to']]
                            : $item['data']['to'],
                    )
                    ->map(fn($r) => is_array($r)
                        ? ($r['email'] ?? ($r['name'] ?? ''))
                        : $r
                    )
                    ->implode(', ')
                }}</p>
                @if(!empty($item['data']['cc']))
                    <p>CC: {{
                        collect(
                            is_string($item['data']['cc'])
                                ? json_decode($item['data']['cc'], true) ?? [$item['data']['cc']]
                                : $item['data']['cc'],
                        )
                        ->map(fn($r) => is_array($r)
                            ? ($r['email'] ?? ($r['name'] ?? ''))
                            : $r
                        )
                        ->implode(', ')
                    }}</p>
                @endif
                @if(!empty($item['data']['bcc']))
                    <p>BCC: {{
                        collect(
                            is_string($item['data']['bcc'])
                                ? json_decode($item['data']['bcc'], true) ?? [$item['data']['bcc']]
                                : $item['data']['bcc'],
                        )
                        ->map(fn($r) => is_array($r)
                            ? ($r['email'] ?? ($r['name'] ?? ''))
                            : $r
                        )
                        ->implode(', ')
                    }}</p>
                @endif
            </div>
        "></i> --}}

        
    </div>

@if($item['data']['type'] !== 'incoming')
    @if(($item['data']['send_status'] ?? '') === 'failed')
        {{-- Delivery Failed Message --}}
        <div class="alert alert-danger d-flex align-items-center justify-content-between py-2 px-3 mt-2 mb-0 shadow-sm">
            <div>
                <strong>Delivery Failed.</strong>
                We couldn’t send this email due to a temporary issue.<br>
            </div>
            <a href="javascript:void(0);" 
               class="alert-link retry-email-link ms-3 fw-semibold text-decoration-underline"
               data-id="{{ $item['data']['id'] }}">
               Try Again
            </a>
        </div>
    @else
        @php
            $hasOpenEvent = !empty($item['data']['open_count']) && $item['data']['open_count'] > 0;
            $hasClickEvent = !empty($item['data']['click_count']) && $item['data']['click_count'] > 0;
        @endphp

        {{-- Show send status only if no open or click event --}}
        @unless($hasOpenEvent || $hasClickEvent)
            <div class="email-folder d-flex align-items-center mt-1">
                <span class="folder-dot me-1"
                      style="color: 
                          {{ ($item['data']['send_status'] ?? '') === 'sent' ? '#28a745' : 
                             (($item['data']['send_status'] ?? '') === 'pending' ? '#ffc107' : '#6c757d') }};">
                    &bull;
                </span>
                <span class="folder-name text-capitalize">
                    {{ ($item['data']['send_status'] ?? '') === 'sent' ? 'Sent' : 
                       (($item['data']['send_status'] ?? '') === 'pending' ? 'Sending…' : 'Queued') }}
                </span>
            </div>
        @endunless
    @endif
@endif






</div>




                    @if (
                        !empty($item['data']['open_count']) &&
                        $item['data']['open_count'] > 0 &&
                        $item['data']['type'] === 'outgoing' &&
                        $item['data']['send_status'] === 'sent'
                    )
                        <p class="mb-0 text-primary small toggle-activity-row" style="cursor:pointer; display: flex; align-items: center;">
                            <i class="fa fa-caret-right toggle-activity text-primary me-2"
                            data-target="#timeline-{{ $item['data']['uuid'] }}"
                            style="width: 14px; text-align: center;"></i>
                            <span>
                                Opens: {{ $item['data']['open_count'] ?? 0 }}
                                <span class="mx-1">|</span>
                                Clicks: {{ $item['data']['click_count'] ?? 0 }}
                            </span>
                        </p>
                    @endif



                </div>
            </div>
            {{-- Thread Count (Bootstrap Tooltip) --}}
            @if (!empty($item['data']['thread_email_count']) && $item['data']['thread_email_count'] > 0)
                <span class="ms-2 text-muted" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="This thread contains {{ $item['data']['thread_email_count'] }} related email(s)">
                    <i class="fa fa-envelope"></i>
                    <sup>{{ $item['data']['thread_email_count'] }}</sup>
                </span>
            @endif

<p style="font-size: 9px;">
    {{ !empty($item['data']['date']) 
        ? \Carbon\Carbon::parse($item['data']['date'])->setTimezone('Asia/Karachi')->format('M d, Y h:i A') 
        : 'Unknown Date' 
    }}
</p>


        </div>
        {{-- Body preview --}}
        <p class="user_toggle" style="margin-top: 4px; color: #555; font-size: 13px;padding:0px 18px;">
            @if(isset($item['data']['subject']))
                @if(str_starts_with(strtolower($item['data']['subject']), 're:'))
                    <span style="color: #666; font-style: italic;">
                        Re: {{ \Illuminate\Support\Str::limit(trim(substr($item['data']['subject'], 3)), 80, '...') }}
                    </span>
                @elseif(str_starts_with(strtolower($item['data']['subject']), 'fwd:'))
                    <span style="color: #666; font-style: italic;">
                        Fwd: {{ \Illuminate\Support\Str::limit(trim(substr($item['data']['subject'], 4)), 80, '...') }}
                    </span>
                @else
                    <span style="color: #333; font-weight: 500;">
                        {{ \Illuminate\Support\Str::limit($item['data']['subject'], 80, '...') }}
                    </span>
                @endif
            @else
                <span style="color: #999; font-style: italic;">No subject</span>
            @endif
        </p>
    </div>

    <div>
        <div class="contentdisplaytwo {{ $item['data']['uuid'] }}" style="display: none;">


            @if (
                ($item['data']['type'] ?? '') === 'outgoing' &&
                    ($item['data']['send_status'] ?? '') === 'sent' &&
                    (($item['data']['open_count'] ?? 0) > 0 || ($item['data']['click_count'] ?? 0) > 0))

                <div class="activity-section mt-3">

                    <div id="timeline-{{ $item['data']['uuid'] }}" class="timeline" style="display: none;">
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
                <div class="new-profile-email-wrapper d-flex justify-content-end gap-2 mt-2">
                    <div class="activities-seprater reply-btn" data-from="{{ $item['data']['from']['email'] ?? '' }}"
                        data-subject="{{ $item['data']['subject'] ?? '' }}"
                        data-date="{{ $item['data']['date']->format('M d, Y H:i') ?? '' }}"
                        data-body='@json($item['data']['body']['html'] ?? $item['data']['body']['text'])'
                        data-thread-id="{{ $item['data']['thread_id'] ?? '' }}"
                        data-in-reply-to="{{ $item['data']['message_id'] ?? '' }}"
                        data-references='@json($item['data']['references'] ?? null)'>
                        Reply
                    </div>
                    @php
                        $toCount = is_array($item['data']['to']) ? count($item['data']['to']) : 1;
                        $ccCount = isset($item['data']['cc']) && is_array($item['data']['cc']) ? count($item['data']['cc']) : 0;
                    @endphp
                    @if ($toCount + $ccCount > 1)
                        <div class="activities-seprater replyall-btn"
                            data-from="{{ $item['data']['from']['email'] ?? '' }}"
                            data-to='@json($item['data']['to'] ?? [])'
                            data-cc='@json($item['data']['cc'] ?? [])'
                            data-subject="{{ $item['data']['subject'] ?? '' }}"
                            data-date="{{ isset($item['data']['date']) ? $item['data']['date']->format('M d, Y H:i') : '' }}"
                            data-body='@json($item['data']['body']['html'] ?? $item['data']['body']['text'] ?? '')'
                            data-thread-id="{{ $item['data']['thread_id'] ?? '' }}"
                            data-in-reply-to="{{ $item['data']['message_id'] ?? '' }}"
                            data-references='@json($item['data']['references'] ?? null)'>
                            Reply All
                        </div>
                    @endif

                    <div class="activities-seprater forward-btn" data-from="{{ $item['data']['from']['email'] ?? '' }}"
                        data-subject="{{ $item['data']['subject'] ?? '' }}"
                        data-date="{{ $item['data']['date']->format('M d, Y H:i') ?? '' }}"
                        data-body='@json($item['data']['body']['html'] ?? $item['data']['body']['text'])'
                        data-message-id="{{ $item['data']['message_id'] ?? '' }}">
                        Forward
                    </div>
                    {{-- <div class="activities-seprater open-form-btn">Delete</div> --}}
                </div>
            <div class="new-profile-parent-wrapper">

                <div class="new-profile-email-wrapper">
                    <div class="user_profile_img">
                        <div class="avatarr">
                            {{ $item['data']['from']['name'] ? strtoupper(substr($item['data']['from']['name'], 0, 2)) : strtoupper(substr($item['data']['from']['email'], 0, 2)) }}
                        </div>
                    </div>
                    <div class="user_profile_text">
                        <p>{{ $item['data']['from']['name'] ?? $item['data']['from']['email'] ?? '' }}
                        </p>
                        <div class="tooltip-wrapper" style="display: inline-block;">
                            <p class="mb-0">
                                from: {{ $item['data']['from']['email'] ?? '' }}<br>
                                to: 
                                {{ collect(
                                    is_string($item['data']['to'])
                                        ? json_decode($item['data']['to'], true) ?? [$item['data']['to']]
                                        : $item['data']['to'],
                                )
                                ->map(fn($r) => is_array($r) ? ($r['email'] ?? ($r['name'] ?? '')) : $r)
                                ->take(1)
                                ->implode(', ') }}
                                @if(
                                    count(
                                        collect(
                                            is_string($item['data']['to'])
                                                ? json_decode($item['data']['to'], true) ?? [$item['data']['to']]
                                                : $item['data']['to'],
                                        )
                                    ) > 1
                                )
                                    , <span class="text-muted">...</span>
                                @endif
                                @if(!empty($item['data']['cc']))
                                    <br>cc: 
                                    {{ collect(
                                        is_string($item['data']['cc'])
                                            ? json_decode($item['data']['cc'], true) ?? [$item['data']['cc']]
                                            : $item['data']['cc'],
                                    )
                                    ->map(fn($r) => is_array($r) ? ($r['email'] ?? ($r['name'] ?? '')) : $r)
                                    ->take(1)
                                    ->implode(', ') }}
                                    @if(
                                        count(
                                            collect(
                                                is_string($item['data']['cc'])
                                                    ? json_decode($item['data']['cc'], true) ?? [$item['data']['cc']]
                                                    : $item['data']['cc'],
                                            )
                                        ) > 1
                                    )
                                        , <span class="text-muted">...</span>
                                    @endif
                                @endif
                                @if(!empty($item['data']['bcc']))
                                    <br>bcc: 
                                    {{ collect(
                                        is_string($item['data']['bcc'])
                                            ? json_decode($item['data']['bcc'], true) ?? [$item['data']['bcc']]
                                            : $item['data']['bcc'],
                                    )
                                    ->map(fn($r) => is_array($r) ? ($r['email'] ?? ($r['name'] ?? '')) : $r)
                                    ->take(1)
                                    ->implode(', ') }}
                                    @if(
                                        count(
                                            collect(
                                                is_string($item['data']['bcc'])
                                                    ? json_decode($item['data']['bcc'], true) ?? [$item['data']['bcc']]
                                                    : $item['data']['bcc'],
                                            )
                                        ) > 1
                                    )
                                        , <span class="text-muted">...</span>
                                    @endif
                                @endif
                            </p>

           
                        </div>
@if($item['data']['type'] !== 'incoming')
    @if(($item['data']['send_status'] ?? '') === 'failed')
        <div class="alert alert-danger d-flex align-items-center justify-content-between py-2 px-3 mt-2 mb-0 shadow-sm">
            <div>
                <strong>Delivery Failed.</strong>
                We couldn’t send this email due to a temporary issue.<br>
            </div>
            <a href="javascript:void(0);" 
               class="alert-link retry-email-link ms-3 fw-semibold text-decoration-underline"
               data-id="{{ $item['data']['uuid'] }}">
               Try Again
            </a>
        </div>
    @else
        {{-- Only show send status if no open or click event exists --}}
        @if($item['data']['show_send_status'])
            <div class="email-folder d-flex align-items-center mt-2">
                <span class="folder-dot me-1"
                      style="color: 
                          {{ ($item['data']['send_status'] ?? '') === 'sent' ? '#28a745' : 
                             (($item['data']['send_status'] ?? '') === 'pending' ? '#ffc107' : '#6c757d') }};">
                    &bull;
                </span>
                <span class="folder-name text-capitalize">
                    {{ ($item['data']['send_status'] ?? '') === 'sent' ? 'Sent' : 
                       (($item['data']['send_status'] ?? '') === 'pending' ? 'Sending…' : 'Queued') }}
                </span>
            </div>
        @endif
    @endif
@endif



                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="user-cont-hide">
    <div class="user_cont user-cont-hide">
        @php
            $htmlContent = $item['data']['body']['html'] ?? '';
            $isHtmlEmpty = empty(trim(strip_tags($htmlContent)));
            $previewContent = Str::limit(strip_tags($htmlContent), 100, '...');
        @endphp
        {{-- <p>{!! nl2br(e($previewContent)) !!}</p> --}}
    </div>
</div>

    <div class="contentdisplaytwo {{ $item['data']['uuid'] }}" style="display: none;">
    <div class="user_cont user-email-template">
        {!! $htmlContent !!}
    </div>

     @if (!empty($item['data']['attachments']))
    <div class="attachments-section my-4">
        <h6><i class="fa fa-paperclip"></i> Attachments ({{ count($item['data']['attachments']) }})</h6>
        <div class="attachments-list">
            @foreach ($item['data']['attachments'] as $attachment)
                <div class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                    <div class="me-2 text-muted fs-5">
                        <i class="fa {{ $attachment['mime_type'] && Str::startsWith($attachment['mime_type'], 'image/') ? 'fa-file-image-o' : 'fa-file-o' }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-medium">{{ $attachment['original_name'] ?? 'Unknown File' }}</div>
                        <div class="text-muted small">
                            Type: {{ strtoupper($attachment['mime_type'] ?? 'UNKNOWN') }}
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
        @if (isset($item['data']['thread_email_count']) && $item['data']['thread_email_count'] > 0)
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
        @endif
        <div class="thread-emails" id="thread-{{ $item['data']['uuid'] }}" style="display: none;">
            @if (isset($item['data']['thread_email_count']) && $item['data']['thread_email_count'] > 0)
                @foreach ($item['data']['thread_emails'] as $threadItem)
                    <div class="thread-email-item border-top pt-3 mt-3">
                        <div class="new-profile-email-wrapper">
                            <div class="user_profile_img">
                                <div class="avatarr">
                                    {{ $threadItem['from']['name'] ? strtoupper(substr($threadItem['from']['name'], 0, 2)) : strtoupper(substr($threadItem['from']['email'], 0, 2)) }}
                                </div>
                            </div>
                            <div class="user_profile_text">
                                <p>{{ $threadItem['from']['name'] ?? ($threadItem['from']['email'] ?? '') }}
                                </p>
                                <p>
                                    to:
                                    {{ collect(
                                        is_string($threadItem['to']) ? json_decode($threadItem['to'], true) ?? [$threadItem['to']] : $threadItem['to'],
                                    )->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? '') : $r)->implode(', ') }}
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
                            {!! $threadIsHtmlEmpty ? nl2br($threadItem['body']['text'] ?? '') : $threadHtmlContent !!}
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
