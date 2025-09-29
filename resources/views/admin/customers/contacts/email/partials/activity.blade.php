@if (!empty($timeline) && count($timeline) > 0)
    @include('admin.customers.contacts.email.static-content.email')

    @foreach ($timeline as $item)
        @if ($item['type'] === 'note')
            {{-- ================= NOTE ================= --}}
            <div class="data-highlights">
                <div class="cstm_note">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="data-top-heading-header">
                                <h2>Note By {{ ucwords($item['data']->creator?->name ?? 'Unknown') }}</h2>
                                <p>
                                    {{ $item['date']
                                        ? \Carbon\Carbon::parse($item['date'])->timezone('Asia/Karachi')->format('M j, Y \a\t g:i A \G\M\TP')
                                        : '---' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="cstm_note_2">
                    <div class="row">
                        <div class="col-md-12 cstm_note_cont">
                            <p class="user_cont" id="note-text-{{ $item['data']->id }}">
                                {{ $item['data']->note ?? 'No Note Available' }}
                            </p>
                            <div class="cstm_right_icon">
                                <button class="p-0 border-0 cstm_btn">
                                    <i class="fas fa-edit me-2 editNoteModal" data-bs-toggle="modal"
                                        data-bs-target="#editNoteModal" data-id="{{ $item['data']->id }}"
                                        data-note="{{ $item['data']->note }}"></i>
                                </button>
                                <form action="{{ route('admin.customer.contact.note.delete', $item['data']->id) }}"
                                    method="POST" class="deleteNoteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-0 border-0 cstm_btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($item['type'] === 'email')
            {{-- ================= EMAIL ================= --}}
       <div class="email-box-container mb-4 border rounded bg-white p-3" style="margin: 0; border-radius: 0;">
            <div class="toggle-btnss" data-target=".content-{{ $item['data']['uuid'] }}">
                <div class="activ_head">
                    <div class="email-child-wrapper">
                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                        <div>
                            <h2>
                                Email - {{ $item['data']['subject'] ?? '(No Subject)' }}
                                <span class="user_cont">from {{ $item['data']['from']['name'] ?? $item['data']['from']['email'] ?? 'Unknown' }}</span>
                            </h2>
                            <p class="user_cont">from: {{ $item['data']['from']['email'] ?? 'Unknown' }}</p>
                            <p class="user_cont">
                                to:
                                {{ collect(is_string($item['data']['to']) ? json_decode($item['data']['to'], true) ?? [$item['data']['to']] : $item['data']['to'])
                                    ->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)
                                    ->implode(', ') }}
                            </p>
                            @if (!empty($item['data']['open_count']) && $item['data']['open_count'] > 0 && $item['data']['type'] === 'outgoing' && $item['data']['folder'] === 'sent')
                                <p class="mb-0 text-primary small">
                                    Opens: {{ $item['data']['open_count'] ?? 0 }} |
                                    Clicks: {{ $item['data']['click_count'] ?? 0 }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <p>{{ !empty($item['data']['date']) ? \Carbon\Carbon::parse($item['data']['date'])->format('M d, Y h:i A') : 'Unknown Date' }}</p>
                </div>
            </div>

            <div>
                <div class="contentdisplaytwo {{ $item['data']['uuid'] }}" style="display: none;">
                    <div class="new-profile-parent-wrapper">
                        <div class="new-profile-email-wrapper">
                            <div class="user_profile_img">
                                <div class="avatarr">
                                    {{ $item['data']['from']['name'] ? strtoupper(substr($item['data']['from']['name'], 0, 2)) : strtoupper(substr($item['data']['from']['email'], 0, 2)) }}
                                </div>
                            </div>
                            <div class="user_profile_text">
                                <p>{{ $item['data']['from']['name'] ?? ($item['data']['from']['email'] ?? 'Unknown') }}</p>
                                <p style="font-weight: 500">
                                    to:
                                    {{ collect(is_string($item['data']['to']) ? json_decode($item['data']['to'], true) ?? [$item['data']['to']] : $item['data']['to'])
                                        ->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)
                                        ->implode(', ') }}
                                </p>
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
                                            Reply</div>
                            <div class="activities-seprater open-form-btn">Forward</div>
                            <div class="activities-seprater open-form-btn">Delete</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="user-cont-hide">
                <div class="user_cont user-cont-hide">
                    @php
                        $htmlContent = $item['data']['body']['html'] ?? '';
                        $isHtmlEmpty = empty(trim(strip_tags($htmlContent)));
                        $previewContent = $isHtmlEmpty ? ($item['data']['body']['text'] ?? 'No body content available.') : strip_tags($htmlContent);
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
                        <h6><i class="fa fa-paperclip"></i> Attachments ({{ count($item['data']['attachments']) }})</h6>
                        <div class="attachments-list">
                            @foreach ($item['data']['attachments'] as $attachment)
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
                                        <a href="{{ $attachment['download_url'] ?? '#' }}" class="btn btn-sm btn-outline-primary">
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

        @endif
    @endforeach
@else
    <p class="text-muted">No notes or emails found.</p>
@endif
