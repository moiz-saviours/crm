<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading">Manage Payment</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="error-messages"></div>
                <div class="form-group mb-3">
                    <label for="brand_key" class="form-label">Brand</label>
                    <select class="form-control" id="brand_key" name="brand_key" required>
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
                    <select class="form-control" id="team_key" name="team_key" required>
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
                    <select class="form-control" id="agent_id" name="agent_id" required>
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
                    <select class="form-control" id="type" name="type" title="Please select customer type" required>
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
                    <select class="form-control first-field-inputs" id="cus_contact_key" name="cus_contact_key">
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
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="1"
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
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="">Select Payment Method</option>
                        <option value="authorize" {{ old('payment_method') == 'authorize' ? 'selected' : '' }}>
                            Authorize
                        </option>
                        <option value="edp" {{ old('payment_method') == 'edp' ? 'selected' : '' }}>
                            Edp
                        </option>
                        <option value="stripe" {{ old('payment_method') == 'stripe' ? 'selected' : '' }}>
                            Stripe
                        </option>
                        <option value="credit card" {{ old('payment_method') == 'credit card' ? 'selected' : '' }}>
                            Credit Card
                        </option>
                        <option value="bank transfer" {{ old('payment_method') == 'bank transfer' ? 'selected' : '' }}>
                            Bank Transfer
                        </option>
                        <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('payment_method')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date"
                           value="{{ old('payment_date') }}" required>
                    @error('payment_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="transaction_id" class="form-label">Transaction ID</label>
                    <input type="text" class="form-control" id="transaction_id" name="transaction_id"
                           value="{{ old('transaction_id') }}" required>
                    @error('transaction_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>

@push('script')
    <!------- CUSTOM FORM -------->
    <script>
        $(document).ready(function () {
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
