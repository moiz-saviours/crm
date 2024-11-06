@extends('admin.layouts.app')
@section('title', 'Brand / Create')
@section('content')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5>Create Brand</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
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
                            </div><div class="mb-3">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
