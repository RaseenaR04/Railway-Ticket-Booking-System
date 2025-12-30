<?php
session_start();
include("connection.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);

function showAlert($message) {
    echo "<script>alert('$message');</script>";
}

function authenticateUser($email, $password, $con) {
    if (empty($email) || empty($password)) {
        showAlert('Please enter both email and password.');
        return false;
    }

    $query = "SELECT passenger_id, password FROM passenger WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['email'] = $email;
            $_SESSION['passenger_id'] = $row['passenger_id'];
            header("location: home/home.php");
            exit();
        } else {
            showAlert('Incorrect password. Please try again.');
        }
    } else {
        showAlert('No account found with this email. Please sign up.');
    }
    $stmt->close();
    return false;
}

if (isset($_POST['signin'])) {
    authenticateUser($_POST['email'], $_POST['password'], $con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);
        .signin-page {
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
            width: 100%;
            border: 0;
            background: #3dab43;
            padding: 15px;
            color: #ffffff;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .form button:hover {
            background-color: rgb(10, 130, 10);
        }
        .form button:active {
            background-color: #1b5e20;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="signin-page">
    <div class="form">
        <h2>LOGIN ACCOUNT</h2>
        <br>
        <form class="signin-form" method="post" id="signin-form">
            <div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" required name="email">
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
                    <button type="submit" id="btn-signin" name="signin">
                        SIGN IN
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
