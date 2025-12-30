<?php
session_start();
include("connection.php");

if (isset($_POST['submit'])) {
    $n  = $_POST['passenger_name'];
    $d  = $_POST['dob'];
    $g  = $_POST['gender'];
    $c  = $_POST['phone'];
    $e  = $_POST['email'];
    $p  = $_POST['password'];
    $cp = $_POST['cpassword'];

    if (empty($n) || empty($d) || empty($g) || empty($c) || empty($e) || empty($p) || empty($cp)) {
        echo "<script>alert('Ensure you fill the form properly.');</script>";
    } elseif ($p !== $cp) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        $check_email = $con->prepare("SELECT passenger_id FROM passenger WHERE email = ? OR phone = ?");
        $check_email->bind_param("ss", $e, $c);
        $check_email->execute();
        $check_email->store_result();

        if ($check_email->num_rows > 0) {
            echo "<script>alert('Email or phone number already exists!');</script>";
        } else {
            $password = password_hash($p, PASSWORD_DEFAULT);
            $stmt = $con->prepare("INSERT INTO passenger (passenger_name, dob, gender, email, password, phone) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $n, $d, $g, $e, $password, $c);
            if ($stmt->execute()) {
                echo "<script>alert('Congratulations! You are now registered.');</script>";
                header("Location: signin.php");
                exit();
            } else {
                echo "<script>alert('We could not register you. Please try again later.');</script>";
            }
            $stmt->close();
        }
        $check_email->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);
        .signup-page {
            width: 60%;
            padding: 5% 0 0;
            margin: auto;
        }
        .form {
            position: relative;
            z-index: 1;
            background: #ffffff;
            max-width: 70%;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2),
                        0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        .form input,
        select {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #40af46;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .form button:hover {
            background-color: rgb(10, 130, 10);
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="signup-page">
    <div class="form">
        <h2>Create Account</h2>
        <br>
        <marquee>You need to create an account to book/view trains!</marquee>
        <form class="login-form" method="post" id="signup-form">
            <div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" required minlength="4" name="passenger_name">
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label>DOB</label>
                    <input type="date" required name="dob">
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label>Gender</label>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Select your gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label>Contact Number</label>
                    <input type="text" minlength="10" pattern="[0-9]{10}" required name="phone">
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" required name="email">
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="cpassword" id="cpassword" required>
                </div>
            </div>
            <div>
                <div class="form-group">
                    <button type="submit" id="btn-signup" name="submit">
                        CREATE ACCOUNT
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
