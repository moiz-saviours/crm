@push('style')
    <style>
        /*.generatePassword {*/
        /*    padding: 8px;*/
        /*    cursor: pointer;*/
        /*    font-size: 18px;*/
        /*    background-color: var(--bs-primary);*/
        /*    border-radius: 5px;*/
        /*    height: 35px;*/
        /*    width: 35px;*/
        /*    color: var(--bs-light);*/
        /*    display: flex;*/
        /*    align-items: center;*/
        /*    justify-content: center;*/
        /*    margin-left: 5px;*/
        /*    transition: background-color 0.3s ease;*/
        /*    margin-bottom: 15px;*/

        /*}*/
        .generatePassword-update{
            background: #2D3F4F;
            color: #fff;
            font-size: 12px;
            padding: 8px 21px;
            border-radius: 5px;
            margin: 0 auto;
            display: block;
            width: 50%;
            text-align: center;
            cursor: pointer;
        }
        .generatePassword:hover {
            color: var(--bs-primary);
            background-color: var(--bs-light);
            border: 1px solid var(--bs-primary);
        }
    </style>
@endpush

<div class="custom-form">
    <form id="manage-form-2" class="manage-form">
        <div class="form-container" id="formContainerChangePassword">
            <label for="crsf_token_1" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token_1" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1">
                <span id="custom-form-heading">Manage Password</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">

                <div class="form-group mb-3">
                    <label for="change_password" class="form-label">Password</label>
                    <div class="d-fldex align-items-center">
                        <input type="text" id="change_password" name="change_password" class="form-control" placeholder="Generated Password" required>
                        <i id="generatePassword" class="generatePassword generatePassword-update " title="Change Password">Generate Password</i>
                    </div>
                    @error('password')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>
