<style>

    .email-template {
        display: none;
    }

    .email-template.open {
        display: block;
        position: fixed;
        justify-content: end;
        /*position: absolute;*/
        bottom: 0;
        right: 50px;
        z-index: 10026;
    }

    .email-header-main-wrapper {
        color: #fff;
        display: flex;
        justify-content: space-between;
        padding: 10px 30px;
        background-color: #2d3e50;
    }

    .email-child-wrapper-one {
        display: flex;
        align-items: center;
        gap: 12px
    }

    .email-child-wrapper {
        display: flex;
        align-items: center;
        gap: 12px;
        background-color: #fff;
    }

    .email-child-wrapper input {
        width: 500px;
        border: none;
    }

    .email-child-wrapper input:focus-visible {
        outline: none;
    }


    .email-titles {
        font-weight: 500;
        margin: 0;
    }

    .email-titles-hide {
        color: #ccc;
        font-weight: 500;
        margin: 0;
    }

    .email-titles-show {
        color: #2d3e50;
        font-weight: 600;
        margin: 0px;
    }

    .icon-display-email-box {
        color: #ccc;
        font-size: 12px;
    }

    .email-divider {
        background-color: #ddd;
        height: 1px;
    }

    .email-sending-titles {
        font-weight: 700;
        margin: 0;
        color: gray;
    }

    .email-sender-box {
        padding: 12px 0px;
        margin: 0;
        background-color: #eaf0f6;
        border-color: #cbd6e2;
        /* color: #506e91; */
        font-size: 12px;
        font-weight: 400;
        padding: 4px 17px;
        border-radius: 3px;
        border-style: solid;
        border-width: 1px;
    }

    .email-sender-box-icon {
        color: gray;
        font-size: 10px;
        padding-left: 7px;
    }

    .email-sending-box {
        display: flex;
        justify-content: space-between;
        background-color: #fff;
        padding: 10px 30px;
    }

    .main-content-email-box {
        background-color: #fff;
        padding: 20px 0px;
        text-align: center;

    }
    .main-content-email-box textarea {
        width: 95%;
        min-height: 200px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0px 30px;
        resize: vertical;

    }
    .main-content-email-box textarea:focus-visible {
        outline: none;
    }

    .main-content-email-text {
        color: #000;
        text-align: center;
        font-size: 15px;
    }

    .main-content-email-para {
        margin: 0;
        color: gray;
        padding: 20px 0px;
    }

    .connect-to-inbox-btn {
        background-color: #2d3e50;
        border: none;
        color: #fff;
        font-size: 13px;
        font-weight: 400;
        padding: 7px 16px;
        border-radius: 0px;
        font-weight: 600;
        border-radius: 4px;
    }

    .email-footer-div {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        padding: 10px 30px;
    }

    .email-footer-btn {
        background-color: #fff;
        border: 1px solid #2d3e50;
        color: #2d3e50;
        font-size: 12px;
        font-weight: 400;
        padding: 3px 17px;
        border-radius: 0px;
        border-radius: 4px;
    }

    .email-sender-name {
        margin: 0;
        color: #33475b;
    }

    .email-sender-emailid {
        font-size: 12px;
        color: #2d3e50;
        font-weight: 500;
    }

    .email-warning-icon {
        color: #f5c26b;
        padding-left: 9px;
        font-size: 12px;
    }

    .email-titles-dropdown {
        color: #2d3e50;
        font-weight: 600;
        margin: 0px;
        background-color: transparent;
        border: none;
        cursor: pointer;
    }

    .email-titles-dropdown:hover {
        text-decoration: underline;
    }

    .email-titles-dropdown-menu.show {
        width: 45%;
        width: 22%;
        /* transform: translate3d(240px, 100px, 0px); */
        transform: translate(210px, 100px) !important;
        padding: 21px 40px;
        border-radius: 0;
    }

    .dropdown-img {
        width: 238px;
    }

    .get-started-icon {
        padding-left: 8px;
    }

    .quotes-titles-dropdown-menu.show {
        width: 45%;
        width: 18%;
        /* transform: translate3d(240px, 100px, 0px); */
        transform: translate(316px, 100px) !important;
        padding: 0;
        border-radius: 0;
    }

    .quotes-header-box {
        padding: 21px 32px;

    }

    .quotes-content-para {
        color: #6c757da1;
    }

    .quotes-titles-link {
        color: #2d3e50;
        font-weight: 600;
        margin: 0px;

    }

    .quotes-titles-link:hover {
        color: #2d3e50;
    }

