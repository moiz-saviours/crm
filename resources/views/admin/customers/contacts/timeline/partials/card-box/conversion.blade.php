            {{-- ================= CONVERSION LOG ================= --}}
            <div class="data-highlights">
                <div class="cstm_note">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="data-top-heading-header">
                                <h2>{{ $item['data']->data->message ?? 'Lead converted' }}</h2>
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
                            <p class="user_cont mt-3">
                                Lead converted to Customer: <b>{{ $item['data']->data->customer_name ?? '---' }}</b>
                                ({{ $item['data']->data->customer_email ?? '---' }})
                                by {{ $item['data']->data->converted_by ?? 'System' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>