@extends('admin.layouts.app')
@section('title', 'Invoice / Create')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm" aria-current="page">
        <a href="{{ route('admin.invoice.index') }}">Invoice</a>
    </li>
    <li class="breadcrumb-item text-sm active" aria-current="page">
        <a href="{{ route('admin.invoice.create') }}">Create</a>
    </li>
@endpush
@section('content')
    @push('style')
        @include('admin.invoices.style')
    @endpush
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h5>Create Invoice</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.invoice.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="brand_key" class="form-label">Brand</label>
                                    <select class="form-control searchable" id="brand_key" name="brand_key"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Please select a brand" required>
                                        <option value="" disabled>Please select brand</option>
                                        @foreach($brands as $brand)
                                            <option
                                                value="{{ $brand->brand_key }}" {{ old('brand_key') == $brand->brand_key ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="team_key" class="form-label">Team</label>
                                    <select class="form-control searchable" id="team_key" name="team_key"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Please select a team" required>
                                        <option value="" disabled>Please select team</option>
                                        @foreach($teams as $team)
                                            <option
                                                value="{{ $team->team_key }}" {{ old('team_key') == $team->team_key ? 'selected' : '' }}>
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="type" class="form-label">Customer Type</label>
                                    <select class="form-control" id="type" name="type" data-bs-toggle="tooltip" data-bs-placement="top" title="Please select customer type" required>
                                        <option value="0" {{ old('type') == 0 ? 'selected' : '' }}>
                                            Fresh
                                        </option>
                                        @if($customer_contacts->count() > 0)
                                            <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>
                                                Upsale
                                            </option>
                                        @endif
                                    </select>
                                    @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div id="fresh-customer-contact-fields" class="col-md-9 mb-3 d-none">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="customer_contact_name" class="form-label">Customer Contact Name</label>
                                            <input type="text" class="form-control" id="customer_contact_name"
                                                   name="customer_contact_name"
                                                   value="{{ old('customer_contact_name') }}">
                                            @error('customer_contact_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="customer_contact_email" class="form-label">Customer Contact Email</label>
                                            <input type="email" class="form-control" id="customer_contact_email"
                                                   name="customer_contact_email"
                                                   value="{{ old('customer_contact_email') }}">
                                            @error('customer_contact_email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="customer_contact_phone" class="form-label">Customer Contact Phone</label>
                                            <input type="text" class="form-control" id="customer_contact_phone"
                                                   name="customer_contact_phone"
                                                   value="{{ old('customer_contact_phone') }}">
                                            @error('customer_contact_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="upsale-customer-contact-fields" class="col-md-3 mb-3 d-none">
                                    <label for="special_key" class="form-label">Select Customer Contact</label>
                                    <select class="form-control" id="special_key" name="special_key">
                                        <option value="">Select Customer Contact</option>
                                        @foreach($customer_contacts as $customer_contact)
                                            <option value="{{ $customer_contact->special_key }}" {{ old('special_key') == $customer_contact->special_key ? 'selected' : '' }}>
                                                {{ $customer_contact->name }} ({{ $customer_contact->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('special_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="agent_id" class="form-label">Agent</label>
                                    <select class="form-control searchable" id="agent_id" name="agent_id" data-bs-toggle="tooltip" data-bs-placement="top" title="Please select agent" required>
                                        <option value="" disabled>Select Agent</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('agent_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('agent_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" step="0.01"
                                           min="1"
                                           max="{{config('invoice.max_amount')}}" value="{{ old('amount') }}" required>
                                    @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description"
                                                      rows="3">{{ old('description') }}</textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        @include('admin.invoices.script')
        <script>
            $(document).ready(function () {
                $('#type').on('change', function () {
                    const type = $(this).val();
                    $('#fresh-customer-contact-fields').toggleClass('d-none', type != 0);
                    $('#customer_contact_name, #customer_contact_email, #customer_contact_phone').prop('required', type == 0);
                    $('#upsale-customer-contact-fields').toggleClass('d-none', type != 1);
                    $('#special_key').prop('required', type == 1);
                }).trigger('change');
            });
        </script>
    @endpush
@endsection
