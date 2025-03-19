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
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading">Manage Employee</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select class="form-control" id="department" name="department">
                        <option value="" disabled selected>Select Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                    @error('department')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-control" id="role" name="role">
                        <option value="" disabled selected>Select Role</option>
                    </select>
                    @error('role')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="position" class="form-label">Position</label>
                    <select class="form-control" id="position" name="position">
                        <option value="" disabled selected>Select Position</option>
                    </select>
                    @error('position')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="team_key" class="form-label">Select Team</label>
                    <select class="form-control" id="team_key" name="team_key">
                        <option value="" disabled selected>Select Team</option>
                    </select>
                    @error('teams')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="emp_id" class="form-label">Employee Id</label>
                    <input type="text" class="form-control" id="emp_id" name="emp_id" placeholder="Enter Employee Id">
                    @error('emp_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required>
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
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="pseudo_email" class="form-label">Pseudo Email</label>
                    <input type="email" class="form-control" id="pseudo_email" name="pseudo_email"
                           placeholder="Enter Pseudo Email">
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
                    <label for="pseudo_phone" class="form-label">Pseudo Phone Number</label>
                    <input type="text" class="form-control" id="pseudo_phone" name="pseudo_phone"
                           placeholder="e.g. +1234567890">
                    @error('pseudo_phone')
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
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"
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
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    @error('address')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City"/>
                    @error('city')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control" id="state" name="state" placeholder="Enter State"/>
                    @error('state')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country" placeholder="Enter Country"/>
                    @error('country')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="postal_code" class="form-label">Postal Code</label>
                    <input type="text" class="form-control" id="postal_code" name="postal_code"
                           placeholder="Enter Postal Code"/>
                    @error('postal_code')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter Date of Birth"/>
                    @error('dob')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="date_of_joining" class="form-label">Date of Joining</label>
                    <input type="date" class="form-control" id="date_of_joining" name="date_of_joining"
                           placeholder="Enter Date of Joining"/>
                    @error('date_of_joining')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="target" class="form-label">Target</label>
                    <input type="number" class="form-control" id="target" name="target" placeholder="25000" min="1"/>
                    @error('target')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="createPassword" class="form-label">Password</label>
                    <div class="d-flex align-items-center">
                        <input type="text" id="createPassword" name="password" class="form-control"
                               placeholder="Generated Password">
                        <i id="generatePassword" class="generatePassword fa fa-key ms-2" title="Generate Password"></i>
                    </div>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
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
@push('script')
    <script>
        const roles = @json($roles->keyBy('id'));
        const positions = @json($positions->keyBy('id'));

        document.addEventListener('DOMContentLoaded', () => {
            const department = document.getElementById('department');
            const role = document.getElementById('role');
            const position = document.getElementById('position');

            const populateDropdown = (dropdown, items, key, value) => {
                dropdown.innerHTML = '<option value="" disabled selected>Select ' + dropdown.id.charAt(0).toUpperCase() + dropdown.id.slice(1) + '</option>';
                items.filter(item => item[key] === value).forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.id;
                    option.textContent = item.name;
                    dropdown.appendChild(option);
                });
            };

            department.addEventListener('change', () => {
                const departmentId = parseInt(department.value, 10);
                populateDropdown(role, Object.values(roles), 'department_id', departmentId);
                position.innerHTML = '<option value="" disabled selected>Select Position</option>';
            });

            role.addEventListener('change', () => {
                const roleId = parseInt(role.value, 10);
                populateDropdown(position, Object.values(positions), 'role_id', roleId);
            });
        });
    </script>
@endpush
