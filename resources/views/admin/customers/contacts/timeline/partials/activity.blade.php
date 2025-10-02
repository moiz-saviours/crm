<style>
    .thread-email-item {
        margin-left: 20px;
        border-left: 2px solid #e9ecef;
        padding-left: 15px;
    }

    .toggle-thread-btn {
        cursor: pointer;
        color: #007bff;
    }

    .toggle-thread-btn:hover {
        text-decoration: underline;
    }

    .folder-dot {
        font-size: 1.5rem;
        margin-right: 0.2rem;
    }

    .folder-name {
        font-size: 0.675rem;
        vertical-align: super;
    }
</style>
@if (!empty($timeline) && count($timeline) > 0)
    @include('admin.customers.contacts.timeline.static-content.email')

    @foreach ($timeline as $item)
        @if ($item['type'] === 'note')
            {{-- ================= NOTE ================= --}}
            <div class="data-highlights">
                <div class="cstm_note">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="data-top-heading-header">
                                <h2>Note By {{ ucwords($item['data']->creator?->name ?? 'Unknown') }}</h2>
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
                        <div class="col-md-12 cstm_note_cont">
                            <p class="user_cont" id="note-text-{{ $item['data']->id }}">
                                {{ $item['data']->note ?? 'No Note Available' }}
                            </p>
                            <div class="cstm_right_icon">
                                <button class="p-0 border-0 cstm_btn">
                                    <i class="fas fa-edit me-2 editNoteModal" data-bs-toggle="modal"
                                        data-bs-target="#editNoteModal" data-id="{{ $item['data']->id }}"
                                        data-note="{{ $item['data']->note }}"></i>
                                </button>
                                <form action="{{ route('admin.customer.contact.note.delete', $item['data']->id) }}"
                                    method="POST" class="deleteNoteForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-0 border-0 cstm_btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($item['type'] === 'email')
            {{-- ================= EMAIL ================= --}}
            @include('admin.customers.contacts.timeline.partials.card-box.email')
        @elseif ($item['type'] === 'activity')
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

                <div class="cstm_note_2">
                    <div class="row">
                        <div class="col-md-12 cstm_note_cont">
                            <p class="user_cont mt-4">
                                {{ $customer_contact->name ?? '---' }}
                                with IP {{ $item['data']->ip ?? 'Unknown' }}
                                using {{ $item['data']->browser ?? 'Unknown Browser' }}
                                from {{ $item['data']->country ?? 'Unknown' }}
                                and entered at
                                {{ $item['data']->data->user_in_time ? \Carbon\Carbon::parse($item['data']->data->user_in_time)->format('Y-m-d H:i:s') : '---' }},
                                left at
                                {{ $item['data']->data->user_out_time ? \Carbon\Carbon::parse($item['data']->data->user_out_time)->format('Y-m-d H:i:s') : '---' }},
                                visited '{{ $item['data']->data->url ?? '---' }}',
                                stayed for {{ $item['data']->data->total_duration ?? '---' }} seconds,
                                scrolled {{ $item['data']->data->scroll_max_percent ?? 0 }}% down,
                                clicked {{ $item['data']->data->click_count ?? 0 }} times
                                @if (!empty($item['data']->data->form_submissions))
                                    , submitted form '{{ $item['data']->data->form_submissions[0]->form_name ?? '' }}'
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@else
    <p class="text-muted">No notes or emails found.</p>
@endif
