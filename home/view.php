<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['email'])) {
    header("Location: ../signin.php");
    exit();
}

$email = $_SESSION['email'];

$query = $con->prepare(
    "SELECT p.payment_id, p.amount, p.schedule_id, s.date, b.class, b.no 
     FROM payment p
     JOIN booked b ON p.payment_id = b.payment_id
     JOIN schedule s ON b.schedule_id = s.schedule_id
     JOIN passenger pa ON p.passenger_id = pa.passenger_id
     WHERE pa.email = ?"
);
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .bookings-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 800px;
            box-sizing: border-box;
        }
        h2 {
            color: #007bff;
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
        }
        .booking-item {
            margin-bottom: 20px;
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }
        .booking-item p {
            margin: 5px 0;
        }
        .btn-view-payment {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            margin-top: 10px;
        }
        .btn-view-payment:hover {
            background-color: #0056b3;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
        .btn-home {
            padding: 12px 30px;
            font-size: 16px;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
        }
        .btn-home:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<div class="bookings-container">
    <h2>Your Bookings</h2>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $payment_id  = $row['payment_id'];
            $amount      = $row['amount'];
            $schedule_id = $row['schedule_id'];
            $date        = $row['date'];
            $class       = $row['class'];
            $num_tickets = $row['no'];

            echo "<div class='booking-item'>
                    <p><strong>Payment ID:</strong> " . htmlspecialchars($payment_id) . "</p>
                    <p><strong>Schedule ID:</strong> " . htmlspecialchars($schedule_id) . "</p>
                    <p><strong>Class:</strong> " . htmlspecialchars($class) . "</p>
                    <p><strong>Number of Tickets:</strong> " . htmlspecialchars($num_tickets) . "</p>
                    <p><strong>Schedule Date:</strong> " . htmlspecialchars($date) . "</p>
                    <p><strong>Total Amount Paid:</strong> ₹" . htmlspecialchars($amount) . "</p>
                    <a href='view_payment.php?payment_id=" . htmlspecialchars($payment_id) . "' class='btn-view-payment'>View Payment</a>
                  </div>";
        }
    } else {
        echo "<p>No bookings found!</p>";
    }
    ?>
    <div class="button-container">
        <a href="home.php" class="btn-home">Go to Home</a>
    </div>
</div>
</body>
</html>
