@push('style')
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
            min-width: 50px;
            min-height: 50px;
            /*width: 50px;*/
            /*height: 50px;*/
            cursor: pointer;
        }

        .image-checkbox-container strong {
            font-size: 11px;
        }

        strong.employee-name {
            font-size: 9px;
        }

        .select-user-checkbox {
            position: absolute !important;
            top: 0;
            left: 0;
            width: 100% !important;
            height: 100%;
            opacity: 0; /* Invisible but clickable */
            cursor: pointer;
            margin: 0px !important;
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
            font-size: 21px;
            font-weight: bold;
            pointer-events: none; /* Allows clicks to pass through to checkbox */
            padding: 8px !important;
        }

        .select-user-checkbox:checked + .checkmark-overlay {
            display: flex;
        }

        .image-checkbox-container img.user-image {
            /*position: absolute;*/
        }

        .assign-brands select[multiple] option:checked, .assign-brands select[multiple]:focus option:checked {
            background: var(--bs-primary) linear-gradient(0deg, var(--bs-primary) 0%, var(--bs-primary) 100%);
            color: var(--bs-primary-color);
        }

        @media (max-width: 576px) {
            .team-emp .col-md-2 {
                width: 25%;
            }

        }
    </style>

@endpush
<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading" class="tour-teamcreation"> Manage Team</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Team Name</label>
                    <input type="text" class="form-control tour-teamname" id="name" name="name" placeholder="Enter name" required>
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Team Lead</label>
                    <select class="form-control select2 tour-teamlead unique-select-2" id="lead_id" name="lead_id">
                        <option value="" selected>Select Team Lead</option>
                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}"
                                {{ old('lead_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                        @error('lead')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="designation" class="form-label">Description</label>
                    <input type="text" class="form-control tour-teamdesc" id="description" name="description">

                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <style>
                    .main-images-wrapper {
                        display: flex;
                        justify-content: left;
                        gap: 7px;
                        flex-wrap: wrap;
                        align-items: center;
                        overflow-y: scroll;
                        overflow-x: hidden;
                        height: 250px;
                    }

                    .main-img-box {
                        text-align: center;
                    }
                </style>

                <div class="form-group mb-3">
                    <label for="user" class="form-label tour-teammember">Team Members</label>

                    <div class="main-images-wrapper">

                        @foreach($users as $user)

                            <div class="main-img-box">
                                <div class="image-checkbox-container">
                                    <input type="checkbox" name="employees[]" value="{{ $user->id }}"
                                           id="user-{{ $user->id }}"
                                           {{ in_array($user->id, old('employees', [])) ? 'checked' : '' }}
                                           class="select-user-checkbox" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->email }}">
                                    <img
                                        src="{{ $user->image && file_exists(public_path('assets/images/employees/'.$user->image)) ? asset('assets/images/employees/'.$user->image) : ($user->gender == 'male' ? asset('assets/img/team-4.jpg') : asset('assets/img/team-1.jpg')) }}"
                                        alt="{{ $user->name }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->email }}"
                                        class="rounded-circle user-image">
                                    <div class="checkmark-overlay">✔</div>
                                </div>
                                <div>
                                    <strong class="employee-name">{{ $user->name }}</strong>
                                </div>
                            </div>

                        @endforeach

                    </div>
                    <div class="row">
                        {{--                        @foreach($users as $user)--}}
                        {{--                            <div class="col-md-2">--}}
                        {{--                                <div class="image-checkbox-container">--}}
                        {{--                                    <input type="checkbox" name="employees[]" value="{{ $user->id }}"--}}
                        {{--                                           id="user-{{ $user->id }}"--}}
                        {{--                                           {{ in_array($user->id, old('employees', [])) ? 'checked' : '' }}--}}
                        {{--                                           class="select-user-checkbox">--}}
                        {{--                                    <img--}}
                        {{--                                        src="{{ $user->image && file_exists(public_path('assets/images/employees/'.$user->image)) ? asset('assets/images/employees/'.$user->image) : asset('assets/img/team-1.jpg') }}"--}}
                        {{--                                        alt="{{ $user->name }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $user->email }}"--}}
                        {{--                                        class="rounded-circle user-image" width="30" height="30">--}}
                        {{--                                    <div class="checkmark-overlay">✔</div>--}}
                        {{--                                </div>--}}
                        {{--                                <div>--}}
                        {{--                                    <strong class="employee-name">{{ $user->name }}</strong>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        @endforeach--}}
                    </div>
                    @error('employees.*')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <!-- Assign Brands Section -->
                    <div class="assign-brands">
                        <div class="mb-3">
                            @php
                                $allBrandsSelected = count(old('brands', [])) === $brands->count();
                            @endphp

                                <!-- Select All Toggle Section -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="font-weight-bold mb-0 text-center">Brands</h5>
                                <div class="form-check form-check-update d-flex align-items-center form-check-inline">
                                    <input type="checkbox" id="select-all-brands"
                                           class="form-check-input ">
                                    <label class="form-check-label" for="select-all-brands">
                                        <small id="select-all-label">Select All</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Brands Select Dropdown -->
                            <div class="form-group">
                                <select name="brands[]" id="brands" class="form-control tour-teambrand" multiple>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->brand_key }}"
                                            {{ in_array($brand->brand_key, old('brands', [])) ? 'selected' : '' }}>
                                            {{ $brand->name }} - {{ $brand->url }}
                                        </option>
                                    @endforeach
                                </select>

                                <!-- Error Display for Brands -->
                                @error('brands')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3 ">
                    <label for="status" class="form-label ">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-teamsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>


@push('script')

    <script>
        $(document).ready(function () {
            function handleFormVisibility() {
                if ($('#manage-form').is(':visible')) {
                    $('.select-user-checkbox').prop('checked', false);
                    $('.checkmark-overlay').hide();
                }
            }
            handleFormVisibility();

            $(document).on('dblclick', function (event) {
                if (
                    (!$(event.target).closest('.form-container').length &&
                        !$(event.target).is('.form-container') &&
                        !$(event.target).closest('.open-form-btn').length &&
                        !$(event.target).is('.editBtn')
                    ) ||
                    $(event.target).is('.form-container .close-btn')
                ) {
                    if ($(".select-user-checkbox").length > 0) {
                        $(".select-user-checkbox").prop('checked', false).siblings('.checkmark-overlay').hide();
                    }
                }
            });
        });

        /** For Assign brand to team */
        $('#select-all-brands').change(function () {
            const isChecked = this.checked;
            $('#brands option').prop('selected', isChecked);
            $('#select-all-label').text(isChecked ? 'Unselect All' : 'Select All');
        });

        $('#brands option').click(function () {
            if ($('#brands option:checked').length === $('#brands option').length) {
                $('#select-all-brands').prop('checked', true);
                $('#select-all-label').text('Unselect All');
            } else {
                $('#select-all-brands').prop('checked', false);
                $('#select-all-label').text('Select All');
            }
        });
        var $formContainer = $('.form-container');
        var observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'class') {
                    if (!$formContainer.hasClass('open')) {
                        $('#select-all-label').text($('#select-all-brands').checked ? 'Unselect All' : 'Select All');
                    }
                }
            });
        });
        observer.observe($formContainer[0], {
            attributes: true
        });

    </script>

@endpush
