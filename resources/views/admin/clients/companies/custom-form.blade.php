@push('style')
    <style>
        .assign-brands select[multiple] option:checked, .assign-brands select[multiple]:focus option:checked {
            background: var(--bs-primary) linear-gradient(0deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
            color: var(--bs-primary-color);
        }
    </style>

@endpush
<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1 tour-clientcompanycreation">
                Manage Client Company
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
                                           class="form-check-input">
                                    <label class="form-check-label" for="select-all-brands">
                                        <small id="select-all-label">Select All</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Brands Select Dropdown -->
                            <div class="form-group">
                                <select name="brands[]" id="brands" class="form-control tour-clientcompanybrand" multiple>
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
                    <label for="c_contact_key" class="form-label">Contact</label>
                    <select class="form-control searchable tour-clientcompanycontact" id="c_contact_key" name="c_contact_key"
                            title="Please select a brand" required>
                        <option value="" disabled>Please select Contact</option>
                        @foreach($client_contacts as $client_contact)
                            <option
                                value="{{ $client_contact->special_key }}"
                                {{--                                {{ $client_company->c_contact_key == $client_contact->special_key ? 'selected' : '' }}--}}
                            >
                                {{ $client_contact->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="name" class="form-label ">Name</label>
                    <input type="text" class="form-control tour-clientcompanyname "  id="name" name="name" placeholder="Enter name">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control tour-clientcompanyemail" id="email" name="email" placeholder="Enter email">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="url" class="form-label">Url</label>
                    <input type="text" class="form-control tour-clientcompanyurl" id="url" name="url" placeholder="Enter url">
                    @error('url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="logo" class="form-label">Logo (Optional)</label>
                    <div class="input-group">
                        <input type="file" class="form-control tour-clientcompanylogo" id="logo" name="logo" accept="image/*">
                        <input type="url" class="form-control" id="logo_url" name="logo_url"
                               placeholder="https://example.com/logo.png">
                    </div>
                    <small class="form-text text-muted">You can either upload an image or provide a valid image
                        URL.</small>
                    @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('logo_url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control tour-clientcompanydesc" id="description" name="description" rows="3"></textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control tour-clientcompanystatus" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-clientcompanysubmit"><i class="fas fa-save me-2"></i> Save</button>
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
