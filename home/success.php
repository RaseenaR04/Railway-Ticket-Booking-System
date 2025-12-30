<?php
session_start();
if (isset($_SESSION['payment_id'])) {
    $payment_id = $_SESSION['payment_id'];
} else {
    echo "Payment ID not found!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
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
        .success-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 600px;
            font-size: 18px;
        }
        .success-container h2 {
            font-size: 28px;
            color: #28a745;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .success-container p {
            color: #333;
            margin-bottom: 30px;
            font-size: 16px;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .btn-home, .btn-details {
            padding: 12px 30px;
            font-size: 16px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s;
        }
        .btn-home {
            background-color: #007bff;
        }
        .btn-home:hover {
            background-color: #0056b3;
        }
        .btn-details {
            background-color: #6a9e3a;
        }
        .btn-details:hover {
            background-color: #4c7a29;
        }
        @media (max-width: 768px) {
            .success-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<div class="success-container">
    <h2>Payment Successful!</h2>
    <p>Your payment has been processed successfully. Thank you for your purchase!</p>
    <div class="button-container">
        <a href="home.php" class="btn-home">Go to Home</a>
        <a href="view_payment.php?payment_id=<?php echo htmlspecialchars($payment_id); ?>" class="btn-details">View Payment Details</a>
    </div>
</div>
</body>
</html>
