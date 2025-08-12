<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading">Manage Company</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <input type="text" class="form-control" id="designation" name="designation"
                           placeholder="e.g. Software Engineer">
                    @error('designation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control" id="gender" name="gender">
                        <option value="" disabled>Select Gender</option>
                        <option value="male" selected>Male</option>
                        <option value="female">Female</option>
                    </select>
                    @error('gender')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number"
                           placeholder="e.g. +1234567890">
                    @error('phone_number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    @error('address')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="image" class="form-label d-block">Profile Image (Optional)</label>

                    <div class="d-flex align-items-start">
                        <!-- Image Upload Section (Left) -->
                        <div class="me-3 image-div" id="image-div" style="display: none">
                            <label for="image">
                                <img id="image-display" src="" alt="Preview"
                                     class="img-thumbnail"
                                     style="cursor: pointer; max-width: 100px;"
                                     title="Click to choose a new file">
                            </label>
                        </div>

                        <!-- Input Fields (Right) -->
                        <div class="flex-grow-1">
                            <div class="">
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" aria-describedby="imageHelp">
                            </div>
                            <div class="input-group">
                                <input type="url" class="form-control" id="image_url" name="image_url"
                                       placeholder="https://example.com/image.png" aria-describedby="imageHelp">
                            </div>
                            <small id="imageHelp" class="form-text text-muted">
                                You can either upload an image or provide a valid image URL.
                            </small>
                            <!-- Validation Error Messages -->
                            @error('image')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                            @error('image_url')
                            <span class="text-danger d-block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
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
