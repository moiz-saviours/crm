<div class="create_modal_area">
    <h4>Add Brand</h4>

    <div class="card-body">
        <!-- <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Brand Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="url" class="form-label">Brand URL</label>
                <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com">
                @error('url')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="logo" class="form-label">Brand Logo (Optional)</label>
                <div class="input-group">
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                    <input type="url" class="form-control" id="logo_url" name="logo_url" placeholder="https://example.com/logo.png">
                </div>
                <small class="form-text text-muted">You can either upload an image or provide a valid image URL.</small>
                @error('logo')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('logo_url')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('admin.brand.index') }}" class="btn btn-secondary">Cancel</a>
        </form> -->

        <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="name" class="form-label">Brand Name</label>
                    <input type="text" class="form-control" id="name" name="name" required placeholder="Web Name">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col">
                    <label for="url" class="form-label">Brand URL</label>
                    <input type="url" class="form-control" id="url" name="url" placeholder="https://example.com">
                    @error('url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="logo" class="form-label">Brand Logo (Optional)</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
                    </div>
                    @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col">
                    <label for="logo_url" class="form-label">Brand Logo URL (Optional)</label>
                    <input type="url" class="form-control" id="logo_url" name="logo_url" placeholder="https://example.com/logo.png">
                    @error('logo_url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="example@domain.com">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4" placeholder="Your Description"></textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="activeStatus" value="1" checked>
                    <label class="form-check-label" for="activeStatus">
                        Active
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="status" id="inactiveStatus" value="0">
                    <label class="form-check-label" for="inactiveStatus">
                        Inactive
                    </label>
                </div>
            </div>

            <div class="create_modal_btns">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
</div>