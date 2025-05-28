<?php
if (!in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']) && (isset($invoiceDetails['invoice']['status']) && $invoiceDetails['invoice']['status'] != 1)) {
    try {

        $ip = $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ip-api.com/json/{$ip}?fields=countryCode");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpCode === 200) {
            $data = json_decode($response, true);
            if (isset($data['countryCode']) && $data['countryCode'] === 'PK') {
                echo '<!DOCTYPE html>
                    <html>
                    <head>
                        <title>Access Restricted</title>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    </head>
                    <body>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                Swal.fire({
                                    icon: "error",
                                    title: "Access Denied",
                                    html: "<p style=\"margin: 1rem 0\">Our services are not available in your region due to regulatory restrictions. We apologize for any inconvenience..</p>",
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    willClose: () => {
                                        document.body.innerHTML = "<h1 style=\"text-align:center;margin-top:50px;\">Access Restricted</h1>";
                                    }
                                });
                            });
                        </script>
                    </body>
                    </html>';
                exit();
            }
        }
//        $vpnCheck = curl_init();
//        curl_setopt($vpnCheck, CURLOPT_URL, "https://vpnapi.io/api/{$ip}?key=4239106e6b264bcda480cf535d7aee57");
//        curl_setopt($vpnCheck, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($vpnCheck, CURLOPT_TIMEOUT, 3);
//        $vpnResponse = curl_exec($vpnCheck);
//        $vpnHttpCode = curl_getinfo($vpnCheck, CURLINFO_HTTP_CODE);
//        curl_close($vpnCheck);
//
//        if ($vpnHttpCode === 200) {
//            $vpnData = json_decode($vpnResponse, true);
//            if (($vpnData['security']['vpn'] ?? false) || ($vpnData['security']['proxy'] ?? false)) {
//                echo '<!DOCTYPE html>
//                    <html>
//                    <head>
//                        <title>Security Notice</title>
//                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
//                        <style>
//                            .swal2-confirm {
//                                background-color: #3085d6 !important;
//                            }
//                            .swal2-cancel {
//                                background-color: #d33 !important;
//                            }
//                        </style>
//                    </head>
//                    <body>
//                        <script>
//                            document.addEventListener("DOMContentLoaded", function() {
//                                Swal.fire({
//                                    icon: "warning",
//                                    title: "Security Notice",
//                                    html: `<div style="text-align:left;">
//                                        <p style="margin-bottom:1rem;">We\'ve detected you\'re using a VPN or proxy service.</p>
//                                        <p style="margin-bottom:1rem;">For your security and compliance with regional regulations:</p>
//                                        <ul style="margin-left:1.5rem;margin-bottom:1.5rem;">
//                                            <li>Transactions via VPN may be flagged as suspicious</li>
//                                            <li>Some features may not work as expected</li>
//                                            <li>Your account may require additional verification</li>
//                                        </ul>
//                                        <p>Do you want to continue with VPN enabled?</p>
//                                    </div>`,
//                                    showCancelButton: true,
//                                    confirmButtonText: "Continue Anyway",
//                                    cancelButtonText: "Disable VPN",
//                                    allowOutsideClick: false,
//                                    allowEscapeKey: false,
//                                    backdrop: "rgba(0,0,0,0.7)",
//                                    customClass: {
//                                        popup: "vpn-warning-popup"
//                                    }
//                                }).then((result) => {
//                                    if (result.isDismissed) {
//                                        window.location.href = "https://support.example.com/vpn-guide";
//                                    }
//                                    // If confirmed, continue loading page
//                                });
//                            });
//                        </script>
//                    </body>
//                    </html>';
//                exit();
//            }
//        }
    } catch (Exception $e) {
        file_put_contents('geolocation_errors.log', date('Y-m-d H:i:s') . ' - ' . $e->getMessage() . "\n", FILE_APPEND);
    }
}
?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Invoice</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon//favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon//favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/favicon//site.webmanifest')}}">

    <link rel="stylesheet" href="{{asset('assets/css/checkout.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
          integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="{{asset('build/toaster/css/toastr.min.css')}}">


    <!-- pdf download links -->
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
$isLocalhost = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);
$isInvoicePaid = isset($invoiceDetails['invoice']['status']) && $invoiceDetails['invoice']['status'] == 1;
$shouldCheckGeolocation = !$isLocalhost && !$isInvoicePaid;
?>
<script>
    (function () {
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.3s';

        const isLocalhost = ['localhost', '127.0.0.1', '0.0.0.0'].includes(window.location.hostname);
        const blockedCountries = ['AF', 'AM', 'AZ', 'BH', 'BD', 'BT', 'BN', 'KH', 'CN', 'CY', 'GE', 'IN', 'ID', 'IR', 'IQ', 'IL', 'JP', 'JO', 'KZ', 'KW', 'KG', 'LA', 'LB', 'MY', 'MV', 'MN', 'MM', 'NP', 'KP', 'OM', 'PK', 'PS', 'PH', 'QA', 'SA', 'SG', 'KR', 'LK', 'SY', 'TW', 'TJ', 'TH', 'TL', 'TR', 'TM', 'UZ', 'VN', 'YE'];
        const accessDeniedMessage = 'Our services are not available in your region due to regulatory restrictions. We apologize for any inconvenience.';

        const shouldCheckGeolocation = <?php echo $shouldCheckGeolocation ? 'true' : 'false'; ?>;

        if (!shouldCheckGeolocation) {
            console.debug('check bypassed:',
                isLocalhost ? 'Local development environment detected' : 'Invoice is paid');
            document.body.style.opacity = '1';
            return;
        }

        if (isLocalhost) {
            console.debug('check bypassed: Local development environment detected');
            document.body.style.opacity = '1';
            return;
        }

        const showLoading = () => {
            // Swal.fire({
            //     title: 'Verifying Access',
            //     html: 'Checking regional availability...',
            //     allowOutsideClick: false,
            //     allowEscapeKey: false,
            //     showConfirmButton: false,
            //     didOpen: () => Swal.showLoading()
            // });
        };
        const blockAccess = (message) => {
            document.body.innerHTML = '';
            document.body.style.opacity = '1';

            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                html: `<p style="margin: 1rem 0">${message}</p>`,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
            });
        };

        const verifyAccess = async () => {
            showLoading();

            try {
                const response = await fetch("https://geolocation-db.com/json/");

                if (!response.ok) {
                    throw new Error(`API error: ${response.status}`);
                }

                const data = await response.json();
                console.debug('data:', data?.IPv4, data?.country_code);

                const userCountry = (data.country_code || '').toUpperCase();
                console.debug('user country:', userCountry);

                if (blockedCountries.includes(userCountry)) {
                    blockAccess(accessDeniedMessage);
                } else {
                    Swal.close();
                    document.body.style.opacity = '1';
                }
            } catch (error) {
                console.error('check failed:', error);
                Swal.close();
                document.body.style.opacity = '1';
            }
        };

        document.addEventListener("DOMContentLoaded", verifyAccess);
    })();
</script>
<div class="loader-container loader-light" style="display: none">
    <div class="loader"></div>
    <div class="loading-text">Processing Payment...</div>
    <div class="funny-message">Counting coins...</div>
</div>
<div id="toaster-container"></div>
<?php if (!isset($invoiceDetails['success']) || !$invoiceDetails['success']): ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('toaster-container');
        const toast = document.createElement('div');
        toast.className = 'toaster error';
        toast.textContent = <?= json_encode($invoiceDetails['message'] ?? $invoiceDetails['error'] ?? 'An unknown error occurred') ?>;
        container.appendChild(toast);
        setTimeout(() => toast.remove(), 4000);
    });
</script>
    <?php exit(); endif; ?>
