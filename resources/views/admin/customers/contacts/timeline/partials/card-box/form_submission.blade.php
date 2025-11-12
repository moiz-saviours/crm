<div class="data-highlights mt-3">
    <div class="cstm_note">
        <div class="row">
            <div class="col-md-12">
                <div class="data-top-heading-header d-flex align-items-center justify-content-between" style="cursor: pointer;">
                    <div class="d-flex align-items-center toggle-form-section">
                        <i class="fas fa-chevron-right toggle-icon me-2"></i>
                        <h2 class="m-0">Form Submission</h2>
                    </div>
                    <p>
                        {{ $item['date']
                            ? \Carbon\Carbon::parse($item['date'])->timezone('Asia/Karachi')->format('M j, Y \a\t g:i A \G\M\TP')
                            : '---' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @php
        $activityData = $item['data']->data ?? null;
        $formData = $activityData->data ?? null;
    @endphp

    @if(!empty($formData))
        <div class="cstm_note_2">
            <div class="row">
                <div class="col-md-12 cstm_form_cont">
                    <p class="user_cont mt-2 mb-4">
                        {{ $customer_contact->name ?? "---" }} submitted Form

                    </p>

                    <div class="form-infromation mb-3 form-submissions-content" style="display: none;">
                        @if(!empty($formData->Name))
                            <p class="name-title">Name</p>
                            <p class="name-content">{{ $formData->Name ?? "---" }}</p>
                        @endif

                        @if(!empty($formData->Email))
                            <p class="name-title">Email</p>
                            <p class="name-content">{{ $formData->Email ?? "---" }}</p>
                        @endif

                        @if(!empty($formData->Phone))
                            <p class="name-title">Phone</p>
                            <p class="name-content">{{ $formData->Phone ?? "---" }}</p>
                        @endif

                        @if(!empty($formData->msg))
                            <p class="name-title">Message</p>
                            <p class="name-content">{{ $formData->msg ?? "---" }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
