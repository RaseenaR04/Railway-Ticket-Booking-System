<?php
session_start();
include("../connection.php");

if (isset($_GET['payment_id'])) {
    $payment_id = (int)$_GET['payment_id'];

    $query = $con->prepare("SELECT payment_id FROM payment WHERE payment_id = ?");
    $query->bind_param("i", $payment_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cancelPayment = $con->prepare("DELETE FROM payment WHERE payment_id = ?");
            $cancelPayment->bind_param("i", $payment_id);
            $cancelPayment->execute();

            $cancelBooking = $con->prepare("DELETE FROM booked WHERE payment_id = ?");
            $cancelBooking->bind_param("i", $payment_id);
            $cancelBooking->execute();

            header("Location: home.php");
            exit();
        }
    } else {
        echo "Payment not found!";
        exit();
    }
    $query->close();
} else {
    echo "Payment ID not provided!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .cancel-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 600px;
            font-size: 18px;
        }
        .cancel-container h2 {
            font-size: 28px;
            color: #dc3545;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .cancel-container p {
            color: #333;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .cancel-button, .cancel-button1 {
            padding: 12px 30px;
            font-size: 16px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .cancel-button {
            background: linear-gradient(45deg, #ff6347, #ff0000);
        }
        .cancel-button1 {
            background: linear-gradient(45deg, rgb(42, 194, 221), rgba(0, 157, 255, 0.78));
        }
        .cancel-button:hover {
            background: linear-gradient(45deg, rgba(196, 10, 10, 0.77), rgb(228, 8, 30));
            transform: scale(1.05);
        }
        .cancel-button1:hover {
            background: linear-gradient(45deg, rgba(47, 0, 255, 0.9), rgba(73, 53, 220, 0.61));
            transform: scale(1.05);
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
    </style>
</head>
<body>
<div class="cancel-container">
    <h2>Cancel Payment</h2>
    <p>Are you sure you want to cancel this payment? This action cannot be undone.</p>
    <form method="POST">
        <button type="submit" class="cancel-button">Cancel Payment</button>
    </form>
    <br>
    <div class="button-container">
        <a href="home.php" class="cancel-button1">Go to Home</a>
    </div>
</div>
</body>
</html>