<?php
$invoiceData = $invoiceDetails['invoice'] ?? [];
$currency = $invoiceDetails['invoice']['currency'] ?? "";
$currency = [
    'USD' => '$',
    'GBP' => '£',
    'AUD' => 'A$',
    'CAD' => 'C$'
][$currency] ?? '';
$amount = number_format($invoiceData['amount'] ?? 0, 2);
$taxable = $invoiceData['taxable'] ?? 0;
$tax_type = $invoiceData['tax_type'] == 'percentage' ? '%' : ($invoiceData['tax_type'] == 'fixed' ? $currency : '');
$tax_value = $invoiceData['tax_value'] ?? 0;
$tax_amount = number_format($invoiceData['tax_amount'] ?? 0, 2);
$total_amount = number_format($invoiceData['total_amount'] ?? 0, 2);
$description = htmlspecialchars($invoiceData['description'] ?? 'N/A', ENT_QUOTES, 'UTF-8');
$status = $invoiceData['status'] ?? 0;
$dueDate = (new DateTime($invoiceData['due_date'] ?? 'now'))->format('Y-m-d');
$currentDate = (new DateTime())->format('Y-m-d');
$brandData = $invoiceData['brand'] ?? [];
$countries = ['US' => 'United States', 'AF' => 'Afghanistan', 'AL' => 'Albania', 'DZ' => 'Algeria', 'AS' => 'American Samoa', 'AD' => 'Andorra', 'AO' => 'Angola', 'AI' => 'Anguilla', 'AG' => 'Antigua and Barbuda', 'AR' => 'Argentina', 'AM' => 'Armenia', 'AW' => 'Aruba', 'AU' => 'Australia', 'AT' => 'Austria', 'AZ' => 'Azerbaijan', 'BS' => 'Bahamas', 'BH' => 'Bahrain', 'BD' => 'Bangladesh', 'BB' => 'Barbados', 'BY' => 'Belarus', 'BE' => 'Belgium', 'BZ' => 'Belize', 'BJ' => 'Benin', 'BM' => 'Bermuda', 'BT' => 'Bhutan', 'BO' => 'Bolivia', 'BA' => 'Bosnia and Herzegovina', 'BW' => 'Botswana', 'BR' => 'Brazil', 'BN' => 'Brunei', 'BG' => 'Bulgaria', 'BF' => 'Burkina Faso', 'BI' => 'Burundi', 'CV' => 'Cabo Verde', 'KH' => 'Cambodia', 'CM' => 'Cameroon', 'CA' => 'Canada', 'KY' => 'Cayman Islands', 'CF' => 'Central African Republic', 'TD' => 'Chad', 'CL' => 'Chile', 'CN' => 'China', 'CO' => 'Colombia', 'KM' => 'Comoros', 'CG' => 'Congo', 'CD' => 'Congo (Democratic Republic)', 'CR' => 'Costa Rica', 'HR' => 'Croatia', 'CU' => 'Cuba', 'CY' => 'Cyprus', 'CZ' => 'Czech Republic', 'DK' => 'Denmark', 'DJ' => 'Djibouti', 'DM' => 'Dominica', 'DO' => 'Dominican Republic', 'EC' => 'Ecuador', 'EG' => 'Egypt', 'SV' => 'El Salvador', 'GQ' => 'Equatorial Guinea', 'ER' => 'Eritrea', 'EE' => 'Estonia', 'SZ' => 'Eswatini', 'ET' => 'Ethiopia', 'FJ' => 'Fiji', 'FI' => 'Finland', 'FR' => 'France', 'GA' => 'Gabon', 'GM' => 'Gambia', 'GE' => 'Georgia', 'DE' => 'Germany', 'GH' => 'Ghana', 'GR' => 'Greece', 'GD' => 'Grenada', 'GU' => 'Guam', 'GT' => 'Guatemala', 'GN' => 'Guinea', 'GW' => 'Guinea-Bissau', 'GY' => 'Guyana', 'HT' => 'Haiti', 'HN' => 'Honduras', 'HU' => 'Hungary', 'IS' => 'Iceland', 'IN' => 'India', 'ID' => 'Indonesia', 'IR' => 'Iran', 'IQ' => 'Iraq', 'IE' => 'Ireland', 'IL' => 'Israel', 'IT' => 'Italy', 'JM' => 'Jamaica', 'JP' => 'Japan', 'JO' => 'Jordan', 'KZ' => 'Kazakhstan', 'KE' => 'Kenya', 'KI' => 'Kiribati', 'KP' => 'North Korea', 'KR' => 'South Korea', 'KW' => 'Kuwait', 'KG' => 'Kyrgyzstan', 'LA' => 'Laos', 'LV' => 'Latvia', 'LB' => 'Lebanon', 'LS' => 'Lesotho', 'LR' => 'Liberia', 'LY' => 'Libya', 'LI' => 'Liechtenstein', 'LT' => 'Lithuania', 'LU' => 'Luxembourg', 'MG' => 'Madagascar', 'MW' => 'Malawi', 'MY' => 'Malaysia', 'MV' => 'Maldives', 'ML' => 'Mali', 'MT' => 'Malta', 'MH' => 'Marshall Islands', 'MR' => 'Mauritania', 'MU' => 'Mauritius', 'MX' => 'Mexico', 'FM' => 'Micronesia', 'MD' => 'Moldova', 'MC' => 'Monaco', 'MN' => 'Mongolia', 'ME' => 'Montenegro', 'MA' => 'Morocco', 'MZ' => 'Mozambique', 'MM' => 'Myanmar', 'NA' => 'Namibia', 'NR' => 'Nauru', 'NP' => 'Nepal', 'NL' => 'Netherlands', 'NZ' => 'New Zealand', 'NI' => 'Nicaragua', 'NE' => 'Niger', 'NG' => 'Nigeria', 'MK' => 'North Macedonia', 'NO' => 'Norway', 'OM' => 'Oman', 'PK' => 'Pakistan', 'PW' => 'Palau', 'PA' => 'Panama', 'PG' => 'Papua New Guinea', 'PY' => 'Paraguay', 'PE' => 'Peru', 'PH' => 'Philippines', 'PL' => 'Poland', 'PT' => 'Portugal', 'QA' => 'Qatar', 'RO' => 'Romania', 'RU' => 'Russia', 'RW' => 'Rwanda', 'WS' => 'Samoa', 'SM' => 'San Marino', 'SA' => 'Saudi Arabia', 'SN' => 'Senegal', 'RS' => 'Serbia', 'SC' => 'Seychelles', 'SL' => 'Sierra Leone', 'SG' => 'Singapore', 'SK' => 'Slovakia', 'SI' => 'Slovenia', 'SB' => 'Solomon Islands', 'SO' => 'Somalia', 'ZA' => 'South Africa', 'ES' => 'Spain', 'LK' => 'Sri Lanka', 'SD' => 'Sudan', 'SR' => 'Suriname', 'SE' => 'Sweden', 'CH' => 'Switzerland', 'SY' => 'Syria', 'TW' => 'Taiwan', 'TJ' => 'Tajikistan', 'TZ' => 'Tanzania', 'TH' => 'Thailand', 'TL' => 'Timor-Leste', 'TG' => 'Togo', 'TO' => 'Tonga', 'TT' => 'Trinidad and Tobago', 'TN' => 'Tunisia', 'TR' => 'Turkey', 'TM' => 'Turkmenistan', 'TV' => 'Tuvalu', 'UG' => 'Uganda', 'UA' => 'Ukraine', 'AE' => 'United Arab Emirates', 'GB' => 'United Kingdom', 'US' => 'United States', 'UY' => 'Uruguay', 'UZ' => 'Uzbekistan', 'VU' => 'Vanuatu', 'VA' => 'Vatican City', 'VE' => 'Venezuela', 'VN' => 'Vietnam', 'YE' => 'Yemen', 'ZM' => 'Zambia', 'ZW' => 'Zimbabwe'];
$payment_methods = $invoiceDetails['invoice']['payment_methods'] ?? [];
$non_bank_methods = array_filter($payment_methods, function ($method) {
    return $method !== "bank transfer";
});
if (!empty($non_bank_methods)) {
    $first_merchant = reset($non_bank_methods); // Get first non-bank method
} else if (in_array("bank transfer", $payment_methods)) {
    $first_merchant = "bank transfer";
} else {
    $first_merchant = "";
} ?>
<section class="invoice-template py-2">
    <div class="container-fluid">
        <div class="row first-row">
            <div class="col-md-12">
                <div class="icon">
                    <img src="{{asset('assets/images/other/printer-svgrepo-com.svg')}}" alt="" class="icon-i"
                         onclick="printDiv('invoice')">
                    <img src="{{asset('assets/images/other/down-line-svgrepo-com.svg')}}" alt="" class="icon-i2"
                         onclick="generatePDF()">
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class=" col-lg-6 col-12">

                <div class="box-shade ">
                    <div id="invoice">

                        <div class="invoice-info">
                            <div class="row align-items-end">
                                <div class="ribbon">
                                    <?php
                                    if ($status == 1) {
                                        echo '<div class="ribbon-inner ribbon-paid">Paid</div>';
                                    } elseif ($dueDate >= $currentDate) {
                                        echo '<div class="ribbon-inner ribbon-unpaid">Unpaid</div>';
                                    } else {
                                        echo '<div class="ribbon-inner ribbon-overdue">Overdue</div>';
                                    }
                                    ?>
                                </div>
                                <div class="col-md-6 col-4">
                                    <div class="brand-logo">
                                        <img
                                            src="<?= htmlspecialchars($brandData['logo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                            class="img-fluid images" alt="<?= $brandData['name'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-6 col-8 text-right ">
                                    <div class="invoice-detail">
                                        <h1>Invoice</h1>
                                        <h4>Invoice Number
                                            # <?= htmlspecialchars($invoiceData['invoice_number'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                                        <h4>Invoice Id
                                            # <?= htmlspecialchars($invoiceData['invoice_key'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                                        <?php
                                        if ($status != 1) {
                                            echo '<h5>Balance Due</h5>
                                        <h6>' . $currency . $total_amount . '</h6>';
                                        } else {
                                            echo '<h5>Invoice Paid</h5>';
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h2 class="brandname"><?= htmlspecialchars($brandData['name'] ?? '', ENT_QUOTES, 'UTF-8') ?></h2>
                                    <p><?= htmlspecialchars($brandData['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                    <p>
                                        Email: <?= htmlspecialchars($brandData['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                </div>
                                <!--                            <div class="col-md-6 text-right">-->
                                <!--                                <p>Invoice-->
                                <!--                                    Date: -->
                                <?php //= htmlspecialchars($invoiceData['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?><!--</p>-->
                                <!--                                <p>Due-->
                                <!--                                    Date: -->
                                <?php //= htmlspecialchars($invoiceData['due_date'] ?? '', ENT_QUOTES, 'UTF-8') ?><!--</p>-->
                                <!--                            </div>-->

                                <div
                                    class="col-md-6 <?= $invoiceDetails['invoice']['status'] == 1 ? '' : 'd-none' ?>"
                                    style="display: flex;justify-content: flex-end;">
                                    <img src="{{asset('assets/images/other/paid.png')}}" alt="" class="paid mr-5">
                                </div>
                            </div>
                            <div class="row align-items-end third-col mt-3">
                                <div class="col-md-6 containeree">
                                    <h5>Bill To,</h5>
                                    <div class="row">
                                        <div class="col-md-3 col-4">
                                            <div class="para-1">
                                                <p>name:</p>
                                                <p>email: </p>
                                                <p>phone:</p>
                                                <!-- <p>address:</p>
                                                <p>country:</p> -->

                                            </div>
                                        </div>

                                        <div class="col-md-9 col-8">
                                            <div class="para-2">
                                                <p> <?= $invoiceDetails['invoice']['customer']['name'] ?? '' ?></p>
                                                <p> <?= $invoiceDetails['invoice']['customer']['email'] ?? '' ?></p>
                                                <p> <?= $invoiceDetails['invoice']['customer']['phone'] ?? '' ?></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 invoice-balance-text">
                                    <div class="row">
                                        <div class="col-md-5 col-4">
                                            <p><b>Invoice
                                                    Date:</b></p>
                                            <p><b>Due
                                                    Date:</b></p>
                                        </div>

                                        <div class="col-md-7 col-8">

                                            <p> <?= htmlspecialchars($invoiceData['created_at'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                                            <p> <?= htmlspecialchars($invoiceData['due_date'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>

                                        </div>


                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab">
                            <div class="row ">
                                <div class="col-md-12 ">
                                    <div class="table-responsive">
                                        <table class="table custom-invoice-table">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" class="roww">#</th>
                                                <th scope="col col-width-1">Description</th>
                                                <th scope="col col-width-2"></th>
                                                <th scope="col col-width-2"></th>
                                                <th scope="col">Amount</th>


                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td class=""><?= $description ?></td>
                                                <td class=""></td>
                                                <td class=""></td>
                                                <td class=" amount"><?= $currency . $amount ?></td>
                                                <!-- <td class="col-width-1"><?= $description ?></td>
                                        <td class="col-width-2"></td>
                                        <td class="col-width-2"></td>
                                        <td class="col-width-1 amount"><?= $currency . $amount ?></td> -->

                                            </tr>
                                            <!-- Tax Amount -->
                                            <tr>
                                                <th scope="row" class="roww"></th>
                                                <td class="roww"></td>
                                                <td class="roww"></td>
                                                <td class="roww">Tax :
                                                    &nbsp;<?= $taxable ? ($tax_type . $tax_value) : "" ?></td>
                                                <td class="roww amount"><?= $currency . $tax_amount ?></td>
                                            </tr>
                                            <!-- Tax Amount-->

                                            <!-- Subtotal Row -->
                                            <tr>
                                                <th scope="row" class="roww"></th>
                                                <td class="roww"></td>
                                                <td class="roww"></td>
                                                <td class="roww">Sub total</td>
                                                <td class="roww amount"><?= $currency . $amount ?></td>
                                            </tr>

                                            <tr>
                                                <th scope="row" class="roww"></th>
                                                <td class="roww"></td>
                                                <td class="roww"></td>
                                                <td class="td" class="roww"><b>total</b></td>
                                                <td class="td amount" class="roww">
                                                    <b><?= $currency . $total_amount ?></b></td>
                                            </tr>
                                            <tr>
                                                <th scope="row"></th>
                                                <td></td>
                                                <td id="td"></td>
                                                <td id="td"><b>Balance Due</b></td>
                                                <td class="td amount" id="td">
                                                    <b><?= $currency . ($status != 1 ? $total_amount : "0.00") ?></b>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-end">
                            <p>Thanks for your business.</p>
                        </div>

                    </div>
                </div>
            </div>
            <div
                class="col-lg-6 col-12 <?= $invoiceDetails['invoice']['status'] == 1 ? 'd-none' : '' ?> <?= isset($invoiceDetails['invoice']['payment_methods']) && count($invoiceDetails['invoice']['payment_methods']) > 0 ? '' : '' ?>">
                <div class="box-shade-2">
                    <div class="row">
                        <div class="col-md-3 side-bar-1">
                            <div class="nav justify-content-left nav-pills side-bar" id="v-pills-tab" role="tablist"
                                 aria-orientation="vertical">

                                <!-- Credit Card Tab -->
                                @if (in_array('authorize', $invoiceDetails['invoice']['payment_methods']))
                                    <button
                                        class="nav-link side-bar-btns  {{$first_merchant == "authorize" ? 'active' : ""}}"
                                        id="v-pills-credit-card-tab"
                                        data-toggle="pill"
                                        data-target="#v-pills-credit-card" type="button" role="tab"
                                        aria-controls="v-pills-credit-card"
                                        aria-selected="false">Credit Card
                                    </button>
                                @endif

                                <!-- EDP Tab -->
                                @if (in_array('edp', $invoiceDetails['invoice']['payment_methods']))
                                    <button
                                        class="nav-link side-bar-btns {{$first_merchant == "edp" ? 'active' : ""}}"
                                        id="v-pills-edp-tab"
                                        data-toggle="pill"
                                        data-target="#v-pills-edp" type="button" role="tab"
                                        aria-controls="v-pills-edp"
                                        aria-selected="false">{{$first_merchant == "edp" ? "Credit Card" : 'EDP'}}
                                    </button>
                                @endif

                                <!-- PayPal Tab -->
                                @if (in_array('paypal', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['payment_method_keys']['paypal']) && !empty($invoiceDetails['invoice']['payment_method_keys']['paypal']))
                                    <button
                                        class="nav-link side-bar-btns {{$first_merchant == "paypal" ? 'active' : ""}}"
                                        id="v-pills-paypal-tab" data-toggle="pill"
                                        data-target="#v-pills-paypal" type="button" role="tab"
                                        aria-controls="v-pills-paypal"
                                        aria-selected="true">Paypal
                                    </button>
                                @endif

                                <!-- Stripe Tab -->
                                @if (in_array('stripe', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['payment_method_keys']['stripe']) && !empty($invoiceDetails['invoice']['payment_method_keys']['stripe']))
                                    <button
                                        class="nav-link side-bar-btns {{$first_merchant == "stripe" ? 'active' : ""}}"
                                        id="v-pills-stripe-tab" data-toggle="pill"
                                        data-target="#v-pills-stripe" type="button" role="tab"
                                        aria-controls="v-pills-stripe"
                                        aria-selected="false">Stripe
                                    </button>
                                @endif

                                <!-- Bank Transfer Tab -->
                                @if (in_array('bank transfer', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['bank_details']) && !empty($invoiceDetails['invoice']['bank_details']) )
                                    <button
                                        class="nav-link side-bar-btns {{$first_merchant == "bank transfer" ? 'active' : ""}}"
                                        id="v-pills-bank-transfer-tab" data-toggle="pill"
                                        data-target="#v-pills-bank-transfer" type="button" role="tab"
                                        aria-controls="v-pills-bank-transfer"
                                        aria-selected="true">Bank Transfer
                                    </button>
                                @endif
                                @php
                                    $hasOnlyBankTransfer = isset($payment_methods) && count($payment_methods) === 1 && in_array('bank transfer', $payment_methods);
                                @endphp
                                <!-- Upload Receipt Tab -->
                                @if(!$hasOnlyBankTransfer)
                                    <button
                                        class="nav-link side-bar-btns  {{!isset($invoiceDetails['invoice']['payment_methods']) || count($invoiceDetails['invoice']['payment_methods']) < 1 ? 'active' : '' }}"
                                        id="v-pills-upload-attachment-tab" data-toggle="pill"
                                        data-target="#v-pills-upload-attachment" type="button" role="tab"
                                        aria-controls="v-pills-upload-attachment"
                                        aria-selected="true"><i class="fa-solid fa-upload mr-2"></i> Add Receipt
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="tab-content" id="v-pills-tabContent">

                                <!-- Credit Card Tab -->
                                <div class="tab-pane fade {{$first_merchant == "authorize" ? 'show active' : ""}}"
                                     id="v-pills-credit-card" role="tabpanel"
                                     aria-labelledby="v-pills-credit-card-tab">
                                    <div class="form-txt" id="form-txt-1">
                                        <h1>Card Details</h1>
                                    </div>
                                    <form id="paymentForm-credit_card" class="paymentForm"
                                          action="{{route('api.authorize.process-payment')}}">
                                        @csrf
                                        <input type="hidden" name="invoice_number"
                                               value="{{$invoiceData['invoice_key']}}">
                                        <!-- Card Number -->
                                        <div class="form-group">
                                            <label for="card_number-credit_card">Card number</label>
                                            <input type="text" class="form-control" id="card_number-credit_card"
                                                   name="card_number"
                                                   placeholder="1234-1234-1234-1234" maxlength="19"
                                                   autocomplete="false">
                                            <span id="card_type_logo-credit_card" class="cctype"></span>
                                            <small id="card_number-credit_card_error" class="text-danger"></small>
                                        </div>
                                        <!-- CVV and Expiry -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="expiry_month-credit_card">Expires on</label>
                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <select class="form-control"
                                                                        id="expiry_month-credit_card"
                                                                        name="expiry_month">
                                                                    <option value="" disabled>MM</option>
                                                                    <option value="01">01</option>
                                                                    <option value="02">02</option>
                                                                    <option value="03">03</option>
                                                                    <option value="04">04</option>
                                                                    <option value="05">05</option>
                                                                    <option value="06">06</option>
                                                                    <option value="07">07</option>
                                                                    <option value="08">08</option>
                                                                    <option value="09">09</option>
                                                                    <option value="10">10</option>
                                                                    <option value="11">11</option>
                                                                    <option value="12" selected>12</option>
                                                                </select>
                                                                <small id="expiry_month-credit_card_error"
                                                                       class="text-danger"></small>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select class="form-control"
                                                                        id="expiry_year-credit_card"
                                                                        name="expiry_year">
                                                                    <option value="" disabled>YYYY</option>
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            var select = document.getElementById('expiry_year-credit_card');
                                                                            var currentYear = new Date().getFullYear();

                                                                            for (var i = 0; i < 31; i++) {
                                                                                var option = document.createElement('option');
                                                                                option.value = currentYear + i;
                                                                                option.text = currentYear + i;
                                                                                select.appendChild(option);
                                                                            }
                                                                        });
                                                                    </script>
                                                                </select>
                                                                <small id="expiry_year-credit_card_error"
                                                                       class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <small id="expiry-credit_card_error"
                                                                       class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cvv-credit_card">CVV</label>
                                                <input type="password" class="form-control" id="cvv-credit_card"
                                                       name="cvv"
                                                       placeholder="CVC" maxlength="4" autocomplete="false">
                                                <small id="cvv-credit_card_error" class="text-danger"></small>
                                            </div>
                                        </div>
                                        <!-- First Name and Last Name -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name-credit_card">First Name</label>
                                                <input type="text" class="form-control" id="first_name-credit_card"
                                                       name="first_name" placeholder="First Name" autocomplete="false">
                                                <small id="first_name-credit_card_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name-credit_card">Last Name</label>
                                                <input type="text" class="form-control" id="last_name-credit_card"
                                                       name="last_name" placeholder="Last Name" autocomplete="false">
                                                <small id="last_name-credit_card_error" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Billing Address -->
                                        <div class="form-txt">
                                            <h1>Billing address</h1>
                                            <p>the billing address entered here must match the billing address of card
                                                holder.</p>
                                        </div>

                                        <!-- Email and Phone -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="email-credit_card">Email Address</label>
                                                <input type="email" class="form-control" id="email-credit_card"
                                                       name="email"
                                                       placeholder="Email Address" autocomplete="false">
                                                <small id="email-credit_card_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone-credit_card">Phone Number</label>
                                                <input type="text" class="form-control" id="phone-credit_card"
                                                       name="phone"
                                                       placeholder="Phone Number" autocomplete="false">
                                                <small id="phone-credit_card_error" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="address-credit_card">Street Address</label>
                                            <input type="text" class="form-control" id="address-credit_card"
                                                   name="address"
                                                   placeholder="Street Address" autocomplete="false">
                                            <small id="address-credit_card_error" class="text-danger"></small>
                                        </div>

                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city-credit_card">City</label>
                                                    <input type="text" class="form-control" id="city-credit_card"
                                                           name="city"
                                                           placeholder="City" autocomplete="false">
                                                    <small id="city-credit_card_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state-credit_card">State</label>
                                                    <input type="text" class="form-control" id="state-credit_card"
                                                           name="state"
                                                           placeholder="State" autocomplete="false">
                                                    <small id="state-credit_card_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="zipcode-credit_card">Postal Code</label>
                                                    <input type="text" class="form-control" id="zipcode-credit_card"
                                                           name="zipcode"
                                                           placeholder="Postal Code" autocomplete="false">
                                                    <small id="zipcode-credit_card_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="country-credit_card">Country</label>
                                                    <select id="country-credit_card" name="country" class="form-control"
                                                            autocomplete="false">
                                                        @foreach ($countries as $code => $country)
                                                            <option
                                                                value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($country) ?></option>
                                                        @endforeach
                                                    </select>
                                                    <small id="country-credit_card_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="payment-btn-wrapper">
                                            <button type="submit" id="submit-btn-credit_card"
                                                    class="btn btn-primary make-payment-btn">Pay
                                                Now {{$currency . $total_amount}}
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- EDP Tab -->
                                <div class="tab-pane fade {{$first_merchant == "edp" ? 'show active' : ""}}"
                                     id="v-pills-edp" role="tabpanel"
                                     aria-labelledby="v-pills-edp-tab">
                                    <div class="form-txt" id="">
                                        <h1>Card Details</h1>
                                    </div>
                                    <form id="paymentForm-edp" class="paymentForm"
                                          action="{{route('api.secure.process-payment')}}">
                                        @csrf
                                        <input type="hidden" name="invoice_number"
                                               value="{{$invoiceData['invoice_key']}}">

                                        <!-- Card Number -->
                                        <div class="form-group">
                                            <label for="card_number-edp">Card number</label>
                                            <input type="text" class="form-control" id="card_number-edp"
                                                   name="card_number"
                                                   placeholder="1234-1234-1234-1234" maxlength="19"
                                                   autocomplete="false">
                                            <span id="card_type_logo-edp" class="cctype"></span>
                                            <small id="card_number-edp_error" class="text-danger"></small>
                                        </div>

                                        <!-- CVV and Expiry -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="expiry_month-edp">Expires on</label>
                                                <div class="form-row">
                                                    <div class="col-md-12">
                                                        <div class="form-row">
                                                            <div class="col-md-6">
                                                                <select class="form-control" id="expiry_month-edp"
                                                                        name="expiry_month">
                                                                    <option value="" disabled>MM</option>
                                                                    <option value="01">01</option>
                                                                    <option value="02">02</option>
                                                                    <option value="03">03</option>
                                                                    <option value="04">04</option>
                                                                    <option value="05">05</option>
                                                                    <option value="06">06</option>
                                                                    <option value="07">07</option>
                                                                    <option value="08">08</option>
                                                                    <option value="09">09</option>
                                                                    <option value="10">10</option>
                                                                    <option value="11">11</option>
                                                                    <option value="12" selected>12</option>
                                                                </select>
                                                                <small id="expiry_month-edp_error"
                                                                       class="text-danger"></small>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select class="form-control" id="expiry_year-edp"
                                                                        name="expiry_year">
                                                                    <option value="" disabled>YYYY</option>
                                                                    <script>
                                                                        document.addEventListener('DOMContentLoaded', function () {
                                                                            var select = document.getElementById('expiry_year-edp');
                                                                            var currentYear = new Date().getFullYear();

                                                                            for (var i = 0; i < 31; i++) {
                                                                                var option = document.createElement('option');
                                                                                option.value = currentYear + i;
                                                                                option.text = currentYear + i;
                                                                                select.appendChild(option);
                                                                            }
                                                                        });
                                                                    </script>
                                                                </select>
                                                                <small id="expiry_year-edp_error"
                                                                       class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <small id="expiry-edp_error"
                                                                       class="text-danger"></small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="cvv-edp">CVV</label>
                                                <input type="password" class="form-control" id="cvv-edp" name="cvv"
                                                       placeholder="CVC" maxlength="4" autocomplete="false">
                                                <small id="cvv-edp_error" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- First Name and Last Name -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name-edp">First Name</label>
                                                <input type="text" class="form-control" id="first_name-edp"
                                                       name="first_name" placeholder="First Name" autocomplete="false">
                                                <small id="first_name-edp_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name-edp">Last Name</label>
                                                <input type="text" class="form-control" id="last_name-edp"
                                                       name="last_name" placeholder="Last Name" autocomplete="false">
                                                <small id="last_name-edp_error" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Billing Address -->
                                        <div class="form-txt">
                                            <h1>Billing address</h1>
                                            <p>the billing address entered here must match the billing address of card
                                                holder.</p>
                                        </div>
                                        <!-- Email and Phone -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="email-edp">Email Address</label>
                                                <input type="email" class="form-control" id="email-edp" name="email"
                                                       placeholder="Email Address" autocomplete="false">
                                                <small id="email-edp_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone-edp">Phone Number</label>
                                                <input type="text" class="form-control" id="phone-edp" name="phone"
                                                       placeholder="Phone Number" autocomplete="false">
                                                <small id="phone-edp_error" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Billing Address -->
                                        <div class="form-group">
                                            <label for="address-edp">Street Address</label>
                                            <input type="text" class="form-control" id="address-edp" name="address"
                                                   placeholder="Street Address" autocomplete="false">
                                            <small id="address-edp_error" class="text-danger"></small>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city-edp">City</label>
                                                    <input type="text" class="form-control" id="city-edp" name="city"
                                                           placeholder="City" autocomplete="false">
                                                    <small id="city-edp_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state-edp">State</label>
                                                    <input type="text" class="form-control" id="state-edp" name="state"
                                                           placeholder="State" autocomplete="false">
                                                    <small id="state-edp_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="zipcode-edp">Postal Code</label>
                                                    <input type="text" class="form-control" id="zipcode-edp"
                                                           name="zipcode"
                                                           placeholder="Postal Code" autocomplete="false">
                                                    <small id="zipcode-edp_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="country-edp">Country</label>
                                                    <select id="country-edp" name="country" class="form-control"
                                                            autocomplete="false">
                                                        @foreach ($countries as $code => $country)
                                                            <option
                                                                value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($country) ?></option>
                                                        @endforeach
                                                    </select>
                                                    <small id="country-edp_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Shipping Information -->
                                        <div class="shiping-form mt-4">
                                            <input type="checkbox" id="shipping-edp" name="shipping" checked/>
                                            <label for="shipping-edp"><p>Shipping information is the same as
                                                    billing</p></label>
                                        </div>

                                        <!-- Shipping Address Fields (Hidden by Default) -->
                                        <div class="shipping-fields" style="display: none;">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingName-edp">Shipping First Name</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingName-edp"
                                                               placeholder="Shipping First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippinglastName-edp">Shipping Last Name</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippinglastName-edp"
                                                               placeholder="Shipping Last Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingNumber-edp">Shipping Phone
                                                            Number</label>
                                                        <input type="number" class="form-control form-input-fields"
                                                               id="shippingNumber-edp"
                                                               placeholder="Shipping Phone Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingAddress-edp">Shipping Street
                                                            Address</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingAddress-edp"
                                                               placeholder="Shipping Street Address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingCity-edp">Shipping City</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingCity-edp" placeholder="Shipping City">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingState-edp">Shipping State</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingState-edp" placeholder="Shipping State">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingCode-edp">Shipping Postal Code</label>
                                                        <input type="number" class="form-control form-input-fields"
                                                               id="shippingCode-edp"
                                                               placeholder="Shipping Postal Code">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingStatetwo-edp">Country</label>
                                                        <select id="shippingStatetwo-edp"
                                                                class="form-control form-input-fields">
                                                            @foreach ($countries as $code => $country)
                                                                <option
                                                                    value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($country) ?></option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="payment-btn-wrapper">
                                            <button type="submit" id="submit-btn-edp"
                                                    class="btn btn-primary make-payment-btn">Pay
                                                Now {{$currency . $total_amount}}
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- PayPal Tab -->
                                <div
                                    class="tab-pane fade {{in_array('paypal', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['payment_method_keys']['paypal']) && !empty($invoiceDetails['invoice']['payment_method_keys']['paypal']) && $first_merchant == "paypal" ? 'show active' : ""}}"
                                    id="v-pills-paypal" role="tabpanel"
                                    aria-labelledby="v-pills-paypal-tab">
                                    <div class="sec-btn"
                                         style="display: flex;justify-content: center;min-height:215px;">
                                        <div id="paypal-button-container" style="width: 80%;"></div>
                                        <form id="paymentForm-paypal" class="paypalPaymentForm">
                                        </form>
                                    </div>
                                </div>

                                <!-- Stripe Tab -->
                                <div
                                    class="tab-pane fade {{in_array('stripe', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['payment_method_keys']['stripe']) && !empty($invoiceDetails['invoice']['payment_method_keys']['stripe']) && $first_merchant == "stripe" ? 'show active' : ""}}"
                                    id="v-pills-stripe" role="tabpanel"
                                    aria-labelledby="v-pills-stripe-tab">
                                    <div class="form-txt" id="">
                                        <h1>Card Details</h1>
                                    </div>

                                    <form id="paymentForm-stripe" class="stripePaymentForm  paymentForm"
                                          action="{{route('api.stripe.process-payment')}}">
                                        @csrf
                                        <input type="hidden" name="invoice_number"
                                               value="{{$invoiceData['invoice_key']}}">
                                        <div class="form-group">
                                            <label>Card Details</label>
                                            <div id="card-stripe" class="form-control"></div>
                                            <small id="card-stripe_error" class="text-danger"></small>
                                        </div>

                                        <!-- First Name and Last Name -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name-stripe">First Name</label>
                                                <input type="text" class="form-control" id="first_name-stripe"
                                                       name="first_name" placeholder="First Name" autocomplete="false">
                                                <small id="first_name-stripe_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name-stripe">Last Name</label>
                                                <input type="text" class="form-control" id="last_name-stripe"
                                                       name="last_name" placeholder="Last Name" autocomplete="false">
                                                <small id="last_name-stripe_error" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Billing Address -->
                                        <div class="form-txt">
                                            <h1>Billing address</h1>
                                            <p>the billing address entered here must match the billing address of card
                                                holder.</p>
                                        </div>
                                        <!-- Email and Phone -->
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="email-stripe">Email Address</label>
                                                <input type="email" class="form-control" id="email-stripe" name="email"
                                                       placeholder="Email Address" autocomplete="false">
                                                <small id="email-stripe_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="phone-stripe">Phone Number</label>
                                                <input type="text" class="form-control" id="phone-stripe" name="phone"
                                                       placeholder="Phone Number" autocomplete="false">
                                                <small id="phone-stripe_error" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <!-- Billing Address -->
                                        <div class="form-group">
                                            <label for="address-stripe">Street Address</label>
                                            <input type="text" class="form-control" id="address-stripe" name="address"
                                                   placeholder="Street Address" autocomplete="false">
                                            <small id="address-stripe_error" class="text-danger"></small>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city-stripe">City</label>
                                                    <input type="text" class="form-control" id="city-stripe" name="city"
                                                           placeholder="City" autocomplete="false">
                                                    <small id="city-stripe_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="state-stripe">State</label>
                                                    <input type="text" class="form-control" id="state-stripe"
                                                           name="state"
                                                           placeholder="State" autocomplete="false">
                                                    <small id="state-stripe_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="zipcode-stripe">Postal Code</label>
                                                    <input type="text" class="form-control" id="zipcode-stripe"
                                                           name="zipcode"
                                                           placeholder="Postal Code" autocomplete="false">
                                                    <small id="zipcode-stripe_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-2">
                                                    <label for="country-stripe">Country</label>
                                                    <select id="country-stripe" name="country" class="form-control"
                                                            autocomplete="false">
                                                        @foreach ($countries as $code => $country)
                                                            <option
                                                                value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($country) ?></option>
                                                        @endforeach
                                                    </select>
                                                    <small id="country-stripe_error" class="text-danger"></small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Shipping Information -->
                                        {{--                                        <div class="shiping-form mt-4">--}}
                                        {{--                                            <input type="checkbox" id="shipping-stripe" name="shipping" checked/>--}}
                                        {{--                                            <label for="shipping-stripe"><p>Shipping information is the same as--}}
                                        {{--                                                    billing</p></label>--}}
                                        {{--                                        </div>--}}

                                        <!-- Shipping Address Fields (Hidden by Default) -->
                                        <div class="shipping-fields" style="display: none;">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingName-stripe">Shipping First Name</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingName-stripe"
                                                               placeholder="Shipping First Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippinglastName-stripe">Shipping Last Name</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippinglastName-stripe"
                                                               placeholder="Shipping Last Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingNumber-stripe">Shipping Phone
                                                            Number</label>
                                                        <input type="number" class="form-control form-input-fields"
                                                               id="shippingNumber-stripe"
                                                               placeholder="Shipping Phone Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingAddress-stripe">Shipping Street
                                                            Address</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingAddress-stripe"
                                                               placeholder="Shipping Street Address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingCity-stripe">Shipping City</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingCity-stripe" placeholder="Shipping City">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingState-stripe">Shipping State</label>
                                                        <input type="text" class="form-control form-input-fields"
                                                               id="shippingState-stripe" placeholder="Shipping State">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingCode-stripe">Shipping Postal Code</label>
                                                        <input type="number" class="form-control form-input-fields"
                                                               id="shippingCode-stripe"
                                                               placeholder="Shipping Postal Code">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label for="shippingStatetwo-stripe">Country</label>
                                                        <select id="shippingStatetwo-stripe"
                                                                class="form-control form-input-fields">
                                                            @foreach ($countries as $code => $country)
                                                                <option
                                                                    value="<?= htmlspecialchars($code) ?>"><?= htmlspecialchars($country) ?></option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="payment-btn-wrapper">
                                            <button type="submit" id="submit-btn-stripe"
                                                    class="btn btn-primary make-payment-btn">
                                                <span
                                                    id="stripe-button-text">PAY NOW {{$currency . $total_amount}}</span>
                                                <span id="stripe-btn-spinner"
                                                      class="spinner-border spinner-border-sm d-none"
                                                      role="status"></span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Bank Transfer Tab -->
                                @if (in_array('bank transfer', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['bank_details']) && !empty($invoiceDetails['invoice']['bank_details']) )
                                    <div
                                        class="tab-pane fade {{in_array('bank transfer', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['bank_details']) && !empty($invoiceDetails['invoice']['bank_details']) && $first_merchant == "bank transfer" ? 'show active' : ""}}"
                                        id="v-pills-bank-transfer" role="tabpanel"
                                        aria-labelledby="v-pills-bank-transfer-tab">
                                        <div class="" style="min-height:250px;">
                                            <div class="form-txt top-bar">
                                                <h1>Bank Transfer</h1>
                                                <i class="fa-regular fa-copy copy-all-btn"
                                                   onclick="copyAllToClipboard(this)"><span> Copy All </span></i>
                                            </div>
                                            <div
                                                style="font-size: 14px;margin: 5px;padding: 5px 0px 0px 5px;font-style: italic;font-weight: 400;color: #3C3D3A;">
                                                <div class="bank-details-container">
                                                    @php
                                                        $lines = explode("\n", $invoiceDetails['invoice']['bank_details']);
                                                    @endphp
                                                    @foreach($lines as $line)
                                                        <div class="copy-line">
                                                            <span class="line-text">{{ $line }}</span>
                                                            <i class="fa-regular fa-copy copy-btn"
                                                               onclick="copyToClipboard(this)"></i>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="payment-btn-wrapper">
                                                <button type="button" class="btn btn-primary"
                                                        onclick="document.getElementById('bd-att-sec').classList.remove('d-none'); this.classList.add('d-none');"
                                                        style="background-color: #343a40 !important;border: none !important;color: #fff !important;font-size: 14px !important;padding: 9px 13px !important;">
                                                    Add Receipt
                                                </button>
                                            </div>

                                            <div id="bd-att-sec" class="d-none" style="min-height:250px;padding: 0px 20px; line-height: 14px; font-size: 12px;">
                                                <div class="form-txt">
                                                    <h1>Upload Receipt</h1>
                                                    <p class="text-muted">Only upload payment-related files (PDF, JPG,
                                                        PNG). Max
                                                        size: 5MB.</p>
                                                </div>
                                                <form id="bankDetailsAttachmentForm" class="upload-attachment"
                                                      action="{{route('api.upload-payment-proof')}}"
                                                      enctype="multipart/form-data">
                                                    <div class="form-group">
                                                        <label for="bd-att-upload_attachment-email">Email Address:</label>
                                                        <input type="email" class="form-control"
                                                               id="bd-att-upload_attachment-email"
                                                               name="email" placeholder="test@example.com"
                                                               autocomplete="false"
                                                               required>
                                                        <small id="email-upload_attachment_error"
                                                               class="text-danger"></small>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="bd-att-upload_attachment-transaction_id">Transaction /
                                                            Reference
                                                            Id:</label>
                                                        <input type="text" class="form-control"
                                                               id="bd-att-upload_attachment-transaction_id"
                                                               name="transaction_id" placeholder="12345678910"
                                                               autocomplete="false" required>
                                                        <small id="transaction_id-upload_attachment_error"
                                                               class="text-danger"></small>
                                                    </div>
                                                    @if(isset($payment_methods) && !empty($payment_methods))
                                                        <div class="form-group">
                                                            <label for="bd-att-upload_attachment-payment_method">Payment
                                                                Method:</label>
                                                            <select class="form-control"
                                                                    id="bd-att-upload_attachment-payment_method"
                                                                    name="payment_method" required>
                                                                @foreach($payment_methods as $pm_key=> $payment_method)
                                                                    <option value="{{$payment_method}}"
                                                                    @if(in_array('bank transfer', $payment_methods))
                                                                        {{ $payment_method == 'bank transfer' ? 'selected' : '' }}
                                                                        @else
                                                                        {{ $pm_key == 0 ? 'selected' : '' }}
                                                                        @endif
                                                                    >{{ucwords($payment_method)}}</option>
                                                                @endforeach
                                                            </select>
                                                            <small id="bd-att-payment_method-upload_attachment_error"
                                                                   class="text-danger"></small>
                                                        </div>
                                                    @endif
                                                    <div class="form-group">
                                                        <label for="bd-att-upload_attachment-file">Attachment:</label>
                                                        <input type="file" id="bd-att-upload_attachment-file"
                                                               class="form-control"
                                                               name="file"
                                                               style="height: calc(1.5em + .75rem + 6px);"
                                                               accept=".pdf,.jpg,.jpeg,.png" multiple required/>
                                                        <div class="form-text mt-2 ml-2" style="font-size: 14px;">
                                                            Allowed:
                                                            Receipts, Invoices, or Payment proof.
                                                        </div>
                                                        <small id="bd-att-file-upload_attachment_error"
                                                               class="text-danger"></small>
                                                    </div>
                                                    <div class="form-check mb-2 ml-2">
                                                        <input type="checkbox" class="form-check-input"
                                                               id="bd-att-confirmLegal"
                                                               required/>
                                                        <label class="form-check-label" for="bd-att-confirmLegal"
                                                               style="font-size: 14px;">
                                                            I confirm this file is related to my payment.
                                                        </label>
                                                    </div>
                                                    <!-- Submit Button -->
                                                    <div class="payment-btn-wrapper">
                                                        <button type="submit" id="uploadBtnBdAtt"
                                                                class="btn btn-primary"
                                                                style="background-color: #343a40 !important;border: none !important;color: #fff !important;font-size: 14px !important;padding: 9px 13px !important;">
                                                            Submit Receipt
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div id="bankDetailsUploadStatus" class="mt-3"></div>
                                        </div>
                                    </div>
                                @endif


                                <!-- Upload Receipt Tab -->
                                <div
                                    class="tab-pane fade {{!isset($invoiceDetails['invoice']['payment_methods']) || count($invoiceDetails['invoice']['payment_methods']) < 1 ? 'show active' : '' }}"
                                    id="v-pills-upload-attachment" role="tabpanel"
                                    aria-labelledby="v-pills-upload-attachment-tab">
                                    <div class="" style="min-height:250px;">
                                        <div class="form-txt">
                                            <h1>Upload Receipt</h1>
                                            <p class="text-muted">Only upload payment-related files (PDF, JPG, PNG). Max
                                                size: 5MB.</p>
                                        </div>
                                        <form id="paymentForm-uploadAttachment" class="upload-attachment"
                                              action="{{route('api.upload-payment-proof')}}"
                                              enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="upload_attachment-email">Email Address:</label>
                                                <input type="email" class="form-control" id="upload_attachment-email"
                                                       name="email" placeholder="test@example.com" autocomplete="false"
                                                       required>
                                                <small id="email-upload_attachment_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-group">
                                                <label for="upload_attachment-transaction_id">Transaction / Reference
                                                    Id:</label>
                                                <input type="text" class="form-control"
                                                       id="upload_attachment-transaction_id"
                                                       name="transaction_id" placeholder="12345678910"
                                                       autocomplete="false" required>
                                                <small id="transaction_id-upload_attachment_error"
                                                       class="text-danger"></small>
                                            </div>
                                            @if(isset($payment_methods) && !empty($payment_methods))
                                                <div class="form-group">
                                                    <label for="upload_attachment-payment_method">Payment
                                                        Method:</label>
                                                    <select class="form-control"
                                                            id="upload_attachment-payment_method"
                                                            name="payment_method" required>
                                                        @foreach($payment_methods as $pm_key=> $payment_method)
                                                            <option value="{{$payment_method}}"
                                                            @if(in_array('bank transfer', $payment_methods))
                                                                {{ $payment_method == 'bank transfer' ? 'selected' : '' }}
                                                                @else
                                                                {{ $pm_key == 0 ? 'selected' : '' }}
                                                                @endif
                                                            >{{ucwords($payment_method)}}</option>
                                                        @endforeach
                                                    </select>
                                                    <small id="payment_method-upload_attachment_error"
                                                           class="text-danger"></small>
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="upload_attachment-file">Attachment:</label>
                                                <input type="file" id="upload_attachment-file" class="form-control"
                                                       name="file"
                                                       style="height: calc(1.5em + .75rem + 6px);"
                                                       accept=".pdf,.jpg,.jpeg,.png" multiple required/>
                                                <div class="form-text mt-2 ml-2" style="font-size: 14px;">Allowed:
                                                    Receipts, Invoices, or Payment proof.
                                                </div>
                                                <small id="file-upload_attachment_error" class="text-danger"></small>
                                            </div>
                                            <div class="form-check mb-2 ml-2">
                                                <input type="checkbox" class="form-check-input" id="confirmLegal"
                                                       required/>
                                                <label class="form-check-label" for="confirmLegal"
                                                       style="font-size: 14px;">
                                                    I confirm this file is related to my payment.
                                                </label>
                                            </div>
                                            <!-- Submit Button -->
                                            <div class="payment-btn-wrapper">
                                                <button type="submit" id="uploadBtn" class="btn btn-primary"
                                                        style="background-color: #343a40 !important;border: none !important;color: #fff !important;font-size: 14px !important;padding: 9px 13px !important;">
                                                    Submit Receipt
                                                </button>
                                            </div>
                                            <div id="uploadStatus" class="mt-3"></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($invoiceDetails['invoice']['payment_methods']) && count($invoiceDetails['invoice']['payment_methods']) > 0)
            <!-- Payment methods are available -->
        @else
            <div class="d-flex justify-content-center mt-2">
                <div class="text-center">
                    <p>Please reach out to our sales support team for assistance, as no payment gateway is currently
                        available.</p>
                </div>
            </div>
        @endif
    </div>
</section>
<section class="thanks">
    <div class="container" style="min-width: 100%;">
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
                <!--                <h5>Lorem ipsum dolor sit <br> amet consectetur adipisicing elit.-->
                <!--                </h5>-->
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>
<script>
    function generatePDF() {
        const element = document.getElementById('invoice');
        html2pdf()
            .from(element)
            .save();
    }
    function printDiv(divName) {
        const printContents = document.getElementById(divName).innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
    function copyToClipboard(button) {
        const text = button.closest('.copy-line').querySelector('.line-text').innerText;
        navigator.clipboard.writeText(text).then(() => {
            button.classList.add('success');
            setTimeout(() => {
                button.classList.remove('success');
            }, 1500);
        });
    }

    function copyAllToClipboard(button) {
        let allText = '';
        document.querySelectorAll('.line-text').forEach(el => {
            allText += el.innerText + '\n';
        });
        navigator.clipboard.writeText(allText.trim()).then(() => {
            button.classList.add('success');
            setTimeout(() => {
                button.classList.remove('success');
            }, 1500);
        });
    }
    async function checkImageForNSFW(imgElement) {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = imgElement.width;
        canvas.height = imgElement.height;
        ctx.drawImage(imgElement, 0, 0);
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
        let skinPixelCount = 0;

        for (let i = 0; i < imageData.length; i += 4) {
            const [r, g, b] = imageData.slice(i, i + 3);
            if (r > 200 && g > 150 && b > 120 && r > g && r > b) {
                skinPixelCount++;
            }
        }
        const ratio = skinPixelCount / (canvas.width * canvas.height);
        return ratio > 0.3;
    }
    document.addEventListener('DOMContentLoaded', function () {
        const mainUploadForm = document.getElementById('paymentForm-uploadAttachment');
        if (mainUploadForm) {
            mainUploadForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const uploadStatus = document.getElementById('uploadStatus');
                const uploadBtn = document.getElementById('uploadBtn');
                handleAttachmentFormSubmit(mainUploadForm, uploadStatus, uploadBtn);
            });
        }

        const bankDetailsForm = document.getElementById('bankDetailsAttachmentForm');
        if (bankDetailsForm) {
            bankDetailsForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const uploadStatus = document.getElementById('bankDetailsUploadStatus');
                const uploadBtn = document.getElementById('uploadBtnBdAtt');
                handleAttachmentFormSubmit(bankDetailsForm, uploadStatus, uploadBtn);
            });
        }
    });
    async function handleAttachmentFormSubmit(form, uploadStatusElement, uploadButton) {
        const files = form.querySelector('input[type="file"]').files;
        uploadStatusElement.innerHTML = '';
        uploadButton.disabled = true;

        if (files.length === 0) {
            uploadStatusElement.innerHTML = '<div class="alert alert-danger">Please select at least one file.</div>';
            uploadButton.disabled = false;
            return;
        }

        const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        const maxSize = 10 * 1024 * 1024; // 10MB

        for (const file of files) {
            if (!allowedTypes.includes(file.type)) {
                uploadStatusElement.innerHTML = `<div class="alert alert-danger">Invalid file type (${file.name}). Only PDF/JPG/PNG allowed.</div>`;
                uploadButton.disabled = false;
                return;
            }

            if (file.size > maxSize) {
                uploadStatusElement.innerHTML = `<div class="alert alert-danger">File too large (${file.name}). Max 10MB allowed.</div>`;
                uploadButton.disabled = false;
                return;
            }
        }

        uploadStatusElement.innerHTML = '<div class="alert alert-info">Scanning files for security...</div>';

        try {
            for (const file of files) {
                if (file.type.startsWith('image/')) {
                    await new Promise((resolve) => {
                        const img = new Image();
                        img.src = URL.createObjectURL(file);

                        img.onload = async () => {
                            const isSuspicious = await checkImageForNSFW(img);
                            URL.revokeObjectURL(img.src);

                            if (isSuspicious) {
                                uploadStatusElement.innerHTML = `
                                <div class="alert alert-warning">
                                    <strong>Warning:</strong> Inappropriate content detected in ${file.name}.
                                </div>`;
                                throw new Error("NSFW content detected");
                            }
                            resolve();
                        };
                    });
                }
            }

            uploadStatusElement.innerHTML = '<div class="alert alert-info">Preparing upload...</div>';
            const formData = new FormData(form);
            formData.append('invoice_number', `{{ $invoiceData['invoice_key'] }}`);
            formData.delete('file');
            files.forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });

            const response = await fetch(form.action || '/api/upload-payment-proof', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();

            if (!response.ok || !result?.success) {
                uploadStatusElement.innerHTML = ``;
                if (result?.errors) {
                    if (Array.isArray(result.errors)) {
                        result.errors.forEach((error) => {
                            toastr.error(typeof error === 'string' ? error : JSON.stringify(error));
                        });
                    } else if (typeof result.errors === 'object') {
                        Object.entries(result.errors).forEach(([field, messages]) => {
                            const errorMessages = Array.isArray(messages) ? messages : [messages];
                            errorMessages.forEach(msg => {
                                toastr.error(msg);
                            });
                        });
                    }
                } else if (result?.error) {
                    toastr.error(result.error);
                } else if (result?.message) {
                    toastr.error(result.message);
                } else {
                    toastr.error('An unknown error occurred');
                }
                return;
            }

            if (result?.skipped_files && result.skipped_files.length > 0) {
                const skippedList = result.skipped_files.map(f => `<li>${f.name} (${Math.round(f.size / 1024)} KB)</li>`).join('');
                uploadStatusElement.innerHTML = `
                <div class="alert alert-warning mt-2">
                    <strong>Note:</strong> The following files were not uploaded due to attachment limits:
                    <ul>${skippedList}</ul><br>
                    Reference ID: ${result.reference_id || 'N/A'}
                </div>`;
            } else {
                uploadStatusElement.innerHTML = `
                <div class="alert alert-success">
                    All files and information submitted successfully!<br>
                    Reference ID: ${result.reference_id || 'N/A'}
                </div>`;
            }

            form.reset();
            if (form.id === 'bankDetailsAttachmentForm') {
                document.getElementById('bd-att-sec').classList.add('d-none');
                document.querySelector('#v-pills-bank-transfer .payment-btn-wrapper button').classList.remove('d-none');
            }

        } catch (error) {
            if (error.message === "NSFW content detected") {
            } else {
                let errorMessage = 'An unexpected error occurred';

                if (error.message.includes('Network Error') ||
                    error.message.includes('ECONNRESET') ||
                    error.message.includes('connection closed') ||
                    error.message.includes('Failed to fetch')) {
                    errorMessage = 'Network connection was interrupted. Please check your internet connection and try again.';
                } else if (error.message) {
                    errorMessage = error.message;
                }

                uploadStatusElement.innerHTML = `
            <div class="alert alert-danger">
                ${errorMessage}
            </div>`;
            }
        } finally {
            uploadButton.disabled = false;
        }
    }
    !function () {
        document.currentScript?.remove()
    }();
</script>

@if($status == 0)
    @if (in_array('paypal', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['payment_method_keys']['paypal']) && !empty($invoiceDetails['invoice']['payment_method_keys']['paypal']))
        <script>
            const paypal_script = document.createElement('script');
            paypal_script.src = `https://www.paypal.com/sdk/js?client-id={{$invoiceDetails['invoice']['payment_method_keys']['paypal']}}&currency={{$invoiceDetails['invoice']['currency'] ?? 'USD'}}&components=buttons,card-fields&disable-funding=venmo,paylater,card`;
            paypal_script.setAttribute("data-namespace", "paypal_sdk");
            paypal_script.onload = loadPaypalButtons;
            document.head.appendChild(paypal_script);

            function loadPaypalButtons() {
                const r = document.querySelector(".loader-container");
                const a = document.querySelector(".funny-message");
                const e = ["Counting coins...", "Bribing the bank manager...", "Convincing the payment gateway...",
                    "Training the payment pigeons...", "Negotiating with the money tree...",
                    "Polishing the credit card...", "Asking the ATM nicely...",
                    "Charging the payment lasers...", "Summoning the payment wizard...",
                    "Calming the angry payment gods..."];
                let t = 0, n = null;

                function i() {
                    a.textContent = e[t], t = (t + 1) % e.length;
                }

                function d() {
                    r.style.display = "none", n && clearInterval(n);
                }
                let paypalHandled = false;

                paypal_sdk.Buttons({
                    style: {
                        layout: 'vertical',
                        color: 'gold',
                        shape: 'pill',
                        label: 'paypal'
                    },
                    createOrder: function (data, actions) {
                        paypalHandled = false;
                        r.style.display = "flex";
                        n = setInterval(i, 500);

                        return $.ajax({
                            url: '{{ route("api.paypal.create-order") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                invoice_number: '{{ $invoiceData['invoice_key'] }}'
                            }
                        }).then(function (response) {
                            d();
                            return response.orderID;
                        }).catch(function (xhr) {
                            d();
                            console.error('PayPal order creation failed:', xhr);
                            const errorMsg = xhr.responseJSON?.error || 'Failed to create PayPal order. Please try again.';
                            toastr.error(errorMsg, 'Payment Error');
                            throw new Error(errorMsg);
                        });
                    },
                    onApprove: function (data, actions) {
                        r.style.display = "flex";
                        n = setInterval(i, 500);

                        return $.ajax({
                            url: '{{ route("api.paypal.capture-order") }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                orderID: data.orderID,
                                invoice_number: '{{ $invoiceData['invoice_key'] }}'
                            }
                        }).then(function (res) {
                            if (res.message) {
                                toastr.success(res.message, "Success");
                            }
                            location.reload();
                        }).catch(function (err) {
                            d();
                            console.error("Payment capture failed:", err);
                            const errorMsg = err.responseJSON?.error || 'Payment capture failed. Please try again.';
                            toastr.error(errorMsg, 'Payment Error');
                        });
                    },
                    onCancel: function (data) {
                        if (paypalHandled) return;
                        paypalHandled = true;
                        d();
                        $.post('{{ route("api.paypal.cancel-order") }}', {
                            _token: '{{ csrf_token() }}',
                            invoice_number: '{{ $invoiceData['invoice_key'] }}',
                            order_id: data.orderID || null
                        });
                        console.log('Payment was cancelled', data);
                        toastr.warning('Payment was cancelled', 'Payment Cancelled');
                    },
                    onError: function (err) {
                        if (paypalHandled) return;
                        paypalHandled = true;
                        d();
                        console.error("PayPal error:", err);
                        toastr.error('An error occurred with PayPal. Please try another payment method.', 'Payment Error');
                    }
                }).render('#paypal-button-container');
            }
            !function () {
                document.currentScript?.remove()
            }();
        </script>
    @endif
    @if(array_intersect(['stripe','edp','authorize'], $invoiceDetails['invoice']['payment_methods']))
        @if (in_array('stripe', $invoiceDetails['invoice']['payment_methods']) && isset($invoiceDetails['invoice']['payment_method_keys']['stripe']) && !empty($invoiceDetails['invoice']['payment_method_keys']['stripe']))
            <script src="https://js.stripe.com/v3/"></script>
            <script>
                window.STRIPE_PUBLISHABLE_KEY = `{{$invoiceDetails['invoice']['payment_method_keys']['stripe']}}`;
                window.stripe = Stripe(window.STRIPE_PUBLISHABLE_KEY);
                const elements = window.stripe.elements();
                const cardElement = elements.create('card', {
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#32325d',
                            '::placeholder': {
                                color: '#aab7c4'
                            }
                        },
                        invalid: {
                            color: '#fa755a',
                            iconColor: '#fa755a'
                        }
                    }
                });
                cardElement.mount('#card-stripe');
                !function () {
                    document.currentScript?.remove()
                }();
            </script>
        @endif
        <script>{!! \File::get(public_path('assets/js/checkout.js')) !!}</script>
    @endif
@endif
</body>
</html>
