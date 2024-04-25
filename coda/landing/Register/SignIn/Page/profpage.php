<?php

@include 'tracking_db.php';
session_start();

if (!isset($_SESSION['prof_name']) || !isset($_SESSION['user_id'])) {
    header('Location: /coda/landing/Register/SignIn/signin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/prof.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>CSD Faculty</title>
  </head>
  <body>

<nav>  

<div class="wrapper">
  <nav class="navbar">
    <div class="navbar_left">
      <div class="nav__logo">
        <a href="#"><img src="imahe/FAST.png" alt="logo" /></a>
      </div>
    </div>
    <div class="navbar_center_text">
      <a href="#">Home</a>
      <a href="sched.php">Add Schedule</a>
      <a href="view_schedule.php">View schedule</a>
      <li><a class="logout" href="logout.php"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
          </ul>
    </div>

    <div class="navbar_right">
      <div class="notifications">
        
        
      </div>
      <div class="profile">
        <div class="icon_wrap">
          <img src="imahe/profile/prof1.png" alt="profile_pic">
        </div>

        <div class="profile_dd">
          <ul class="profile_ul">
            <li class="profile_li"><a class="profile" href="#"><span class="picon"><i class="fas fa-user-alt"></i>
                </span>Profile</a>
              <div class="btn">My Account</div>
            </li>
            <li><a class="address" href="#"><span class="picon"><i class="fas fa-map-marker"></i></span>Address</a></li>
            <li><a class="settings" href="#"><span class="picon"><i class="fas fa-cog"></i></span>Settings</a></li>
            <li><a class="logout" href="#"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>

    </nav>
    
    <header class="itloog__container header__container" id="homealone">
      <div class="header__content">
        <h1>Computer Studies<br><h1 class="dp">Department</h1></h1>
    
        <form action="" class="search-bar">
         <input type="text" placeholder="search name..">
         <button type="submit" i class="ri-search-line"></i></button>
        </form> 

      </div>
      <div class="header__image">
        <img src="imahe/torch.png" alt="header" />
      </div>
    </header>

    
</html>
