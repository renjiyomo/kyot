<?php

@include 'tracking_db.php';

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>CSD Sign In</title>
   <link rel="stylesheet" href="signin.css">

</head>
<body>

<?php

@include 'tracking_db.php';

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);

   // Check if user exists in the users table
   $select_user = "SELECT * FROM users WHERE email = '$email' && password = '$pass'";
   $result_user = mysqli_query($conn, $select_user);

   if(mysqli_num_rows($result_user) > 0){
      $row_user = mysqli_fetch_array($result_user);
   
      $user_id = $row_user['user_id'];
   
      if($row_user['user_type'] == 'a'){
         $_SESSION['admin_name'] = $row_user['names'];
         $_SESSION['user_id'] = $user_id; 
         header('location: adminpage.php');
      } elseif($row_user['user_type'] == 'u'){
         $_SESSION['user_name'] = $row_user['names'];
         $_SESSION['user_id'] = $user_id; 
         header('location: Page/StudentPage.php');
      }
   }

   // Check if user exists in the faculties table
   $select_faculty = "SELECT * FROM faculties WHERE email = '$email' && password = '$pass'";
   $result_faculty = mysqli_query($conn, $select_faculty);

   if(mysqli_num_rows($result_faculty) > 0){
      $row_faculty = mysqli_fetch_array($result_faculty);
   
      $faculty_id = $row_faculty['faculty_id'];
   
      if($row_faculty['type'] == 'p' && $row_faculty['status'] == 'a'){
         $_SESSION['prof_name'] = $row_faculty['names'];
         $_SESSION['user_id'] = $faculty_id; 
         header('location: Page/profpage.php');
      }
   } else {
      $error[] = 'Incorrect email or password!';
   }

}

?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>Sign In</h3>
      <?php
      if(isset($error)){
         foreach($error as $error_msg){
            echo '<span class="error-msg">'.$error_msg.'</span>';
         }
      }
      ?>
      <input type="email" name="email" required placeholder="Enter your email">
      <input type="password" name="password" required placeholder="Enter your password">
      <input type="submit" name="submit" value="Login" class="form-btn">
      <p>Don't have an account? <a href="/coda/landing/Register/signup.php">Register</a></p>
   </form>

</div>

</body>
</html>
