<?php
// Include your existing database connection
include('tracking_db.php');

session_start();

if (!isset($_SESSION['prof_name']) || !isset($_SESSION['user_id'])) {
    header('Location: /coda/landing/Register/SignIn/signin.php');
    exit();
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $day_of_week = $_POST["day_of_week"];
    $subject = $_POST["subject"];
    $from_month = $_POST["from_month"];
    $to_month = $_POST["to_month"];
    $room_id = $_POST["room_id"];
    $course_id = $_POST["course_id"]; // New line to capture selected course ID
    $year = $_POST["year"]; // New line to capture selected year
    $block = $_POST["block"]; // New line to capture selected block

    // Combine year and block into a single string
    $year_and_block = $year . $block;

    // Insert data into database
    $sql = "INSERT INTO schedules (user_id, course_id, start_time, end_time, day_of_week, subject, from_month, to_month, room_id, year_and_block)
            VALUES ('$user_id', '$course_id', '$start_time', '$end_time', '$day_of_week', '$subject', '$from_month', '$to_month', '$room_id', '$year_and_block')";

    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql_rooms = "SELECT * FROM rooms";
$result_rooms = mysqli_query($conn, $sql_rooms);
$room_options = "";
if (mysqli_num_rows($result_rooms) > 0) {
    while ($row = mysqli_fetch_assoc($result_rooms)) {
        $room_id = $row['room_id'];
        $room_name = $row['room_name'];
        $room_options .= "<option value='$room_id'>$room_name</option>";
    }
}

// Array of month names
$months = array(
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
);

// Array of days of the week
$days_of_week = array(
    "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Schedule</title>
</head>
<body>

<div class="navbar_center_text">
    <a href="#">Home</a>
    <a href="addsched.php">Add Schedule</a>
    <a href="view_schedule.php">View schedule</a>
    <a class="logout" href="logout.php"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a>
</div>
    
<div class="form-container">
    <h2>Add Schedule</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <label for="course">Course:</label>
        <select id="course" name="course_id" required>
            <?php
            $sql_courses = "SELECT * FROM courses";
            $result_courses = mysqli_query($conn, $sql_courses);
            if (mysqli_num_rows($result_courses) > 0) {
                while ($row = mysqli_fetch_assoc($result_courses)) {
                    $course_id = $row['course_id'];
                    $course_code = $row['course_code'];
                    echo "<option value='$course_id'>$course_code</option>";
                }
            }
            ?>
        </select><br><br>

        <label for="year_block">Year and Block:</label>
<div class="year-block-select">
    <select id="year" name="year" required>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
    </select>
    <select id="block" name="block" required>
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
    </select>
</div>

        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required><br><br>

        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required><br><br>

        <label for="day_of_week">Day of Week:</label>
        <select id="day_of_week" name="day_of_week" required>
            <?php
            foreach ($days_of_week as $day) {
                echo "<option value='$day'>$day</option>";
            }
            ?>
        </select><br><br>
  
        <label for="subject">Subject:</label>
        <input type="text" id="subject" name="subject" required><br><br>

        <label for="from_month">From Month:</label>
        <select id="from_month" name="from_month" required>
            <?php
            foreach ($months as $month) {
                echo "<option value='$month'>$month</option>";
            }
            ?>
        </select><br><br>

        <label for="to_month">To Month:</label>
        <select id="to_month" name="to_month" required>
            <?php
            foreach ($months as $month) {
                echo "<option value='$month'>$month</option>";
            }
            ?>
        </select><br><br>

        <label for="room">Room:</label>
        <select id="room" name="room_id" required>
            <?php echo $room_options; ?>
        </select><br><br>

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
