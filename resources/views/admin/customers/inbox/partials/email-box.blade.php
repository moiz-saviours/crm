<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="email-detail-{{ $email->id }}" role="tabpanel"
     aria-labelledby="email-detail-{{ $email->id }}-tab">
    <div
        class="d-flex justify-content-between align-items-center email-header-main px-3 border-bottom">
        <div class="d-flex align-items-center">
            <span
                class="profile-avatar-h me-3">{{ strtoupper(implode('', array_map(function($word) {
    return substr($word, 0, 1);
}, array_slice(explode(' ', $email->from_name ?: $email->from_email), 0, 2)))) }}</span>
            <div>
                <span class="main-area-email-para">{{ $email->from_email }}</span><br/>
                <span class="main-area-email-para-time">Created {{ $email->message_date->diffForHumans() }}</span>
            </div>
        </div>
    </div>
    <div class="p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="profile-description">Owner</span>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="user-info-dropdown">
                <div class="user-info d-flex align-items-center" id="userDropdownToggle"
                     role="button" aria-expanded="false">
                    <div class="icon-wrapper me-2">
                        <i class="fas fa-user-circle profile-icon"
                           aria-hidden="true"></i>
                        <span class="status-dot"></span>
                    </div>
                    <p class="user_name mb-0">{{ $email->from_name }}</p>
                    <i class="fas fa-caret-down ms-2 custom-fa-caret-down"
                       aria-hidden="true"></i>
                </div>

                <div class="user-dropdown-menu" id="userDropdownMenu">
                    <div class="search-box">
                        <input type="text" placeholder="Search for a specific user">
                        <i class="fas fa-search search-icon"></i>
                    </div>

                    <div class="d-flex justify-content-end mb-2">
                        <button class="unassign-btn">Unassign</button>
                    </div>

                    <div class="user-list">
                        <div
                            class="user-item-row active-user d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-2">
                                    <i class="fas fa-user-circle"></i>
                                    <span class="status-dot-sm away"></span>
                                </div>
                                <div>
                                    <p class="item-user-name mb-0">Hasnat Khan</p>
                                    <p class="item-user-status mb-0 away-text">Away</p>
                                </div>
                            </div>
                            <i class="fas fa-check check-icon"></i>
                        </div>

                    </div>
                </div>
            </div>

            {{--            <div class="user-info-dropdown">--}}
            {{--                <input type="checkbox" id="user-dropdown-toggle-{{ $email->id }}" class="dropdown-toggle">--}}
            {{--                <label for="user-dropdown-toggle-{{ $email->id }}" class="user-info d-flex align-items-center">--}}
            {{--                    <div class="icon-wrapper me-2">--}}
            {{--                        <i class="fas fa-user-circle profile-icon"></i>--}}
            {{--                        <span class="status-dot"></span>--}}
            {{--                    </div>--}}
            {{--                    <p class="user_name mb-0">{{ $email->from_name }}</p>--}}
            {{--                    <i class="fas fa-caret-down ms-2 custom-fa-caret-down"></i>--}}
            {{--                </label>--}}
            {{--                <div class="user-dropdown-menu">--}}
            {{--                    <div class="search-box">--}}
            {{--                        <input type="text" placeholder="Search for a specific user">--}}
            {{--                        <i class="fas fa-search search-icon"></i>--}}
            {{--                    </div>--}}
            {{--                    <div class="d-flex justify-content-end mb-2">--}}
            {{--                        <button class="unassign-btn">Unassign</button>--}}
            {{--                    </div>--}}
            {{--                    <div class="user-list">--}}
            {{--                        <div class="user-item-row active-user d-flex align-items-center justify-content-between">--}}
            {{--                            <div class="d-flex align-items-center">--}}
            {{--                                <div class="avatar-sm me-2">--}}
            {{--                                    <i class="fas fa-user-circle"></i>--}}
            {{--                                    <span class="status-dot-sm away"></span>--}}
            {{--                                </div>--}}
            {{--                                <div>--}}
            {{--                                    <p class="item-user-name mb-0">{{ $email->from_name }}</p>--}}
            {{--                                    <p class="item-user-status mb-0 away-text">Away</p>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                            <i class="fas fa-check check-icon"></i>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <p class="mb-2 "><b>{{ Str::limit($email->subject, 30, '...') }}</b></p>
        </div>
        <div class="email-reply-wrapper">
            <div
                data-test-id="dashed-label"
                class="date-separator-wrapper">
                <div
                    data-test-id="dash-left"
                    class="date-line-segment"
                ></div>

                <div class="date-label-badge">
                    <p class="date-label-text">October 9</p>
                </div>

                <div
                    data-test-id="dash-right"
                    class="date-line-segment"
                ></div>
            </div>
            <div class="d-flex align-items-start email-reply-block">
                <i class="fas fa-user-circle  me-2" style="font-size: 20px"></i>
                <div class="flex-grow-1">
                    <div
                        class="d-flex justify-content-between align-items-start email-header-row"
                    >
                    <p class="email-from mb-0 d-flex align-items-center">
                        <b>{{ $email->from_name }}</b>
                        <span class="small ms-2">{{ $email->message_date->format('g:i A') }}</span>
                        <span class="emailbox-trigger ms-4 last-span text-bold">
                              Email
                              <i class="fas fa-caret-down ms-2 last-span-icon"></i>
                            </span>
                    </p>
                    <div class="d-flex align-items-center icon-actions gap-2" >
                                <span class="icon-wrapper-two" ><i
                                        class="fas fa-reply"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        title="reply"
                                        data-bs-custom-class="custom-blue-tooltip"
                                    ></i
                                    ></span>
                        <span class="icon-wrapper-two" ><i
                                class="fas fa-reply-all"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Reply all"
                                data-bs-custom-class="custom-blue-tooltip"
                            ></i
                            ></span>
                        <span class="icon-wrapper-two" ><i
                                class="fas fa-forward"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Forward"
                                data-bs-custom-class="custom-blue-tooltip"
                            ></i
                            ></span>
                        <span class="icon-wrapper-two" ><i
                                class="fas fa-ellipsis-v"
                                data-bs-toggle="tooltip"
                                data-bs-placement="top"
                                title="Message Action"
                                data-bs-custom-class="custom-blue-tooltip"
                            ></i
                            ></span>
                    </div>
                    </div>
                    <div class="emailbox-container shadow-sm">
                        <div class="emailbox-arrow"></div>
                        <div class="emailbox-content">
                            <div class="emailbox-row">
                                <span class="emailbox-label">From:</span>
                                <span class="emailbox-value" id="fromText"
                                >hasnat.khan@stellers.org</span
                                >
                                <i
                                    class="fas fa-copy emailbox-copy"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Copy"
                                    data-bs-custom-class="custom-blue-tooltip"
                                ></i>
                            </div>
                            <div class="emailbox-row">
                                <span class="emailbox-label">To:</span>
                                <span class="emailbox-value" id="toText"
                                >Hasnat Developer
                                    &lt;hasnat.developer@pivotbookwriting.com&gt;</span
                                >
                                <i
                                    class="fas fa-copy emailbox-copy"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="Copy"
                                    data-bs-custom-class="custom-blue-tooltip"
                                ></i>
                            </div>
                            <div class="emailbox-row">
                                <span class="emailbox-label">Date:</span>
                                <span class="emailbox-value" id="dateText"
                                >Thu, Oct 9, 2025 4:28 PM</span
                                >
                            </div>
                            <div class="emailbox-row">
                                <span class="emailbox-label">Subject:</span>
                                <span class="emailbox-value" id="subjectText"
                                >10MB PDF</span
                                >
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 email-to text-muted small">
                        To: @php
                            $toDisplay = $email->from_email; // fallback

                            if (isset($email->to)) {
                                $toEmails = is_string($email->to) ? json_decode($email->to, true) : $email->to;

                                if (is_array($toEmails) && !empty($toEmails)) {
                                    $recipients = [];
                                    foreach ($toEmails as $recipient) {
                                        if (isset($recipient['name']) && !empty($recipient['name'])) {
                                            $recipients[] = $recipient['name'] . ' <' . $recipient['email'] . '>';
                                        } else {
                                            $recipients[] = $recipient['email'];
                                        }
                                    }
                                    $toDisplay = implode(', ', $recipients);
                                } elseif (isset($email->to_email)) {
                                    $toDisplay = $email->to_email;
                                }
                            } elseif (isset($email->to_email)) {
                                $toDisplay = $email->to_email;
                            }
                        @endphp
                        {{ $toDisplay }}
                    </p>
                    <p class="email-body mt-2">
                        {{ $email->body }}
                    </p>


                </div>
            </div>
        </div>
        <hr/>
        <div class="resizable-panel">
            <div class="resizable-content">
                <div
                    class="d-flex justify-content-start align-items-center mt-3 envelop-open-text-section">
                    <i class="fas fa-envelope-open-text me-1 icon-email-reply"></i>
                    <span class="email-comment-tabs email-decription">Email <i
                            class="fas fa-caret-down ms-1"></i></span>
                    <i class="fas fa-comment ms-4 me-2 icon-comment"></i>
                    <span class="email-comment-tabs comment-description">Comment</span>
                    <span class="ms-auto">
                            <i class="fa-solid fa-up-right-and-down-left-from-center enlarge-icon"></i>
                          </span>
                </div>
                <div
                    class="d-flex justify-content-between align-items-center text-muted mt-2 mb-2 email-area-choose-reciepeint">
                    <div
                        class="recipient-selection-container d-flex align-items-center flex-grow-1 me-3">
                        <i class="fas fa-reply" id="reply-icon"></i>
                        <div class="d-flex flex-wrap align-items-center flex-grow-1">
                            <input
                                class="email-area-input-for-recipeint ms-2 flex-grow-1 border-0"
                                placeholder="Enter or choose a recipient"
                                type="text"
                                autocomplete="off"/>
                        </div>
                    </div>
                    <i class="fas fa-ellipsis-v ms-3" id="more-options-icon"></i>
                </div>
            </div>
        </div>
        <div class="form-control mt-2 email-compose-box">
            <div class="editor-wrapper">
                <div id="editorContent-{{ $email->id }}" class=" text-placeholder"
                     contenteditable="true">
                    Write a message. Press '/' or highlight text to
                    access AI commands.
                </div>
                <div class="editor-toolbar d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="editor-icon fas fa-font me-3" data-bs-toggle="tooltip"
                           title="Change Font"></i>
                        <i class="editor-icon fas fa-smile me-3 text-primary"
                           data-bs-toggle="tooltip"
                           title="Press window with ;"></i>
                        <div class="dropdown me-3">
                            <i class="editor-icon fas fa-link" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false"></i>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Insert Link</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Remove Link</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropdown me-3">
                            <i class="editor-icon fas fa-image" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false"></i>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Upload New
                                        Image</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Insert Existing
                                        Image</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropup me-3">
                            <i class="editor-icon fas fa-paperclip" role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false"></i>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Attach File</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Browse
                                        Documents</a>
                                </li>
                            </ul>
                        </div>
                        <div class="dropup me-3">
                            <button class="btn btn-secondary insert-btn" type="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                Insert
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="#">Insert Invoice</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Insert
                                        Documents</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Insert Code</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <button class="btn btn-primary send-btn">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
