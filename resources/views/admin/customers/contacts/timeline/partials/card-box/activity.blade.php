 <div class="data-highlights">
                <div class="cstm_note">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="data-top-heading-header">
                                <h2>Activities for {{ $customer_contact->name }}</h2>
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
                            <p class="user_cont mt-4">
                                {{ $customer_contact->name ?? "---"}}
                                with IP {{ $item['data']->ip ?? 'Unknown' }}
                                using {{ $item['data']->browser ?? 'Unknown Browser' }}
                                from {{ $item['data']->country ?? 'Unknown' }}
                                and entered at
                                {{ isset($activityData->user_in_time) ? \Carbon\Carbon::parse($activityData->user_in_time)->format('Y-m-d H:i:s') : '---' }},
                                left at
                                {{ isset($activityData->user_out_time) ? \Carbon\Carbon::parse($activityData->user_out_time)->format('Y-m-d H:i:s') : '---' }},
                                visited '{{ $activityData->url ?? '---' }}',
                                stayed for {{ $activityData->total_duration ?? '---' }} seconds,
                                scrolled {{ $activityData->scroll_max_percent ?? 0 }}% down,
                                clicked {{ $activityData->click_count ?? 0 }} times

                                @if(!empty($activityData->form_submissions) && count($activityData->form_submissions) > 0)
                                    @foreach($activityData->form_submissions as $formSubmission)
                                        @php
                                            $formData = $formSubmission->data ?? null;
                                            $formName = $formSubmission->form_name ?? '';
                                        @endphp
                                        , submitted form '{{ $formName }}'

                            @if($formData)
                                <div class="form-infromation">
                                    <p class="main-heading">Form Submit:</p>

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
                                @endif
                                </p>
                        </div>
                    </div>
                </div>

            </div>