@extends('user.layouts.app')
@section('title', 'CustomerContact / Edit')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm text-white" aria-current="page"><a
                href="{{ route('user.client.index') }}">Client</a></li>
    <li class="breadcrumb-item text-sm text-white active" aria-current="page"><a
                href="{{ route('user.client.edit', $client->id) }}">Edit</a></li>
@endpush
@section('content')
    @push('style')
        @include('user.contacts.style')
    @endpush

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5>Edit Client</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.client.update', $client->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="brand_key" class="form-label">Brand</label>
                                    <select class="form-control searchable" id="brand_key" name="brand_key"
                                            title="Please select brand" required>
                                        <option value="" disabled>Please select brand</option>
                                        @foreach($brands as $brand)
                                            <option
                                                    value="{{ $brand->brand_key }}" {{ $client->brand_key == $brand->brand_key ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="team_key" class="form-label">Team</label>
                                    <select class="form-control searchable" id="team_key" name="team_key"
                                            title="Please select team">
                                        <option value="" disabled>Please select team</option>
                                        @foreach($teams as $team)
                                            <option
                                                    value="{{ $team->team_key }}" {{ $client->team_key == $team->team_key ? 'selected' : '' }}>
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="name" class="form-label">Client Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ old('name', $client->name) }}" required>
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ old('email', $client->email) }}" required>
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                           value="{{ old('phone', $client->phone) }}">
                                    @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control" id="address" name="address"
                                                      rows="5">{{ old('address', $client->address) }}</textarea>
                                            @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="city" class="form-label">City</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                   value="{{ old('city', $client->city) }}">
                                            @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="country" class="form-label">Country</label>
                                            <select class="form-control searchable" id="country" name="country"
                                                    title="Please select country" required>
                                                @foreach($countries as $code => $country)
                                                    <option
                                                            value="{{ $code }}" {{ (old('country', $client->country) == $code ) || ($code == "US") ? 'selected' : '' }}>
                                                        {{ $country }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="state" class="form-label">State</label>
                                            <input type="text" class="form-control" id="state" name="state"
                                                   value="{{ old('state', $client->state) }}">
                                            @error('state')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="zipcode" class="form-label">Zip Code</label>
                                            <input type="text" class="form-control" id="zipcode" name="zipcode"
                                                   value="{{ old('zipcode', $client->zipcode) }}">
                                            @error('zipcode')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="1" {{ old('status', $client->status) == '1' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="0" {{ old('status', $client->status) == '0' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">Update Client</button>
                                    <a href="{{ route('user.client.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        @include('user.contacts.script')
    @endpush
@endsection
