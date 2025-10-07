<!-- Right Sidebar for Email -->
<div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="sidebar-detail-{{$email->id}}" role="tabpanel"
     aria-labelledby="email-detail-{{$email->id}}-tab">
    <div class="right-sidebar-header d-flex justify-content-between align-items-center">
        <div class="btn-group me-2" role="group">

            <button type="button"
                    class="custom-btn-right btn btn-tertiary-light d-flex align-items-center justify-content-center">
                <i class="fas fa-check-circle me-1" aria-hidden="true"></i>
                <span>Close conversation</span>
            </button>

            <button id="extraBtn1" type="button"
                    class="btn btn-tertiary-light d-none d-flex align-items-center justify-content-center">
                <i class="fas fa-trash me-1" aria-hidden="true"></i>
                <span>Trash</span>
            </button>
        </div>

        <div class="btn-group" role="group">
            <div class="dropdown custom-popup">
                <button type="button" class="btn btn-tertiary-light"
                        id="actionMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-start ms-2"
                    aria-labelledby="actionMenuButton1">
                    <li>
                        <a class="dropdown-item" href="#"><i
                                class="fas fa-trash me-2 text-danger"></i>
                            Move to Trash</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i
                                class="fas fa-ban me-2 text-warning"></i>
                            Block Sender</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#"><i
                                class="fas fa-exclamation-triangle me-2 text-secondary"></i>
                            Mark as Spam</a>
                    </li>
                </ul>
            </div>
            <button type="button" class="btn btn-tertiary-light info-circle-iconnn">
                <i class="fas fa-info-circle"></i>
            </button>
        </div>
    </div>

    <div class="d-flex align-items-center mt-3 mb-3 ms-2">
        <span class="profile-avatar-h me-3 right-sidebar-profile-avator">{{ strtoupper(implode('', array_map(function($word) {
    return substr($word, 0, 1);
}, array_slice(explode(' ', $email->from_name ?: $email->from_email), 0, 2)))) }}</span>
        <div>
            <span class="main-area-email-para-right-sidebar">{{ $email->from_email }}</span><br/>
        </div>
    </div>
    <hr/>

    <div id="sortable-container-1">
        <!-- About Contact -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#about-contact-section-1" aria-expanded="false"
                 aria-controls="about-contact-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>About this Contact</span>
                <i class="fas fa-info-circle info-circle-icon ms-auto"></i>
            </div>
            <div class="collapse custom-sidebar-content" id="about-contact-section-1">
                <div class="contact-info-item">
                    <p class="info-label">Email</p>
                    <p class="info-value">hasnatkha@gmail.com</p>
                </div>
                <div class="contact-info-item">
                    <p class="info-label">Phone Number</p>
                    <p class="info-value">---</p>
                </div>
                <div class="contact-info-item">
                    <p class="info-label">Contact owner</p>
                    <p class="info-value">Moiz Athar</p>
                </div>
                <div class="contact-info-item">
                    <p class="info-label">Total revenue</p>
                    <p class="info-value">---</p>
                </div>
                <div class="contact-info-item">
                    <p class="info-label">Recent deal amount</p>
                    <p class="info-value">---</p>
                </div>
                <div class="contact-info-item">
                    <p class="info-label">
                        Date entered (Customer Lifecycle Stage)
                    </p>
                    <p class="info-value">---</p>
                </div>
            </div>
        </div>

        <!-- Companies -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#companies-section-1" aria-expanded="false"
                 aria-controls="companies-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Companies (1)</span>
            </div>
            <div class="collapse custom-sidebar-content" id="companies-section-1">
                <div class="company-card">
                    <div class="company-header">
                        <span class="btn btn-sm btn-outline-primary">Primary</span>
                        <div>
                            <span class="btn btn-sm btn-dark">Preview</span>
                            <span
                                class="btn btn-sm btn-dark dropdown-toggle">More</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <span class="me-2 fw-bold">--</span>
                        <i class="fas fa-building fa-2x text-muted ms-auto"></i>
                    </div>
                    <p class="company-link">
                        <a href="http://pivotbookwriting.com" target="_blank">pivotbookwriting.com<i
                                class="fas fa-external-link-alt"></i></a>
                        <i class="fas fa-copy"></i>
                    </p>
                    <p>Phone: --</p>
                </div>
                <p class="view-commpany ms-3 mt-2">
                    View Associated Company
                </p>
            </div>
        </div>

        <!-- Other Conversations -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#other-conversations-section-1" aria-expanded="false"
                 aria-controls="other-conversations-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Other Conversations (1)</span>
            </div>
            <div class="collapse custom-sidebar-content"
                 id="other-conversations-section-1">
                <div class="other-conversations-section">
                    <p>
                        <i class="fas fa-envelope"></i> Assigned to Moiz
                        Athar
                    </p>
                    <p>
                        <a href="http://pivotbookwriting.com" target="_blank">Test
                            <i class="fas fa-external-link-alt ms-2"></i></a>
                    </p>
                    <p>Latest message sent 8 hours ago</p>
                </div>
            </div>
        </div>

        <!-- Contacts -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#contacts-section-1" aria-expanded="false"
                 aria-controls="contacts-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Contacts (0)</span>
            </div>
            <div class="collapse custom-sidebar-content" id="contacts-section-1">
                <div class="contacts-section">
                    <p>See the people associated with this record</p>
                </div>
            </div>
        </div>

        <!-- Subscriptions -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#subscriptions-section-1" aria-expanded="false"
                 aria-controls="subscriptions-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Subscriptions (0)</span>
            </div>
            <div class="collapse custom-sidebar-content" id="subscriptions-section-1">
                <div class="contacts-section">
                    <p>
                        Automate subscription management and recurring
                        billing from this record
                    </p>
                    <div class="d-flex justify-content-center">
                        <button class="right-sec-payment-btn">
                            Set up Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#payments-section-1" aria-expanded="false"
                 aria-controls="payments-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Payments (0)</span>
            </div>
            <div class="collapse custom-sidebar-content" id="payments-section-1">
                <div class="contacts-section">
                    <p>
                        Track payments associated with this record. A
                        payment is created when a customer pays or
                        recurring payment is processed through HubSpot.
                    </p>
                    <div class="d-flex justify-content-center">
                        <button class="right-sec-payment-btn">
                            Set up Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#ticket-section-1" aria-expanded="false"
                 aria-controls="ticket-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Tickets (02)</span>
            </div>
            <div class="collapse custom-sidebar-content" id="ticket-section-1"></div>
        </div>

        <!-- Deals -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#deals-section-1" aria-expanded="false"
                 aria-controls="deals-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Deals (04)</span>
            </div>
            <div class="collapse custom-sidebar-content" id="deals-section-1"></div>
        </div>

        <!-- Other Tickets -->
        <div class="sortable-item">
            <div class="custom-sidebar-header collapsed" data-bs-toggle="collapse"
                 data-bs-target="#other-ticket-section-1" aria-expanded="false"
                 aria-controls="other-ticket-section-1">
                <i class="fas fa-grip-vertical drag-handle-icon"></i>
                <i class="fas fa-angle-right custom-toggle-icon"></i>
                <span>Other Tickets (04)</span>
            </div>
            <div class="collapse custom-sidebar-content"
                 id="other-ticket-section-1"></div>
        </div>
    </div>
</div>
