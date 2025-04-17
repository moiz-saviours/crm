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

           /* .card {
   box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06);
   } */

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
       </style>
   @endpush

    <section id="content" class="content">
        <div class="content__boxed rounded-0">
            <div class="content__wrap d-md-flex align-items-start">
                <div class="col-md-4 mb-3">
                    <div class="profile-card">
                        <div class="d-flex flex-column align-items-center text-center">
                            <div class="img-box">
                                <img id="profile-img" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle">
                                <label for="file-input" class="edit-icon">✏️</label>
                                <input type="file" id="file-input" style="display: none;" accept="image/*">
                            </div>
                            <div class="mt-3">
                                <h4>John Doe</h4>
                                <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
                                <button class="btn btn-primary">Edit Profile</button>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="row profile-sec">
            <div class="col-md-6">
                <form action="">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label"> Name</label>
                            <input type="text" class="form-control" name="fname"  >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Phone No.</label>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" name="department">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control" name="position">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="target" class="form-label">Monthly Target</label>
                            <input type="target" class="form-control" name="target" >
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dob" class="form-label">Date Of Birth</label>
                            <input type="date" class="form-control" name="dob" placeholder="dd/mm/yy">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="doj" class="form-label">Date Of Joining</label>
                            <input type="date" class="form-control" name="phone" placeholder="dd/mm/yy">
                        </div>
                    </div>
                    <button class="btn btn-primary">Save Profile</button>

                </form>
            </div>
        </div>
    </section>


    @push('script')
        <script>
            $(document).ready(function () {
                $('#edit-icon').click(function () {
                    $('#file-input').click();
                });
            });
        </script>
    @endpush

@endsection
