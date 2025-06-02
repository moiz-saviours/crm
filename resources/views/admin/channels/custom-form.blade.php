<div class="custom-form">
    <form id="manage-form" class="manage-form m-0" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
{{--            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>--}}
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading">Manage Channel</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="{{ old('name') }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug"
                           value="{{ old('slug') }}" required>
                    @error('slug')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="url" class="form-label">URL</label>
                    <input type="url" class="form-control" id="url" name="url"
                           value="{{ old('url') }}" required>
                    @error('url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" class="form-control" id="logo" name="logo"
                           accept="image/*">
                    @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="favicon" class="form-label">Favicon</label>
                    <input type="file" class="form-control" id="favicon" name="favicon"
                           accept="image/*">
                    @error('favicon')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description"
                              rows="3">{{ old('description') }}</textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="language" class="form-label">Language</label>
                    <select class="form-control" id="language" name="language" required>
                        <option value="en" {{ old('language', 'en') == 'en' ? 'selected' : '' }}>English</option>
                        <option value="es" {{ old('language') == 'es' ? 'selected' : '' }}>Spanish</option>
                        <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>French</option>
                        <!-- Add more language options as needed -->
                    </select>
                    @error('language')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="timezone" class="form-label">Timezone</label>
                    <select class="form-control" id="timezone" name="timezone" required>
                        <option value="UTC" {{ old('timezone', 'UTC') == 'UTC' ? 'selected' : '' }}>UTC</option>
                        <option value="America/New_York" {{ old('timezone') == 'America/New_York' ? 'selected' : '' }}>
                            Eastern Time (ET)
                        </option>
                        <option value="America/Chicago" {{ old('timezone') == 'America/Chicago' ? 'selected' : '' }}>
                            Central Time (CT)
                        </option>
                        <option
                            value="America/Los_Angeles" {{ old('timezone') == 'America/Los_Angeles' ? 'selected' : '' }}>
                            Pacific Time (PT)
                        </option>
                        <!-- Add more timezone options as needed -->
                    </select>
                    @error('timezone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title"
                           value="{{ old('meta_title') }}" maxlength="100">
                    @error('meta_title')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" id="meta_description" name="meta_description"
                              maxlength="200" rows="2">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                           value="{{ old('meta_keywords') }}">
                    @error('meta_keywords')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                    </select>
                    @error('status')
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
    <script>
        $(document).ready(function () {
            $('#name').on('blur', function () {
                const name = $(this).val();
                if (name && !$('#slug').val()) {
                    const slug = name.toLowerCase()
                        .replace(/[^\w ]+/g, '')
                        .replace(/ +/g, '-');
                    $('#slug').val(slug);
                }
            });
        });
    </script>
@endpush

