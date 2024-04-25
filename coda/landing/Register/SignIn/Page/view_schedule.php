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

// Handle delete action
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM schedules WHERE sched_id = '$delete_id'";
    if (mysqli_query($conn, $delete_sql)) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $sched_id = $_POST["sched_id"];
    $course_id = $_POST["course_id"];
    $year = $_POST["year"];
    $block = $_POST["block"];
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $day_of_week = $_POST["day_of_week"];
    $subject = $_POST["subject"];
    $from_month = $_POST["from_month"];
    $to_month = $_POST["to_month"];
    $room_id = $_POST["room_id"];

    $year_and_block = $year . $block;

    // Update the schedule in the database
    $update_sql = "UPDATE schedules SET course_id = '$course_id',
                    start_time = '$start_time', end_time = '$end_time', day_of_week = '$day_of_week',
                    subject = '$subject', from_month = '$from_month', to_month = '$to_month', room_id = '$room_id',  year_and_block = '$year_and_block'
                    WHERE sched_id = '$sched_id'";
    if (mysqli_query($conn, $update_sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . mysqli_error($conn);
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

// Fetch schedules added by the logged-in user with room names and course information
$sql = "SELECT s.*, r.room_name, c.course_code 
        FROM schedules s 
        INNER JOIN rooms r ON s.room_id = r.room_id 
        INNER JOIN courses c ON s.course_id = c.course_id
        WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View My Schedules</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Popup container */
        .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Popup content */
        .popup-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
    </style>
</head>
<body>

<div class="navbar_center_text">
    <a href="#">Home</a>
    <a href="sched.php">Add Schedule</a>
    <a href="view_schedule.php">View schedule</a>
    <a class="logout" href="logout.php"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a>
    
</div>

<div class="schedule-container">
    <h2>My Schedules</h2>
    <table>
        <thead>
        <tr>
            <th>Course</th> <!-- Modified to display course -->
            <th>Start Time</th>
            <th>End Time</th>
            <th>Day of Week</th>
            <th>Subject</th>
            <th>From Month</th>
            <th>To Month</th>
            <th>Room Name</th>
            <th>Actions</th> <!-- New column for actions -->
        </tr>
        </thead>
        <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $start_time = date("h:i A", strtotime($row['start_time']));
                $end_time = date("h:i A", strtotime($row['end_time']));
                $course_display = $row['course_code'] . ' - ' . $row['year_and_block']; // Concatenate course code with year and block
                echo "<tr>";
                echo "<td>" . $course_display . "</td>"; // Display concatenated course information
                echo "<td>" . $start_time . "</td>";
                echo "<td>" . $end_time . "</td>";
                echo "<td>" . $row['day_of_week'] . "</td>";
                echo "<td>" . $row['subject'] . "</td>";
                echo "<td>" . $row['from_month'] . "</td>";
                echo "<td>" . $row['to_month'] . "</td>";
                echo "<td>" . $row['room_name'] . "</td>";
                echo "<td>
        <button onclick=\"openPopup(" . $row['sched_id'] . ")\">Edit</button>
        <button onclick=\"confirmDelete(" . $row['sched_id'] . ")\">Delete</button>
      </td>"; // Edit and Delete buttons

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No schedules added yet.</td></tr>"; // Adjusted colspan
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Popup for editing schedule -->
<div id="editPopup" class="popup">
    <div class="popup-content">
        <!-- Add your form for editing schedule here -->
        <h2>Edit Schedule</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <input type="hidden" id="sched_id" name="sched_id"> <!-- Hidden field for schedule ID -->

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
        <button onclick="closePopup()">Close</button>
    </div>
</div>

<script>
    function openPopup(sched_id) {
        // Show the popup
        var popup = document.getElementById('editPopup');
        popup.style.display = 'block';

        // Set schedule ID in hidden field
        document.getElementById('sched_id').value = sched_id;

        // Fetch schedule details using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var schedule = JSON.parse(xhr.responseText);

                // Populate form fields with schedule details
                document.getElementById('course').value = schedule.course_id;
                document.getElementById('year').value = schedule.year_and_block.charAt(0); // Extract year from year_and_block
                document.getElementById('block').value = schedule.year_and_block.charAt(1); // Extract block from year_and_block
                document.getElementById('start_time').value = schedule.start_time;
                document.getElementById('end_time').value = schedule.end_time;
                document.getElementById('day_of_week').value = schedule.day_of_week;
                document.getElementById('subject').value = schedule.subject;
                document.getElementById('from_month').value = schedule.from_month;
                document.getElementById('to_month').value = schedule.to_month;
                document.getElementById('room').value = schedule.room_id;
            }
        };
        xhr.open("GET", "get_schedule_details.php?sched_id=" + sched_id, true);
        xhr.send();
    }

    function closePopup() {
        // Close the popup
        var popup = document.getElementById('editPopup');
        popup.style.display = 'none';
    }
</script>

<script>
    function confirmDelete(sched_id) {
        if (confirm("Are you sure you want to delete this schedule?")) {
            window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?delete_id=" + sched_id;
        }
    }
</script>

</body>
</html>
