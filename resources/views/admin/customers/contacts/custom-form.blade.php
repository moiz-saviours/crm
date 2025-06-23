<div class="custom-form">
    <form id="manage-form" class="manage-form" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
                <label for="crsf_token" class="form-label d-none">Crsf Token</label>
                <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading" class="tour-admincreation">Manage Contact</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="brand_key" class="form-label">Brand</label>
                    <select class="form-control searchable tour-contactbrand" id="brand_key" name="brand_key"
                            title="Please select a brand" required>
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
                <div class="form-group mb-3">
                    <label for="team_key" class="form-label">Team</label>
                    <select class="form-control searchable tour-contactteam" id="team_key" name="team_key"
                            title="Please select a team">
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
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Client Name</label>
                    <input type="text" class="form-control tour-contactname" id="name" name="name"
                           value="{{ old('name') }}" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control tour-contactemail" id="email" name="email"
                           value="{{ old('email') }}" required>
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control tour-contactphone" id="phone" name="phone"
                           value="{{ old('phone') }}">
                    @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control tour-contactaddress" id="address" name="address"
                              rows="5">{{ old('address') }}</textarea>
                    @error('address')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group mb-3">
                    <div class="col-md-12 mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" class="form-control tour-contactcity" id="city" name="city"
                               value="{{ old('city') }}">
                        @error('city')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>
                </div>

                    <div class="form-group mb-3">
                        <div class="col-md-12 mb-3">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-control searchable tour-contactcountry" id="country" name="country"
                                    title="Please select country" required>
                                @foreach($countries as $code => $country)
                                    <option
                                        value="{{ $code }}" {{ (old('country') == $code ) || ($code == "US") ? 'selected' : '' }}>
                                        {{ $country }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control tour-contactstate" id="state" name="state"
                                       value="{{ old('state') }}">
                                @error('state')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="zipcode" class="form-label">Zip Code</label>
                                <input type="text" class="form-control tour-contactzip" id="zipcode" name="zipcode"
                                       value="{{ old('zipcode') }}">
                                @error('zipcode')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control tour-contactstatus" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            </div>
            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-contactsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>

</div>
