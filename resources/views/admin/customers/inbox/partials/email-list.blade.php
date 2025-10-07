<a href="#email-detail-{{ $email->id }}"
   class="list-group-item list-group-item-action email-main-body {{ $loop->first ? 'active' : '' }}"
   data-bs-toggle="tab" data-bs-target="#email-detail-{{ $email->id }}"
   data-sidebar-target="#sidebar-detail-{{ $email->id }}"
   role="tab" aria-controls="email-detail-{{ $email->id }}"
   aria-selected="{{ $loop->first ? 'true' : 'false' }}"
   data-name="{{ $email->from_name }}"
   data-email="{{ $email->from_email }}"
   data-subject="{{ $email->subject }}">
    <div class="d-flex align-items-center">
        <div class="icon-checkbox-wrapper me-3">
            <i class="far fa-envelope {{ $loop->first ? 'active-enelops' : '' }}"></i>
            <label class="custom-checkbox me-2" onclick="event.stopPropagation()">
                <input type="checkbox" class="hover-checkbox"/>
                <span class="check-icon"></span>
            </label>
        </div>
        <div class="email-contents flex-grow-1">
            <p class="mb-0 email-address">{{ $email->from_email }}</p>
            <p class="mb-0 email-subject">{{ $email->subject }}</p>
            <p class="small-para mb-0 text-muted">
                <i class="fas fa-reply me-2"></i>{{ Str::limit($email->body, 30) }}
            </p>
        </div>
        <p class="para-second mb-0">{{ $email->created_at->diffForHumans() }}</p>
    </div>
</a>
