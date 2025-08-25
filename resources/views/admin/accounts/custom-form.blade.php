@push('style')
    <style>
        .generatePassword {
            padding: 8px;
            cursor: pointer;
            font-size: 18px;
            background-color: var(--bs-primary);
            border-radius: 5px;
            height: 35px;
            width: 35px;
            color: var(--bs-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 5px;
            transition: background-color 0.3s ease;
            margin-bottom: 15px;

        }

        .generatePassword:hover {
            color: var(--bs-primary);
            background-color: var(--bs-light);
            border: 1px solid var(--bs-primary);
        }
    </style>
@endpush

<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data" class="manage-form">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading" class="tour-admincreation">Manage Account</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control tour-adminname" id="name" name="name" placeholder="Enter name" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="pseudo_name" class="form-label">Pseudo Name</label>
                    <input type="text" class="form-control" id="pseudo_name" name="pseudo_name"
                           placeholder="Enter Pseudo name">
                    @error('pseudo_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control tour-adminemail" id="email" name="email" placeholder="Enter email" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="pseudo_email" class="form-label">Pseudo Email</label>
                    <input type="email" class="form-control" id="pseudo_email" name="pseudo_email"
                           placeholder="Enter Pseudo Email">
                    @error('pseudo_email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="designation" class="form-label">Designation</label>
                    <input type="text" class="form-control tour-admindesignation" id="designation" name="designation"
                           placeholder="e.g. Software Engineer">
                    @error('designation')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select class="form-control tour-admingender" id="gender" name="gender">
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
                    <input type="text" class="form-control tour-adminphone" id="phone_number" name="phone_number"
                           placeholder="e.g. +1234567890">
                    @error('phone_number')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="pseudo_phone" class="form-label">Pseudo Phone Number</label>
                    <input type="text" class="form-control" id="pseudo_phone" name="pseudo_phone"
                           placeholder="e.g. +1234567890">
                    @error('pseudo_phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control tour-adminaddress" id="address" name="address" rows="3"></textarea>
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
                                <input type="file" class="form-control tour-adminimage" id="image" name="image" accept="image/*"
                                       aria-describedby="imageHelp">
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
                    <label for="createPassword" class="form-label">Password</label>
                    <div class="d-flex align-items-center">
                        <input type="text" id="createPassword" name="password" class="form-control tour-adminpassword"
                               placeholder="Generated Password">
                        <i id="generatePassword" class="generatePassword fa fa-key ms-2" title="Generate Password"></i>
                    </div>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control tour-adminstatus" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-adminsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>
