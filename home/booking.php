<?php
session_start();
include("../connection.php");

if (isset($_GET['schedule_id'])) {
    $schedule_id = $_GET['schedule_id'];
    $query = $con->prepare("SELECT s.schedule_id, s.train_id, s.route_id, s.date, s.time, s.first_fee, s.second_fee, 
                            t.train_name, t.first_seat, t.second_seat,
                            r.start, r.stop 
                            FROM schedule s 
                            JOIN train t ON s.train_id = t.train_id 
                            JOIN route r ON s.route_id = r.route_id 
                            WHERE s.schedule_id = ?");
    $query->bind_param("i", $schedule_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row          = $result->fetch_assoc();
        $train_name   = $row['train_name'];
        $start_station= $row['start'];
        $stop_station = $row['stop'];
        $fees_1st     = $row['first_fee'];
        $fees_2nd     = $row['second_fee'];
        $seats_1st    = $row['first_seat'];
        $seats_2nd    = $row['second_seat'];
    } else {
        echo "Invalid Schedule!";
        exit();
    }
    $query->close();
} else {
    echo "No schedule selected!";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BOOKING</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('../images/train3.jpg') no-repeat center center/cover;
            font-family: Arial, sans-serif;
            color: white;
        }
        .booking-container {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            text-align: center;
            width: 40%;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
        }
        h2 {
            text-decoration: underline;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        select, button {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
        }
        button {
            background-color: #ffcc00;
            color: black;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff9900;
        }
    </style>
    <script>
        function updateSeats() {
            var classType = document.getElementById("class").value;
            var seatsDropdown = document.getElementById("num_tickets");
            seatsDropdown.innerHTML = "";
            var maxSeats = classType === "1st" ? <?php echo (int)$seats_1st; ?> : <?php echo (int)$seats_2nd; ?>;
            for (var i = 1; i <= maxSeats; i++) {
                var option = document.createElement("option");
                option.value = i;
                option.text = i;
                seatsDropdown.appendChild(option);
            }
        }
    </script>
</head>
<body>
    <div class="booking-container">
        <h2>Book for <?php echo htmlspecialchars($start_station . " to " . $stop_station); ?></h2>
        <form action="payment.php" method="POST">
            <input type="hidden" name="schedule_id" value="<?php echo htmlspecialchars($schedule_id); ?>">
            <label for="class">Class:</label>
            <select name="class" id="class" onchange="updateSeats()" required>
                <option value="">Select Class</option>
                <option value="1st">First Class - ₹<?php echo htmlspecialchars($fees_1st); ?> (Seats: <?php echo htmlspecialchars($seats_1st); ?>)</option>
                <option value="2nd">Second Class - ₹<?php echo htmlspecialchars($fees_2nd); ?> (Seats: <?php echo htmlspecialchars($seats_2nd); ?>)</option>
            </select>
            <label for="num_tickets">Number of Tickets:</label>
            <select name="num_tickets" id="num_tickets" required>
                <option value="">Select Number</option>
            </select>
            <button type="submit">Confirm Booking</button>
        </form>
    </div>
</body>
</html>
