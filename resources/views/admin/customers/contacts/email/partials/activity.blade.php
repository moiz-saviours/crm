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
                                    @include('admin.customers.contacts.email.static-content.email')

            {{-- ================= EMAIL ================= --}}
            <div class="email-box-container mb-4 border rounded bg-white p-3">
                <div class="toggle-btnss" data-target=".content-{{ $item['data']['uuid'] }}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fa fa-caret-right me-2 text-primary"></i>
                            <div>
                                <h2 class="mb-0 fs-6 fw-semibold text-dark">
                                    {{ $item['data']['from']['name'] ?? $item['data']['from']['email'] }} -
                                    {{ $item['data']['subject'] ?? '(No Subject)' }}
                                </h2>
                                <p class="mb-1 text-muted small">
                                    from: {{ $item['data']['from']['email'] ?? 'Unknown' }}
                                </p>
                                <p class="mb-0 text-muted small">
                                    to:
                                    <span class="truncate-recipients"
                                        title="{{ collect(is_string($item['data']['to']) ? json_decode($item['data']['to'], true) ?? [$item['data']['to']] : $item['data']['to'])->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', ') }}">
                                        {{ Str::limit(collect(is_string($item['data']['to']) ? json_decode($item['data']['to'], true) ?? [$item['data']['to']] : $item['data']['to'])->map(fn($r) => is_array($r) ? $r['email'] ?? ($r['name'] ?? 'Unknown') : $r)->implode(', '),50) }}
                                    </span>
                                </p>

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
                        <div class="text-end" style="min-width: 160px;">
                            <p class="mb-1 text-muted small">
                                {{ !empty($item['date']) ? \Carbon\Carbon::parse($item['date'])->format('M d, Y h:i A') : 'Unknown Date' }}
                            </p>
                            @if (!empty($item['data']['attachments']))
                                <p class="mt-1 mb-0 text-muted small">
                                    <i class="fa fa-paperclip"></i>
                                    {{ count($item['data']['attachments']) }}
                                    attachment{{ count($item['data']['attachments']) > 1 ? 's' : '' }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
                {{-- Collapsible details --}}
                <div class="contentdisplaytwo {{ $item['data']['uuid'] }} mt-3 p-3 rounded border bg-light"
                    style="display: none;">
                    {{-- Activity Timeline --}}
                    @if (
                        !empty($item['data']['open_count']) &&
                            $item['data']['open_count'] > 0 &&
                            $item['data']['type'] === 'outgoing' &&
                            $item['data']['folder'] === 'sent')
                        <div class="activity-section">
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
                                            <p class="mb-0 small"><i class="fa fa-info-circle"></i> No activity recorded
                                            </p>
                                            <small class="text-muted">N/A</small>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif


                    {{-- Attachments --}}
                    @if (!empty($item['data']['attachments']))
                        <div class="attachments-section mb-4">
                            <h6 class="fw-semibold text-dark mb-2">
                                <i class="fa fa-paperclip"></i> Attachments ({{ count($item['data']['attachments']) }})
                            </h6>
                            <div class="attachments-list">
                                @foreach ($item['data']['attachments'] as $attachment)
                                    <div
                                        class="attachment-item d-flex align-items-center mb-2 p-2 border rounded bg-white">
                                        <div class="me-2 text-muted fs-5">
                                            <i class="fa fa-file-o"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="fw-medium">{{ $attachment['filename'] ?? 'Unknown File' }}
                                            </div>
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


                    <div class="email-box-container" style="margin: 0; border-radius: 0;">
                        {{-- Email Body --}}
                        <div class="email-preview mb-4 text-dark small">
                            {!! $item['data']['body']['html'] ?? nl2br($item['data']['body']['text'] ?? 'No body content available.') !!}
                        </div>
                        <div>
                            <div class="new-profile-parent-wrapper">
                                <div class="new-profile-email-wrapper">
                                    <div class="user_profile_img">
                                        <div class="avatarr">MS
                                        </div>
                                    </div>
                                    <div class="user_profile_text">
                                        <p style="padding: 0; margin: 0;">
                                            Devod
                                            Word </p>

                                        <p style="font-weight: 500; padding-left: 0;">
                                            to
                                            info@hasnaat.com,
                                            abc@gmail.com.com
                                        </p>
                                    </div>
                                </div>


                                <div>
                                    <div class="new-profile-email-thread-wrapper">

                                        <div class="activities-seprater ">
                                            Reply all
                                        </div>
                                        <div class="activities-seprater ">
                                            Reply
                                        </div>

                                        <div class="activities-seprater open-form-btn">
                                            Forward
                                        </div>
                                        <div class="activities-seprater open-form-btn">
                                            Delete
                                        </div>


                                    </div>
                                    <div>
                                        <p>12/03/2024 4:48 PM GMT+5
                                        </p>
                                    </div>

                                </div>


                            </div>


                        </div>
                        <div class="user_cont user-email-template">
                            <p>
                                Hi Apex Web Team, <br>

                            </p><p class="email-body-text">
                                I hope you're doing well. I
                                specialize
                                in
                                online
                                reputation management and can help
                                boost
                                your
                                business's presence by generating
                                positive
                                reviews
                                and addressing any negative
                                feedback.

                            </p>
                            <div class="moretext">
                                <p class="email-body-text">
                                    I hope you're doing well. I
                                    specialize
                                    in online
                                    reputation management and can
                                    help
                                    boost
                                    your
                                    business's presence by
                                    generating
                                    positive reviews
                                    and addressing any negative
                                    feedback. I
                                    specialize
                                    in online
                                    reputation management and can
                                    help
                                    boost
                                    your
                                    business.

                                </p>
                                <br>
                                <p>--</p>

                                <p class="email-body-text">
                                    Street Hospitality <br>
                                    <span class="activities-seprater">
                                                                                                                                        +1-97-676552
                                                                                                                                    </span>
                                    <br>
                                    <a href="#" class="email-client-site-link">
                                        Visit our website!</a>
                                </p>

                                <img src="http://localhost:8000/assets/images/logo-img.png" class="img-fluid client-email-logo">

                                <br>
                                <br>
                            </div>


                            <div class="doc-attachment-container">
                                <a href="path/to/your/file.pdf" class="doc-attachment">
                                    <div class="icon-doc">
                                        📎
                                    </div>
                                    <div class="file-info-doc">
                                        <p class="file-name-doc">
                                            Document.pdf
                                        </p>
                                        <p class="file-size-doc">2
                                            MB
                                        </p>
                                    </div>
                                </a>
                            </div>

                            <div class="comment-head-thread-wrapper">


                                <div>

                                    <div class="email-child-wrapper">
                                        <!-- <a
                                    class="moreless-button activities-addition-links">
                                    Read more</a> -->
                                        <a class="moreless-button activities-addition-links">See
                                            more</a>
                                    </div>
                                </div>
                                <div>

                                    <div class="thread-dropdown-display">
                                        <button type="button" class="dropdown-toggle custom-drop-btn-design" id="dropdownMenuButtonthread" data-bs-toggle="dropdown" aria-expanded="false">
                                            3
                                            association
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonthread">
                                            <div>

                                                <div class="dropdown-content-wraper">
                                                    <ul class="nested-select-list">
                                                        <li class="checkbox-item">

                                                            <label>Companies
                                                                0</label>
                                                        </li>
                                                        <li class="checkbox-item">

                                                            <label>Carts
                                                                0</label>
                                                        </li>
                                                        <li class="checkbox-item">

                                                            <label>Contacts
                                                                0</label>
                                                        </li>
                                                        <li class="checkbox-item">

                                                            <label>Leads
                                                                0</label>
                                                        </li>
                                                        <li class="checkbox-item">

                                                            <label>Deals
                                                                0</label>
                                                        </li>
                                                        <li class="checkbox-item">

                                                            <label>Orders
                                                                0</label>
                                                        </li>
                                                        <!-- Add more items as needed -->
                                                    </ul>
                                                    <div>
                                                        <div class="search-box-select">
                                                            <input type="text" placeholder="Search current associations" class="search-input">
                                                        </div>
                                                        <div class="select-contact-box-space">
                                                            <p class="select-contact">
                                                                Contacts
                                                            </p>

                                                            <input type="checkbox" id="contact2">
                                                            <label for="contact2">HoeoSQMLp
                                                                becelhmerthewatt@yahoo.com</label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>


                            </div>


                        </div>

                    </div>
                </div>
            </div>
        @endif
    @endforeach
@else
    <p class="text-muted">No notes or emails found.</p>
@endif
