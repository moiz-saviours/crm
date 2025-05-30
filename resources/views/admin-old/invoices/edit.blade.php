@extends('admin.layouts.app')
@section('title', 'Invoice / Edit')
@push('breadcrumb')
    <li class="breadcrumb-item text-sm" aria-current="page">
        <a href="{{ route('admin.invoice.index') }}">Invoice</a>
    </li>
    <li class="breadcrumb-item text-sm active" aria-current="page">
        <a href="{{ route('admin.invoice.edit', $invoice->id) }}">Edit</a>
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
                        <h5>Edit Invoice</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.invoice.update', $invoice->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="brand_key" class="form-label">Brand</label>
                                    <select class="form-control searchable" id="brand_key" name="brand_key"
                                            title="Please select a brand" required>
                                        <option value="" disabled>Please select brand</option>
                                        @foreach($brands as $brand)
                                            <option
                                                value="{{ $brand->brand_key }}" {{ old('brand_key', $invoice->brand_key) == $brand->brand_key ? 'selected' : '' }}>
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
                                            title="Please select a team" required>
                                        <option value="" disabled>Please select team</option>
                                        @foreach($teams as $team)
                                            <option
                                                value="{{ $team->team_key }}" {{ old('team_key', $invoice->team_key) == $team->team_key ? 'selected' : '' }}>
                                                {{ $team->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="row">
                                        <div class="col-md-10 mb-3">
                                            <label for="type" class="form-label">Client Type</label>
                                            <select class="form-control" id="type" name="type"
                                                    title="Please select client type" required>
                                                <option
                                                    value="0" {{ old('type', $invoice->type) == 0 ? 'selected' : '' }}>
                                                    Fresh
                                                </option>
                                                @if($clients && $clients->count() > 0)
                                                    <option
                                                        value="1" {{ old('type', $invoice->type) == 1 ? 'selected' : '' }}>
                                                        Upsale
                                                    </option>
                                                @endif
                                            </select>
                                            @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 mb-3" style="display:flex;align-items: flex-end;">
                                            <a href="javascript:void(0)" title="create new client"
                                               id="create-new-client"><i class="fas fa-add"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div id="fresh-client-fields" class="col-md-9 mb-3 d-none">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="client_name" class="form-label">Client Name</label>
                                            <input type="text" class="form-control" id="client_name"
                                                   name="client_name"
                                                   value="{{ old('client_name', optional($invoice->client)->name) }}">
                                            @error('client_name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="client_email" class="form-label">Client Email</label>
                                            <input type="email" class="form-control" id="client_email"
                                                   name="client_email"
                                                   value="{{ old('client_email', optional($invoice->client)->email) }}">
                                            @error('client_email')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="client_phone" class="form-label">Client Phone</label>
                                            <input type="text" class="form-control" id="client_phone"
                                                   name="client_phone"
                                                   value="{{ old('client_phone', optional($invoice->client)->phone) }}">
                                            @error('client_phone')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div id="upsale-client-fields" class="col-md-3 mb-3">
                                    <label for="client_key" class="form-label">Select Client</label>
                                    <select class="form-control" id="client_key" name="client_key">
                                        <option value="">Select Client</option>
                                        @foreach($clients as $client)
                                            <option
                                                value="{{ $client->client_key }}" {{ old('client_key', $invoice->client_key) == $client->client_key ? 'selected' : '' }}>
                                                {{ $client->name }} ({{ $client->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_key')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="agent_id" class="form-label">Agent</label>
                                    <select class="form-control searchable" id="agent_id" name="agent_id"
                                            title="Please select agent" required>
                                        <option value="" disabled>Select Agent</option>
                                        @foreach($users as $user)
                                            <option
                                                value="{{ $user->id }}" {{ old('agent_id', $invoice->agent_id) == $user->id ? 'selected' : '' }}>
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
                                           max="{{config('invoice.max_amount')}}" value="{{ old('amount', $invoice->amount) }}" required>
                                    @error('amount')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description"
                                                      rows="3">{{ old('description', $invoice->description) }}</textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
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
                    $("#create-new-client").toggle(type == 1);
                    $('#fresh-client-fields').toggleClass('d-none', type != 0);
                    $('#client_name, #client_email, #client_phone').prop('required', type == 0);
                    $('#upsale-client-fields').toggleClass('d-none', type != 1);
                    $('#client_key').prop('required', type == 1);
                });

                $('#create-new-client').on('click', () => $('#create-new-client').hide() && $("#type").val(0).trigger('change'));

            });
        </script>
    @endpush
@endsection
