<style>
    .login-section {
         /*background-image: linear-gradient(310deg, #5e72e4b0 0%, #825ee47a 100%);*/

        /*background-image: linear-gradient(310deg, #0000002e 0%, #21252996 100%), url('../assets/images/crm-bg.jpg');*/
        background-image: url("{{asset('assets/images/crm-bg.jpg')}}") ;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        padding: 30px 0px;
        min-height: 100vh ;
        display: flex;
        align-items: center;

    }

    .main-login-row {
        /* box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        background: #fff;
        border-radius: 25px; */
    }

    .left-side-box {
        padding: 50px 28px;
        background: var(--bs-primary);
        color: #fff;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
        border-radius: 9px;
        margin-top: 12px;
    }

    .login-labels {
        font-size: 14px;
        margin-bottom: 7px;
    }

    .login-inputs {
        width: 100%;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 6px 12px;
        margin-bottom: 12px;
    }

    .login-inputs:focus-visible {
        outline: none;
        /* border: 1px solid #ccc; */
    }

    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 46px;
        height: 23px;

    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 15px;
        width: 15px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #ff7043;
        /* background-color: var( --bs-primary) */
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #ff7043;
        /* box-shadow: 0 0 1px var( --bs-primary); */
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .save-password-div {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    .remember-me-text {
        margin-bottom: 0;
    }

    .login-btn {
        color: #fff;
        background-color: #ff7043;
        /* background-color: var(--bs-primary); */
        border: none;
        border-radius: 9px;
        width: 100%;
        padding: 7px 12px;
        margin: 17px 0px;
    }

    .password-link {
        /* color: var(--bs-primary); */
        color: #fff;
        text-decoration: none;

    }

    .password-link:hover {
        color: #fff;
        text-decoration: underline;
        /* font-weight: 600; */
    }


    :root {
        --bs-primary: #5e72e4b0;
    }

    .main-logo-heading {
        text-align: center;
        color: #fff;

    }

    .logo-h {
        max-width: 58%;

    }

    .forgot-password-div {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .site-links {
        color: #0091ae;
        text-decoration: none;
        font-size: 10px;

    }

    .site-links:hover {
        color: #0091ae;
        text-decoration: underline;
    }

    .visit-sites-text {
        font-size: 14px;
    }



    /* .login-section h2 {
        font-size: 22px;
    } */
</style>
