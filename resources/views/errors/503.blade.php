<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode - Laravel Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #ff2d20;
            --secondary-color: #1d68a7;
            --accent-color: #f59e0b;
            --text-color: #2d3748;
            --light-bg: #f7fafc;
            --white: #ffffff;
            --gray-200: #edf2f7;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23e2e8f0' fill-opacity='0.4' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        .maintenance-container {
            background-color: var(--white);
            border-radius: 12px;
            box-shadow: var(--shadow);
            padding: 40px;
            max-width: 800px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .construction-bar {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: repeating-linear-gradient(
                45deg,
                var(--accent-color),
                var(--accent-color) 10px,
                #000 10px,
                #000 20px
            );
        }

        .logo {
            margin: 20px 0 30px;
        }

        .logo svg {
            width: 70px;
            height: 70px;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 2.5rem;
            font-weight: 700;
        }

        p {
            margin-bottom: 25px;
            font-size: 1.1rem;
            color: var(--text-color);
        }

        .status {
            background-color: var(--light-bg);
            padding: 18px;
            border-radius: 10px;
            margin: 30px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-left: 4px solid var(--accent-color);
        }

        .status-dot {
            height: 14px;
            width: 14px;
            background-color: var(--accent-color);
            border-radius: 50%;
            margin-right: 12px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .progress-container {
            background-color: var(--gray-200);
            border-radius: 10px;
            height: 12px;
            margin: 30px 0;
            overflow: hidden;
            position: relative;
        }

        .progress-bar {
            height: 100%;
            width: 65%;
            background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
            border-radius: 10px;
            animation: progressAnimation 1.5s ease-in-out infinite alternate;
            position: relative;
        }

        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-image: linear-gradient(
                -45deg,
                rgba(255, 255, 255, 0.2) 25%,
                transparent 25%,
                transparent 50%,
                rgba(255, 255, 255, 0.2) 50%,
                rgba(255, 255, 255, 0.2) 75%,
                transparent 75%,
                transparent
            );
            z-index: 1;
            background-size: 20px 20px;
            animation: move 1s linear infinite;
        }

        @keyframes move {
            0% {
                background-position: 0 0;
            }
            100% {
                background-position: 20px 20px;
            }
        }

        @keyframes progressAnimation {
            0% { width: 65%; }
            100% { width: 68%; }
        }

        .construction-icons {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin: 30px 0;
        }

        .icon {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .icon i {
            font-size: 2.5rem;
            color: var(--secondary-color);
            margin-bottom: 8px;
        }

        .icon span {
            font-size: 0.9rem;
            color: var(--text-color);
        }

        .contact-info {
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid var(--gray-200);
        }

        .contact-info h3 {
            margin-bottom: 15px;
            color: var(--secondary-color);
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background-color: var(--light-bg);
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background-color: var(--primary-color);
            color: var(--white);
            transform: translateY(-3px);
        }

        .countdown {
            margin: 25px 0;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--secondary-color);
        }

        @media (max-width: 600px) {
            .maintenance-container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .construction-icons {
                flex-wrap: wrap;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
<div class="maintenance-container">
    <div class="construction-bar"></div>

    <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 841.9 595.3">
            <path fill="#ff2d20" d="M666.8 338.5c-10.8-7.2-23.8-11.1-37.6-11.1-38.1 0-69 30.9-69 69 0 13.8 4.1 26.8 11.1 37.6-4.8 8.2-11.3 15.4-19.1 21.1-12.8-10.1-29.1-16.1-46.6-16.1-38.1 0-69 30.9-69 69 0 17.5 6.5 33.5 17.3 45.8-8.2 4.8-17.5 8.1-27.5 9.4-7.2 10.8-11.1 23.8-11.1 37.6 0 38.1 30.9 69 69 69 13.8 0 26.8-4.1 37.6-11.1 8.2 4.8 17.5 8.1 27.5 9.4 10.1-12.8 25.5-21.1 42.9-21.1 17.5 0 33 8.3 42.9 21.1 10-1.3 19.3-4.6 27.5-9.4 10.8 7.2 23.8 11.1 37.6 11.1 38.1 0 69-30.9 69-69 0-13.8-4.1-26.8-11.1-37.6 4.8-8.2 8.1-17.5 9.4-27.5 12.8-10.1 21.1-25.5 21.1-42.9 0-17.5-8.3-33-21.1-42.9-1.3-10-4.6-19.3-9.4-27.5 7.2-10.8 11.1-23.8 11.1-37.6 0-38.1-30.9-69-69-69zm-37.6 99.1c16.9 0 30.6 13.7 30.6 30.6s-13.7 30.6-30.6 30.6-30.6-13.7-30.6-30.6 13.7-30.6 30.6-30.6z"/>
            <path fill="#ff2d20" d="M329.7 338.5c-10.8-7.2-23.8-11.1-37.6-11.1-38.1 0-69 30.9-69 69 0 13.8 4.1 26.8 11.1 37.6-4.8 8.2-11.3 15.4-19.1 21.1-12.8-10.1-29.1-16.1-46.6-16.1-38.1 0-69 30.9-69 69 0 17.5 6.5 33.5 17.3 45.8-8.2 4.8-17.5 8.1-27.5 9.4-7.2 10.8-11.1 23.8-11.1 37.6 0 38.1 30.9 69 69 69 13.8 0 26.8-4.1 37.6-11.1 8.2 4.8 17.5 8.1 27.5 9.4 10.1-12.8 25.5-21.1 42.9-21.1 17.5 0 33 8.3 42.9 21.1 10-1.3 19.3-4.6 27.5-9.4 10.8 7.2 23.8 11.1 37.6 11.1 38.1 0 69-30.9 69-69 0-13.8-4.1-26.8-11.1-37.6 4.8-8.2 8.1-17.5 9.4-27.5 12.8-10.1 21.1-25.5 21.1-42.9 0-17.5-8.3-33-21.1-42.9-1.3-10-4.6-19.3-9.4-27.5 7.2-10.8 11.1-23.8 11.1-37.6 0-38.1-30.9-69-69-69zm-37.6 99.1c16.9 0 30.6 13.7 30.6 30.6s-13.7 30.6-30.6 30.6-30.6-13.7-30.6-30.6 13.7-30.6 30.6-30.6z"/>
        </svg>
    </div>

    <h1>Site Under Construction</h1>

    <p>We're performing scheduled maintenance to improve your experience. Our team is working hard to bring you an upgraded application with new features and enhancements.</p>

    <div class="status">
        <div class="status-dot"></div>
        <span>Maintenance in progress - Estimated completion in approximately 2 hours</span>
    </div>

    <div class="progress-container">
        <div class="progress-bar"></div>
    </div>

    <div class="countdown">
        <i class="far fa-clock"></i> Estimated time remaining: <span id="countdown">00:00:00</span>
    </div>

    <div class="construction-icons">
        <div class="icon">
            <i class="fas fa-tools"></i>
            <span>Development</span>
        </div>
        <div class="icon">
            <i class="fas fa-cogs"></i>
            <span>Optimization</span>
        </div>
        <div class="icon">
            <i class="fas fa-server"></i>
            <span>Deployment</span>
        </div>
        <div class="icon">
            <i class="fas fa-rocket"></i>
            <span>Launch</span>
        </div>
    </div>

    <div class="contact-info">
        <h3>Need Immediate Assistance?</h3>
        <p>Contact our support team for urgent inquiries:</p>

        <p><i class="far fa-envelope"></i> {{ 'developer@' . ltrim(config('session.domain'), '.') }}</p>

        <div class="social-links">
            <a href="#" class="social-link">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-link">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-link">
                <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" class="social-link">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </div>
</div>

<script>
    // Countdown timer with session storage
    function startCountdown(duration, display) {
        // Check if we have a saved timer in session storage
        let savedTime = sessionStorage.getItem('maintenanceTimer');
        let startTime = Date.now();
        let timer;

        if (savedTime) {
            // Use the saved time remaining
            timer = parseInt(savedTime);
        } else {
            // Start new timer
            timer = duration;
            sessionStorage.setItem('maintenanceTimer', timer);
            sessionStorage.setItem('maintenanceStartTime', startTime);
        }

        let interval = setInterval(function () {
            // Calculate hours, minutes, and seconds
            let hours = parseInt(timer / 3600, 10);
            let minutes = parseInt((timer % 3600) / 60, 10);
            let seconds = parseInt(timer % 60, 10);

            // Format with leading zeros
            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            // Display the timer
            display.textContent = hours + ":" + minutes + ":" + seconds;

            // Save current time to session storage
            sessionStorage.setItem('maintenanceTimer', timer);

            // Check if timer has expired
            if (--timer < 0) {
                clearInterval(interval);
                display.textContent = "00:00:00";
                // Clear session storage when timer completes
                sessionStorage.removeItem('maintenanceTimer');
                sessionStorage.removeItem('maintenanceStartTime');

                // Optional: Check if maintenance is over
                checkMaintenanceStatus();
            }
        }, 1000);
    }

    // Function to check if maintenance is over
    function checkMaintenanceStatus() {
        // This would typically make an API call to check maintenance status
        console.log("Checking if maintenance is complete...");
        // In a real implementation, you would ping your server here
    }

    window.onload = function () {
        const twoHours = 2 * 60 * 60; // 2 hours in seconds
        const display = document.querySelector('#countdown');

        if (display) {
            startCountdown(twoHours, display);
        }

        // Clear session storage when page is about to be closed/refreshed
        window.addEventListener('beforeunload', function() {
            // Note: We're not clearing here to maintain timer across refreshes
            // sessionStorage.removeItem('maintenanceTimer');
            // sessionStorage.removeItem('maintenanceStartTime');
        });
    };
</script>
</body>
</html>
