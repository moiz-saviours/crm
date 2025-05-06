@extends('admin.layouts.app')
@section('title', 'Team / Create')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm " aria-current="page"><a
            href="{{ route('admin.team.index') }}">Team</a></li>
    <li class="breadcrumb-item text-sm  active" aria-current="page"><a
            href="{{ route('admin.team.create') }}">Create</a>
    </li>
@endpush
@section('content')
    @push('style')
        @include('admin.teams.style')
        <style>
            /** Select Employee through image*/

            .team-emp {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                text-align: center;
                box-shadow: rgba(50, 50, 93, 0.25) 0px 30px 60px -12px, rgb(0 0 0 / 0%) 0px 18px 36px -18px;
                border-radius: 25px;
                padding: 20px;
            }

            .team-emp .col-md-2 {
                display: flex;
                flex-direction: column;
                border: none;
                font-size: 12px;
                align-items: center;
                position: relative;
            }

            .image-checkbox-container {
                position: relative;
                width: 50px;
                height: 50px;
                cursor: pointer;
            }

            .image-checkbox-container strong {
                font-size: 11px;
            }

            .select-user-checkbox {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                opacity: 0; /* Invisible but clickable */
                cursor: pointer;
            }

            .user-image {
                width: 100%;
                height: auto;
                border-radius: 50%;
                pointer-events: none; /* Prevents checkmark overlay from blocking clicks */
            }

            .checkmark-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                display: none;
                align-items: center;
                justify-content: center;
                color: green;
                font-size: 24px;
                font-weight: bold;
                pointer-events: none; /* Allows clicks to pass through to checkbox */
            }

            .select-user-checkbox:checked + .checkmark-overlay {
                display: flex;
            }

            @media (max-width: 576px) {
                .team-emp .col-md-2 {
                    width: 25%;
                }

            }
        </style>
    @endpush
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5>Create Team</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.team.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <!-- Team Information -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Team Name</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                       value="{{ old('name') }}" required>
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Team Lead -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="lead_id" class="form-label">Team Lead</label>
                                                <select class="form-control select2" id="lead_id" name="lead_id">
                                                    <option value="" selected>Select Team Lead</option>
                                                    @foreach($users as $user)
                                                        <option
                                                            value="{{ $user->id }}" {{ old('lead_id') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description"
                                                  rows="3">{{ old('description') }}</textarea>
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="checkbox" class="form-control status-toggle" id="status"
                                               name="status"
                                               {{ old('status') == 1 ? 'checked' : '' }} data-bs-toggle="toggle">
                                    </div>

                                    <!-- Team Members -->
                                    <div class="mb-3">
                                        <h5 class="text-center">Team Members</h5>
                                        <div class="row team-emp">
                                            @foreach($users as $user)
                                                <div class="col-md-2">
                                                    <div class="image-checkbox-container">
                                                        <input type="checkbox" name="employees[]" value="{{ $user->id }}" id="user-{{ $user->id }}"
                                                               {{ in_array($user->id, old('employees', [])) ? 'checked' : '' }}
                                                               class="select-user-checkbox">
                                                        <img
                                                            src="{{ $user->image && file_exists(public_path('assets/images/employees/'.$user->image)) ? asset('assets/images/employees/'.$user->image) : asset('assets/img/team-1.jpg') }}"
                                                            alt="{{ $user->name }}" title="{{ $user->email }}"
                                                            class="rounded-circle user-image" width="50" height="50">
                                                        <div class="checkmark-overlay">✔</div>
                                                    </div>
                                                    <div>
                                                        <strong>{{ $user->name }}</strong>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <!-- Assign Brands Section -->
                                    <div class="assign-brands">
                                        <div class="mb-3">
                                            @php
                                                $allBrandsSelected = count(old('brands', [])) === $brands->count();
                                            @endphp

                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h5 class="font-weight-bold mb-0 text-center">Brands</h5>
                                                <div class="form-check form-check-inline">
                                                    <input type="checkbox" id="select-all-brands"
                                                           class="form-check-input" {{ $allBrandsSelected ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="select-all-brands">
                                                        <small
                                                            id="select-all-label">{{ $allBrandsSelected ? 'Unselect' : 'Select' }}
                                                            All</small>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @foreach($brands as $brand)
                                                    <div class="col-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input brand-checkbox"
                                                                   type="checkbox" name="brands[]"
                                                                   value="{{ $brand->brand_key }}"
                                                                   id="brand-{{ $brand->brand_key }}" {{ in_array($brand->brand_key, old('brands',  [])) ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                   for="brand-{{ $brand->brand_key }}">{{ $brand->name }}</label>
                                                            <span
                                                                class="brand-url d-block text-muted">{{ $brand->url }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit and Cancel Buttons -->
                            <button type="submit" class="btn btn-secondary">Submit</button>
                            <a href="{{ route('admin.team.index') }}" class="btn btn-danger">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        @include('admin.teams.script')

        <script>
            /** For Assign brand to team */

            $('#select-all-brands').change(function () {
                const isChecked = this.checked;
                $('.brand-checkbox').prop('checked', isChecked);
                $('#select-all-label').text(isChecked ? 'Unselect All' : 'Select All');
            });

            $('.brand-checkbox').change(function () {
                if ($('.brand-checkbox:checked').length === $('.brand-checkbox').length) {
                    $('#select-all-brands').prop('checked', true);
                    $('#select-all-label').text('Unselect All');
                } else {
                    $('#select-all-brands').prop('checked', false);
                    $('#select-all-label').text('Select All');
                }
            });

        </script>

    @endpush
@endsection
