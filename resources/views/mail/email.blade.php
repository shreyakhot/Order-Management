<!DOCTYPE html>
<html>
<head>
    <title>Email</title>
    <style>
        /* Reset some default styles */
        body, p {
            margin: 0;
            padding: 0;
        }

        /* Set the background color and font family */
        body {
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        /* Center the email content */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
        }

        /* Style the header */
        .header {
            text-align: center;
            padding: 8px 0;
            background-color: #f2f2f2;
        }

        /* Style the main content */
        .content {
            padding: 20px;
            color: #333333;
        }

        /* Style the call-to-action button */
        .cta-button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            color: white !important;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Style the footer */
        .footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="header">
        <h3>Welcome to Our Newsletter!</h3>
    </div>
    <div class="content">
        <p>Dear {{ $data['user']->name }},</p>
        <p>We are excited to have you on board!</p>
        <p>
            Our goal is to simplify digital transactions for merchants,
            payment providers, and banks, by delivering exceptional services
            that eliminate complexities and inconveniences.
        </p>
        <a class="cta-button" href="https://www.interpay.sa">Get Started</a>
        <p>Thank you for joining us!</p>
    </div>
    {{--<div class="footer">
        <a href="https://www.interpay.sa">https://www.interpay.sa</a>
    </div>--}}
</div>
</body>
</html>