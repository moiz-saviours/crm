<div class="custom-form">
    <form id="manage-form" class="manage-form" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading" class="tour-dealcreation">Manage Deal</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="cus_company_key" class="form-label">Company</label>
                    <select class="form-control searchable tour-dealcompany unique-select-2" id="cus_company_key" name="cus_company_key"
                            title="Please select a company">
                        <option value="" selected>Please select company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->special_key }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                    @error('cus_company_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="cus_contact_key" class="form-label">Contact</label>
                    <select class="form-control searchable tour-dealcontact unique-select-2" id="cus_contact_key" name="cus_contact_key"
                            title="Please select a contact">
                        <option value="" selected>Please select contact</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->special_key }}">{{ $contact->name }}</option>
                        @endforeach
                    </select>
                    @error('cus_contact_key')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="name" class="form-label">Deal Name</label>
                    <input type="text" class="form-control tour-dealname" id="name" name="name"
                           value="{{ old('name') }}" placeholder="Enter deal name">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="deal_stage" class="form-label">Deal Stage</label>
                    <select class="form-control tour-dealstage" id="deal_stage" name="deal_stage" required>
                        <option value="" selected>Please select deal stage</option>
                        @foreach($dealStages as $key => $stage)
                            <option value="{{ $key }}">{{ $stage }}</option>
                        @endforeach
                    </select>
                    @error('deal_stage')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" step="0.01" class="form-control tour-dealamount" id="amount" name="amount"
                           value="{{ old('amount', 0.00) }}" placeholder="0.00">
                    @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control tour-dealstartdate" id="start_date" name="start_date"
                           value="{{ old('start_date') }}">
                    @error('start_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="close_date" class="form-label">Close Date</label>
                    <input type="date" class="form-control tour-dealclosedate" id="close_date" name="close_date"
                           value="{{ old('close_date') }}">
                    @error('close_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="deal_type" class="form-label">Deal Type</label>
                    <input type="text" class="form-control tour-dealtype" id="deal_type" name="deal_type"
                           value="{{ old('deal_type') }}" placeholder="Enter deal type">
                    @error('deal_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select class="form-control tour-dealpriority" id="priority" name="priority">
                        <option value="" selected>Please select priority</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                    @error('priority')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="services" class="form-label">Services</label>
                    <select class="form-control searchable tour-dealservices unique-select-2" id="services" name="services"
                            title="Please select services">
                        <option value="" selected>Please select services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @error('services')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input tour-dealcontactactivity" type="checkbox" id="is_contact_start_date" 
                               name="is_contact_start_date" value="1">
                        <label class="form-check-label" for="is_contact_start_date">
                            Add timeline activity from selected Contacts
                        </label>
                    </div>
                    <input type="date" class="form-control mt-2 tour-dealcontactdate" id="contact_start_date" 
                           name="contact_start_date" value="{{ old('contact_start_date') }}" style="display: none;">
                    @error('contact_start_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input tour-dealhubspotactivity" type="checkbox" id="is_company_start_date" 
                               name="is_company_start_date" value="1">
                        <label class="form-check-label" for="is_company_start_date">
                            Add timeline activity from HubSpot
                        </label>
                    </div>
                    <input type="date" class="form-control mt-2 tour-dealhubspotdate" id="company_start_date" 
                           name="company_start_date" value="{{ old('company_start_date') }}" style="display: none;">
                    @error('company_start_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control tour-dealstatus" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-dealsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>