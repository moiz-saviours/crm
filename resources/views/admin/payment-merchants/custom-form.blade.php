@push('style')
    <style>
        .assign-brands select[multiple] option:checked, .assign-brands select[multiple]:focus option:checked {
            background: var(--bs-primary) linear-gradient(0deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
            color: var(--bs-primary-color);
        }
    </style>
@endpush
<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data" class="m-0">
        <div class="form-container" id="formContainer">
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading">Manage Client Account</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">

                <!-- Assign Brands -->
                <div class="form-group mb-3">
                    <!-- Assign Brands Section -->
                    <div class="assign-brands">
                        <div class="mb-3">
                            @php
                                $allBrandsSelected = count(old('brands', [])) === $brands->count();
                            @endphp

                                <!-- Select All Toggle Section -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="font-weight-bold mb-0 text-center">Brands</h5>
                                <div
                                    class="form-check form-check-update d-flex align-items-center form-check-inline">
                                    <input type="checkbox" id="select-all-brands"
                                           class="form-check-input" {{ $allBrandsSelected ? 'checked' : '' }}>
                                    <label class="form-check-label" for="select-all-brands">
                                        <small
                                            id="select-all-label">{{ $allBrandsSelected ? 'Unselect' : 'Select' }}
                                            All</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Brands Select Dropdown -->
                            <div class="form-group">
                                <select name="brands[]" id="brands" class="form-control" multiple>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_key }}"
                                            {{ in_array($brand->brand_key, old('brands', [])) ? 'selected' : '' }}>
                                            {{ $brand->name }} - {{ $brand->url }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Error Display for Brands -->
                                @error('brands')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="client_contact" class="form-label">Client Contact</label>
                    <select class="form-control" id="client_contact" name="c_contact_key" required>
                        <option value="" selected>Select Client Contact</option>
                        @foreach($client_contacts as $client_contact)
                            <option
                                value="{{ $client_contact->special_key }}" {{ old('client_contact') == $client_contact->special_key ? 'selected' : '' }}>
                                {{ $client_contact->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('c_contact_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="client_company" class="form-label">Client Company</label>
                    <select class="form-control" id="client_company" name="c_company_key" required>
                        <option value="" disabled selected>Select Client Company</option>
                    </select>
                    @error('c_company_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Client Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name') }}"
                           required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="descriptor" class="form-label">Descriptor</label>
                    <input type="text" class="form-control" id="descriptor" name="descriptor"
                           value="{{ old('descriptor') }}"
                           required>
                    @error('descriptor')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="vendor_name" class="form-label">Vendor Name</label>
                    <input type="text" class="form-control" id="vendor_name" name="vendor_name"
                           value="{{ old('vendor_name') }}" required>
                    @error('vendor_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email"
                           value="{{ old('email') }}" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="login_id" class="form-label">Login ID</label>
                    <input type="text" class="form-control" id="login_id" name="login_id"
                           value="{{ old('login_id') }}" required>
                    @error('login_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="transaction_key" class="form-label">Transaction Key</label>
                    <input type="text" class="form-control" id="transaction_key"
                           name="transaction_key"
                           value="{{ old('transaction_key') }}" required>
                    @error('transaction_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="limit" class="form-label">Limit</label>
                    <input type="number" class="form-control" id="limit" name="limit" step="1"
                           min="1"
                           value="{{ old('limit') }}" required>
                    @error('limit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" step="1"
                           min="1"
                           value="{{ old('capacity') }}" required>
                    @error('capacity')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="environment" class="form-label">Environment</label>
                    <select class="form-control" id="environment" name="environment" required>
                        <option
                            value="sandbox" {{ old('environment') == 'sandbox' ? 'selected' : '' }}>
                            Sandbox
                        </option>
                        <option
                            value="production" {{ old('environment') == 'production' ? 'selected' : '' }}>
                            Production
                        </option>
                    </select>
                    @error('environment')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                            Active
                        </option>
                        <option
                            value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                            Inactive
                        </option>
                        <option
                            value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>
                            Suspended
                        </option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn">Save</button>
                <button type="button" class="btn-secondary close-btn">Cancel</button>
            </div>
        </div>
    </form>
</div>

@push('script')
    <script>
        $(document).ready(function () {

            /** For Assign brand to team */
            $('#select-all-brands').change(function () {
                const isChecked = this.checked;
                $('#brands option').prop('selected', isChecked);
                $('#select-all-label').text(isChecked ? 'Unselect All' : 'Select All');
            });

            $('#brands option').click(function () {
                if ($('#brands option:checked').length === $('#brands option').length) {
                    $('#select-all-brands').prop('checked', true);
                } else {
                    $('#select-all-brands').prop('checked', false);
                }
            });

            var $formContainer = $('.form-container');
            var observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
                    if (mutation.attributeName === 'class') {
                        if (!$formContainer.hasClass('open')) {
                            const $companyDropdown = $('#client_company');
                            $companyDropdown.empty();
                            $companyDropdown.append('<option value="" selected disabled>Select Client Company</option>');
                        }
                    }
                });
            });
            observer.observe($formContainer[0], {
                attributes: true
            });
            $(document).on('change', '#client_contact', function (e) {
                e.preventDefault();
                const id = $(this).val();
                const $companyDropdown = $('#client_company');
                $companyDropdown.html('<option value="">Loading...</option>');
                if (id) {
                    AjaxRequestPromise(`{{ route('admin.client.contact.companies') }}/${id}`, null, 'GET')
                        .then(response => {
                            $companyDropdown.empty();
                            $companyDropdown.append('<option value="" selected disabled>Select Client Company</option>');
                            if (response.client_companies && response.client_companies.length > 0) {
                                response.client_companies.forEach(company => {
                                    $companyDropdown.append(`<option value="${company.special_key}">${company.name}</option>`);
                                });
                            } else {
                                $companyDropdown.empty();
                                $companyDropdown.html('<option value="" disabled>No Companies Found. Please add some.</option>');
                                toastr.error('No Companies Found. Please add some.');
                            }
                        })
                        .catch(() => {
                            toastr.error('Failed to load companies. Please try again later.');
                        });
                } else {
                    $companyDropdown.html('<option value="" selected disabled>Select Client Company</option>');
                }
            });
        });
    </script>
@endpush

