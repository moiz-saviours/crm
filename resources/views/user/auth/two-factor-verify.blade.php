<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="{{ config('session.lifetime')-1 }}">
    <title>Secure Login | Two-Factor Verification</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/toaster/css/toastr.min.css') }}">
    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon2.png')}}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .code-input {
            width: 3rem;
            height: 3.5rem;
            font-size: 1.5rem;
            text-align: center;
            margin-right: 0.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .code-input:focus {
            border-color: #0ea5e9;
            outline: none;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
        }

        .dark .code-input {
            background-color: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }

        .hidden-code-input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
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
                    <i class="fas fa-shield-alt text-2xl"></i>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                Two-Factor Verification
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                We've sent a 6-digit code to your {{ $method === 'email' ? 'email' : 'phone' }}
            </p>
        </div>

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf
            <input type="text" id="email" name="email" value="{{$email}}" class="absolute opacity-0 w-0 h-0"
                   autocomplete="off">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Verification Code
                </label>

                <div class="flex justify-center" id="codeInputsContainer">
                    <input type="text" id="pasteInput" class="absolute opacity-0 w-0 h-0" autocomplete="off">
                    @for($i = 0; $i < 6; $i++)
                        <input type="text" name="code[]" maxlength="1"
                               class="code-input focus:ring-primary-500 focus:border-primary-500"
                               data-index="{{ $i }}"
                               oninput="handleCodeInput(this)"
                               onkeydown="handleBackspace(this, event)"
                               onfocus="this.select()">
                    @endfor
                </div>
            </div>

            {{--            <div class="mb-6">--}}
            {{--                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">--}}
            {{--                    Recovery Code (if needed)--}}
            {{--                </label>--}}
            {{--                <input type="text" name="recovery_code"--}}
            {{--                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent bg-white dark:bg-dark-700">--}}
            {{--                @error('recovery_code')--}}
            {{--                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>--}}
            {{--                @enderror--}}
            {{--            </div>--}}

            <div class="flex items-center justify-between mb-6">
                <div class="text-sm">
                    <a href="{{ route('2fa.show') }}"
                       class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500">
                        Use a different method
                    </a>
                </div>
                <div class="text-sm">
                    <button type="button" id="resend-button" onclick="resendCode()"
                            class="font-medium text-primary-600 dark:text-primary-400 hover:text-primary-500">
                        Resend Code
                    </button>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        <span id="resend-timer">in 0:30</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="btn-primary w-full py-3 px-4 rounded-lg font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                    Verify Code
                    <i class="fas fa-arrow-right ml-2"></i>
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
<script src="{{asset('assets/toaster/js/toastr.min.js')}}"></script>
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
        "hideMethod": "fadeOut"
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
    @error('code')
    toastr.error(`{{ $message }}`);
    @enderror

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

    function handleCodeInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
        if (input.value.length === 1) {
            const nextIndex = parseInt(input.dataset.index) + 1;
            const nextInput = document.querySelector(`input[data-index="${nextIndex}"]`);
            if (nextInput) {
                nextInput.focus();
                nextInput.select();
            }
        }

        if (input.value.length > 1) {
            const fullCode = input.value;
            input.value = fullCode[0];
            const currentIndex = parseInt(input.dataset.index);
            const inputs = document.querySelectorAll('.code-input');
            for (let i = 1; i < fullCode.length && (currentIndex + i) < 6; i++) {
                inputs[currentIndex + i].value = fullCode[i];
            }
            const lastFilledIndex = Math.min(currentIndex + fullCode.length - 1, 5);
            inputs[lastFilledIndex].focus();
        }
    }
    function handleBackspace(input, event) {
        if (event.key === 'Backspace' && input.value === '') {
            const prevIndex = parseInt(input.dataset.index) - 1;
            const prevInput = document.querySelector(`input[data-index="${prevIndex}"]`);
            if (prevInput) {
                prevInput.focus();
                prevInput.select();
            }
        }
    }
    let timerInterval = null;
    let hasCheckedStatus = false;
    function resendCode() {
        const resendButton = document.getElementById('resend-button');
        const resendTimer = document.getElementById('resend-timer');

        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }

        resendButton.disabled = true;
        resendButton.classList.add('opacity-50');
        resendButton.classList.add('hidden');
        resendTimer.classList.remove('hidden');

        fetch('{{ route("2fa.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                method: '{{ $method }}',
                email: '{{ $email }}',
                resend: true
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.message) toastManager.show('success', data.message);
                    startCountdown(resendButton, resendTimer);
                    if ('{{ $method }}' === 'sms') hasCheckedStatus = false;
                    if (data.response_id) {
                        setTimeout(() => {
                            checkSMSStatus(data.response_id);
                            localStorage.setItem(`sms_status_checked_${data.response_id}`, 'true');
                            hasCheckedStatus = true;
                        }, 2000);
                    }
                } else {
                    toastManager.show('error', data.error || data.message || 'Failed to resend verification code.');
                    resetResendButton(resendButton, resendTimer);
                }
            })
            .catch(error => {
                console.log(error)
                toastManager.show('error', 'An error occurred while resending the code');
                resetResendButton(resendButton, resendTimer);
            });
    }
    @if ($method === 'sms' && !empty($response_id))
    document.addEventListener('DOMContentLoaded', function () {
        const statusCheckKey = 'sms_status_checked_{{ $response_id }}';
        const hasCheckedBefore = localStorage.getItem(statusCheckKey);

        if (!hasCheckedBefore && !hasCheckedStatus) {
            checkSMSStatus(`{{ $response_id }}`);
            localStorage.setItem(statusCheckKey, 'true');
            hasCheckedStatus = true;
        }
    });
    function checkSMSStatus(response_id) {
        fetch(`{{ route('twilio.sms.status') }}/${response_id}`)
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.json();
            })
            .then(data => {
                if (data.status) {
                    let status = data.status.toLowerCase();
                    switch (status) {
                        case 'queued':
                            toastManager.show('info', 'Your message has been queued for delivery.');
                            break;
                        case 'sent':
                            toastManager.show('success', 'Your message was sent successfully.');
                            break;
                        case 'delivered':
                            toastManager.show('success', 'Your message was delivered successfully.');
                            break;
                        case 'failed':
                        case 'undelivered':
                            toastManager.show('error', 'Message delivery failed. Please try again or contact support.');
                            break;
                        default:
                            toastManager.show('warning', `Message status: ${status}`);
                    }
                }
            })
            .catch(error => {
                console.error('Status check error:', error);
            });
    }
    @endif
    function startCountdown(button, timerElement) {
        let seconds = 30;
        updateTimerDisplay();
        if (timerInterval) {
            clearInterval(timerInterval);
        }
        timerInterval = setInterval(() => {
            seconds--;
            updateTimerDisplay();

            if (seconds <= 0) {
                clearInterval(timerInterval);
                timerInterval = null;
                resetResendButton(button, timerElement);
            }
        }, 1000);

        function updateTimerDisplay() {
            timerElement.textContent = `Resend in 0:${seconds < 10 ? '0' : ''}${seconds}`;
        }
    }
    function resetResendButton(button, timerElement) {
        button.disabled = false;
        button.classList.remove('opacity-50');
        button.classList.remove('hidden');
        timerElement.classList.add('hidden');
    }
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.code-input').focus();
        const resendButton = document.getElementById('resend-button');
        const resendTimer = document.getElementById('resend-timer');

        resendButton.disabled = true;
        resendButton.classList.add('opacity-50');
        resendButton.classList.add('hidden');
        resendTimer.classList.remove('hidden');
        startCountdown(resendButton, resendTimer);

        document.getElementById('codeInputsContainer').addEventListener('paste', function (e) {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text/plain').replace(/[^0-9]/g, '');

            if (pasteData.length === 6) {
                const inputs = document.querySelectorAll('.code-input');
                inputs.forEach((input, index) => {
                    input.value = pasteData[index] || '';
                });
                // Focus the last input
                inputs[5].focus();
            } else {
                toastManager.show('error', 'Please paste a 6-digit code.');
            }
        });
        document.getElementById('pasteInput').addEventListener('paste', function (e) {
            e.preventDefault();
            const pasteData = e.clipboardData.getData('text/plain').replace(/[^0-9]/g, '');

            if (pasteData.length === 6) {
                const inputs = document.querySelectorAll('.code-input');
                inputs.forEach((input, index) => {
                    input.value = pasteData[index] || '';
                });
                inputs[5].focus();
            } else {
                toastManager.show('error', 'Please paste a 6-digit code.');
            }
        });
    });
</script>
</body>
</html>
