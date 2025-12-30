<?php
session_start();
include("../connection.php");

if (!isset($_SESSION['email'], $_SESSION['passenger_id'])) {
    header("Location: ../signin.php");
    exit();
}

$passenger_id = (int)$_SESSION['passenger_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedule_id  = isset($_POST['schedule_id']) ? (int)$_POST['schedule_id'] : 0;
    $class        = isset($_POST['class']) ? $_POST['class'] : '';
    $num_tickets  = isset($_POST['num_tickets']) ? (int)$_POST['num_tickets'] : 0;
} else {
    echo "Invalid request!";
    exit();
}

$checkPassengerQuery = $con->prepare("SELECT passenger_id FROM passenger WHERE passenger_id = ?");
$checkPassengerQuery->bind_param("i", $passenger_id);
$checkPassengerQuery->execute();
$checkPassengerResult = $checkPassengerQuery->get_result();

if ($checkPassengerResult->num_rows == 0) {
    echo "Passenger does not exist!";
    exit();
}

$query = $con->prepare("SELECT date, first_fee, second_fee FROM schedule WHERE schedule_id = ?");
$query->bind_param("i", $schedule_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $row            = $result->fetch_assoc();
    $date           = $row['date'];
    $cost_per_ticket= ($class === "1st") ? $row['first_fee'] : $row['second_fee'];
    $total_amount   = $num_tickets * $cost_per_ticket;

    if (!isset($_SESSION['payment_id'])) {
        $payment_id = rand(100000, 999999);
        $_SESSION['payment_id'] = $payment_id;
    } else {
        $payment_id = $_SESSION['payment_id'];
    }

    if (isset($_POST['pay'])) {
        $insertBooked = $con->prepare("INSERT INTO booked (schedule_id, payment_id, class, no, date, amount, passenger_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertBooked->bind_param("isisssi", $schedule_id, $payment_id, $class, $num_tickets, $date, $total_amount, $passenger_id);
        $insertBooked->execute();
        $book_id = $con->insert_id;

        $insertPayment = $con->prepare("INSERT INTO payment (book_id, payment_id, schedule_id, amount, passenger_id) VALUES (?, ?, ?, ?, ?)");
        $insertPayment->bind_param("iiiid", $book_id, $payment_id, $schedule_id, $total_amount, $passenger_id);
        $insertPayment->execute();

        header("Location: success.php");
        exit();
    }
} else {
    echo "Invalid Schedule!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .payment-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
            border: 1px solid #ddd;
            margin-top: 30px;
        }
        .payment-container h2 {
            font-size: 22px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .payment-summary {
            margin-bottom: 30px;
            border: 1px solid #f2f2f2;
            padding: 18px;
            border-radius: 8px;
            background-color: #fafafa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }
        .payment-detail {
            padding: 10px 15px;
            margin-bottom: 8px;
            border-bottom: 1px solid #e2e2e2;
            font-size: 18px;
            color: #555;
            text-align: left;
            font-weight: 500;
        }
        .payment-detail:last-child {
            border-bottom: none;
        }
        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #6a9e3a;
        }
        .payment-button {
            padding: 12px 24px;
            background-color: #6a9e3a;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            width: 100%;
            border: none;
            margin-top: 15px;
            cursor: pointer;
        }
        .payment-button:hover {
            background-color: #4c7a29;
        }
        @media (max-width: 768px) {
            .payment-container {
                padding: 15px;
            }
            .payment-button {
                font-size: 14px;
                padding: 10px 18px;
            }
        }
    </style>
</head>
<body>
<div class="payment-container">
    <h2>Payment Details</h2>
    <div class="payment-summary">
        <div class="payment-detail">
            <p><strong>Schedule ID:</strong> <?php echo htmlspecialchars($schedule_id); ?></p>
        </div>
        <div class="payment-detail">
            <p><strong>Payment ID:</strong> <?php echo htmlspecialchars($payment_id); ?></p>
        </div>
        <div class="payment-detail">
            <p><strong>Class:</strong> <?php echo htmlspecialchars($class); ?></p>
        </div>
        <div class="payment-detail">
            <p><strong>Number of Seats:</strong> <?php echo htmlspecialchars($num_tickets); ?></p>
        </div>
        <div class="payment-detail">
            <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
        </div>
        <div class="total-amount">
            <p><strong>Total Amount:</strong> ₹<?php echo htmlspecialchars($total_amount); ?></p>
        </div>
    </div>
    <form action="payment.php" method="POST" id="payment-form">
        <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($schedule_id); ?>">
        <input type="hidden" name="class" value="<?php echo htmlspecialchars($class); ?>">
        <input type="hidden" name="num_tickets" value="<?php echo htmlspecialchars($num_tickets); ?>">
        <button type="submit" name="pay" class="payment-button">Pay Now</button>
    </form>
</div>
</body>
</html>
