<?php
// Landing page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Railway Ticket Booking System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            color: #333;
            line-height: 1.6;
            font-size: 16px;
        }
        header {
            background-color: #003366;
            padding: 20px 0;
            color: white;
        }
        .container {
            width: 90%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .auth-links a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }
        .auth-links a:hover {
            color: #ffcc00;
        }
        main {
            height: calc(100vh - 150px);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-image: url('images/train4.jpg');
            background-size: cover;
            background-position: center;
            color: white;
        }
        .main-content {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 40px;
            border-radius: 10px;
            max-width: 500px;
        }
        .main-content h2 {
            font-size: 2.5rem;
            font-family: "Bebas Neue", sans-serif;
            font-weight: 400;
            font-style: normal;
            margin-bottom: 20px;
            color: goldenrod;
        }
        .main-content p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #e0e0e0;
        }
        footer {
            background-color: #003366;
            text-align: center;
            padding: 15px;
            color: white;
            font-size: 0.9rem;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                text-align: center;
            }
            .logo h1 {
                font-size: 2rem;
            }
            .main-content h2 {
                font-size: 2rem;
            }
            .main-content p {
                font-size: 1rem;
            }
            .auth-links a {
                margin-left: 10px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <h1>Railway Ticket Booking System</h1>
        </div>
        <div class="auth-links">
            <a href="signin.php">Sign In</a> | <a href="signup.php">Sign Up</a>
        </div>
    </div>
</header>
<main>
    <div class="main-content">
        <h2>Welcome to Railway Management System</h2>
        <p>Manage train schedules, reservations, and more!</p>
    </div>
</main>
<footer>
    <p>&copy; 2025 Railway Management. All rights reserved.</p>
</footer>
</body>
</html>
