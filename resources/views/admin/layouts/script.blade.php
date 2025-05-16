<!-- Bootstrap JS [ OPTIONAL ] -->
<script
    src="{{asset('assets/themes/nifty/assets/js/bootstrap.min.705accd2201a27b32a1b95615e20fbb58fc9f3200388517b3a66f322ad955857.js')}}"></script>
<!-- JS [ OPTIONAL ] -->
<script
    src="{{asset('assets/themes/nifty/assets/js/nifty.min.b960437305df20c97b96bfb28e62b7d655ad70041fcfed38fae70d11012b2b58.js')}}"></script>

<!-- Plugin scripts [ OPTIONAL ] -->
<script
    src="{{asset('assets/themes/nifty/assets/pages/dashboard-1.min.b651fbd1a6f6a43e11bc01617b4481ab0edc4ba4582106c466d7ae2a9a9ac178.js')}}"></script>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script id="_dm-jsOverlayScrollbars"
        src="{{asset('assets/themes/nifty/assets/vendors/overlayscrollbars/overlayscrollbars.browser.es6.min.js')}}"></script>
<!-- New -->
{{--https://cdn.datatables.net/v/bs4/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/date-1.5.4/fc-5.0.4/fh-4.0.1/sc-2.4.3/sp-2.3.3/sl-2.1.0/datatables.min.css--}}
<link href="{{asset('assets/css/datatable/new/datatables.min.css')}}" rel="stylesheet">
{{--https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js--}}
<script src="{{asset('assets/js/plugins/datatable/new/pdfmake.min.js')}}"></script>
{{--https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js--}}
<script src="{{asset('assets/js/plugins/datatable/new/vfs_fonts.js')}}"></script>
{{--https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.1.8/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/b-print-3.2.0/cr-2.0.4/date-1.5.4/fc-5.0.4/fh-4.0.1/sc-2.4.3/sp-2.3.3/sl-2.1.0/datatables.min.js--}}
<script src="{{asset('assets/js/plugins/datatable/new/datatables.min.js')}}"></script>
{{--<script type="text/javascript" charset="utf-8"--}}
{{--        src="https://cdn.datatables.net/1.10.25/extensions/Editor/js/dataTables.editor.min.js"></script>--}}
<!-- New -->

<!-- SweetAlert2 -->
<script src="{{asset('assets/js/plugins/sweetalert2@11.js')}}"></script>

{{--Chart JS Script--}}

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<!-- Jquery UI -->
{{--<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>--}}
<!-- End Jquery UI -->

<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>


<!-- Scroll Top -->
<script>
    $(".scroll-page").on("click", function () {
        document.getElementById("root").scrollIntoView({behavior: 'smooth', block: 'start'});
    })
</script>
<!-- Scroll Top -->

<!-- Toaster -->
<script src="{{asset('build/toaster/js/toastr.min.js')}}"></script>

<script>
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "preventOpenDuplicates": true,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "3000", // 5 seconds
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    @if(session('success'))
    setTimeout(function () {
        toastr.success("{{ session('success') }}");
    }, 1500);
    @php session()->forget('success'); @endphp
    @endif

    // Display error messages (multiple)
    @if(session('errors') && session('errors')->any())
    let errorMessages = {!! json_encode(session('errors')->all()) !!};
    let displayedCount = 0;

    setTimeout(function () {
        errorMessages.forEach((message, index) => {
            if (displayedCount < 5) {
                toastr.error(message);
                displayedCount++;
            } else {
                setTimeout(() => toastr.error(message), index * 1000);
            }
        });
    }, 1500);

    @php session()->forget('errors'); @endphp
    @endif


    const userSettings = @json(auth()->user()->settings ?? []);
    document.addEventListener('DOMContentLoaded', function () {
        const settings = userSettings;
        function stringToBoolean(value) {
            if (typeof value === 'string') {
                return value.toLowerCase() === 'true';
            }
            return Boolean(value);
        }
        function isElementInDesiredState(element, desiredState) {
            if (element.type === 'checkbox' || element.type === 'radio') {
                return element.checked === desiredState;
            }
            return false;
        }
        if (settings.layouts) {
            const fluidLayoutRadio = document.getElementById('_dm-fluidLayoutRadio');
            if (stringToBoolean(settings.layouts.fluidLayout) && !isElementInDesiredState(fluidLayoutRadio, true)) {
                fluidLayoutRadio.click();
            }

            const boxedLayoutRadio = document.getElementById('_dm-boxedLayoutRadio');
            if (stringToBoolean(settings.layouts.boxedLayout) && !isElementInDesiredState(boxedLayoutRadio, true)) {
                boxedLayoutRadio.click();
            }

            const centeredLayoutRadio = document.getElementById('_dm-centeredLayoutRadio');
            if (stringToBoolean(settings.layouts.centeredLayout) && !isElementInDesiredState(centeredLayoutRadio, true)) {
                centeredLayoutRadio.click();
            }
        }

        if (settings.transitions) {
            const transitionSelect = document.getElementById('_dm-transitionSelect');
            if (transitionSelect.value !== settings.transitions.transitionTiming) {
                transitionSelect.value = settings.transitions.transitionTiming;
                const changeEvent = new Event('change', {bubbles: true});
                transitionSelect.dispatchEvent(changeEvent);
            }
        }

        if (settings.header) {
            const stickyHeaderCheckbox = document.getElementById('_dm-stickyHeaderCheckbox');
            if (stringToBoolean(settings.header.stickyHeader) && !isElementInDesiredState(stickyHeaderCheckbox, true)) {
                stickyHeaderCheckbox.click();
            }
        }

        if (settings.navigation) {
            const stickyNavCheckbox = document.getElementById('_dm-stickyNavCheckbox');
            if (stringToBoolean(settings.navigation.stickyNav) && !isElementInDesiredState(stickyNavCheckbox, true)) {
                stickyNavCheckbox.click();
            }

            const profileWidgetCheckbox = document.getElementById('_dm-profileWidgetCheckbox');
            if (stringToBoolean(settings.navigation.profileWidget) && !isElementInDesiredState(profileWidgetCheckbox, true)) {
                profileWidgetCheckbox.click();
            }

            const miniNavRadio = document.getElementById('_dm-miniNavRadio');
            if (stringToBoolean(settings.navigation.miniNav) && !isElementInDesiredState(miniNavRadio, true)) {
                miniNavRadio.click();
            }

            const maxiNavRadio = document.getElementById('_dm-maxiNavRadio');
            if (stringToBoolean(settings.navigation.maxiNav) && !isElementInDesiredState(maxiNavRadio, true)) {
                maxiNavRadio.click();
            }

            const pushNavRadio = document.getElementById('_dm-pushNavRadio');
            if (stringToBoolean(settings.navigation.pushNav) && !isElementInDesiredState(pushNavRadio, true)) {
                pushNavRadio.click();
            }

            const slideNavRadio = document.getElementById('_dm-slideNavRadio');
            if (stringToBoolean(settings.navigation.slideNav) && !isElementInDesiredState(slideNavRadio, true)) {
                slideNavRadio.click();
            }

            const revealNavRadio = document.getElementById('_dm-revealNavRadio');
            if (stringToBoolean(settings.navigation.revealNav) && !isElementInDesiredState(revealNavRadio, true)) {
                revealNavRadio.click();
            }
        }

        if (settings.sidebar) {
            const disableBackdropCheckbox = document.getElementById('_dm-disableBackdropCheckbox');
            if (stringToBoolean(settings.sidebar.disableBackdrop) && !isElementInDesiredState(disableBackdropCheckbox, true)) {
                disableBackdropCheckbox.click();
            }

            const staticSidebarCheckbox = document.getElementById('_dm-staticSidebarCheckbox');
            if (stringToBoolean(settings.sidebar.staticPosition) && !isElementInDesiredState(staticSidebarCheckbox, true)) {
                staticSidebarCheckbox.click();
            }

            const stuckSidebarCheckbox = document.getElementById('_dm-stuckSidebarCheckbox');
            if (stringToBoolean(settings.sidebar.stuckSidebar) && !isElementInDesiredState(stuckSidebarCheckbox, true)) {
                stuckSidebarCheckbox.click();
            }

            const uniteSidebarCheckbox = document.getElementById('_dm-uniteSidebarCheckbox');
            if (stringToBoolean(settings.sidebar.uniteSidebar) && !isElementInDesiredState(uniteSidebarCheckbox, true)) {
                uniteSidebarCheckbox.click();
            }

            const pinnedSidebarCheckbox = document.getElementById('_dm-pinnedSidebarCheckbox');
            if (stringToBoolean(settings.sidebar.pinnedSidebar) && !isElementInDesiredState(pinnedSidebarCheckbox, true)) {
                pinnedSidebarCheckbox.click();
            }
        }

        if (settings.colors) {
            const themeToggler = document.getElementById('settingsThemeToggler');
            if (stringToBoolean(settings.colors.themeColor) && !isElementInDesiredState(themeToggler, true)) {
                themeToggler.click();
            }

            const colorSchemeButton = document.querySelector(`._dm-colorSchemes[data-color="${settings.colors.colorScheme}"]`);
            if (colorSchemeButton && !colorSchemeButton.classList.contains('active')) {
                colorSchemeButton.click();
            }

            const colorSchemeModeButton = document.querySelector(`._dm-colorModeBtn[data-color-mode="${settings.colors.colorSchemeMode}"]`);
            if (colorSchemeModeButton && !colorSchemeModeButton.classList.contains('active')) {
                colorSchemeModeButton.click();
            }
        }

        if (settings.font) {
            const fontSizeRange = document.getElementById('_dm-fontSizeRange');
            const fontSizeValue = document.getElementById('_dm-fontSizeValue');

            if (fontSizeRange.value !== settings.font.fontSize) {
                fontSizeRange.value = settings.font.fontSize;
                const inputEvent = new Event('input', {bubbles: true});
                fontSizeRange.dispatchEvent(inputEvent);
                fontSizeValue.textContent = settings.font.fontSize;
            }
        }

        setTimeout(function () {
            if (settings.scrollbars) {
                const bodyScrollbarCheckbox = document.getElementById('_dm-bodyScrollbarCheckbox');
                if (stringToBoolean(settings.scrollbars.bodyScrollbar) && !isElementInDesiredState(bodyScrollbarCheckbox, true)) {
                    bodyScrollbarCheckbox.click();
                }

                const sidebarScrollbarCheckbox = document.getElementById('_dm-sidebarsScrollbarCheckbox');
                if (stringToBoolean(settings.scrollbars.sidebarScrollbar) && !isElementInDesiredState(sidebarScrollbarCheckbox, true)) {
                    sidebarScrollbarCheckbox.click();
                }
            }
        }, 1000)
    });
    document.getElementById('settingsForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const settings = {
            layouts: {
                fluidLayout: document.getElementById('_dm-fluidLayoutRadio').checked,
                boxedLayout: document.getElementById('_dm-boxedLayoutRadio').checked,
                centeredLayout: document.getElementById('_dm-centeredLayoutRadio').checked,
            },
            transitions: {
                transitionTiming: document.getElementById('_dm-transitionSelect').value,
            },
            header: {
                stickyHeader: document.getElementById('_dm-stickyHeaderCheckbox').checked,
            },
            navigation: {
                stickyNav: document.getElementById('_dm-stickyNavCheckbox').checked,
                profileWidget: document.getElementById('_dm-profileWidgetCheckbox').checked,
                miniNav: document.getElementById('_dm-miniNavRadio').checked,
                maxiNav: document.getElementById('_dm-maxiNavRadio').checked,
                pushNav: document.getElementById('_dm-pushNavRadio').checked,
                slideNav: document.getElementById('_dm-slideNavRadio').checked,
                revealNav: document.getElementById('_dm-revealNavRadio').checked,
            },
            sidebar: {
                disableBackdrop: document.getElementById('_dm-disableBackdropCheckbox').checked,
                staticPosition: document.getElementById('_dm-staticSidebarCheckbox').checked,
                stuckSidebar: document.getElementById('_dm-stuckSidebarCheckbox').checked,
                uniteSidebar: document.getElementById('_dm-uniteSidebarCheckbox').checked,
                pinnedSidebar: document.getElementById('_dm-pinnedSidebarCheckbox').checked,
            },
            colors: {
                themeColor: document.getElementById('settingsThemeToggler').checked,
                colorScheme: document.querySelector('._dm-colorSchemes.active')?.dataset.color,
                colorSchemeMode: document.querySelector('._dm-colorModeBtn.active')?.dataset.colorMode
            },
            font: {
                fontSize: document.getElementById('_dm-fontSizeRange').value,
            },
            scrollbars: {
                bodyScrollbar: document.getElementById('_dm-bodyScrollbarCheckbox').checked,
                sidebarScrollbar: document.getElementById('_dm-sidebarsScrollbarCheckbox').checked,
            },
        };
        const formData = new FormData();
        flattenObject(settings, 'settings', formData);
        AjaxRequestPromise(`{{route('admin.save.settings')}}`, formData, 'POST', {useToastr: true})
            .then(response => {
                console.log('Settings updated successfully:', response);
            })
            .catch(error => console.log('An error occurred while updating the record.'));

    });
    function flattenObject(obj, parentKey = '', formData = new FormData()) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key)) {
                const nestedKey = parentKey ? `${parentKey}[${key}]` : key;
                if (typeof obj[key] === 'object' && !(obj[key] instanceof File)) {
                    flattenObject(obj[key], nestedKey, formData); // Recursively flatten nested objects
                } else {
                    formData.append(nestedKey, obj[key]); // Append primitive values to FormData
                }
            }
        }
        return formData;
    }
    $(function () {
        // $('._dm-settings-container__content .enabled').click();
        // $("#_dm-stickyHeaderCheckbox").prop("checked") || $("#_dm-stickyHeaderCheckbox").click();
        // $("#dm_colorModeContainer ._dm-colorModeBtn[data-color-mode='tm--primary-mn']:not(.active)").click();
    });

    /** Loader Start */
    const loaders = ['sk-plane', 'sk-chase', 'sk-bounce', 'sk-wave', 'sk-pulse', 'sk-flow', 'sk-swing', 'sk-circle', 'sk-circle-fade', 'sk-grid', 'sk-fold', 'sk-wander'];
    let randomLoader;

    function randomLoaderFunction() {
        return loaders[Math.floor(Math.random() * loaders.length)];
    }

    randomLoader = randomLoaderFunction();

    $(`#loader`).show();
    $(`.${randomLoader}`).removeClass('load-spinner');
    $(document).ready(function () {
        if (@json(View::hasSection('datatable'))) {
            setTimeout(() => {
                $('#loader').hide();
                $(`.${randomLoader}`).toggleClass('load-spinner');
            }, 1000);
        } else {
            $(`#loader`).hide();
            $(`.${randomLoader}`).toggleClass('load-spinner');
        }

        // $('#testTable').DataTable();
    });
    /** Loader End */

    $(document).ajaxStart(function () {
        randomLoader = randomLoaderFunction();
        $(`#loader`).show();
        $(`#loader`).addClass('loader-light');
        $(`.${randomLoader}`).removeClass('load-spinner');
    });

    $(document).ajaxStop(function () {
        $(`#loader`).hide();
        $(`#loader`).removeClass('loader-light');
        $(`.${randomLoader}`).addClass('load-spinner');
    });

    var error = false;
    function refreshCsrfToken() {
        return $.get('{{route('csrf.token')}}').then(response => {
            $('meta[name="csrf-token"]').attr('content', response.token);
        });
    }
    $(document).ready(function () {
        /** Ajax Error Handle Start */
        $.ajaxSetup({
            error: function (jqXHR, textStatus, errorThrown) {
                error = true;
                if (jqXHR.status === 429) {
                    Swal.fire({
                        title: 'Too Many Requests',
                        text: 'You are making requests too frequently. Please slow down and try again later.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                } else if (jqXHR.status === 500) {
                    Swal.fire({
                        title: 'Server Error',
                        text: 'An unexpected error occurred on the server. Please try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (jqXHR.status === 404) {
                    Swal.fire({
                        title: 'Not Found',
                        text: 'The requested resource could not be found.',
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                } else if (jqXHR.status === 403) {
                    Swal.fire({
                        title: 'Forbidden',
                        text: jqXHR.responseJSON.error ?? 'You do not have permission to perform this action.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (jqXHR.status === 0) {
                    Swal.fire({
                        title: 'Network Error',
                        text: 'It seems you are offline or there was a network issue.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else if (jqXHR.status === 422) {
                    // Swal.fire({
                    //     title: 'Error',
                    //     text: `An error occurred: ${jqXHR.status} - ${jqXHR.statusText}`,
                    //     icon: 'error',
                    //     confirmButtonText: 'OK'
                    // });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: `An error occurred: ${jqXHR.status} - ${jqXHR.statusText}`,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
    /** Ajax Error Handle End */

    let currentRequest = null;
    $(document).ajaxSend(function (event, jqXHR, settings) {
        if (currentRequest) {
            currentRequest.abort();
        }
        currentRequest = jqXHR;
    });
    $(document).ajaxComplete(function (event, jqXHR, settings) {
        currentRequest = null;
        error = false;

    });
    $(document).ajaxError(function myErrorHandler(event, jqXHR, ajaxOptions, thrownError) {
        if (jqXHR.status === 422 || (jqXHR.responseJSON && jqXHR.responseJSON.errors)) {
            return;
        }
        resetFields();

        const formContainer = $('.form-container');
        if (formContainer.length > 0) {
            formContainer.removeClass('open')
        }
        const manageForm = $('.custom-form form')
        if (manageForm.length > 0) {
            manageForm[0].reset();
            manageForm.removeData('id');
        }
        if (jqXHR.status === 429) {
            Swal.fire({
                title: 'Too Many Requests',
                text: 'You are making requests too frequently. Please slow down and try again later.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        } else if (jqXHR.status === 500) {
            Swal.fire({
                title: 'Server Error',
                text: 'An unexpected error occurred on the server. Please try again later.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else if (jqXHR.status === 404) {
            Swal.fire({
                title: 'Not Found',
                text: 'The requested resource could not be found.',
                icon: 'info',
                confirmButtonText: 'OK'
            });
        } else if (jqXHR.status === 403) {
            Swal.fire({
                title: 'Forbidden',
                text: jqXHR.responseJSON.error ?? 'You do not have permission to perform this action.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else if (jqXHR.status === 0) {
            Swal.fire({
                title: 'Network Error',
                text: 'It seems you are offline or there was a network issue.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else if (jqXHR.status === 401) {
            Swal.fire({
                title: 'Unauthorized',
                text: 'Your session has expired or you are not authorized to perform this action. Please log in again.',
                icon: 'warning',
                confirmButtonText: 'Login',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `{{route('admin.login')}}`;
                }
            });
        } else if (jqXHR.status === 403) {
            Swal.fire({
                title: 'Forbidden',
                text: 'You do not have permission to perform this action.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                title: 'Error',
                text: `An error occurred: ${jqXHR.status} - ${jqXHR.statusText}`,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });

    function AjaxDeleteRequestPromise(url, data, method = 'DELETE', options = {}) {
        method = method.toUpperCase();
        options = {
            useDeleteSwal: false, /* * Show SweetAlert confirmation for delete */
            deleteSwalMessage: 'This action cannot be undone.',
            ...options
        };
        if (options.useDeleteSwal && method === 'DELETE') {
            return Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: options.deleteSwalMessage,
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                customClass: {
                    cancelButton: 'swal2-left-button',
                    confirmButton: 'swal2-right-button'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    return AjaxRequestPromise(url, data, method, options).then(response => {
                        return {isConfirmed: true, response: response};
                    });
                }
                return Promise.reject({isConfirmed: false, message: 'Phew! The delete action was saved.'});
            });
        } else {
            return AjaxRequestPromise(url, data, method, options);
        }
    }

    function AjaxRequestPromise(url, data, method = 'GET', options = {}) {
        method = method.toUpperCase();
        options = {
            useReload: false, /* * Reload the page after success */
            useRedirect: false, /* * Redirect to another page after success */
            redirectLocation: '', /* * Location to redirect to */
            useSwal: false, /* * Show SweetAlert notification */
            title: 'Success', /* * Title for SweetAlert */
            showConfirmButton: true, /* * Display confirm button in SweetAlert */
            confirmButtonText: 'OK', /* * Confirm button text in SweetAlert */
            cancelButtonText: 'Reload', /* * Cancel button text in SweetAlert */
            useSwalReload: false, /* * Reload the page if SweetAlert is confirmed */
            icon: 'success', /* * SweetAlert & toastr icon: 'success', 'error', 'warning', 'info' */
            useToastr: false, /* * Show toastr notification */
            message: 'Request was successful.', /* * Message text for toastr & SweetAlert*/
            useToastrReload: false, /* * Reload the page after toastr notification */
            ...options /* * Use provided options if any */
        };
        if (method === 'GET' && data && Object.keys(data).length > 0) {
            const queryString = $.param(data);
            url = `${url}?${queryString}`;
        }
        return new Promise((resolve, reject) => {
            $('form').find('.is-invalid').removeClass('is-invalid');
            $('form').find('.text-danger').fadeOut();
            $.ajax({
                url: url,
                type: method,
                data: method === 'GET' ? null : data,
                processData: method === 'GET',
                contentType: method === 'GET' ? 'application/x-www-form-urlencoded' : false,
                headers: method === 'GET' ? {} : {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function () {
                    // $('#loading').show();
                },
                success: function (response) {
                    if (typeof response === 'string' && response.startsWith('<!DOCTYPE html>')) {
                        toastr['error']("It looks like you've been disconnected. Please reload the page.");
                        return reject(error);
                    }
                    const message = response.message || response.success || options.message || 'Request was successful.';

                    if (options.useSwal) {
                        Swal.fire({
                            icon: options.icon,
                            title: options.title,
                            text: message,
                            confirmButtonText: options.showConfirmButton ? options.confirmButtonText : null,
                            showConfirmButton: options.showConfirmButton,
                            cancelButtonText: options.useSwalReload ? options.cancelButtonText : null,
                            showCancelButton: options.useSwalReload,
                            focusConfirm: false,
                            customClass: {
                                cancelButton: 'swal2-left-button',
                                confirmButton: 'swal2-right-button'
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (options.useRedirect && options.redirectLocation) {
                                    window.location.href = options.redirectLocation;
                                }
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if (options.useSwalReload) {
                                    location.reload();
                                }
                            }
                        });
                    }

                    /** Toastr notification */
                    if (options.useToastr) {
                        toastr[options.icon](message);
                        if (options.useToastrReload) {
                            setTimeout(() => location.reload(), 5000);
                        } else if (options.useRedirect && options.redirectLocation) {
                            setTimeout(() => window.location.href = options.redirectLocation, 5000);
                        }
                    }

                    /** Handle redirection or page reload */
                    if (!options.useSwal && !options.useToastr) {
                        if (options.useReload) {
                            location.reload();
                        } else if (options.useRedirect && options.redirectLocation) {
                            window.location.href = options.redirectLocation;
                        }
                    }
                    resolve(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    const response = jqXHR.responseJSON;
                    const message = response?.message || response?.error || errorThrown || 'Something went wrong. Please try again.';
                    if (jqXHR.status === 419 || message.includes("CSRF token mismatch")) {
                        return refreshCsrfToken().then(() => {
                            return AjaxRequestPromise(url, data, method, options);
                        }).catch(() => {
                            console.log("Failed to refresh CSRF token. Please try again.");
                            reject(textStatus);
                        });
                    }
                    if (jqXHR.status === 422 && response && response.errors) {
                        const isUpdate = url.includes('update');

                        if (response.errors && Array.isArray(response.errors)) {
                            let errorMessages = '';
                            response.errors.forEach(message => {
                                errorMessages += `<p>${message}</p>`;
                            });
                            $('.error-messages').html(`<div class="alert alert-danger text-danger">${errorMessages}</div>`).show();
                            setTimeout(function () {
                                $('.error-messages').fadeOut();
                            }, 5000);
                        } else if (response.errors) {
                            let firstError = false;
                            for (let field in response.errors) {
                                firstError = true;
                                const fieldSelector = $(isUpdate ? `#edit_${field}` : `#edit_${field}`).length > 0 ? `#edit_${field}` : `#${field}`;
                                if (firstError) {
                                    document.getElementById(field).scrollIntoView({
                                        behavior: 'smooth',
                                        block: 'center'
                                    });
                                }

                                const errorMessages = response.errors[field];

                                $(fieldSelector).next('.text-danger').remove();

                                if (Array.isArray(errorMessages)) {
                                    errorMessages.forEach(message => {
                                        $(fieldSelector).after(`<span class="text-danger">${message}</span>`);
                                    });
                                } else {
                                    $(fieldSelector).after(`<span class="text-danger">${errorMessages}</span>`);
                                }

                                $(fieldSelector).addClass('is-invalid');

                                setTimeout(function () {
                                    $(fieldSelector).removeClass('is-invalid');
                                    $(fieldSelector).siblings('.text-danger').fadeOut();
                                }, 10000);
                            }
                        }

                    }
                    /** Show generic error with SweetAlert */
                    if (options.useSwal) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: message,
                            confirmButtonText: options.showConfirmButton ? options.confirmButtonText : null,
                            showConfirmButton: options.showConfirmButton,
                            cancelButtonText: options.useSwalReload ? options.cancelButtonText : null,
                            showCancelButton: options.useSwalReload,
                            focusConfirm: false,
                            customClass: {
                                cancelButton: 'swal2-left-button',
                                confirmButton: 'swal2-right-button'
                            },
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (options.useRedirect && options.redirectLocation) {
                                    window.location.href = options.redirectLocation;
                                }
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if (options.useSwalReload) {
                                    location.reload();
                                }
                            }
                        });
                    }
                    /** Show generic error with toastr */
                    if (options.useToastr) {
                        if (jqXHR.status !== 422 || !jqXHR.responseJSON.errors) {
                            toastr['error'](message);
                        }
                        if (options.useToastrReload) {
                            setTimeout(() => location.reload(), 5000);
                        } else if (options.useRedirect && options.redirectLocation) {
                            setTimeout(() => window.location.href = options.redirectLocation, 5000);
                        }
                    }

                    reject(textStatus);
                },
                complete: function (jqXHR, textStatus) {
                    if (jqXHR.status !== 422 || !jqXHR.responseJSON.errors) {
                        if (url.includes('store') || url.includes('update')) {
                            $(".modal").modal('hide');
                            $('.form-container').removeClass('open');
                            resetFields();
                            const manageForm = $('.custom-form form')
                            if (manageForm.length > 0) {
                                manageForm[0].reset();
                            }
                        }
                    }
                }
            });
        });
    }

    function generateRandomPassword(length) {
        const upperCase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const lowerCase = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        const symbols = '!@#$%^&*()';
        const allChars = upperCase + lowerCase + numbers + symbols;
        let password = '';
        for (let i = 0; i < 2; i++) {
            password += upperCase.charAt(Math.floor(Math.random() * upperCase.length));
            password += lowerCase.charAt(Math.floor(Math.random() * lowerCase.length));
            password += numbers.charAt(Math.floor(Math.random() * numbers.length));
            password += symbols.charAt(Math.floor(Math.random() * symbols.length));
        }
        for (let i = password.length; i < length; i++) {
            password += allChars.charAt(Math.floor(Math.random() * allChars.length));
        }
        password = password.split('').sort(() => 0.5 - Math.random()).join('');
        return password;
    }

    function resetFields() {
        $('.second-fields').fadeOut();
        $('.first-fields').fadeIn();
        $('.first-field-inputs').prop('required', true);
        $('.second-field-inputs').prop('required', false);
        $('.image-div').css('display', 'none');

        // $('.first-fields').fadeOut(() => {
        //     $('.second-fields').fadeIn();
        //     $('.second-field-inputs').prop('required', true);
        //     $('.first-field-inputs').prop('required', false);
        // });
    }
    $(document).ready(function () {

        const formContainerClass = document.querySelector('.form-container');
        if (!formContainerClass) {
            return;
        }
        const toggleInputs = () => {
            const isDisabled = formContainerClass.classList.contains('open');
            const searchInputs = document.querySelectorAll('input[type="search"]');
            const selectInputs = document.querySelectorAll('.dt-container select');
            const checkboxInputs = document.querySelectorAll('.dt-container input[type="checkbox"]');
            searchInputs.forEach(input => input.disabled = isDisabled);
            selectInputs.forEach(input => input.disabled = isDisabled);
            checkboxInputs.forEach(input => input.disabled = isDisabled);
        };

        const observer = new MutationObserver(toggleInputs);

        observer.observe(formContainerClass, {
            attributes: true,
            attributeFilter: ['class'],
        });

        toggleInputs();

        const formContainer = $('#formContainer');
        const manageForm = $('.custom-form form')

        let isAjaxRequestInProgress = false;
        $(document).ajaxStart(function () {
            isAjaxRequestInProgress = true;
        }).ajaxStop(function () {
            isAjaxRequestInProgress = false;
        }).ajaxError(function () {
            error = true;
        });

        if (formContainer.length > 0) {
            openCustomForm(formContainer, manageForm);
            closeCustomForm(formContainer, manageForm);
        } else {
            // console.warn('#formContainer does not exist.');
        }

        // Function to open and reset the form
        function openCustomForm(formContainer, manageForm) {
            $('.open-form-btn, .editBtn').click(function () {
                manageForm[0].reset();
                manageForm.removeData('id');
                resetFields();
                // Show message if no access
                if ($(this).hasClass('void')) {
                    $(this).attr('title', "You don't have access to create a record.")
                        .tooltip({placement: 'bottom'}).tooltip('show');
                } else {
                    formContainer.addClass('open');
                    $('.form-body').animate({
                        scrollTop: $('.form-body').offset().top - 500
                    }, 500);
                }
            });
        }
        $(document).on('click', function (event) {
            if (
                (!$(event.target).closest('.form-container').length &&
                    !$(event.target).is('.form-container') &&
                    !$(event.target).closest('.open-form-btn').length &&
                    !$(event.target).is('.editBtn') &&
                    !$(event.target).is('.changePwdBtn')
                ) ||
                $(event.target).is('.form-container .close-btn')
            ) {
                closeCustomForm(formContainer, manageForm);
            }
        });
        // Function to close the form and reset form fields
        function closeCustomForm(formContainer, manageForm) {
            // Close the form
            formContainer.removeClass('open');
            $('.form-container').removeClass('open');
            resetFields();

            // Reset the form if available
            if (manageForm.length > 0) {
                manageForm[0].reset();
                manageForm.removeData('id');
            }

        }
        $(".tab-item").on("click", function () {
            $(".tab-item").removeClass("active");
            $(".tab-pane").removeClass("active");

            $(this).addClass("active");

            const targetPane = $(this).data("tab");
            $("#" + targetPane).addClass("active");

            let tabId = $(this).attr("data-tab");
            let targetTable = $("#" + tabId).find("table");
            if ($.fn.DataTable.isDataTable(targetTable)) {
                targetTable.DataTable().columns.adjust().draw();
            }
        });
        $(".searchbox__btn").on('click', function () {
            const searchTerm = $("#header-search-input").val().trim();
            if (searchTerm) {
                const currentUrl = window.location.origin + window.location.pathname;
                window.location.href = `${currentUrl}?search=${searchTerm}`;
                // window.location.href = `${currentUrl}?search=${encodeURIComponent(searchTerm)}`;
            } else {
                window.location.href = window.location.origin + window.location.pathname;
            }
        });

        const params = new URLSearchParams(window.location.search);
        function onAllDataTablesReady(callback) {
            const tables = $.fn.dataTable.tables({api: true});
            let readyCount = 0;

            if (!tables.length) {
                callback();
                return;
            }

            tables.each(function () {
                const dt = new $.fn.dataTable.Api(this);
                if (dt.settings()[0]._bInitComplete) {
                    readyCount++;
                } else {
                    $(dt.table().node()).on('init.dt', function () {
                        readyCount++;
                        if (readyCount === tables.length) {
                            callback();
                        }
                    });
                }
                if (readyCount === tables.length) {
                    callback();
                }
            });
        }

        setTimeout(function () {
            onAllDataTablesReady(function () {
                const searchId = params.get('ref');
                const searchTerm = params.get('search');

                if (searchId) {
                    $('.editBtn').each(function () {
                        if ($(this).data('id') == searchId) {
                            $(this).click();
                        }
                    });
                }
                if (searchTerm) {
                    $($.fn.dataTable.tables({visible: true})).each(function () {
                        const dt = $(this).DataTable();
                        dt.search(searchTerm).draw();
                    });
                }
            });
        }, 100);
    });
    !function () {
        document.currentScript?.remove()
    }();
</script>
