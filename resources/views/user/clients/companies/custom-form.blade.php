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
            <div class="form-header fh-1">
                Manage Client Company
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="c_contact_key" class="form-label">Contact</label>
                    <select class="form-control searchable" id="c_contact_key" name="c_contact_key"
                            title="Please select a brand" required>
                        <option value="" disabled>Please select Contact</option>
                        @foreach($client_contacts as $client_contact)
                            <option
                                value="{{ $client_contact->special_key }}">
                                {{ $client_contact->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="url" class="form-label">Url</label>
                    <input type="text" class="form-control" id="url" name="url" placeholder="Enter url">
                    @error('url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="logo" class="form-label">Logo (Optional)</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
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
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>
