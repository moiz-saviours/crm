<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Mode</title>
    <style>
        :root {
            --primary-color: #ff2d20;
            --secondary-color: #1d68a7;
            --text-color: #2d3748;
            --light-bg: #f7fafc;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
        }

        .maintenance-container {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            padding: 40px;
            max-width: 700px;
            width: 100%;
            text-align: center;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo svg {
            width: 60px;
            height: 60px;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 2.5rem;
        }

        p {
            margin-bottom: 25px;
            font-size: 1.1rem;
        }

        .status {
            background-color: var(--light-bg);
            padding: 15px;
            border-radius: 8px;
            margin: 30px 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .status-dot {
            height: 12px;
            width: 12px;
            background-color: #ecc94b;
            border-radius: 50%;
            margin-right: 10px;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .progress-container {
            background-color: #edf2f7;
            border-radius: 10px;
            height: 10px;
            margin: 30px 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            width: 65%;
            background-color: var(--secondary-color);
            border-radius: 10px;
            animation: progressAnimation 1.5s ease-in-out infinite alternate;
        }

        @keyframes progressAnimation {
            0% { width: 65%; }
            100% { width: 68%; }
        }

        .contact-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
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
            width: 40px;
            height: 40px;
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

        @media (max-width: 600px) {
            .maintenance-container {
                padding: 25px;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
<div class="maintenance-container">
    <div class="logo">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 841.9 595.3">
            <path fill="#ff2d20" d="M666.8 338.5c-10.8-7.2-23.8-11.1-37.6-11.1-38.1 0-69 30.9-69 69 0 13.8 4.1 26.8 11.1 37.6-4.8 8.2-11.3 15.4-19.1 21.1-12.8-10.1-29.1-16.1-46.6-16.1-38.1 0-69 30.9-69 69 0 17.5 6.5 33.5 17.3 45.8-8.2 4.8-17.5 8.1-27.5 9.4-7.2 10.8-11.1 23.8-11.1 37.6 0 38.1 30.9 69 69 69 13.8 0 26.8-4.1 37.6-11.1 8.2 4.8 17.5 8.1 27.5 9.4 10.1-12.8 25.5-21.1 42.9-21.1 17.5 0 33 8.3 42.9 21.1 10-1.3 19.3-4.6 27.5-9.4 10.8 7.2 23.8 11.1 37.6 11.1 38.1 0 69-30.9 69-69 0-13.8-4.1-26.8-11.1-37.6 4.8-8.2 8.1-17.5 9.4-27.5 12.8-10.1 21.1-25.5 21.1-42.9 0-17.5-8.3-33-21.1-42.9-1.3-10-4.6-19.3-9.4-27.5 7.2-10.8 11.1-23.8 11.1-37.6 0-38.1-30.9-69-69-69zm-37.6 99.1c16.9 0 30.6 13.7 30.6 30.6s-13.7 30.6-30.6 30.6-30.6-13.7-30.6-30.6 13.7-30.6 30.6-30.6z"/>
            <path fill="#ff2d20" d="M329.7 338.5c-10.8-7.2-23.8-11.1-37.6-11.1-38.1 0-69 30.9-69 69 0 13.8 4.1 26.8 11.1 37.6-4.8 8.2-11.3 15.4-19.1 21.1-12.8-10.1-29.1-16.1-46.6-16.1-38.1 0-69 30.9-69 69 0 17.5 6.5 33.5 17.3 45.8-8.2 4.8-17.5 8.1-27.5 9.4-7.2 10.8-11.1 23.8-11.1 37.6 0 38.1 30.9 69 69 69 13.8 0 26.8-4.1 37.6-11.1 8.2 4.8 17.5 8.1 27.5 9.4 10.1-12.8 25.5-21.1 42.9-21.1 17.5 0 33 8.3 42.9 21.1 10-1.3 19.3-4.6 27.5-9.4 10.8 7.2 23.8 11.1 37.6 11.1 38.1 0 69-30.9 69-69 0-13.8-4.1-26.8-11.1-37.6 4.8-8.2 8.1-17.5 9.4-27.5 12.8-10.1 21.1-25.5 21.1-42.9 0-17.5-8.3-33-21.1-42.9-1.3-10-4.6-19.3-9.4-27.5 7.2-10.8 11.1-23.8 11.1-37.6 0-38.1-30.9-69-69-69zm-37.6 99.1c16.9 0 30.6 13.7 30.6 30.6s-13.7 30.6-30.6 30.6-30.6-13.7-30.6-30.6 13.7-30.6 30.6-30.6z"/>
        </svg>
    </div>

    <h1>We'll Be Back Soon!</h1>

    <p>Our application is currently undergoing scheduled maintenance. We apologize for any inconvenience and appreciate your patience.</p>

    <div class="status">
        <div class="status-dot"></div>
        <span>Maintenance in progress - Estimated completion in approximately 2 hours</span>
    </div>

    <div class="progress-container">
        <div class="progress-bar"></div>
    </div>

    <p>For urgent inquiries, please contact our support team:</p>

    <div class="contact-info">
        <p>Email: support@yourcompany.com</p>
        <p>Phone: +1 (555) 123-4567</p>

        <div class="social-links">
            <a href="#" class="social-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                </svg>
            </a>
            <a href="#" class="social-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                </svg>
            </a>
            <a href="#" class="social-link">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
                </svg>
            </a>
        </div>
    </div>
</div>
</body>
</html>
