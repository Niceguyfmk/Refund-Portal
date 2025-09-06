<!DOCTYPE html>
<html lang="en">
<!-- test commit by dev  php setup-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AZA Ventures - Refund Portal</title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <!-- <link rel="manifest" href="site.webmanifest"> -->

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/libs/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/libs/remixicon/fonts/remixicon.css">
    <link rel="stylesheet" href="../assets/libs/aos/dist/aos.css">
    <link rel="stylesheet" href="../assets/fonts/fonts.css">
    <link rel="stylesheet" href="../assets/css/app.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
        }

        .hero-section {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb2d);
            color: white;
            min-height: 100vh;
            display: flex;  
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .search-container {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-input {
            padding: 15px 20px;
            border-radius: 50px;
            border: none;
            width: 100%;
            font-size: 18px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .search-btn {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 30px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .search-btn:hover {
            background: #0069d9;
        }

        .verification-type {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .verification-option {
            padding: 15px 30px;
            border-radius: 50px;
            background: rgba(255, 255, 255, 0.1);
            cursor: pointer;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .verification-option:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .verification-option.active {
            background: rgba(255, 255, 255, 0.3);
            border-color: white;
            font-weight: bold;
        }

        .verification-icon {
            margin-right: 10px;
        }

        .input-label {
            display: block;
            margin-bottom: 10px;
            font-size: 24px;
            font-weight: 500;
        }

        .error-message {
            color: #ff4d4d;
            font-weight: 500;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>