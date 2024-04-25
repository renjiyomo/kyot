<?php
include('tracking_db.php');
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
  header('Location: /coda/landing/Register/SignIn/signin.php');
  exit();
}

// Check if professor_id is set in the URL
if (!isset($_GET['professor_id'])) {
  header('Location: studentpage.php'); // Redirect to studentpage.php if professor_id is not set
  exit();
}

$faculty_id = $_GET['professor_id']; // Retrieve professor_id from the URL parameter
$query = "SELECT * FROM faculties WHERE faculty_id = $faculty_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
  $faculty_row = mysqli_fetch_assoc($result);
  $faculty_name = $faculty_row['names'];
  $faculty_coordinator = $faculty_row['coordinator'];
  $faculty_contact = $faculty_row['contact_no'];
  $faculty_email = $faculty_row['email'];
  $faculty_address = $faculty_row['address'];
  $faculty_image = $faculty_row['image'];
} else {
  $faculty_name = "Faculty";
  $faculty_coordinator = "";
  $faculty_contact = "";
  $faculty_email = "";
  $faculty_address = "";
  $faculty_image = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="css/portfolio.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
</head>
<body>
   <div class="container">
       <div class="profile-card"> 
            <div class="profile-pic">
                <img src="imahe/profile/<?php echo $faculty_image; ?>" alt="user avatar">
            </div>

            <div class="profile-details">
                 <div class="intro">
                    <h2><?php echo $faculty_name; ?></h2>
                    <h4><?php echo $faculty_coordinator; ?></h4>
                 </div>

                 <div class="contact-info">
                    <div class="row">
                         <div class="icon">
                            <i class="fa fa-phone"  style="color:var(--light-green)"></i>
                         </div>
                         <div class="content">
                            <span>Phone</span>
                            <h5><?php echo $faculty_contact; ?></h5>
                         </div>
                    </div>

                    <div class="row">
                        <div class="icon">
                           <i class="fa fa-envelope-open"  style="color:var(--light-green)"></i>
                        </div>
                        <div class="content">
                           <span>Email</span>
                           <h5><?php echo $faculty_email; ?></h5>
                        </div>
                   </div>
    
                   <div class="row">
                    <div class="icon">
                       <i class="fa fa-map-marker"  style="color:var(--light-purple)"></i>
                    </div>
                    <div class="content">
                       <span>Location</span>
                       <h5><?php echo $faculty_address; ?></h5>
                    </div>
                 </div>
            </div>
         </div>
       </div>

       <div class="about">
           <h1>Schedule</h1>
           <br>
           <h2>wala pa po.</h2>
       </div>
   </div>
</body>
</html>
