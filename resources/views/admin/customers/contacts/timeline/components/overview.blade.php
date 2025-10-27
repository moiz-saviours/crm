<div>
    <div class="data-highlights">
        <div class="data-top-heading-header">
            <h2>Data highlights</h2>
            <p class="contact-card-details-head">12/03/2024 4:48 PM
                GMT+5
            </p>
        </div>
        <div class="data-row">
            <div>
                <h5>CREATE DATE</h5>
                <p>{{$customer_contact->created_at}}</p>
            </div>
            <div>
                <h5>LIFECYCLE STAGE</h5>
                <p>Lead</p>
            </div>
            <div>
                <h5>LAST ACTIVITY DATE</h5>
                <p>12/03/2024 4:48 PM GMT+5</p>
            </div>
        </div>
    </div>
    <div class="recent-activities">
        <div class="activity">
            <h2>Recent activities</h2>
            <div>
                <p class="recent-filters"> Filter by: <span
                        class="activities-seprater">7 activities</span>
                </p>
            </div>
            <div class="email-box-container">
                <div class="activ_head"
                     onclick="toggleContent('toggledContent1')">
                    <div class="email-child-wrapper">
                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                        <i class="fa fa-envelope-o new-sidebar-icons"
                           aria-hidden="true"></i>
                        <p>Inbound email from
                            <span class="activities-seprater">{{$customer_contact->name}}</span>
                        </p>
                    </div>
                    <p class="usre_date">Dec 3, 2024 at 4:48 PM GMT+5 </p>
                </div>
                <div class="collpase-divider mt-2 mb-2"></div>
                <div>
                    <div class="contact-us-text">
                        <p>contact us</p>
                    </div>
                    <div class="user_profile-hidden" id="toggledContent1">
                        <div class="user_profile_img">
                            <div class="avatarr">MM</div>
                        </div>
                        <div class="user_profile_text">
                            <p>Mike Stewar mikestewar1932@outlook.com
                            </p>
                            <p style="font-weight: 500">to
                                info@phototouchexpert.com
                            </p>
                        </div>
                    </div>
                </div>
                <div class="user_cont">
                    <p>
                        Hi there, I hope you're doing well. I specialize
                        in
                        online reputation management and can help boost
                        your
                        business's presence by generating positive
                        reviews
                        and
                        addressing any negative feedback.
                    </p>
                </div>
                <div>
                    <div class="comment-active_head" id="toggledContent1">
                        <div>
                            <div class="email-child-wrapper"
                                 id="toggleButton">
                                <i class="fa fa-commenting-o add-coment-icon"
                                   aria-hidden="true"></i>
                                <span class="activities-addition-links">Add Comments</span>
                            </div>
                            <div id="contents" class="hidden comment-box">
                                <div class="editor-container">
                                    <div class="avatarr">MM</div>
                                    <div>
                                        <!-- editor -->
                                        <!-- <div class="editor-container">
                                    <button
                                        class="your-create-contact create-contact">comment</button>
                                    <button
                                        class="your-comment-cancel">Cancel</button>
                                </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                class="dropdown-toggle custom-drop-btn-design"
                                id="dropdownMenuButtonassociate"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                            3
                            association
                        </button>
                        <ul class="dropdown-menu"
                            aria-labelledby="dropdownMenuButtonassociate">
                            <div>
                                <div class="dropdown-content-wraper">
                                    <ul class="nested-select-list">
                                        <li class="checkbox-item">
                                            <label>Companies 0</label>
                                        </li>
                                        <li class="checkbox-item">
                                            <label>Carts 0</label>
                                        </li>
                                        <li class="checkbox-item">
                                            <label>Contacts 0</label>
                                        </li>
                                        <li class="checkbox-item">
                                            <label>Leads 0</label>
                                        </li>
                                        <li class="checkbox-item">
                                            <label>Deals 0</label>
                                        </li>
                                        <li class="checkbox-item">
                                            <label>Orders 0</label>
                                        </li>
                                        <!-- Add more items as needed -->
                                    </ul>
                                    <div>
                                        <div class="search-box-select">
                                            <input type="text" placeholder="Search current associations"
                                                   class="search-input">
                                        </div>
                                        <div
                                            class="select-contact-box-space">
                                            <p class="select-contact">Contacts</p>
                                            <input type="checkbox" id="contact2">
                                            <label for="contact2">HoeoSQMLp becelhmerthewatt@yahoo.com</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                    <div class="collpase-divider mt-2 mb-2"></div>
                    <div class=" mt-2 mb-2">
                        <a href="#" class="activities-addition-links">View full activity</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="activity">
            <div class="association-activities-box">
                <h2>Companies</h2>
                <div>
                    <i class="fa fa-plus companies-add-forms open-form-btn"
                       aria-hidden="true"> Add</i>
                </div>
            </div>
            <p class="user_cont text-center"> No associated objects of this type exist or you don't have permission to
                view them.</p>
        </div>
    </div>
</div>
