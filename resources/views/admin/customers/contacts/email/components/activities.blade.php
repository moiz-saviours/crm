      <div class="activ_head mt-3">

          <!-- Searchbox input -->
          <div class="search-containers">
              <form id="search-form" style="margin:0;">
                  <input type="text" class="search-inputs" placeholder="Search activities" name="query">
                  <button class="search-btns">
                      <i class="fa fa-search" aria-hidden="true"></i>
                  </button>
              </form>
          </div>
          <!-- Text-only buttons aligned to right -->
          <div class="d-flex ms-auto" style="gap: 10px;">
              <button id="refresh-emails" class="btn btn-primary fetching-buttons">
                  Refresh
              </button>
              <button id="fetch-emails" class="btn btn-primary fetching-buttons">
                  Fetch From Remote
              </button>
          </div>
          <!-- dropdown  -->
          <div class="dropdown">
              <button class="new-activity-dropdown btn-secondary dropdown-toggle d-none" type="button"
                  id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                  Collapse all
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                  <li><a class="dropdown-item" href="#">Action</a></li>
                  <li><a class="dropdown-item" href="#">Another action</a>
                  </li>
                  <li><a class="dropdown-item" href="#">Something else
                          here</a></li>
              </ul>
          </div>


      </div>

      <div class="custom-tabs-row">
          <ul class="nav nav-tabs newtabs-space" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                  <button class="nav-link customize active" id="act-tab" data-bs-toggle="tab" data-bs-target="#act"
                      type="button" role="tab" aria-controls="act" aria-selected="true">Activity
                  </button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link customize" id="notes-tab" data-bs-toggle="tab" data-bs-target="#notes"
                      type="button" role="tab" aria-controls="notes" aria-selected="true">Notes
                  </button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link customize" id="emails-tab" data-bs-toggle="tab" data-bs-target="#emails"
                      type="button" role="tab" aria-controls="emails" aria-selected="true">
                      Emails
                  </button>
              </li>

              <li class="nav-item" role="presentation">
                  <button class="nav-link customize" id="call-tab" data-bs-toggle="tab" data-bs-target="#call"
                      type="button" role="tab" aria-controls="call" aria-selected="false" tabindex="-1">Calls
                  </button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link customize" id="task-tab" data-bs-toggle="tab" data-bs-target="#task"
                      type="button" role="tab" aria-controls="task" aria-selected="false" tabindex="-1">Tasks
                  </button>
              </li>
              <li class="nav-item" role="presentation">
                  <button class="nav-link customize" id="meeting-tab" data-bs-toggle="tab" data-bs-target="#meeting"
                      type="button" role="tab" aria-controls="meeting" aria-selected="false"
                      tabindex="-1">Meetings
                  </button>
              </li>
          </ul>
          <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="act" role="tabpanel" aria-labelledby="act-tab">
                  <div>
                      <div>
                          <p class="recent-filters"> Filter by:
                              <span class="activities-seprater">Filter activity
                                  ({{ !empty($timeline) && count($timeline) > 0 ? count($timeline) : 0 }}/{{ !empty($timeline) && count($timeline) > 0 ? count($timeline) : 0 }})</span>
                          </p>
                      </div>
                      <p class="date-by-order"> May 2021</p>
                      <div class="recent-activities">
                          <div id="email-section">
                              @include('admin.customers.contacts.email.partials.activity')
                          </div>
                      </div>


                      <div class="data-highlights">
                          <div class="data-top-heading-header">
                              <h2>Life Cycle</h2>
                              <p>12/03/2024 4:48 PM GMT+5</p>
                          </div>
                          <p class="user_cont"> No associated objects of this
                              type
                              exist or you don't have permission to view them.
                              <span class="activities-seprater"> View detail
                                  <i class="fa fa-external-link" aria-hidden="true"></i>
                              </span>
                          </p>
                      </div>

                      {{-- <div class="recent-activities">


                                                            <div class="email-box-container ">
                                                                <div class="toggle-btnss">
                                                                    <div class="activ_head ">
                                                                        <div class="email-child-wrapper">
                                                                            <i class="fa fa-caret-right"
                                                                                aria-hidden="true"></i>
                                                                            <di>
                                                                                <h2>
                                                                                    Email - #Professional Image
                                                                                    Editing
                                                                                    <span class="user_cont">from
                                                                                        Harry
                                                                                        Brown</span>
                                                                                </h2>
                                                                                <p class="user_cont">from Harry
                                                                                    Brown</p>
                                                                            </di>
                                                                        </div>
                                                                        <p>12/03/2024 4:48 PM GMT+5</p>
                                                                    </div>
                                                                </div>


                                                                <div>
                                                                    <!-- <div class="contact-us-text">
                                                                        --
                                                                    </div> -->
                                                                    <div class="contentdisplay ">

                                                                        <div class="new-profile-parent-wrapper">
                                                                            <div class="new-profile-email-wrapper">
                                                                                <div class="user_profile_img">
                                                                                    <div class="avatarr">MS
                                                                                    </div>
                                                                                </div>
                                                                                <div class="user_profile_text">
                                                                                    <p>Mike Stewar</p>
                                                                                    <p style="font-weight: 500">
                                                                                        --
                                                                                    </p>
                                                                                </div>
                                                                            </div>

                                                                            <div class="new-profile-email-wrapper open-email-form"
                                                                                style="position: relative">
                                                                                <div class="activities-seprater ">
                                                                                    Reply
                                                                                </div>

                                                                                <div
                                                                                    class="activities-seprater open-form-btn">
                                                                                    Forward
                                                                                </div>
                                                                                <div
                                                                                    class="activities-seprater open-form-btn">
                                                                                    Delete
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- <div class="user_profile-hidden activ_head "
                                                                        id="toggledContent01">
                                                                        <div class="">
                                                                            <div class="user_profile_img">
                                                                                <div class="avatarr">MM</div>
                                                                            </div>
                                                                            <div class="user_profile_text">
                                                                                <p>Mike Stewar mikestewar1932@outlook.com
                                                                                </p>
                                                                                <p style="font-weight: 500">--
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <i class="fa fa-plus companies-add-forms open-form-btn"
                                                                                aria-hidden="true"> Add</i>
                                                                        </div>
                                                                    </div> -->
                                                                </div>
                                                                <div class="user_cont user-email-template">
                                                                    <p>
                                                                        Hi, <br> I hope you're doing well. I
                                                                        specialize
                                                                        in
                                                                        online reputation management and can
                                                                        help
                                                                        boost
                                                                        your
                                                                        business's presence by generating
                                                                        positive
                                                                        reviews
                                                                        and
                                                                        addressing any negative feedback.
                                                                    </p>
                                                                </div>
                                                                <!-- <div class="user_cont-toggler">
                                                                    <p>
                                                                        Hi, <br> I hope you're doing well. I specialize in
                                                                        online reputation management and can help boost your
                                                                        business's presence by generating positive reviews
                                                                        and
                                                                        addressing any negative feedback.
                                                                    </p>
                                                                </div> -->


                                                            </div>

                                                            <div class="data-highlights">
                                                                <div class="data-top-heading-header">
                                                                    <h2>Life Cycle</h2>
                                                                    <p>This contact was created </p>
                                                                </div>
                                                                <p class="user_cont"> No associated objects of
                                                                    this
                                                                    type
                                                                    exist or you don't have permission to view
                                                                    them.
                                                                    <span class="activities-seprater"> View
                                                                        detail
                                                                        <i class="fa fa-external-link"
                                                                            aria-hidden="true"></i>
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div> --}}
                  </div>
              </div>
              <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab">
                  <div class="email-threading-row">
                      <button class="threading-email-btn-two" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                          Create Notes
                      </button>
                  </div>
                  <p class="date-by-order">{{ \Carbon\Carbon::now()->format('F Y') }}</p>

                  {{-- @if ($customer_contact->notes->count() > 0)
                                                        @foreach ($customer_contact->notes as $noteKey => $note)
                                                            <div class="data-highlights">
                                                                <div class="cstm_note">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <div class="data-top-heading-header">
                                                                                <h2>Note</h2>
                                                                                <p>
                                                                                    {{ $note->created_at
                                                                                        ? \Carbon\Carbon::parse($note->created_at)->timezone('Asia/Karachi')->format('M j, Y \a\t g:i A \G\M\TP')
                                                                                        : '---' }}
                                                                                </p>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Edit & Delete Icons -->
                                                                <div class="cstm_note_2">
                                                                    <div class="row">
                                                                        <div class="col-md-12 cstm_note_cont">
                                                                            <p class="user_cont"
                                                                               id="note-text-{{$note->id}}">
                                                                                {{ $note->note ?? "No Note Available" }}
                                                                            </p>
                                                                            <div class="cstm_right_icon">
                                                                                <!-- Edit Icon -->
                                                                                <button class="p-0 border-0 cstm_btn">
                                                                                    <i class="fas fa-edit me-2 editNoteModal"
                                                                                       style="cursor: pointer;"
                                                                                       data-bs-toggle="modal"
                                                                                       data-bs-target="#editNoteModal"
                                                                                       data-id="{{$note->id}}"
                                                                                       data-note="{{$note->note}}"></i>
                                                                                </button>
                                                                                <!-- Delete Form -->
                                                                                <form
                                                                                    action="{{ route('admin.customer.contact.note.delete', $note->id) }}"
                                                                                    method="POST"
                                                                                    class="deleteNoteForm">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button type="submit"
                                                                                            class="p-0 border-0 cstm_btn">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="note-para">
                                                            Take notes about this record to keep track of important
                                                            info.
                                                            You can even @mention a teammate if you need to.
                                                        </p>
                                                    @endif --}}
                  @include('admin.customers.contacts.email.partials.note')


              </div>
              <div class="tab-pane fade" id="emails" role="tabpanel" aria-labelledby="email-tab">
                  <!-- Keep your existing HTML for other parts of the edit page -->
                  @include('admin.customers.contacts.email.partials.email')
              </div>




              <div class="tab-pane fade" id="call" role="tabpanel" aria-labelledby="call-tab">
                  @include('admin.customers.contacts.email.static-content.call')
              </div>

              <div class="tab-pane fade" id="task" role="tabpanel" aria-labelledby="task-tab">
                  @include('admin.customers.contacts.email.static-content.task')
              </div>

              <div class="tab-pane fade" id="meeting" role="tabpanel" aria-labelledby="meeting-tab">
                  @include('admin.customers.contacts.email.static-content.meeting')

              </div>
          </div>
      </div>
