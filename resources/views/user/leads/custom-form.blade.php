<div class="custom-form">
    <form id="manage-form" class="manage-form" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading" class="tour-leadcreation">Manage Lead</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="brand_key" class="form-label">Brand</label>
                    <select class="form-control searchable tour-leadbrand unique-select-2" id="brand_key" name="brand_key"
                            title="Please select a brand" required>
                        <option value="" selected>Please select brand</option>
                        @foreach($brands as $brand)
                            <option
                                value="{{ $brand->brand_key }}" {{ old('brand_key') == $brand->brand_key ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    @error('brand_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="team_key" class="form-label">Team</label>
                    <select class="form-control searchable tour-leadteam unique-select-2" id="team_key" name="team_key"
                            title="Please select a Team" required>
                        <option value="" selected>Please select Team</option>
                        @foreach($teams as $team)
                            <option
                                value="{{ $team->team_key }}" {{ old('team_key') == $team->team_key ? 'selected' : '' }}>
                                {{ $team->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control tour-leadname" id="name" name="name"
                           value="{{ old('name') }}">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control tour-leademail" id="email"
                           name="email" value="{{ old('email') }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control tour-leadphone" id="phone"
                           name="phone" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="lead_status_id" class="form-label ">Lead Type</label>
                    <select class="form-control searchable tour-leadtype unique-select-2" id="lead_status_id" name="lead_status_id"
                            required>
                        <option value="" selected>Please select lead status</option>
                        @foreach($lead_statuses as $lead_status)
                            <option
                                value="{{ $lead_status->id }}" {{ old('lead_status_id') == $lead_status->id ? 'selected' : '' }}>
                                {{ $lead_status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('lead_status_id')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <label for="note" class="form-label">Note</label>
                    <textarea class="form-control tour-leadnote" rows="6" id="note" name="note">{{ old('note') }}</textarea>
                    @error('note')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control tour-leadsstatus" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-leadsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>
