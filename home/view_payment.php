<?php
session_start();
include("../connection.php");

if (isset($_GET['payment_id'])) {
    $payment_id = (int)$_GET['payment_id'];
    $query = $con->prepare(
        "SELECT p.payment_id, p.amount, p.schedule_id, s.date, s.first_fee, s.second_fee, b.class, b.no
         FROM payment p
         JOIN booked b ON p.payment_id = b.payment_id
         JOIN schedule s ON b.schedule_id = s.schedule_id
         WHERE p.payment_id = ?"
    );
    $query->bind_param("i", $payment_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row         = $result->fetch_assoc();
        $amount      = $row['amount'];
        $date        = $row['date'];
        $class       = $row['class'];
        $num_tickets = $row['no'];
        $schedule_id = $row['schedule_id'];
    } else {
        echo "No payment details found!";
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
    <title>View Payment Details</title>
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
        .payment-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 80%;
            max-width: 600px;
            font-size: 18px;
        }
        .payment-container h2 {
            font-size: 28px;
            color: #007bff;
            margin-bottom: 20px;
            font-weight: bold;
        }
        .payment-detail {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
        }
        .button-container {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        .btn-home {
            padding: 12px 30px;
            font-size: 16px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            background-color: #007bff;
        }
        .btn-home:hover {
            background-color: #0056b3;
        }
        .btn-cancel {
            padding: 12px 30px;
            font-size: 16px;
            color: #fff;
            background-color: #dc3545;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        .btn-cancel:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
<div class="payment-container">
    <h2>Payment Details</h2>
    <div class="payment-detail">
        <strong>Payment ID:</strong> <?php echo htmlspecialchars($payment_id); ?>
    </div>
    <div class="payment-detail">
        <strong>Schedule ID:</strong> <?php echo htmlspecialchars($schedule_id); ?>
    </div>
    <div class="payment-detail">
        <strong>Class:</strong> <?php echo htmlspecialchars($class); ?>
    </div>
    <div class="payment-detail">
        <strong>Number of Tickets:</strong> <?php echo htmlspecialchars($num_tickets); ?>
    </div>
    <div class="payment-detail">
        <strong>Schedule Date:</strong> <?php echo htmlspecialchars($date); ?>
    </div>
    <div class="payment-detail">
        <strong>Total Amount Paid:</strong> ₹<?php echo htmlspecialchars($amount); ?>
    </div>
    <div class="button-container">
        <a href="home.php" class="btn-home">Go to Home</a>
    </div>
    <form action="cancel.php" method="GET">
        <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment_id); ?>">
        <button type="submit" class="btn-cancel">Cancel Payment</button>
    </form>
</div>
</body>
</html>
