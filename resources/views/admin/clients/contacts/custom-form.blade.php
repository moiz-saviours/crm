@push('style')
    <style>
        .assign-brands select[multiple] option:checked, .assign-brands select[multiple]:focus option:checked {
            background: var(--bs-primary) linear-gradient(0deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
            color: var(--bs-primary-color);
        }
    </style>
@endpush
<div class="custom-form">
    <form id="manage-form" class="manage-form" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1 tour-clientcontactcreation">
                <span id="custom-form-heading">Manage Client Contact</span>
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
                            <div class="d-flex justify-content-between align-items-center mb-3 ">
                                <h5 class="font-weight-bold mb-0 text-center">Brands</h5>
                                <div
                                    class="form-check form-check-update d-flex align-items-center form-check-inline">
                                    <input type="checkbox" id="select-all-brands"
                                           class="form-check-input">
                                    <label class="form-check-label" for="select-all-brands">
                                        <small id="select-all-label">Select All</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Brands Select Dropdown -->
                            <div class="form-group">
                                <select name="brands[]" id="brands" class="form-control tour-clientcontactbrand" multiple>
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
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control tour-clientcontactname" id="name" name="name"
                           value="{{ old('name') }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control tour-clientcontactemail" id="email" name="email"
                           value="{{ old('email') }}" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control tour-clientcontactphone" id="phone" name="phone"
                           value="{{ old('phone') }}">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control tour-clientcontactaddress" id="address" name="address"
                              rows="5">{{ old('address') }}</textarea>
                    @error('address')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control tour-clientcontactcity" id="city" name="city"
                               value="{{ old('city') }}">
                        @error('city')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                <div class="form-group mb-3">

                    <div class="form-group mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control tour-clientcontactstate" id="state" name="state"
                                   value="{{ old('state') }}">
                            @error('state')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-control searchable tour-clientcontactcountry" id="country" name="country"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Please select country" required>
                            @foreach(config('countries') as $code => $country)
                                <option
                                    value="{{ $code }}" {{ (old('country') == $code ) || ($code == "US") ? 'selected' : '' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                        @error('country')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="zipcode" class="form-label">Zip Code</label>
                            <input type="text" class="form-control tour-clientcontactzip" id="zipcode" name="zipcode"
                                   value="{{ old('zipcode') }}">
                            @error('zipcode')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control tour-clientcontactstatus1" id="status" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
                <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-clientcontactsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>

        </div>

    </form>
</div>
@push('script')
    <script>
        /** For Assign brand to team */
        $('#select-all-brands').change(function () {
            const isChecked = this.checked;
            $('#brands option').prop('selected', isChecked);
            $('#select-all-label').text(isChecked ? 'Unselect All' : 'Select All');
        });

        $('#brands option').click(function () {
            if ($('#brands option:checked').length === $('#brands option').length) {
                $('#select-all-brands').prop('checked', true);
                $('#select-all-label').text('Unselect All');
            } else {
                $('#select-all-brands').prop('checked', false);
                $('#select-all-label').text('Select All');
            }
        });
        var $formContainer = $('.form-container');
        var observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'class') {
                    if (!$formContainer.hasClass('open')) {
                        $('#select-all-label').text($('#select-all-brands').checked ? 'Unselect All' : 'Select All');
                    }
                }
            });
        });
        observer.observe($formContainer[0], {
            attributes: true
        });
    </script>
@endpush
