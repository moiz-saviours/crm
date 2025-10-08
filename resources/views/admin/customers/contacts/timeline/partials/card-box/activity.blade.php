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

<div class="data-highlights">
    <div class="cstm_note">
        <div class="row">
            <div class="col-md-12">
                <div class="data-top-heading-header d-flex align-items-center justify-content-between" style="cursor: pointer;">
                    <div class="d-flex align-items-center toggle-form-section">
                        <i class="fas fa-chevron-right toggle-icon me-2" ></i>
                        <h2 class="m-0">Page View</h2>
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
    @endphp

    <div class="cstm_note_2">
        <div class="row">
            <div class="col-md-12 cstm_note_cont" style="display: block">
                <p class="cont_p mt-2">{{ $customer_contact->name }} viewed <a href="{{ $activityData->url ?? '#' }}"
                                                                               class="activity-title"
                                                                               target="_blank"
                                                                               rel="noopener noreferrer">
                        '{{ $activityData->title ?? '---' }}'
                    </a></p>
                <p class="cont_p mt-4 form-submissions-content" style="display: none;">
                    {{ $customer_contact->name ?? "---"}}
                    with IP {{ $activityData->ip ?? 'Unknown' }}
                    using {{ $activityData->browser ?? 'Unknown Browser' }}
                    from {{ $activityData->country ?? 'Unknown' }}
                    and entered at
                    {{ isset($activityData->user_in_time) ? \Carbon\Carbon::parse($activityData->user_in_time)->format('Y-m-d H:i:s') : '---' }},
                    left at
                    {{ isset($activityData->user_out_time) ? \Carbon\Carbon::parse($activityData->user_out_time)->format('Y-m-d H:i:s') : '---' }},
                    Viewed <a href="{{ $activityData->url ?? '#' }}"
                              class="activity-title"
                              target="_blank"
                              rel="noopener noreferrer">
                        '{{ $activityData->title ?? '---' }}'
                    </a>,
                    stayed for {{ $activityData->total_duration ?? '---' }} seconds,
                    scrolled {{ $activityData->scroll_max_percent ?? 0 }}% down,
                    clicked {{ $activityData->click_count ?? 0 }} times
                </p>
            </div>
        </div>
    </div>
</div>

@if(!empty($activityData->form_submissions) && count($activityData->form_submissions) > 0)
    <div class="data-highlights mt-3">
        <div class="cstm_note">
            <div class="row">
                <div class="col-md-12">
                    <div class="data-top-heading-header d-flex align-items-center justify-content-between" style="cursor: pointer;">
                        <div class="d-flex align-items-center toggle-form-section">
                            <i class="fas fa-chevron-right toggle-icon me-2" ></i>
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

        <div class="cstm_note_2">
            <div class="row">
                <div class="col-md-12 cstm_form_cont">
                    @foreach($activityData->form_submissions as $formSubmission)
                        @php
                            $formData = $formSubmission->data ?? null;
                            $formName = $formSubmission->form_name ?? '';
                        @endphp

                        <p class="user_cont mt-2 mb-4">{{$customer_contact->name ?? "---"}} Submitted  <span class="submt_form_name">{{ $formName }}</span></p>

                        @if($formData)
                            <div class="form-infromation mb-3 form-submissions-content" style="display: none;">
                                @if(!empty($formData->Name))
                                    <p class="name-title">Name</p>
                                    <p class="name-content">{{ $formData->Name ?? "---"}}</p>
                                @endif

                                @if(!empty($formData->Email))
                                    <p class="name-title">Email</p>
                                    <p class="name-content">{{ $formData->Email ?? "---"}}</p>
                                @endif

                                @if(!empty($formData->Phone))
                                    <p class="name-title">Phone</p>
                                    <p class="name-content">{{ $formData->Phone ?? "---"}}</p>
                                @endif

                                @if(!empty($formData->msg))
                                    <p class="name-title">Message</p>
                                    <p class="name-content">{{ $formData->msg ?? "---"}}</p>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

@push('script')

@endpush
