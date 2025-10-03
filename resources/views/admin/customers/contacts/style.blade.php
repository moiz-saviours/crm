<style>
    .custom-form .fh-1 {
        background: var(--nf-header-bg);
    }
    td.align-middle.text-center.text-nowrap.editable:hover select {
        border: 1px solid #000;
        border-radius: 5px;
    }
    td.align-middle.text-center.text-nowrap.editable[data],
    td.align-middle.text-center.text-nowrap.editable {
        cursor: pointer;
    }
    .void {
        cursor: not-allowed;
    }
    .custm_header {
        padding: 2px 20px 2px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .actions {
        display: flex;
    }
    .actions h1 {
        margin: auto;
        color: #52a0bf;
        font-size: 15px;
    }
    .filters,
    .table-controls {
        display: flex;
        justify-content: space-between;
        padding: 10px 20px;
        /*border-bottom: 1px solid #ddd;*/
    }
    .filters .filter-tabs button,
    .actions button {
        padding: 5px 12px;
        border: 1px solid #ff5722;
        border-radius: 4px;
        background-color: #fff;
        cursor: pointer;
    }
    .filters .actions .create-contact {
        background-color: #ff5722;
        color: #fff;
        border: none;
    }
    .your-create-contact {
        background-color: #ff5722;
        color: #fff;
        border: none;
        padding: 5px 10px;
        text-transform: capitalize;
    }
    .your-comment-cancel {
        background-color: #fff;
        color: #ff5722;
        border: 1px solid #ff5722;
        padding: 5px 10px;
        text-transform: capitalize;
    }
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }
    .dropdown-content-wraper {
        display: flex;
        justify-content: space-between;
        min-width: 374px;
        width: 100%;
    }
    .select-contact-box-space {
        padding: 8px;
    }
    .association-activities-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .search-box-select {
        /* padding: 8px; */
        padding: 7px 7px;
        /* border-bottom: 1px solid #ccc; */
    }
    .search-box-select input {
        width: 100%;
        padding: 6px;
        border: 1px solid #ccc;
        border-radius: 4px;
        outline: none;
        min-width: 230px;
    }
    .checkbox-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 5px 3px;
        font-size: 12px;
        color: gray;
    }
    .nested-select-list {
        margin: 0;
        padding: 1px 11px;
        height: 129px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .select-contact {
        margin-bottom: 10px;
        font-size: 12px;
        font-weight: 700;
        /* margin-top: 4px; */
        /* padding-left: 8px; */
    }
    .selectionBox option {
        width: 120px !important;
    }
    .search-bar input {
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        width: 250px;
    }
    .contacts-table {
        width: 100%;
        border-collapse: collapse;
    }
    .contacts-table th,
    .contacts-table td {
        padding: 10px;
        text-align: left;
        /*border: 1px solid #ddd;*/
    }
    .contacts-table th {
        /*background-color: #f1f5f9;*/
        font-weight: bold;
    }
    .contacts-table tbody tr:hover {
        background-color: #f9f9f9;
    }
    .header .new_head h1 {
        font-size: 20px;
        color: #52a0bf;
        font-weight: 700;
    }
    .header_btn {
        padding: 0px 30px;
        color: #ff5722;
        margin: 0px 10px;
    }
    .custom-tabs {
        margin: 0px 0px 4px 0px;
        display: flex;
    }
    .tab-nav {
        display: flex;
        justify-content: space-around;
        list-style: none;
        padding: 0;
        margin: 0;
        width: 70%;
    }
    .tab-buttons {
        margin-left: 100px;
    }
    .tab-item {
        padding: 10px 20px;
        cursor: pointer;
        border: 1px solid #cbd6e2;
        background: #f9f9f9;
        width: 100%;
        transition: background 0.3s ease;
    }
    .tab-item.active {
        background: #fff;
        border-bottom: none;
    }
    .tab-item.active i {
        float: right;
        font-size: 14px;
        margin: auto;
    }
    .tab-content {
        /*padding: 10px;*/
        /*margin-top: 10px;*/
    }
    .tab-pane {
        display: none;
    }
    .tab-pane.active {
        display: block;
    }
    .fltr-sec {
        padding-top: 20px;
    }
    .table-li {
        display: flex;
    }
    .table-li .page-title {
        font-size: 14px;
        padding: 0px 30px 0px 0px;
        font-weight: 700;
    }
    .right-icon i {
        float: right;
        margin: 0px 4px;
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
        font-size: 12px;
    }
    .custom-form .form-container {
        position: fixed;
        top: 0;
        right: -100%;
        width: 500px;
        height: 100%;
        background: #ffffff;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
        transition: right 0.5s ease;
        box-sizing: border-box;
        z-index: 1001;
    }
    .custom-form .form-container.open {
        right: 0;
    }
    .custom-form .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        /*background: #52a0bf;*/
        color: white;
        font-size: 18px;
        font-weight: bold;
    }
    .custom-form .form-header .close-btn {
        font-size: 20px;
        font-weight: bold;
        background: none;
        border: none;
        color: white;
        cursor: pointer;
    }
    .custom-form .form-body {
        padding: 20px;
        height: 79.5%;
        overflow-y: scroll;
    }
    .custom-form .form-body label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: var(--bs-heading-color);
    }
    .custom-form .form-body input:not(.is-invalid) {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .custom-form .form-body select {
        width: 100%;
        padding: 8px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        /*color: #757575;*/
        color: var(--nf-sidebar-color)
    }
    .custom-form .form-body button {
        width: 100%;
        padding: 10px;
        /*background: #ff5722;*/
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background: var(--bs-primary);
    }
    .close-icon {
        display: none;
    }
    .tab-item.active .close-icon {
        display: inline;
    }
    .fh-check,
    .fh-radio {
        height: 140px;
        overflow-y: scroll;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    .fh-checkbox,
    .fh-radiobox {
        display: flex;
        width: 100%;
    }
    .fh-checkbox label,
    .fh-radiobox label {
        width: 100%;
    }
    .custom-form .form-body input:not(.is-invalid)[type="checkbox"] {
        width: 2%;
        margin-right: 10px;
        appearance: none;
        cursor: pointer;
        position: relative;
    }
    .custom-form .form-body input:not(.is-invalid)[type="radio"] {
        margin-right: 10px;
        appearance: none;
        width: auto;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
    }
    .fh-checkbox input[type="checkbox"]:checked,
    .fh-radiobox input[type="radio"]:checked {
        background: var(--nf-header-bg);
        border-color: var(--nf-header-bg);
    }
    .fh-checkbox input[type="checkbox"]:checked::after {
        content: '\2713';
        color: #fff;
        font-size: 14px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
        z-index: 99;
    }
    .fh-radiobox input[type="radio"]:checked::after {
        content: '';
        width: 8px;
        height: 8px;
        background-color: #fff;
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .form-button {
        position: absolute;
        bottom: 0;
        width: 100%;
        background-color: var(--bs-body-bg);
        padding: 10px;
        display: flex;
        justify-content: space-evenly;
    }
    .form-button .btn-primary {
        width: 30%;
        padding: 10px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background: var(--bs-primary);
        margin-right: 10px;
    }
    .form-button .btn-secondary {
        width: 30%;
        padding: 10px;
        color: var(--bs-primary);
        border: 1px solid var(--bs-primary);
        border-radius: 4px;
        cursor: pointer;
        background: transparent;
        margin-right: 10px;
    }
    .form-container img {
        max-width: 100px;
        max-height: 100px;
    }

    .form-infromation p {
        margin: 3px;
    }
    .main-heading {
        color: var(--bs-primary);
        font-weight: 500;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 17px;
    }
    .name-title {
        color: var(--nf-mainnav-bg);
        font-weight: 500;
        font-size: 14px;
        font-weight: 600;
    }
    .name-content {
        margin-bottom: 19px;
    }
    .form-infromation .name-content {
        margin-bottom: 8px;
    }
    .form-infromation .main-heading {
        margin-bottom: 8px;
    }

</style>
