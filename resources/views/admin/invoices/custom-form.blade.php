@push('style')
    <style>
        .payment-gateway-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        .payment-gateway-card:hover {
            border-color: #007bff;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.1);
        }

        .payment-gateway-card .form-check-label {
            display: inline;
            font-weight: 500;
            margin-left: 25px;
        }

        .merchant-dropdown {
            margin-top: 10px;
            padding-left: 20px; /* Indent merchants below their type */
        }
    </style>
@endpush
<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1 ">
                <span id="custom-form-heading" class="tour-invoicecreation">Manage Invoice</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3 ">
                    <label for="brand_key" class="form-label">Brand</label>
                    <select class="form-control select2 searchable tour-invoicecreatebrand" id="brand_key" name="brand_key"
                            title="Please select a brand" required autocomplete="off">
                        <option value="" selected disabled>Please select brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->brand_key }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="team_key" class="form-label">Team</label>
                    <select class="form-control searchable tour-invoicecreateteam" id="team_key" name="team_key"
                            title="Please select a team">
                        <option value="" selected disabled>Please select team</option>
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
                    <label for="type" class="form-label">Type</label>
                    <select class="form-control tour-invoiceusertype" id="type" name="type" title="Please select customer type" required>
                        <option value="0" {{ old('type', 1) == 0 ? 'selected' : '' }}>Fresh</option>
                        <option value="1" {{ old('type', 1) == 1 ? 'selected' : '' }}>Upsale</option>
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
                    <select class="form-control first-field-inputs tour-invoicecusselect unique-select-2" id="cus_contact_key" name="cus_contact_key">
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

                <div class="form-group mb-3">
                    <label for="agent_id" class="form-label">Agent</label>
                    <select class="form-control searchable tour-invoiceagentselect unique-select-2" id="agent_id" name="agent_id" title="Please select agent">
                        <option value="" >Select Agent</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('agent_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('agent_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control tour-invoicedateselect" id="due_date" name="due_date"
                           value="{{ old('due_date', now('Pacific/Honolulu')->addDays(5)->format('Y-m-d')) }}"
                           min="{{ now('Pacific/Honolulu')->format('Y-m-d') }}"
                           max="{{ now('Pacific/Honolulu')->addYear()->format('Y-m-d') }}">
                    @error('due_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="currency" class="form-label">Currency</label>
                    <select class="form-control tour-invoicecurselect" id="currency" name="currency">
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                        <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }} disabled>AUD</option>
                        <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }} disabled>CAD</option>
                    </select>
                    @error('currency')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3 tour-invoicemerchant">
                    <div id="merchant-types-container">
                    </div>
                    @error('payment_method')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3 ">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control tour-invoiceamount" id="amount" name="amount" step="1"
                           min="1"
                           max="{{config('invoice.max_amount')}}" value="{{ old('amount') }}">
                    @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="taxable" class="form-label d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-2 tour-invoicetax" id="taxable" name="taxable"
                               value="1" {{ old('taxable') ? 'checked' : '' }}>
                        Is this invoice taxable?
                    </label>
                    @error('taxable')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3 second-fields" id="tax-fields" style="display: none">
                    <div>
                        <label for="tax_type" class="form-label">Tax Type</label>
                        <select class="form-control second-field-inputs" id="tax_type" name="tax_type">
                            <option value="" disabled selected>Select Tax Type</option>
                            <option value="percentage" {{ old('tax_type') == 'percentage' ? 'selected' : '' }}>
                                Percentage
                            </option>
                            <option value="fixed" {{ old('tax_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        </select>
                        @error('tax_type')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label for="tax_value" class="form-label">Tax Value</label>
                        <input type="number" class="form-control second-field-inputs" id="tax_value" name="tax_value"
                               min="1"
                               value="{{ old('tax_value') }}">
                        @error('tax_value')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-3">
                        <label for="tax_amount" class="form-label">Tax Amount</label>
                        <input type="number" class="form-control second-field-inputs" id="tax_amount" name="tax_amount"
                               step="0.01" min="1"
                               readonly
                               value="{{ old('tax_amount') }}">
                        @error('tax_amount')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group mb-3 tour-invoicetotal">
                    <label for="total_amount" class="form-label">Total Amount</label>
                    <input type="number" class="form-control" id="total_amount" name="total_amount" step="0.01"
                           min="1"
                           readonly
                           max="{{config('invoice.max_amount')}}" value="{{ old('amount') }}" required>
                    @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3 tour-invoicedesc">
                    <label for="description" class="form-label">Service Description</label>
                    <textarea class="form-control" id="description" name="description"
                              rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-invoicecomplete"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
    @push('script')
        <!------- CUSTOM FORM -------->
        <script>
            $(document).ready(function () {
                @if($customer_contacts->count() < 1)
                $('#type').val(0).trigger('change')
                @endif
                $('#type').on('change', function () {
                    const type = $(this).val();
                    if (type == 0) {
                        $('#upsale-customer-contact-fields').fadeOut(() => {
                            $('#fresh-customer-contact-fields').fadeIn();
                            $('#customer_contact_name, #customer_contact_email, #customer_contact_phone').each(function () {
                                if ($(this).val().trim() === "") {
                                    $(this).prop('readonly', false);
                                }
                            });
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

            $(document).ready(function () {

                const maxAmount = parseFloat(`{{config('invoice.max_amount')}}`);
                $('#taxable').on('change', function () {
                    if ($(this).is(':checked')) {
                        $('#tax-fields').slideDown();
                        $('#tax_type').prop('required', true);
                        $('#tax_value').prop('required', true);
                    } else {
                        $('#tax-fields').slideUp();
                        $('#tax_type').prop('required', false).val('');
                        $('#tax_value').prop('required', false).val('');
                        $('#tax_amount').val(0);
                        updateTotalAmount();
                    }
                });

                $('#tax_type, #tax_value, #amount').on('input change', function () {
                    const amount = parseFloat($('#amount').val());
                    if (amount > maxAmount) {
                        $('#amount').val(maxAmount);
                    }
                    updateTaxAmount();
                    updateTotalAmount();
                });

                function updateTaxAmount() {
                    const taxType = $('#tax_type').val();
                    let taxValue = parseFloat($('#tax_value').val());
                    const amount = parseFloat($('#amount').val());

                    let taxAmount = 0;
                    if (amount >= maxAmount) {
                        $('#tax_value').val('');
                        $('#tax_amount').val('');
                        return;
                    }

                    if (taxType === 'percentage' && !isNaN(taxValue) && !isNaN(amount)) {
                        if (taxValue > 100) {
                            taxValue = 100;
                            $('#tax_value').val(100);
                        }

                        taxAmount = (amount * taxValue) / 100;
                        if (amount + taxAmount > maxAmount) {
                            taxAmount = maxAmount - amount;
                            $('#tax_value').val(((taxAmount / amount) * 100).toFixed(2));
                        }
                    } else if (taxType === 'fixed' && !isNaN(taxValue)) {
                        const maxFixedTax = maxAmount - amount;
                        if (taxValue > maxFixedTax) {
                            taxValue = maxFixedTax;
                            $('#tax_value').val(maxFixedTax.toFixed(2));
                        }
                        taxAmount = taxValue;
                    }

                    $('#tax_amount').val(taxAmount.toFixed(2));
                }
                function updateTotalAmount() {
                    const amount = parseFloat($('#amount').val());
                    const taxAmount = parseFloat($('#tax_amount').val()) || 0;
                    let totalAmount = amount + taxAmount;

                    if (totalAmount > maxAmount) {
                        // totalAmount = maxAmount;

                        const adjustedTaxAmount = totalAmount - amount;
                        $('#tax_amount').val(adjustedTaxAmount.toFixed(2));
                    }
                    $('#total_amount').val(totalAmount.toFixed(2));
                }
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#cus_contact_key').select2({
                    placeholder: "Select Customer Contact",
                    allowClear: true,
                    width: '100%' // bootstrap form-control ki width maintain karne ke liye
                });

                $('#agent_id').select2({
                    placeholder: "Select Agent",
                    allowClear: true,
                    width: '100%'
                });
            });
        </script>
        <!------- CUSTOM FORM -------->
    @endpush
</div>
