<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Login | Two-Factor Authentication</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('build/toaster/css/toastr.min.css') }}">
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon2.png')}}">
    <script src="{{asset('assets/js/tailwindcss-3.4.16.js')}}"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        dark: {
                            800: '#0f172a',
                            900: '#0a0f1d'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        body.dark {
            background: linear-gradient(135deg, #0c4a6e 0%, #0a0f1d 100%);
        }

        .card {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .method-option {
            transition: all 0.2s ease;
            border: 2px solid #e2e8f0;
        }

        .method-option:hover {
            border-color: #7dd3fc;
            transform: translateY(-2px);
        }

        .method-option.selected {
            border-color: #0ea5e9;
            background-color: #f0f9ff;
        }

        .dark .method-option.selected {
            background-color: rgba(14, 165, 233, 0.1);
            border-color: #0ea5e9;
        }

        .dark .method-option:hover {
            border-color: #0ea5e9;
        }

        .security-badge {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 0.7;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.7;
            }
        }

        .toggle-checkbox:checked {
            right: 0;
            background-color: #0ea5e9;
        }

        .toggle-checkbox:checked + .toggle-label {
            background-color: #0ea5e9;
        }

        .btn-primary {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
            box-shadow: 0 4px 6px rgba(2, 132, 199, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(2, 132, 199, 0.3);
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-dark-900 text-gray-800 dark:text-gray-200 transition-colors duration-300">
<div class="w-full max-w-md mx-4">
    <div class="card bg-white dark:bg-dark-800 p-8">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center space-x-2">
                <div
                    class="security-badge bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 px-3 py-1 rounded-full text-xs font-medium flex items-center">
                    <i class="fas fa-shield-alt mr-1"></i>
                    SECURE VERIFICATION
                </div>
            </div>

            <div class="flex items-center">
                <span class="mr-2 text-sm dark:text-white">Dark Mode</span>
                <div class="relative inline-block w-12 mr-2 align-middle select-none">
                    <input type="checkbox" id="dark-mode-toggle"
                           class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer transition-all duration-300"
                           onclick="toggleDarkMode()">
                    <label for="dark-mode-toggle"
                           class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer transition-all duration-300"></label>
                </div>
            </div>
        </div>

        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div
                    class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 flex items-center justify-center text-primary-500">
                    <i class="fas fa-lock text-2xl"></i>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                Two-Factor Authentication
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Verify your identity with an additional security step
            </p>
        </div>

        <div class="mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-500 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Security Notice</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p>To protect your account, we require an additional verification step.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="verificationForm">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Select Verification Method
                </label>

                <div class="grid grid-cols-1 gap-3">
                    <div class="method-option p-4 rounded-xl cursor-pointer selected" data-method="email"
                         onclick="selectMethod(this, 'email')">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="ml-4">
                                <div class="flex items-center">
                                    <span class="block text-sm font-medium text-gray-900 dark:text-white">Email Verification</span>
                                    <span
                                        class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Recommended</span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Send code
                                    to {{$user->email}}</p>
                            </div>
                            <div class="ml-auto">
                                <i class="fas fa-check-circle text-blue-500 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <div class="method-option p-4 rounded-xl cursor-pointer @if(!$user->phone_number) opacity-50 @endif"
                         @if($user->phone_number)
                             onclick="selectMethod(this, 'sms')"
                         @else
                             onclick="toastManager.show('info', 'Text message requires initial setup in account settings')"
                         @endif
                         data-method="sms">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="ml-4">
                                <span
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Text Message (SMS)</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Send code to
                                    •••••••{{ $user->phone_number ? substr($user->phone_number, -4) : '••••' }}</p>
                            </div>
                            @if($user->phone_number)
                                <div class="ml-auto">
                                    <i class="fas fa-check-circle text-blue-500 text-xl opacity-0"></i>
                                </div>
                            @else
                                <div class="ml-auto">
                                    <span class="text-xs px-2 py-1 rounded bg-gray-100 dark:bg-gray-700">Set up</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="method-option p-4 rounded-xl cursor-pointer opacity-50"
                         onclick="toastManager.show('info', 'Authenticator app requires initial setup in account settings')">
                        <div class="flex items-center">
                            <div
                                class="flex-shrink-0 h-10 w-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                <i class="fas fa-mobile"></i>
                            </div>
                            <div class="ml-4">
                                <span
                                    class="block text-sm font-medium text-gray-900 dark:text-white">Authenticator App</span>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Use Google Authenticator or
                                    similar</p>
                            </div>
                            <div class="ml-auto">
                                <span class="text-xs px-2 py-1 rounded bg-gray-100 dark:bg-gray-700">Set up</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="text-sm">
                    <a href="#" class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500">Having
                        trouble?</a>
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <span id="resend-timer" class="hidden">Resend in 0:30</span>
                </div>
            </div>

            <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                <p id="text-message" class="hidden">We've sent a 6-digit code to your selected method.</p>
            </div>

            <div class="flex justify-end">
                <button type="button" id="submit-button" onclick="sendVerification()"
                        class="btn-primary w-full py-3 px-4 rounded-lg font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    <span id="button-text">Send Verification Code</span>
                    <i class="fas fa-paper-plane ml-2"></i>
                </button>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-center">
                <div class="flex items-center">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Secured by AES-256 encryption</span>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('build/toaster/js/toastr.min.js')}}"></script>
<script>
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "onShown": function () {
            const MAX_TOAST_COUNT = 2;
            const toasts = $('.toast');
            if (toasts.length > MAX_TOAST_COUNT) {
                $(toasts[0]).remove();
            }
        }
    };

    const toastManager = {
        maxToasts: 3,
        show: function (type, message, title = '') {
            let isVisible = false;
            $('.toast').each(function () {
                if ($(this).text().includes(message)) {
                    isVisible = true;
                    return false;
                }
            });
            if (isVisible) return;
            const toasts = $('.toast');
            if (toasts.length >= this.maxToasts) {
                $(toasts[0]).remove();
            }
            toastr.clear();
            toastr.previousToast = null;
            toastr[type](message, title);
        }
    };

    // Dark mode toggle
    function toggleDarkMode() {
        document.body.classList.toggle('dark');
        localStorage.setItem('darkMode', document.body.classList.contains('dark'));
    }

    // Set initial dark mode state
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark');
        document.getElementById('dark-mode-toggle').checked = true;
    }

    // Method selection
    function selectMethod(element, method) {
        // Remove selected class from all options
        document.querySelectorAll('.method-option').forEach(option => {
            option.classList.remove('selected');
            const checkIcon = option.querySelector('.fa-check-circle');
            if (checkIcon) {
                checkIcon.classList.add('opacity-0');
            }
        });

        // Add selected class to clicked option
        element.classList.add('selected');
        const checkIcon = element.querySelector('.fa-check-circle');
        if (checkIcon) {
            checkIcon.classList.remove('opacity-0');
        }
    }

    // Send verification code
    function sendVerification() {
        const button = document.getElementById('submit-button');
        const textButton = document.getElementById('button-text');
        const resendTimer = document.getElementById('resend-timer');
        const textMessage = document.getElementById('text-message');
        const selectedMethod = document.querySelector('.method-option.selected')?.dataset.method;

        if (!selectedMethod) {
            toastManager.show('error', 'Please select a verification method');
            return;
        }

        // Show loading state
        textButton.textContent = 'Sending...';
        button.disabled = true;
        button.classList.add('opacity-75');

        fetch('{{ route("admin.2fa.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({method: selectedMethod, email: `{{$user->email}}`})
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    startCountdown(button, textButton, 'Code Sent!', resendTimer, textMessage, `We've sent a 6-digit code to your ${selectedMethod === 'email' ? 'email' : 'phone'}`);
                    toastManager.show('success', data.message ?? "Verification code sent successfully.");
                    window.location.href = '{{ route("admin.2fa.verify.show") }}?method=' + selectedMethod;
                } else {
                    startCountdown(button, textButton, 'Try Again', resendTimer, textMessage, `Failed to send. Please try again in few seconds.`);
                    const errorMessage = data.error || data.message || 'Failed to send verification code.';
                    toastManager.show('error', errorMessage);
                }
            })
            .catch(error => {
                console.log(error)
                startCountdown(button, textButton, 'Try Again', resendTimer, textMessage, `Failed to send. Please try again in few seconds.`);
                toastManager.show('error', 'An error occurred while sending the verification code');
            });
    }

    function startCountdown(button, textButton, buttonText = null, resendTimer, textMessage, message) {
        textButton.textContent = buttonText ?? 'Try Again';
        button.classList.remove('opacity-75');
        button.disabled = true;

        resendTimer.classList.remove('hidden');
        textMessage.classList.remove('hidden');
        textMessage.textContent = message;

        let seconds = 30;
        resendTimer.textContent = `Resend in 0:${seconds < 10 ? '0' : ''}${seconds}`;

        if (button.timerInterval) {
            clearInterval(button.timerInterval);
        }

        button.timerInterval = setInterval(() => {
            seconds--;
            resendTimer.textContent = `Resend in 0:${seconds < 10 ? '0' : ''}${seconds}`;

            if (seconds <= 0) {
                clearInterval(button.timerInterval);
                resendTimer.classList.add('hidden');
                textMessage.classList.add('hidden');
                resetButton(button, textButton);
            }
        }, 1000);
    }

    function resetButton(button, textButton) {
        textButton.textContent = 'Send Verification Code';
        button.classList.remove('opacity-75');
        button.disabled = false;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const emailOption = document.querySelector('.method-option[data-method="email"]');
        if (emailOption) {
            selectMethod(emailOption, 'email');
        }
    });
</script>
</body>
</html>
