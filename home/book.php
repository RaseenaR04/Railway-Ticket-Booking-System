<?php
session_start();
include("../connection.php");
$sql = "SELECT 
            schedule.schedule_id, 
            schedule.train_id, 
            train.train_name, 
            route.start, 
            route.stop,
            train.first_seat, 
            train.second_seat, 
            schedule.date, 
            schedule.time,
            schedule.first_fee, 
            schedule.second_fee 
        FROM schedule
        INNER JOIN train ON schedule.train_id = train.train_id
        INNER JOIN route ON schedule.route_id = route.route_id";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BOOK TRAIN TICKETS</title>
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
            background-image: url('../images/train1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            z-index: -1;
            opacity: 0.56;
        }
        h2 {
            color: #000000;
            text-decoration: underline;
            margin-bottom: 30px;
        }
        .t-table {
            width: 90%;
            margin: auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            background-color: rgba(255, 255, 255, 0.744);
            border-radius: 10px;
            overflow: hidden;
        }
        .t-table th, .t-table td {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            color: #333;
        }
        .t-table th {
            background-color: #031389;
            color: #ffffff;
            font-size: 16px;
        }
        .t-table td:nth-child(2),
        .t-table td:nth-child(3) {
            font-weight: bold;
        }
        .t-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .t-table tr:hover {
            background-color: #d6e9ff;
            transition: 0.3s;
        }
        .book-btn {
            display: inline-block;
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }
        .book-btn:hover {
            background-color: #218838;
        }
        @media (max-width: 768px) {
            .t-table {
                width: 100%;
                font-size: 12px;
            }
            .t-table th, .t-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <h2>Train Schedule</h2>
    <table border="1" class="t-table">
        <tr>
            <th>Schedule ID</th>
            <th>Train ID</th>
            <th>Train Name</th>
            <th>Start Station</th>
            <th>Stop Station</th>
            <th>Seats (1st Class)</th>
            <th>Seats (2nd Class)</th>
            <th>Date</th>
            <th>Time</th>
            <th>Cost 1st Class</th>
            <th>Cost 2nd Class</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['schedule_id']}</td>
                        <td>{$row['train_id']}</td>
                        <td>{$row['train_name']}</td>
                        <td>{$row['start']}</td>
                        <td>{$row['stop']}</td>
                        <td>{$row['first_seat']}</td>
                        <td>{$row['second_seat']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['time']}</td>
                        <td>{$row['first_fee']}</td>
                        <td>{$row['second_fee']}</td>
                        <td><a href='booking.php?schedule_id={$row['schedule_id']}' class='book-btn'>Book</a></td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No records found</td></tr>";
        }
        ?>
    </table>
</body>
</html>
