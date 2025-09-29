<div class="email-threading-row">
    <button class="threading-email-btn-two" data-bs-toggle="modal" data-bs-target="#addNoteModal">
        Create Notes
    </button>
</div>
@if ($customer_contact->notes->count() > 0)
    @php $lastMonth = null; @endphp
    @foreach ($customer_contact->notes->sortByDesc('created_at') as $noteKey => $note)
        @php
            $currentMonth = \Carbon\Carbon::parse($note->created_at)->format('F Y');
        @endphp
        @if ($lastMonth !== $currentMonth)
            <p class="date-by-order">{{ $currentMonth }}</p>
            @php $lastMonth = $currentMonth; @endphp
        @endif
        <div class="data-highlights">
            <div class="cstm_note">
                <div class="row">
                    <div class="col-md-12">
                        <div class="data-top-heading-header">
                            <h2>Note By {{ ucwords($note->creator?->name) }}</h2>
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
                        <p class="user_cont" id="note-text-{{ $note->id }}">
                            {{ $note->note ?? 'No Note Available' }}
                        </p>
                        <div class="cstm_right_icon">
                            <!-- Edit Icon -->
                            <button class="p-0 border-0 cstm_btn">
                                <i class="fas fa-edit me-2 editNoteModal" style="cursor: pointer;"
                                   data-bs-toggle="modal" data-bs-target="#editNoteModal"
                                   data-id="{{ $note->id }}" data-note="{{ $note->note }}"></i>
                            </button>
                            <!-- Delete Form -->
                            <form action="{{ route('admin.customer.contact.note.delete', $note->id) }}"
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
    @endforeach
@else
    <p class="note-para">
        Take notes about this record to keep track of important
        info.
        You can even @mention a teammate if you need to.
    </p>
@endif