</style>


<section class= "new-template-mail email-template" id="emailTemplate">
    <div class="container-fluid p-0">
        <div class="row justify-content-end">
            <div class="col-lg-12">
                <div class="email-header-main-wrapper">
                    <div class="email-child-wrapper-one">
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                        <p class="email-titles">Email</p>
                    </div>
                    <div class="email-child-wrapper-one">
                        <i class="fa fa-external-link-square" aria-hidden="true"></i>
                        <i class="fa fa-times close-btn" aria-hidden="true" style="cursor:pointer;"></i>
                    </div>
                </div>
                <div class="email-child-wrapper" style="  padding: 10px 30px;">
                    <p class="email-titles-hide">Templates</p>
                    <p class="email-titles-show">Sequence <span><i class="fa fa-lock icon-display-email-box"
                                                                   aria-hidden="true"></i></span></p>
                    <p class="email-titles-hide">Documnets</p>
                    <!-- <p class="email-titles-show">Meetings </p> -->
                    <div class="">
                        <button class="email-titles-dropdown dropdown-toggle" type="button"
                                id="dropdownMenuButtonmeet" data-bs-toggle="dropdown" aria-expanded="false">
                            Meetings
                        </button>
                        <ul class="dropdown-menu email-titles-dropdown-menu"
                            aria-labelledby="dropdownMenuButtonmeet">
                            <li>
                                <h4 class="main-content-email-text">Connect with your Email</h4>
                            </li>
                            <li class="text-center">
                                <img src="img/dropdown-img.png" class="img-fluid dropdown-img">
                            </li>
                            <li class="text-center">
                                <p class="main-content-email-para">Lorem ipsum, dolor sit amet consectetur
                                    adipisicing elit.
                                    Obcaecati culpa optio ex et,</p>
                                <button class="connect-to-inbox-btn">Get started<span><i
                                            class="fa fa-external-link get-started-icon"
                                            aria-hidden="true"></i></span></button>
                            </li>
                        </ul>
                    </div>

                    <div class="">
                        <button class="email-titles-dropdown dropdown-toggle" type="button"
                                id="dropdownMenuButtonquote" data-bs-toggle="dropdown" aria-expanded="false">
                            Quotes
                        </button>
                        <ul class="dropdown-menu quotes-titles-dropdown-menu"
                            aria-labelledby="dropdownMenuButtonquote">
                            <li class="quotes-header-box">
                                <p class="main-content-email-para quotes-content-para ">Lorem ipsum, dolor sit amet
                                    consectetur</p>
                            </li>
                            <li class="email-footer-div">

                                <a href="#" class="quotes-titles-link">How do I create quotes? <span><i
                                            class="fa fa-external-link icon-display-email-box get-started-icon"
                                            aria-hidden="true"></i></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="email-divider "></div>
                <div class="email-child-wrapper" style="  padding: 10px 30px;">
                    <p class="email-sending-titles"> To </p>
                    <p class="email-sender-name">{{$customer_contact->name ?? "---"}} <span
                            class="email-sender-emailid">({{$customer_contact->email ?? "---"}})</span></p>
                </div>
                <div class="email-sending-box">
                    <div class="email-child-wrapper">
                        <p class="email-sending-titles"> From </p>
                        <p class="email-sender-name"> {{($customer_contact->creator)->name ?? "---"}} <span
                                class="email-sender-emailid">({{($customer_contact->creator)->email ?? "---"}})</span><span>
                                </span></p>
                    </div>
{{--                    <div class="email-child-wrapper">--}}
{{--                        <p class="email-titles-show">Cc</p>--}}
{{--                        <p class="email-titles-show">Bcc</p>--}}
{{--                    </div>--}}
                </div>
                <div class="email-divider "></div>
                <div class="email-child-wrapper" style="  padding: 10px 30px;">
                    <p class="email-sending-titles"> Subject </p>
{{--                    <p class="" style="margin: 0;">Re: <span> #Professional Image Editing</i>--}}
{{--                            </span></p>--}}
                    <input type="text" name="subject" />
                </div>
                <div class="email-divider"></div>
                <div class="main-content-email-box">
                    <textarea

                        placeholder="Type your email here..."></textarea>

                </div>

                <div class="email-footer-div ">
                    <button class="email-footer-btn" id="sendEmailBtn">Send</button>
                    <button class="email-footer-btn close-btn gap-2">Cancel</button>
                </div>
            </div>

        </div>
    </div>
</section>
