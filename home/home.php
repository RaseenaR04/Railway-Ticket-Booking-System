<?php
session_start();
include("../connection.php");

$n = $d = $g = $e = $c = "N/A";
if (isset($_SESSION['email'])) {
    $e = $_SESSION['email'];
}

$query = $con->prepare("SELECT * FROM passenger WHERE email = ?");
$query->bind_param("s", $e);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $n = $user['passenger_name'];
    $d = $user['dob'];
    $g = $user['gender'];
    $e = $user['email'];
    $c = $user['phone'];
    $_SESSION['passenger_id'] = $user['passenger_id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Railway Ticket Reservation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f8f9fa;
            text-align: center;
        }
        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('../images/train2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: -1;
            opacity: 0.4;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #333;
            color: white;
            padding: 15px 20px;
        }
        .header h2 {
            margin: 0;
        }
        .header a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            background: rgb(173, 13, 50);
            border-radius: 5px;
        }
        .header a:hover {
            background: #e64a19;
        }
        .container {
            width: 80%;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
            text-align: left;
        }
        .welcome {
            text-align: center;
            font-size: 22px;
            margin: 20px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background: rgb(131, 10, 38);
            color: white;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Railway Ticket Reservation</h2>
    <div>
        <a href="book.php">Book Ticket</a>
        <a href="view.php">View Bookings</a>
    </div>
</div>
<div class="container">
    <h2 class="welcome">Welcome, <?php echo htmlspecialchars($n); ?>!</h2>
    <h3>Your Personal Details</h3>
    <table>
        <tr><th>Name</th><td><?php echo htmlspecialchars($n); ?></td></tr>
        <tr><th>Date of Birth</th><td><?php echo htmlspecialchars($d); ?></td></tr>
        <tr><th>Gender</th><td><?php echo htmlspecialchars($g); ?></td></tr>
        <tr><th>Email</th><td><?php echo htmlspecialchars($e); ?></td></tr>
        <tr><th>Phone</th><td><?php echo htmlspecialchars($c); ?></td></tr>
    </table>
</div>
</body>
</html>
