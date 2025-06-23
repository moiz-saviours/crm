@push('style')
    {{--    <style>--}}
    {{--        #category-tree ul {--}}
    {{--            list-style-type: none;--}}
    {{--            padding-left: 20px;--}}
    {{--        }--}}

    {{--        #category-tree li {--}}
    {{--            margin-bottom: 5px;--}}
    {{--            cursor: pointer;--}}
    {{--        }--}}

    {{--        #category-tree input[type="checkbox"] {--}}
    {{--            margin-right: 10px;--}}
    {{--        }--}}

    {{--        .toggle-symbol {--}}
    {{--            margin-right: 10px;--}}
    {{--            font-weight: bold;--}}
    {{--            cursor: pointer;--}}
    {{--        }--}}

    {{--        .sub-categories, .child-categories {--}}
    {{--            margin-left: 20px;--}}
    {{--        }--}}

    {{--        .sub-categories, .child-categories {--}}
    {{--            display: none;--}}
    {{--        }--}}


    {{--    </style>--}}
    <style>
        /*!* Styling for the multi-hierarchy-tree *!*/
        /*.multi-hierarchy-tree {*/
        /*    list-style-type: none; !* Remove default bullet points *!*/
        /*    padding-left: 20px; !* Indent nested lists *!*/
        /*}*/

        /*.multi-hierarchy-tree li {*/
        /*    margin: 5px 0; !* Add spacing between list items *!*/
        /*}*/

        /*.multi-hierarchy-tree ul {*/
        /*    display: block; !* Show nested lists by default *!*/
        /*}*/

        /*.multi-hierarchy-tree ul.collapsed {*/
        /*    display: none; !* Hide nested lists when collapsed *!*/
        /*}*/

        /*!* Styling for checkboxes *!*/
        /*.multi-hierarchy-tree input[type="checkbox"] {*/
        /*    margin-right: 10px; !* Add spacing between checkbox and label *!*/
        /*    cursor: pointer; !* Make checkboxes clickable *!*/
        /*    transform: scale(1.2); !* Slightly enlarge checkboxes *!*/
        /*    width: 2.5%!important;*/
        /*}*/

        /*!* Styling for toggle icons *!*/
        /*.toggle-icon {*/
        /*    cursor: pointer;*/
        /*    margin-right: 5px;*/
        /*    font-size: 0.75em;*/
        /*}*/

        /*!* Styling for buttons *!*/
        /*.button-container {*/
        /*    margin-bottom: 20px;*/
        /*}*/

        /*.button-container {*/
        /*    display: flex;*/
        /*}*/

        /*.button-container button {*/
        /*    text-align: center;*/
        /*    text-decoration: none;*/
        /*    display: inline-block;*/
        /*    font-size: 16px;*/
        /*    margin: 5px;*/
        /*    transition: background-color 0.3s ease;*/
        /*}*/

        /* Add this CSS to your existing styles */
        .multi-hierarchy-tree {
            list-style-type: none; /* Remove default bullet points */
            padding-left: 20px; /* Indent nested lists */
        }

        .multi-hierarchy-tree li {
            position: relative; /* Required for positioning the connecting lines */
            margin: 5px 0; /* Add spacing between list items */
        }

        .multi-hierarchy-tree ul {
            display: block; /* Show nested lists by default */
            padding-left: 20px; /* Indent nested lists */
        }

        .multi-hierarchy-tree ul.collapsed {
            display: none; /* Hide nested lists when collapsed */
        }

        /* Dotted lines for parent-child relationships */
        .multi-hierarchy-tree li::before {
            content: '';
            position: absolute;
            top: 0;
            left: -15px;
            width: 1px;
            height: 100%;
            border-left: 1px dotted #4CAF50; /* Dotted line color */
        }

        .multi-hierarchy-tree li::after {
            content: '';
            position: absolute;
            top: 10px;
            left: -15px;
            width: 15px;
            height: 1px;
            border-bottom: 1px dotted #4CAF50; /* Dotted line color */
        }

        .multi-hierarchy-tree li:last-child::before {
            height: 10px; /* Adjust height for the last child */
        }

        /* Remove dotted lines for the root level */
        .multi-hierarchy-tree > li::before,
        .multi-hierarchy-tree > li::after {
            display: none;
        }

        /* Styling for checkboxes */
        .multi-hierarchy-tree input[type="checkbox"] {
            margin-right: 10px; /* Add spacing between checkbox and label */
            cursor: pointer; /* Make checkboxes clickable */
            transform: scale(1.2); /* Slightly enlarge checkboxes */
            width: 2.5% !important;
        }

        /* Styling for toggle icons */
        .toggle-icon {
            cursor: pointer;
            margin-right: 5px;
            font-size: 0.75em;
        }

        /* Styling for buttons */
        .button-container {
            margin-bottom: 20px;
            display: flex;
        }

        .button-container button {
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 5px;
            transition: background-color 0.3s ease;
        }
    </style>
@endpush
<div class="custom-form">
    <form id="manage-form" class="manage-form" method="POST" enctype="multipart/form-data">
        <div class="form-container" id="formContainer">
            <label for="crsf_token" class="form-label d-none">Crsf Token</label>
            <input type="text" id="crsf_token" name="crsf_token" value="" style="opacity:0;position:absolute;"/>
            <!-- Form Header -->
            <div class="form-header fh-1 ">
                <span id="custom-form-heading" class="tour-brandcreation">Manage Brand</span>
                <button type="button" class="close-btn">×</button>
            </div>
            <!-- Form Body -->
            <div class="form-body">
                <div class="">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control tour-brandname" id="name" name="name" placeholder="Enter name">
                    @error('name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control tour-brandemail" id="email" name="email" placeholder="Enter email">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="url" class="form-label">Url</label>
                    <input type="text" class="form-control tour-brandurl" id="url" name="url" placeholder="Enter url">
                    @error('url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="">
                    <label for="logo" class="form-label">Logo (Optional)</label>
                    <div class="input-group">
                        <input type="file" class="form-control tour-brandlogo" id="logo" name="logo" accept="image/*">
                        {{--                        <input type="url" class="form-control" id="logo_url" name="logo_url"--}}
                        {{--                               placeholder="https://example.com/logo.png">--}}
                    </div>
                    {{--                    <small class="form-text text-muted">You can either upload an image or provide a valid image--}}
                    {{--                        URL.</small>--}}
                    @error('logo')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                    @error('logo_url')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control tour-branddesc" id="description" name="description" rows="3"></textarea>
                    @error('description')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                @if(isset($clientContacts[0]->client_companies[0]->client_accounts))
                    <div class="form-control mt-5">
                        <div class="button-container">
                            <button type="button" id="toggleCollapseExpandButton" class="btn-primary">Collapse All
                            </button>
                            <button type="button" id="toggleCheckUncheckButton" class="btn-primary">Check All</button>
                        </div>

                        <ul class="multi-hierarchy-tree tour-brandmerchants">
                            @foreach($clientContacts as $client_contact)
                                @if($client_contact->status == 1)
                                    <li>
                                        {{--                                <span class="toggle-icon">▶</span>--}}
                                        <label for="client_contact_{{ $client_contact->id }}"><input type="checkbox"
                                                                                                     id="client_contact_{{ $client_contact->id }}"
                                                                                                     name="client_contacts[]"
                                                                                                     value="{{ $client_contact->special_key }}"> {{ $client_contact->name }}
                                        </label>
                                        <ul>
                                            @foreach($client_contact->client_companies as $client_company)
                                                @if($client_company->status == 1)
                                                    <li>
                                                        {{--                                            <span class="toggle-icon">▶</span>--}}
                                                        <label for="client_company_{{ $client_company->id }}"><input
                                                                type="checkbox"
                                                                id="client_company_{{ $client_company->id }}"
                                                                name="client_companies[]"
                                                                value="{{ $client_company->special_key }}"> {{ $client_company->name }}
                                                        </label>
                                                        <ul>
                                                            @foreach($client_company->client_accounts as $client_account)
                                                                @if($client_account->status == 'active')
                                                                    <li>
                                                                        <label
                                                                            for="client_account_{{ $client_account->id }}"><input
                                                                                type="checkbox"
                                                                                id="client_account_{{ $client_account->id }}"
                                                                                name="client_accounts[]"
                                                                                value="{{ $client_account->id }}"> {{ $client_account->name }}
                                                                        </label>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                {{--                <div id="category-tree">--}}
                {{--                    <ul>--}}
                {{--                        <li>--}}
                {{--                            <input type="checkbox" class="parent-checkbox" id="parent1">--}}
                {{--                            <span class="toggle-symbol">></span> Parent Category 1--}}
                {{--                            <ul class="sub-categories">--}}
                {{--                                <li>--}}
                {{--                                    <input type="checkbox" class="sub-checkbox" id="sub1">--}}
                {{--                                    <span class="toggle-symbol">></span> Sub Category 1--}}
                {{--                                    <ul class="child-categories">--}}
                {{--                                        <li><input type="checkbox" class="child-checkbox" id="child1"> Child Category 1</li>--}}
                {{--                                        <li><input type="checkbox" class="child-checkbox" id="child2"> Child Category 2</li>--}}
                {{--                                    </ul>--}}
                {{--                                </li>--}}
                {{--                                <li>--}}
                {{--                                    <input type="checkbox" class="sub-checkbox" id="sub2">--}}
                {{--                                    <span class="toggle-symbol">></span> Sub Category 2--}}
                {{--                                    <ul class="child-categories">--}}
                {{--                                        <li><input type="checkbox" class="child-checkbox" id="child3"> Child Category 3</li>--}}
                {{--                                        <li><input type="checkbox" class="child-checkbox" id="child4"> Child Category 4</li>--}}
                {{--                                    </ul>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                        <li>--}}
                {{--                            <input type="checkbox" class="parent-checkbox" id="parent2">--}}
                {{--                            <span class="toggle-symbol">></span> Parent Category 2--}}
                {{--                            <ul class="sub-categories">--}}
                {{--                                <li>--}}
                {{--                                    <input type="checkbox" class="sub-checkbox" id="sub3">--}}
                {{--                                    <span class="toggle-symbol">></span> Sub Category 3--}}
                {{--                                    <ul class="child-categories">--}}
                {{--                                        <li><input type="checkbox" class="child-checkbox" id="child5"> Child Category 5</li>--}}
                {{--                                    </ul>--}}
                {{--                                </li>--}}
                {{--                            </ul>--}}
                {{--                        </li>--}}
                {{--                    </ul>--}}
                {{--                </div>--}}




                {{--                <!-- Assign to Contacts -->--}}
                {{--                <div class="form-group">--}}
                {{--                    <label>Assign to Contacts</label>--}}
                {{--                    <select name="contacts[]" id="contacts" class="form-control" multiple>--}}
                {{--                        @foreach($clientContacts as $contact)--}}
                {{--                            <option value="{{ $contact->special_key }}">--}}
                {{--                                {{ $contact->name }}--}}
                {{--                            </option>--}}
                {{--                        @endforeach--}}
                {{--                    </select>--}}
                {{--                </div>--}}

                {{--                <!-- Assign to Companies -->--}}
                {{--                <div class="form-group">--}}
                {{--                    <label>Assign to Companies</label>--}}
                {{--                    <select name="companies[]" id="companies" class="form-control" multiple>--}}
                {{--                        @foreach($clientCompanies as $company)--}}
                {{--                            <option value="{{ $company->special_key }}">--}}
                {{--                                @if(isset($company->client_contact->name))--}}
                {{--                                    {{$company->client_contact->name . ' - ' }}--}}
                {{--                                @endif--}}
                {{--                                {{ $company->name }}--}}
                {{--                            </option>--}}
                {{--                        @endforeach--}}
                {{--                    </select>--}}
                {{--                </div>--}}

                {{--                <!-- Assign to Accounts -->--}}
                {{--                <div class="form-group">--}}
                {{--                    <label>Assign to Accounts</label>--}}
                {{--                    <select name="accounts[]" id="accounts" class="form-control" multiple>--}}
                {{--                        @foreach($clientAccounts as $account)--}}
                {{--                            <option value="{{ $account->id }}">--}}
                {{--                                @if(isset($account->client_company->client_contact->name))--}}
                {{--                                    {{$account->client_company->client_contact->name . ' - ' }}--}}
                {{--                                @endif--}}
                {{--                                @if(isset($account->client_company->name))--}}
                {{--                                    {{$account->client_company->name . ' - ' }}--}}
                {{--                                @endif--}}
                {{--                                {{ $account->name }}--}}
                {{--                            </option>--}}
                {{--                        @endforeach--}}
                {{--                    </select>--}}
                {{--                </div>--}}


                <div class="">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-button">
                <button type="submit" class="btn-primary save-btn tour-brandsubmit"><i class="fas fa-save me-2"></i> Save</button>
                <button type="button" class="btn-secondary close-btn"><i class="fas fa-times me-2"></i> Cancel</button>
            </div>
        </div>
    </form>
</div>
@push('script')
    <script>
        {{--$(document).ready(function () {--}}
        {{--    // Cache the dropdowns--}}
        {{--    const $contacts = $('#contacts');--}}
        {{--    const $companies = $('#companies');--}}
        {{--    const $accounts = $('#accounts');--}}

        {{--    // Fetch all companies and accounts for each contact--}}
        {{--    const contactCompanies = {};--}}
        {{--    const companyAccounts = {};--}}

        {{--    @foreach($clientContacts as $contact)--}}
        {{--        contactCompanies['{{ $contact->special_key }}'] = [--}}
        {{--        @foreach($contact->client_companies as $company)--}}
        {{--            '{{ $company->special_key }}',--}}
        {{--        @endforeach--}}
        {{--    ];--}}
        {{--    @endforeach--}}

        {{--        @foreach($clientCompanies as $company)--}}
        {{--        companyAccounts['{{ $company->special_key }}'] = [--}}
        {{--        @foreach($company->client_accounts as $account)--}}
        {{--            '{{ $account->id }}',--}}
        {{--        @endforeach--}}
        {{--    ];--}}
        {{--    @endforeach--}}

        {{--    // When a contact is selected/deselected--}}
        {{--    $contacts.on('change', function () {--}}
        {{--        const selectedContacts = $(this).val() || [];--}}
        {{--        const selectedCompanies = [];--}}
        {{--        const selectedAccounts = [];--}}

        {{--        // Find all companies and accounts for selected contacts--}}
        {{--        selectedContacts.forEach(contactId => {--}}
        {{--            if (contactCompanies[contactId]) {--}}
        {{--                selectedCompanies.push(...contactCompanies[contactId]);--}}
        {{--            }--}}
        {{--        });--}}

        {{--        // Find all accounts for selected companies--}}
        {{--        selectedCompanies.forEach(companyId => {--}}
        {{--            if (companyAccounts[companyId]) {--}}
        {{--                selectedAccounts.push(...companyAccounts[companyId]);--}}
        {{--            }--}}
        {{--        });--}}

        {{--        // Update companies dropdown--}}
        {{--        $companies.val(selectedCompanies).trigger('change');--}}

        {{--        // Update accounts dropdown--}}
        {{--        $accounts.val(selectedAccounts).trigger('change');--}}
        {{--    });--}}

        {{--    // When a company is selected/deselected--}}
        {{--    $companies.on('change', function () {--}}
        {{--        const selectedCompanies = $(this).val() || [];--}}
        {{--        const selectedAccounts = [];--}}

        {{--        // Find all accounts for selected companies--}}
        {{--        selectedCompanies.forEach(companyId => {--}}
        {{--            if (companyAccounts[companyId]) {--}}
        {{--                selectedAccounts.push(...companyAccounts[companyId]);--}}
        {{--            }--}}
        {{--        });--}}

        {{--        // Update accounts dropdown--}}
        {{--        $accounts.val(selectedAccounts).trigger('change');--}}
        {{--    });--}}
        {{--});--}}



        //        $(document).ready(function () {
        //            $('.parent-checkbox').on('change', function () {
        //                let $parent = $(this);
        //                let $subCategories = $parent.closest('li').find('.sub-categories');
        //                if ($parent.prop('checked')) {
        //                    $subCategories.show();
        //                    $subCategories.find('input[type="checkbox"]').prop('checked', true);
        //                } else {
        //                    $subCategories.find('input[type="checkbox"]').prop('checked', false);
        //                }
        //            });
        //
        //            $('.sub-checkbox').on('change', function () {
        //                let $subCategory = $(this);
        //                let $childCategories = $subCategory.closest('li').find('.child-categories');
        //
        //                if ($subCategory.prop('checked')) {
        //                    $childCategories.show();
        //                    $childCategories.find('input[type="checkbox"]').prop('checked', true);
        //                } else {
        //                    $childCategories.find('input[type="checkbox"]').prop('checked', false);
        //                }
        //            });
        //
        //            $('.toggle-symbol').on('click', function () {
        //                let $toggleSymbol = $(this);
        //                let $parentLi = $toggleSymbol.closest('li');
        //
        //                let $subCategories = $parentLi.find('> .sub-categories');
        //                let $childCategories = $parentLi.find('> .child-categories');
        //
        //                if ($toggleSymbol.text() === '>') {
        //                    if ($subCategories.length) {
        //                        $subCategories.show();
        //                    } else if ($childCategories.length) {
        //                        $childCategories.show();
        //                    }
        //                    $toggleSymbol.text('<');
        //                } else {
        //                    if ($subCategories.length) {
        //                        $subCategories.hide();
        //                    } else if ($childCategories.length) {
        //                        $childCategories.hide();
        //                    }
        //                    $toggleSymbol.text('>');
        //                }
        //            });
        //
        //            // Update parent checkbox state based on subcategory and child category selection
        //            $('input[type="checkbox"]').on('change', function () {
        //                let $checkbox = $(this);
        //
        //                // Check if all subcategories are checked or unchecked
        //                let $subCategories = $checkbox.closest('.sub-categories');
        //                if ($subCategories.length) {
        //                    let allSubChecked = $subCategories.find('.sub-checkbox').length === $subCategories.find('.sub-checkbox:checked').length;
        //                    let $parentCheckbox = $checkbox.closest('li').parents('ul').prev('.parent-checkbox');
        //
        //                    if (allSubChecked) {
        //                        $parentCheckbox.prop('checked', true);
        //                    } else {
        //                        $parentCheckbox.prop('checked', false);
        //                    }
        //                }
        //
        //                // Check if all child categories are checked or unchecked
        //                let $childCategories = $checkbox.closest('.child-categories');
        //                if ($childCategories.length) {
        //                    let allChildChecked = $childCategories.find('.child-checkbox').length === $childCategories.find('.child-checkbox:checked').length;
        //                    let $subCheckbox = $checkbox.closest('li').parents('.sub-categories').prev('.sub-checkbox');
        //
        //                    if (allChildChecked) {
        //                        $subCheckbox.prop('checked', true);
        //                    } else {
        //                        $subCheckbox.prop('checked', false);
        //                    }
        //                }
        //            });
        //
        //            // Ensure child categories are hidden initially
        //            $('.child-categories').hide();
        //            $('.sub-categories').hide();
        //        });


    </script>




    <script>
        function toggleCollapseExpand(isCollapse) {
            const nestedLists = document.querySelectorAll('.multi-hierarchy-tree ul');
            nestedLists.forEach(list => {
                if (isCollapse) {
                    list.classList.add('collapsed');
                } else {
                    list.classList.remove('collapsed');
                }
            });

            const collapseExpandButton = document.getElementById('toggleCollapseExpandButton');
            collapseExpandButton.textContent = isCollapse ? 'Expand All' : 'Collapse All';

            updateToggleIcons();
        }

        function toggleCheckUncheck(isCheck) {
            const checkboxes = document.querySelectorAll('.multi-hierarchy-tree input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = isCheck;
            });

            const checkUncheckButton = document.getElementById('toggleCheckUncheckButton');
            checkUncheckButton.textContent = isCheck ? 'Uncheck All' : 'Check All';
        }

        function updateToggleIcons() {
            const toggleIcons = document.querySelectorAll('.toggle-icon');
            toggleIcons.forEach(icon => {
                const nestedUl = icon.nextElementSibling.nextElementSibling.nextElementSibling;
                if (nestedUl && nestedUl.tagName === 'UL') {
                    icon.textContent = nestedUl.classList.contains('collapsed') ? '▶' : '▼';
                }
            });
        }

        function toggleNestedList(event) {
            const icon = event.target;
            if (icon.classList.contains('toggle-icon')) {
                const nestedUl = icon.nextElementSibling.nextElementSibling.nextElementSibling;
                if (nestedUl && nestedUl.tagName === 'UL') {
                    nestedUl.classList.toggle('collapsed');
                    icon.textContent = nestedUl.classList.contains('collapsed') ? '▶' : '▼';
                }
            }
        }

        function propagateCheckboxState(checkbox) {
            const parentLi = checkbox.closest('li');
            if (parentLi) {
                const nestedLists = parentLi.querySelectorAll('ul');
                nestedLists.forEach(list => {
                    const nestedCheckboxes = list.querySelectorAll('input[type="checkbox"]');
                    nestedCheckboxes.forEach(nestedCheckbox => {
                        nestedCheckbox.checked = checkbox.checked;
                    });
                });
            }
        }

        function checkParentCheckboxes(checkbox) {
            let parentLi = checkbox.closest('li').parentElement.closest('li');
            while (parentLi) {
                const parentCheckbox = parentLi.querySelector('input[type="checkbox"]');
                if (parentCheckbox) {
                    parentCheckbox.checked = true;
                }
                parentLi = parentLi.parentElement.closest('li');
            }
        }

        function uncheckParentIfAllChildrenUnchecked(checkbox) {
            let parentLi = checkbox.closest('li').parentElement.closest('li');
            while (parentLi) {
                const parentCheckbox = parentLi.querySelector('input[type="checkbox"]');
                if (parentCheckbox) {
                    const childCheckboxes = parentLi.querySelectorAll(':scope > ul > li input[type="checkbox"]');
                    const allUnchecked = Array.from(childCheckboxes).every(child => !child.checked);
                    if (allUnchecked) {
                        parentCheckbox.checked = false;
                    }
                }
                parentLi = parentLi.parentElement.closest('li');
            }
        }

        const toggleCollapseExpandButton = document.getElementById('toggleCollapseExpandButton');
        if (toggleCollapseExpandButton) {
            toggleCollapseExpandButton.addEventListener('click', () => {
                const isCollapse = !document.querySelector('.multi-hierarchy-tree ul.collapsed');
                toggleCollapseExpand(isCollapse);
            });
        }
        const toggleCheckUncheckButton = document.getElementById('toggleCheckUncheckButton');
        if (toggleCheckUncheckButton) {
            toggleCheckUncheckButton.addEventListener('click', () => {
                const isCheck = !document.querySelector('.multi-hierarchy-tree input[type="checkbox"]:checked');
                toggleCheckUncheck(isCheck);
            });
        }

        const toggleIcons = document.querySelectorAll('.multi-hierarchy-tree .toggle-icon');
        toggleIcons.forEach(icon => {
            icon.addEventListener('click', toggleNestedList);
        });

        const checkboxes = document.querySelectorAll('.multi-hierarchy-tree input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', () => {
                propagateCheckboxState(checkbox);
                if (checkbox.checked) {
                    checkParentCheckboxes(checkbox);
                } else {
                    uncheckParentIfAllChildrenUnchecked(checkbox);
                }
            });
        });
        updateToggleIcons();
    </script>
@endpush
