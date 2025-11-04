<style>
    .activity-title {
        color: var(--bs-primary);
        font-weight: 500;
    }
    a {
        text-decoration: none;
        text-underline: none;
    }
</style>
<div class="activ_head">
    <div class="search-containers">
        <form id="search-form" style="margin:0;">
            <input type="text" class="search-inputs" placeholder="Search activities" name="query">
            <button class="search-btns">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
        </form>
    </div>
    <div class="d-flex ms-auto" style="gap: 10px;">
        <button id="refresh-emails" 
                class="btn btn-primary fetching-buttons" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Click to refresh the data">
            <i class="fas fa-sync-alt"></i>
        </button>

        <button id="fetch-emails" 
                class="btn btn-primary fetching-buttons" 
                data-bs-toggle="tooltip" 
                data-bs-placement="top" 
                title="Fetch emails from remote server">
            <i class="fas fa-cloud-download-alt"></i>
        </button>

        <div class="dropdown">
            <button class="new-activity-dropdown btn-secondary dropdown-toggle" type="button"
                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                Collapse all
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <li><a class="dropdown-item" href="#">Collapse All</a></li>
                <li><a class="dropdown-item" href="#">Expand All</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="custom-tabs-row">
<ul class="nav nav-tabs newtabs-space" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link customize active" data-tab="activities" data-bs-toggle="tab" data-bs-target="#activities-container"
                type="button" role="tab" aria-controls="activities" aria-selected="true">Activity
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link customize" data-tab="notes" data-bs-toggle="tab" data-bs-target="#notes-container"
                type="button" role="tab" aria-controls="notes" aria-selected="false">Notes
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link customize" data-tab="emails" data-bs-toggle="tab" data-bs-target="#emails-container"
                type="button" role="tab" aria-controls="emails" aria-selected="false">Emails
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link customize" data-tab="calls" data-bs-toggle="tab" data-bs-target="#calls-container"
                type="button" role="tab" aria-controls="calls" aria-selected="false">Calls
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link customize" data-tab="meetings" data-bs-toggle="tab" data-bs-target="#meetings-container"
                type="button" role="tab" aria-controls="meetings" aria-selected="false">Meetings
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link customize" data-tab="chats" data-bs-toggle="tab" data-bs-target="#chats-container"
                type="button" role="tab" aria-controls="chats" aria-selected="false">Chats
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link customize" data-tab="projects" data-bs-toggle="tab" data-bs-target="#projects-container"
                type="button" role="tab" aria-controls="projects" aria-selected="false">Projects
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link customize" data-tab="tasks" data-bs-toggle="tab" data-bs-target="#tasks-container"
                type="button" role="tab" aria-controls="tasks" aria-selected="false">Tasks
        </button>
    </li>
</ul>

    <div class="tab-content " id="myTabContent">
        <div id="timeline-loader" style="display: none; text-align: center; padding: 20px;">
            <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i> Loading...
        </div>
        <div class="tab-pane fade custom-tabs-row-scroll show active" id="activities-container" role="tabpanel" aria-labelledby="act-tab">
            <div>
                <div class="recent-activities">
                    <div class="timeline-header">
                        <p class="recent-filters">
                            Filter by:
                            <span class="activities-seprater">
                                Filter activity (3/{{ (int)$total_count }})
                            </span>
                        </p>
                    </div>
                        <p class="date-by-order"> May 2021</p>
                    <div class="card-box">
                        @include('admin.customers.contacts.timeline.partials.activity')
                    </div>
                </div>
                {{-- <div class="data-highlights">
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
                </div> --}}

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
        <div class="tab-pane fade custom-tabs-row-scroll" id="notes-container" role="tabpanel" aria-labelledby="notes-tab">
            @include('admin.customers.contacts.timeline.partials.note')
        </div>
        <div class="tab-pane fade custom-tabs-row-scroll" id="emails-container" role="tabpanel" aria-labelledby="email-tab">
            @include('admin.customers.contacts.timeline.partials.email')
        </div>
        <div class="tab-pane fade custom-tabs-row-scroll" id="calls-container" role="tabpanel" aria-labelledby="call-tab">
            @include('admin.customers.contacts.timeline.static-content.call')
        </div>
        <div class="tab-pane fade custom-tabs-row-scroll" id="meetings-container" role="tabpanel" aria-labelledby="meeting-tab">
            @include('admin.customers.contacts.timeline.static-content.meeting')
        </div>
        <div class="tab-pane fade custom-tabs-row-scroll" id="projects-container" role="tabpanel" aria-labelledby="project-tab">
            @include('admin.customers.contacts.timeline.partials.project.index')
        </div>
                <div class="tab-pane fade custom-tabs-row-scroll" id="tasks-container" role="tabpanel" aria-labelledby="task-tab">
            @include('admin.customers.contacts.timeline.partials.task.index')
        </div>
        <div class="tab-pane fade" id="chats-container" role="tabpanel" aria-labelledby="chat-tab">
            @include('admin.customers.contacts.timeline.partials.chat.index')
        </div>
        <div id="show-more-container" class="text-center mt-3" style="display: {{ count($timeline) >= $limit ? 'block' : 'none' }};">
            <button id="show-more-btn" class="btn btn-outline-primary btn-sm">
                Show More
            </button>
        </div>
    </div>
</div>
