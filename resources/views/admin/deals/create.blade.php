@extends('admin.layouts.app')
@section('title', 'Deal / Create')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm" aria-current="page">
        <a href="{{ route('admin.deal.index') }}">Deals</a>
    </li>
    <li class="breadcrumb-item text-sm active" aria-current="page">
        <a href="{{ route('admin.deal.create') }}">Create</a>
    </li>
@endpush
@section('content')
    @push('style')
        @include('admin.deals.style')
    @endpush
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5>Create Deal</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.deal.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Company Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="cus_company_key" class="form-label">Company</label>
                                    <select class="form-control searchable" id="cus_company_key" name="cus_company_key"
                                            title="Please select a company">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->special_key }}" {{ old('cus_company_key') == $company->special_key ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cus_company_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Contact Selection -->
                                <div class="col-md-6 mb-3">
                                    <label for="cus_contact_key" class="form-label">Contact</label>
                                    <select class="form-control searchable" id="cus_contact_key" name="cus_contact_key"
                                            title="Please select a contact">
                                        <option value="">Select Contact</option>
                                        @foreach($contacts as $contact)
                                            <option value="{{ $contact->special_key }}" {{ old('cus_contact_key') == $contact->special_key ? 'selected' : '' }}>
                                                {{ $contact->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('cus_contact_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Deal Name -->
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Deal Name</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name') }}" placeholder="Enter deal name">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Deal Stage -->
                                <div class="col-md-6 mb-3">
                                    <label for="deal_stage" class="form-label">Deal Stage</label>
                                    <select class="form-control" id="deal_stage" name="deal_stage" required>
                                        <option value="">Select Deal Stage</option>
                                        @foreach($dealStages as $key => $stage)
                                            <option value="{{ $key }}" {{ old('deal_stage') == $key ? 'selected' : '' }}>
                                                {{ $stage }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('deal_stage')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Amount -->
                                <div class="col-md-6 mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" class="form-control" id="amount" name="amount" 
                                           value="{{ old('amount', 0.00) }}" placeholder="0.00">
                                    @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Start Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" 
                                           value="{{ old('start_date') }}">
                                    @error('start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Close Date -->
                                <div class="col-md-6 mb-3">
                                    <label for="close_date" class="form-label">Close Date</label>
                                    <input type="date" class="form-control" id="close_date" name="close_date" 
                                           value="{{ old('close_date') }}">
                                    @error('close_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Deal Type -->
                                <div class="col-md-6 mb-3">
                                    <label for="deal_type" class="form-label">Deal Type</label>
                                    <input type="text" class="form-control" id="deal_type" name="deal_type" 
                                           value="{{ old('deal_type') }}" placeholder="Enter deal type">
                                    @error('deal_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Priority -->
                                <div class="col-md-6 mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-control" id="priority" name="priority">
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Services -->
                                <div class="col-md-6 mb-3">
                                    <label for="services" class="form-label">Services</label>
                                    <select class="form-control searchable" id="services" name="services"
                                            title="Please select services">
                                        <option value="">Select Services</option>
                                        {{-- @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ old('services') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                    @error('services')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Contact Timeline Options -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_contact_start_date" 
                                               name="is_contact_start_date" value="1" {{ old('is_contact_start_date') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_contact_start_date">
                                            Add timeline activity from selected Contacts
                                        </label>
                                    </div>
                                    <input type="date" class="form-control mt-2" id="contact_start_date" 
                                           name="contact_start_date" value="{{ old('contact_start_date') }}" 
                                           style="{{ !old('is_contact_start_date') ? 'display: none;' : '' }}">
                                    @error('contact_start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Company Timeline Options -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_company_start_date" 
                                               name="is_company_start_date" value="1" {{ old('is_company_start_date') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_company_start_date">
                                            Add timeline activity from HubSpot
                                        </label>
                                    </div>
                                    <input type="date" class="form-control mt-2" id="company_start_date" 
                                           name="company_start_date" value="{{ old('company_start_date') }}" 
                                           style="{{ !old('is_company_start_date') ? 'display: none;' : '' }}">
                                    @error('company_start_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Deal</button>
                            <a href="{{ route('admin.deal.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection