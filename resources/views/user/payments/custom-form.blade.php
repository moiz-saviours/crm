<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1 ">
                <span id="custom-form-heading" class="tour-paymentcreation">Manage Payment</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="error-messages"></div>
                <div class="form-group mb-3 tour-paymentwithinvoice">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="invoice_key" class="form-label mb-0">Invoice</label>
                        <small class="fst-italic">(optional)</small>
                    </div>
                    <select class="form-control " id="invoice_key" name="invoice_key">
                        <option value="">Create New Invoice</option>
                        @foreach($unpaid_invoices as $unpaid_invoice)
                            <option
                                value="{{ $unpaid_invoice->invoice_key }}"
                                data-brand="{{ $unpaid_invoice->brand_key }}"
                                data-team="{{ $unpaid_invoice->team_key }}"
                                data-agent="{{ $unpaid_invoice->agent_id }}"
                                data-currency="{{ $unpaid_invoice->currency }}"
                                data-amount="{{ $unpaid_invoice->total_amount }}"
                                data-customer="{{ optional($unpaid_invoice->customer_contact)->special_key }}"

                                {{ old('invoice_key') == $unpaid_invoice->invoice_key ? 'selected' : '' }}>
                                {{ $unpaid_invoice->invoice_number }} - {{ $unpaid_invoice->invoice_key }}
                                - {{ optional($unpaid_invoice->customer_contact)->name }}
                                - {{$unpaid_invoice->currency}} {{ $unpaid_invoice->total_amount }}
                                - {{ $unpaid_invoice->created_at->format('jS F Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('invoice_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3 ">
                    <label for="brand_key" class="form-label">Brand</label>
                    <select class="form-control tour-paymentbrand" id="brand_key" name="brand_key" required>
                        <option value="">Select Brand</option>
                        @foreach($brands as $brand)
                            <option
                                value="{{ $brand->brand_key }}" {{ old('brand_key') == $brand->brand_key ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="team_key" class="form-label">Team</label>
                    <select class="form-control tour-paymentteam" id="team_key" name="team_key" required>
                        <option value="">Select Team</option>
                        @foreach($teams as $team)
                            <option
                                value="{{ $team->team_key }}" {{ old('team_key') == $team->team_key ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('team_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="agent_id" class="form-label ">Agent</label>
                    <select class="form-control tour-paymentagent" id="agent_id" name="agent_id" required>
                        <option value="">Select Agent</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('agent_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="type" class="form-label">Customer Type</label>
                    <select class="form-control tour-paymentcustype" id="type" name="type" title="Please select customer type" required>
                        <option value="0" {{ old('type', 1) == 0 ? 'selected' : '' }}>Fresh</option>
                        @if($customer_contacts->count() > 0)
                            <option value="1" {{ old('type', 1) == 1 ? 'selected' : '' }}>Upsale</option>
                        @endif
                    </select>
                    @error('type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div id="fresh-customer-contact-fields" class="form-group mb-3 second-fields">
                    <div class="form-group mb-3">
                        <label for="customer_contact_name" class="form-label">Customer Contact Name</label>
                        <input type="text" class="form-control second-field-inputs" id="customer_contact_name"
                               name="customer_contact_name"
                               value="{{ old('customer_contact_name') }}">
                        @error('customer_contact_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="customer_contact_email" class="form-label">Customer Contact Email</label>
                        <input type="email" class="form-control second-field-inputs" id="customer_contact_email"
                               name="customer_contact_email"
                               value="{{ old('customer_contact_email') }}">
                        @error('customer_contact_email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="customer_contact_phone" class="form-label">Customer Contact Phone</label>
                        <input type="text" class="form-control second-field-inputs" id="customer_contact_phone"
                               name="customer_contact_phone"
                               value="{{ old('customer_contact_phone') }}">
                        @error('customer_contact_phone')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div id="upsale-customer-contact-fields" class="form-group mb-3 first-fields">
                    <label for="cus_contact_key" class="form-label">Select Customer Contact</label>
                    <select class="form-control first-field-inputs tour-paymentcuscontact" id="cus_contact_key" name="cus_contact_key">
                        <option value="">Select Customer Contact</option>
                        @foreach($customer_contacts as $customer_contact)
                            <option
                                value="{{ $customer_contact->special_key }}" {{ old('cus_contact_key') == $customer_contact->special_key ? 'selected' : '' }}>
                                {{ $customer_contact->name }} ({{ $customer_contact->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('cus_contact_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{--                <div class="form-group mb-3">--}}
                {{--                    <label for="address" class="form-label">Address</label>--}}
                {{--                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>--}}
                {{--                    @error('address')--}}
                {{--                    <span class="text-danger">{{ $message }}</span>--}}
                {{--                    @enderror--}}
                {{--                </div>--}}

                <div class="form-group mb-3">
                    <label for="currency" class="form-label">Currency</label>
                    <select class="form-control tour-paymentcurselect" id="currency" name="currency">
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }} disabled>AUD</option>
                        <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }} disabled>CAD</option>
                    </select>
                    @error('currency')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control tour-paymentamount" id="amount" name="amount" step="0.01" min="1"
                           value="{{ old('amount') }}" required>
                    @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{--                <div class="form-group mb-3">--}}
                {{--                    <label for="description" class="form-label">Description</label>--}}
                {{--                    <textarea class="form-control" id="description" name="description"--}}
                {{--                              rows="3">{{ old('description') }}</textarea>--}}
                {{--                    @error('description')--}}
                {{--                    <span class="text-danger">{{ $message }}</span>--}}
                {{--                    @enderror--}}
                {{--                </div>--}}

                <div class="form-group mb-3">
                    <label for="client_account" class="form-label">Client Account</label>
                    <select class="form-control tour-paymentaccount" id="client_account" name="client_account" required>
                        <option value="">Select Client Account</option>

                        @foreach($client_contacts as $client_contact)
                            @php
                                $contactKey = $client_contact['special_key'] ?? $client_contact->special_key;
                                $contactName = $client_contact['name'] ?? $client_contact->name;
                                $companies = $client_contact['companies'] ?? $client_contact->companies;
                            @endphp

                            <optgroup label="🧍 {{ $contactName }}" style="display: none;">
                            @foreach($companies as $company)
                                @php
                                    $companyKey = $company['special_key'] ?? $company->special_key;
                                    $companyName = $company['name'] ?? $company->name;
                                    $accounts = $company['client_accounts'] ?? $company->client_accounts;
                                @endphp

                                <optgroup label="🏢 {{ $companyName }}">
                                    @foreach($accounts as $account)
                                        @php
                                            $accountKey = $account['id'] ?? $account->id;
                                            $accountName = $account['name'] ?? $account->name;
                                            $accountPaymentMethod = $account['payment_method'] ?? $account->payment_method;
                                        @endphp
                                        <option
                                            value="{{ $accountKey }}" {{ old('client_account') == $accountKey ? 'selected' : '' }}>
                                            💳 {{ $accountName }} - {{$accountPaymentMethod}}
                                        </option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                                </optgroup>
                            @endforeach
                    </select>
                    @error('client_account')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                {{--                <div class="form-group mb-3">--}}
                {{--                    <label for="payment_method" class="form-label">Payment Method</label>--}}
                {{--                    <select class="form-control" id="payment_method" name="payment_method" required>--}}
                {{--                        <option value="">Select Payment Method</option>--}}
                {{--                        <option value="authorize" {{ old('payment_method') == 'authorize' ? 'selected' : '' }}>--}}
                {{--                            Authorize--}}
                {{--                        </option>--}}
                {{--                        <option value="edp" {{ old('payment_method') == 'edp' ? 'selected' : '' }}>--}}
                {{--                            Edp--}}
                {{--                        </option>--}}
                {{--                        <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>--}}
                {{--                            Stripe--}}
                {{--                        </option>--}}
                {{--                        <option value="credit card" {{ old('payment_method') == 'credit card' ? 'selected' : '' }}>--}}
                {{--                            Credit Card--}}
                {{--                        </option>--}}
                {{--                        <option value="bank transfer" {{ old('payment_method') == 'bank transfer' ? 'selected' : '' }}>--}}
                {{--                            Bank Transfer--}}
                {{--                        </option>--}}
                {{--                        <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>--}}
                {{--                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>--}}
                {{--                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>--}}
                {{--                    </select>--}}
                {{--                    @error('payment_method')--}}
                {{--                    <span class="text-danger">{{ $message }}</span>--}}
                {{--                    @enderror--}}
                {{--                </div>--}}
                <div class="form-group mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="datetime-local" class="form-control tour-paymentdate" id="payment_date" name="payment_date"
                           value="{{ old('payment_date') }}" max="{{now('GMT+5')->toDateString()}}" required>
                    @error('payment_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="transaction_id" class="form-label">Transaction ID</label>
                    <input type="text" class="form-control tour-paymenttrid" id="transaction_id" name="transaction_id"
                           value="{{ old('transaction_id') }}" required>
                    @error('transaction_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

            </div>
            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-paymentsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>


        </div>
    </form>
</div>

@push('script')
    <!------- CUSTOM FORM -------->
    <script>
        $(document).ready(function () {
            let t = false;
            $('#invoice_key').on('change', function (e) {
                if (e.isTrigger) return;
                const selected = $(this).find('option:selected');

                $('#brand_key').val(selected.data('brand') || '').trigger('change');
                $('#team_key').val(selected.data('team') || '').trigger('change');
                $('#agent_id').val(selected.data('agent') || '').trigger('change');
                $('#type').val(selected.data('customer') ? 1 : 0).trigger('change');
                $('#cus_contact_key').val(selected.data('customer') || '').trigger('change');
                $('#currency').val(selected.data('currency') || '');
                $('#amount').val(selected.data('amount') || '');

                if ($(this).val()) {
                    t = false;
                }
            });
            $('#brand_key,#team_key,#agent_id,#type,#cus_contact_key,#currency,#amount').on('change', function (e) {
                if (!e.isTrigger) {
                    if (!t) {
                        t = true;
                        document.getElementById("invoice_key").scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        if(document.getElementById("invoice_key").value != ''){
                            toastr.info('Modifying fields will generate a new invoice.');
                        }
                    }
                    const currentField = $(this);
                    const fieldsToReset = ['#invoice_key'
                        // , '#brand_key', '#team_key', '#agent_id', '#type', '#cus_contact_key', '#amount'
                    ];

                    fieldsToReset.forEach(field => {
                        if (!currentField.is(field)) {
                            if (field === '#type' && currentField.is('#cus_contact_key')) {
                                $(field).val(1).trigger('change');
                            } else {
                                $(field).val(field === '#amount' ? '' : (field === '#type' ? 0 : '')).trigger('change');
                            }
                        }
                    });
                }
            });

            $('#type').on('change', function () {
                const type = $(this).val();
                if (type == 0) {
                    $('#upsale-customer-contact-fields').fadeOut(() => {
                        $('#fresh-customer-contact-fields').fadeIn();
                        $('#customer_contact_name, #customer_contact_email, #customer_contact_phone').prop('required', true);
                        $('#cus_contact_key').prop('required', false);
                    });
                } else if (type == 1) {
                    $('#fresh-customer-contact-fields').fadeOut(() => {
                        $('#upsale-customer-contact-fields').fadeIn();
                        $('#cus_contact_key').prop('required', true);
                        $('#customer_contact_name, #customer_contact_email, #customer_contact_phone').prop('required', false);
                    });
                }
            }).trigger('change');
        });

    </script>
    <!------- CUSTOM FORM -------->
@endpush
