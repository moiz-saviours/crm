@extends('admin.layouts.app')
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
                margin-bottom: 1rem !important;
            }

            .img-box {
                position: relative;
                display: inline-block;
            }

            .img-box img {
                width: 150px;
                height: 150px;
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

            .editable-field {
                background-color: #fff !important;
                border: 1px solid #ced4da !important;
            }
        </style>
    @endpush

    <section id="content" class="content">
        <div class="row">
            <div class="content__boxed rounded-0">
                <div class="content__wrap d-md-flex align-items-center">
                    <div class="col-md-12 mb-3">
                        <div class="profile-card">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="img-box">
                                    <img id="profile-img"
                                         src="{{ auth()->guard('admin')->user()->image ? (filter_var(auth()->guard('admin')->user()->image, FILTER_VALIDATE_URL) ? auth()->guard('admin')->user()->image : (file_exists(public_path('assets/images/admins/'.auth()->guard('admin')->user()->image)) ? asset('assets/images/admins/'.auth()->guard('admin')->user()->image) : (file_exists(public_path('assets/images/admins/'.auth()->guard('admin')->user()->image)) ? asset('assets/images/admins/'.auth()->guard('admin')->user()->image) : asset('assets/themes/nifty/assets/img/profile-photos/2.png')))) : asset('assets/themes/nifty/assets/img/profile-photos/2.png')}}"
                                         alt="Profile Image" class="rounded-circle profile-image">
                                    <label for="file-input" class="edit-icon">✏️</label>
                                    <input type="file" id="file-input" style="display: none;" accept="image/*">
                                </div>
                                <div class="mt-3">
                                    <h4>{{ auth()->user()->name }}</h4>
                                    <p class="text-muted font-size-sm">{{ auth()->user()->designation }}</p>
{{--                                    <button class="btn btn-primary" id="edit-profile-btn">Edit Profile</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-around profile-sec">
                <div class="col-md-6">
                    <form id="profile-form" action="{{ route('admin.profile.update') }}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label"> Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ auth()->user()->name }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label"> Email Address</label>
                                <input type="email" class="form-control" name="email" id="email"
                                       value="{{ auth()->user()->email }}" disabled>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone_number" class="form-label"> Phone No.</label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number"
                                       value="{{ auth()->user()->phone_number }}" disabled>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" id="designation"
                                       value="{{ auth()->user()->designation }}" disabled>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <input type="text" class="form-control" id="gender"
                                       value="{{ auth()->user()->gender }}" disabled>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date Of Birth</label>
                                <input type="date" class="form-control" id="dob"
                                       value="{{ auth()->user()->dob ? \Carbon\Carbon::parse(auth()->user()->dob)->format('Y-m-d') : '' }}"
                                       disabled>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary profile-save-btn" style="display: none;">Save
                            Profile
                        </button>
                    </form>
                </div>
{{--                                           <div class="col-md-4">--}}
{{--                                               <div class="pass-sec">--}}
{{--                                                   <h1>Change Password</h1>--}}
{{--                                                   <form id="profile-form" action="" class="pass-sec-form">--}}
{{--                                                           <div class="col-md-10 mb-3">--}}
{{--                                                               <label for="old-password" class="form-label">Old Password</label>--}}
{{--                                                               <input type="text" class="form-control" name="old-password" id="old-password" value="" disabled>--}}
{{--                                                           </div>--}}
{{--                                                       <div class="col-md-10 mb-3">--}}
{{--                                                           <label for="new-password" class="form-label">Password</label>--}}
{{--                                                           <input type="text" class="form-control" name="new-password" id="new-password" value="" disabled>--}}
{{--                                                       </div>--}}
{{--                                                       <div class="col-md-10 mb-3">--}}
{{--                                                           <label for="confirm-password" class="form-label">Confirm Password</label>--}}
{{--                                                           <input type="text" class="form-control" name="confirm-password" id="confirm-password" value="" disabled>--}}
{{--                                                       </div>--}}
{{--                                                       <button type="submit" class="btn btn-primary">Update Password</button>--}}
{{--                                                   </form>--}}
{{--                                               </div>--}}
{{--                                           </div>--}}
            </div>
        </div>
    </section>

    @push('script')
        <script>
             $(document).ready(function () {
            //     let isEditMode = false;
            //     $('#edit-profile-btn').click(function () {
            //         isEditMode = !isEditMode;
            //         if (isEditMode) {
            //             $(this).text('Cancel');
            //             $('.profile-save-btn').show();
            //             $('#name, #email, #phone_number')
            //                 .prop('disabled', false)
            //                 .addClass('editable-field');
            //         } else {
            //             $(this).text('Edit Profile');
            //             $('.profile-save-btn').hide();
            //             $('#profile-form input').prop('disabled', true).removeClass('editable-field');
            //         }
            //     });

                // Profile image upload with revert on error and nav update
                $('#file-input').change(function () {
                    if (this.files && this.files[0]) {
                        const originalImageSrc = $('#profile-img').attr('src');
                        const navProfileImages = $('.profile-image').not('#profile-img').map(function () {
                            return {
                                element: this,
                                originalSrc: $(this).attr('src')
                            };
                        }).get();

                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const newImageSrc = e.target.result;
                            $('#profile-img').attr('src', newImageSrc);
                            $('.profile-image').not('#profile-img').attr('src', newImageSrc);

                            const formData = new FormData();
                            formData.append('image', $('#file-input')[0].files[0]);
                            formData.append('_token', '{{ csrf_token() }}');

                            const url = '{{ route("admin.profile.image.update") }}';

                            AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                                .then(response => {
                                    const finalImageUrl = response.image_url || newImageSrc;
                                    $('#profile-img').attr('src', finalImageUrl);
                                    $('.profile-image').not('#profile-img').attr('src', finalImageUrl);
                                })
                                .catch(error => {
                                    $('#profile-img').attr('src', originalImageSrc);
                                    navProfileImages.forEach(img => {
                                        $(img.element).attr('src', img.originalSrc);
                                    });
                                    console.log(error);
                                });
                        };

                        reader.readAsDataURL(this.files[0]);
                    }
                });

                // Form submission - only pseudo fields will be submitted
                // $('#profile-form').submit(function (e) {
                //     e.preventDefault();
                //
                //     const formData = new FormData(this);
                //     const url = $(this).attr('action');
                //
                //     AjaxRequestPromise(url, formData, 'POST', {useToastr: true})
                //         .then(response => {
                //             $('#edit-profile-btn').text('Edit Profile');
                //             $('.profile-save-btn').hide();
                //             $('#profile-form input').prop('disabled', true).removeClass('editable-field');
                //             isEditMode = false;
                //         })
                //         .catch(error => {
                //             console.log(error);
                //         });
                // });
            });
        </script>
    @endpush
@endsection
