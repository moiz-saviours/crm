@extends('user.layouts.app')
@section('title','Profile')

@section('content')
    @push('style')
        <style>
            .profile-sec {
                margin: 30px 30px;
            }

            .profile-card img {
                border: 1px solid #2d3e50;
                padding: 10px;
            }

            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: transparent;
                border-radius: .25rem;
            }

            .mb-3, .my-3 {
                margin-bottom: 1rem!important;
            }

            .img-box {
                position: relative;
                display: inline-block;
            }

            .img-box img {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 50%;
            }

            .edit-icon {
                position: absolute;
                bottom: 0;
                right: 0;
                background: #000000aa;
                color: white;
                border-radius: 50%;
                padding: 8px;
                cursor: pointer;
                display: none;
            }

            .img-box:hover .edit-icon {
                display: block;
            }

            .profile-save-btn {
                margin-top: 20px;
            }

            .form-control:disabled {
                background-color: #e9ecef;
                opacity: 1;
            }
        </style>
    @endpush

    <section id="content" class="content">
        <div class="content__boxed rounded-0">
            <div class="content__wrap d-md-flex align-items-start">
                <div class="col-md-4 mb-3">
                    <div class="profile-card">
                        <div class="d-flex flex-column align-items-center text-center">
                            <div class="img-box">
                                <img id="profile-img" src="{{ auth()->user()->profile_image ?? 'https://bootdey.com/img/Content/avatar/avatar7.png' }}" alt="Profile Image" class="rounded-circle">
                                <label for="file-input" class="edit-icon">✏️</label>
                                <input type="file" id="file-input" style="display: none;" accept="image/*">
                            </div>
                            <div class="mt-3">
                                <h4>{{ auth()->user()->name }}</h4>
                                <p class="text-muted font-size-sm">{{ auth()->user()->designation }}</p>
                                <button class="btn btn-primary" id="edit-profile-btn">Edit Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row profile-sec">
            <div class="col-md-6">
                <form id="profile-form" action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Pseudo Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ auth()->user()->pseudo_name }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Pseudo Email Address</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ auth()->user()->pseudo_email }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Pseudo Phone No.</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="{{ auth()->user()->pseudo_phone }}" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Designation</label>
                            <input type="text" class="form-control" name="department" id="department" value="{{ auth()->user()->designation }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="target" class="form-label">Monthly Target</label>
                            <input type="text" class="form-control" name="target" id="target" value="{{ auth()->user()->target }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dob" class="form-label">Date Of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob"
                                   value="{{ auth()->user()->dob ? \Carbon\Carbon::parse(auth()->user()->dob)->format('Y-m-d') : '' }}"
                                   disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="doj" class="form-label">Date Of Joining</label>
                            <input type="date" class="form-control" name="doj" id="doj"
                                   value="{{ auth()->user()->date_of_joining ? \Carbon\Carbon::parse(auth()->user()->date_of_joining)->format('Y-m-d') : '' }}"
                                   disabled>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary profile-save-btn" style="display: none;">Save Profile</button>
                </form>
            </div>
        </div>
    </section>

    @push('script')
        <script>
            $(document).ready(function () {
                // Toggle edit mode
                let isEditMode = false;

                $('#edit-profile-btn').click(function() {
                    isEditMode = !isEditMode;

                    if (isEditMode) {
                        $(this).text('Cancel');
                        $('.profile-save-btn').show();
                        $('#profile-form input').prop('disabled', false);
                    } else {
                        $(this).text('Edit Profile');
                        $('.profile-save-btn').hide();
                        $('#profile-form input').prop('disabled', true);
                        // Reset form to original values if needed
                    }
                });

                // Profile image upload
                $('#file-input').change(function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();

                        reader.onload = function(e) {
                            $('#profile-img').attr('src', e.target.result);

                            // Upload image immediately when selected
                            const formData = new FormData();
                            formData.append('profile_image', $('#file-input')[0].files[0]);
                            formData.append('_token', '{{ csrf_token() }}');

                            const url = '{{ route("user.profile.image.update") }}';

                            AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                                .then(response => {
                                    toastr.success('Profile image updated successfully');
                                })
                                .catch(error => {
                                    console.log(error);
                                    toastr.error('Failed to update profile image');
                                });
                        }

                        reader.readAsDataURL(this.files[0]);
                    }
                });

                // Form submission
                $('#profile-form').submit(function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const url = $(this).attr('action');

                    AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                        .then(response => {
                            toastr.success('Profile updated successfully');
                            $('#edit-profile-btn').text('Edit Profile');
                            $('.profile-save-btn').hide();
                            $('#profile-form input').prop('disabled', true);
                            isEditMode = false;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                });
            });
        </script>
    @endpush
@endsection
