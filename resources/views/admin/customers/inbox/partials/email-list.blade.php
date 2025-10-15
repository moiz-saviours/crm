<a href="#email-detail-{{ $email->id }}"
   class="list-group-item list-group-item-action email-main-body {{ $isFirst ? 'active' : '' }}"
   data-bs-toggle="tab" data-bs-target="#email-detail-{{ $email->id }}"
   data-sidebar-target="#sidebar-detail-{{ $email->id }}"
   role="tab" aria-controls="email-detail-{{ $email->id }}"
   aria-selected="{{ $isFirst ? 'true' : 'false' }}"
   data-name="{{ $email->from_name }}"
   data-email="{{ $email->from_email }}"
   data-subject="{{ $email->subject }}">
    <div class="d-flex align-items-center ">
        <div class="icon-checkbox-wrapper me-3">
            <i class="far fa-envelope aria-hidden="true" {{ $isFirst ? 'active-enelops' : '' }}"></i>
            <label class="my-custom-check-box custom-checkbox" onclick="event.stopPropagation()">
                <input type="checkbox" class="hover-checkbox"/>
                <span class="checkmark" style="margin: 0px 0px 0px 4px;">
                    <svg role="presentation" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                  <path d="M 2 6 L12 6 L12 9 L2 9 L2 6 z"></path>
                                </svg>
                </span>
            </label>
        </div>

        <div class="email-contents flex-grow-1">
            <p class="mb-0 email-address">{{ $email->from_email }}</p>
            <p class="mb-0 email-subject">{{ $email->subject }}</p>
                <p class="small-para mb-0 text-muted">

            </p>
            <div class="rep_btn_sec">
                <i class="fas fa-reply me-2"></i>{{ Str::limit($email->body, 30) }}
                <p class="para-second mb-0">{{ $email->message_date->diffForHumans() }}</p>

            </div>

        </div>


    </div>
</a>
