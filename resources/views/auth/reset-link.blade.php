{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password - VIRTULIST</title>
    <style>
        body {
            font-family: "Lora", serif;
            background-color: #f4f4f4;
            padding: 30px;
            color: #333;
        }

        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .email-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            color: #000;
        }

        .email-body {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .reset-link {
            display: inline-block;
            background-color: #000;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: bold;
        }

        .fallback {
            margin-top: 25px;
            font-size: 14px;
            color: #666;
            word-break: break-word;
        }

        .footer {
            margin-top: 30px;
            font-size: 13px;
            text-align: center;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-title">Reset Your Password - VIRTULIST</div>
        <div class="email-body">
            <p>Hello,</p>
            <p>You have requested to reset your account password.</p>
            <p>Please click the button below to reset your password:</p>
            <p style="text-align: center;">
                <a href="{{ $link }}" class="reset-link">Reset Password</a>
            </p>
            <div class="fallback">
                <p>If the button above doesn't work, copy and paste this link into your browser:</p>
                <p>{{ $link }}</p>
            </div>
        </div>
        <div class="footer">
            If you did not request a password reset, please ignore this email.
        </div>
    </div>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - VIRTULIST</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --text-color: #374151;
            --light-gray: #f3f4f6;
            --medium-gray: #e5e7eb;
            --dark-gray: #6b7280;
            --white: #ffffff;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --rounded-sm: 0.375rem;
            --rounded-md: 0.5rem;
            --rounded-lg: 0.75rem;
            --transition: all 0.2s ease-in-out;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
            margin: 0;
            padding: 20px;
            color: var(--text-color);
            line-height: 1.6;
        }

        .email-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: var(--rounded-lg);
            max-width: 600px;
            margin: 0 auto;
            box-shadow: var(--shadow-lg);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            display: inline-block;
        }

        .email-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 25px;
            text-align: center;
            color: var(--text-color);
        }

        .email-body {
            font-size: 15px;
            margin-bottom: 30px;
        }

        .email-body p {
            margin-bottom: 16px;
        }

        .reset-link-container {
            text-align: center;
            margin: 30px 0;
        }

        .reset-link {
            display: inline-block;
            background-color: var(--primary-color);
            color: var(--white) !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: var(--rounded-md);
            font-weight: 500;
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .reset-link:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .fallback {
            margin-top: 30px;
            padding: 16px;
            background-color: var(--light-gray);
            border-radius: var(--rounded-sm);
            font-size: 14px;
            color: var(--dark-gray);
            word-break: break-all;
        }

        .fallback-title {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--text-color);
        }

        .footer {
            margin-top: 40px;
            font-size: 13px;
            text-align: center;
            color: var(--dark-gray);
            border-top: 1px solid var(--medium-gray);
            padding-top: 20px;
        }

        .footer a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .email-container {
                padding: 25px;
            }
            
            .email-title {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="logo">
            <a href="#" class="logo-text">VIRTULIST</a>
        </div>
        
        <div class="email-title">Reset Your Password</div>
        
        <div class="email-body">
            <p>Hello,</p>
            <p>We received a request to reset the password for your VIRTULIST account. To proceed with resetting your password, please click the button below:</p>
            
            <div class="reset-link-container">
                <a href="{{ $link }}" class="reset-link" id="resetButton">Reset Password</a>
            </div>
            
            <p>This password reset link will expire in 24 hours. If you didn't request a password reset, you can safely ignore this email.</p>
            
            <div class="fallback">
                <div class="fallback-title">Having trouble with the button?</div>
                <p>Copy and paste this URL into your browser:</p>
                <p id="resetLink">{{ $link }}</p>
                <button id="copyButton" style="margin-top: 10px; background: var(--primary-color); color: white; border: none; padding: 6px 12px; border-radius: var(--rounded-sm); cursor: pointer; font-size: 13px;">Copy Link</button>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; 2025 VIRTULIST. All rights reserved.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click animation to reset button
            const resetButton = document.getElementById('resetButton');
            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    this.style.transform = 'translateY(1px)';
                    setTimeout(() => {
                        this.style.transform = 'translateY(-1px)';
                    }, 100);
                });
            }
            
            // Copy link functionality
            const copyButton = document.getElementById('copyButton');
            if (copyButton) {
                copyButton.addEventListener('click', function() {
                    const resetLink = document.getElementById('resetLink').textContent;
                    navigator.clipboard.writeText(resetLink).then(() => {
                        this.textContent = 'Copied!';
                        this.style.backgroundColor = '#10B981';
                        setTimeout(() => {
                            this.textContent = 'Copy Link';
                            this.style.backgroundColor = '#6366F1';
                        }, 2000);
                    }).catch(err => {
                        console.error('Failed to copy text: ', err);
                    });
                });
            }
        });
    </script>
</body>
</html>