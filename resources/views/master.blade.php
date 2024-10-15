<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Information Security Task 1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Dark Theme Styling */
        body {
            background-color: #1c1c1e;
            color: #f8f9fa;
            font-family: 'Montserrat', sans-serif;
        }

        .gradient-custom {
            /* Gradient Background */
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
        }

        /* Card and Form Styling */
        .card {
            background-color: #2c2c2e;
            border: none;
        }

        .form-control, .btn {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #ff7e5f;
            border-color: #ff7e5f;
        }

        .btn-primary:hover {
            background-color: #feb47b;
            border-color: #feb47b;
        }

        /* Header Styling */
        .gradient-text {
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Dark Mode Specific Styling */
        .bg-dark {
            background-color: #121212 !important;
        }

        .text-light {
            color: #f8f9fa !important;
        }

        .alert-success, .alert-danger {
            border-radius: 8px;
        }

        /* Utility Classes for Customization */
        .rounded-4 {
            border-radius: 1rem !important;
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    @yield('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>
