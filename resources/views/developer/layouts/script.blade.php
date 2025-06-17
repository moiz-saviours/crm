<script src="{{asset('assets/js/jquery.min.js')}}"></script>

<script src="{{asset('assets/js/core/popper.min.js')}}"></script>
<script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/smooth-scrollbar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/chartjs.min.js')}}"></script>

<!-- Font Awesome Icons -->
<script src="{{asset('assets/fonts/fontawsome.js')}}"></script>

<!-- SweetAlert2 -->
<script src="{{asset('assets/js/plugins/sweetalert2@11.js')}}"></script>

<!-- Bootstrap 5 JS -->
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>--}}

@if (View::hasSection('datatable'))
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap5.css')}}">

    <!-- DataTables JS -->
    <script src="{{asset('assets/js/plugins/datatable/dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatable/dataTables.bootstrap5.min.js')}}"></script>

    <!-- DataTables Buttons Extension CSS and JS -->
    <script src="{{asset('assets/js/plugins/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatable/buttons.bootstrap5.min.js')}}"></script>

    <!-- Buttons HTML5 Export (for CSV, Excel, PDF) -->
    <script src="{{asset('assets/js/plugins/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatable/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatable/buttons.print.min.js')}}"></script>

    <!-- JSZip and PDFMake (required for Excel and PDF export buttons) -->
    <script src="{{asset('assets/js/plugins/datatable/jszip.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatable/vfs_fonts.js')}}"></script>
@endif
<script>
    var chartElement = document.getElementById("chart-line");
    if (chartElement) {
        var ctx1 = chartElement.getContext("2d");


        var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

        gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
        gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
        gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
        new Chart(ctx1, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: gradientStroke1,
                    borderWidth: 3,
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#ccc',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });
    }
</script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script async defer src="{{asset('assets/js/buttons.js')}}"></script>
<script src="{{asset('assets/js/dashboard.min.js')}}?v=2.1.0"></script>

{{--<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>--}}
{{--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>--}}

<!-- Choices Js For Select Searchable-->
<script src="{{asset('assets/js/plugins/choices.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('.searchable').each(function () {
            var placeholder = $(this).attr('title') || 'Please select an option';
            new Choices(this, {
                placeholderValue: placeholder,
                searchEnabled: true,
                itemSelectText: '',
                removeItemButton: true,
                shouldSort: false,
                allowHTML: true,
                // callbackOnCreateTemplates: {
                //     choice(classes, data) {
                //         const el = Choices.defaults.templates.choice.call(this, classes, data);
                //         if (data.html) {
                //             el.innerHTML = data.html;
                //         }
                //         if (data.style) {
                //             el.style.cssText = data.style;
                //         }
                //         if (data.class) {
                //             el.classList.add(data.class);
                //             el.addClass(data.class);
                //         }
                //         return el;
                //     },
                // },
            });
            $(this).find('option').each(function () {
                var cssStyles = $(this).data('style');
                var classes = $(this).data('class');
                var html = $(this).data('html');
                var id = $(this).val();
                if (id) {
                    var choiceElement = $(this).closest('.choices').find(`.choices__item--choice[data-value="${id}"]`);

                    /**Its appending but not rendering */
                    // if (cssStyles) {
                    //     choiceElement.attr('style', cssStyles);
                    // }
                    // if (classes) {
                    //     choiceElement.addClass(classes);
                    // }
                    // if (html) {
                    //     choiceElement.html(html);
                    // }
                }
            });
            $(this).val('');

        });
    });
</script>

<!-- Toaster -->
<script src="{{asset('assets/toaster/js/toastr.min.js')}}"></script>

<script>
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
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
</script>


<script>
    function refreshCsrfToken() {
        return $.get('{{route('csrf.token')}}').then((response) => {
            $('meta[name="csrf-token"]').attr('content', response.token);
        });
    }

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

                        for (let field in response.errors) {
                            const fieldWithPrefix = isUpdate ? `#edit_${field}` : `#${field}`;

                            const errorMessages = response.errors[field];
                            errorMessages.each(message => {
                                $(fieldWithPrefix).after(`<span class="text-danger">${message}</span>`);
                            });

                            $(fieldWithPrefix).addClass('is-invalid');

                            setTimeout(function () {
                                $(fieldWithPrefix).removeClass('is-invalid');
                                $(fieldWithPrefix).siblings('.text-danger').fadeOut();
                            }, 5000);
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
                        toastr['error'](message);
                        if (options.useToastrReload) {
                            setTimeout(() => location.reload(), 5000);
                        } else if (options.useRedirect && options.redirectLocation) {
                            setTimeout(() => window.location.href = options.redirectLocation, 5000);
                        }
                    }

                    reject(textStatus);
                },
                complete: function () {
                    $(".modal").modal('hide');
                    // $('#loading').hide();
                }
            });
        });
    }

    $('#loader').show();
    $(document).ready(function () {
        if (@json(View::hasSection('datatable'))) {
            setTimeout(() => $('#loader').hide(), 1000);
        } else {
            $('#loader').hide();
        }
        // $("#navbarFixed").click();
    });

</script>

