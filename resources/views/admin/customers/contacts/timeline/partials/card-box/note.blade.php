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