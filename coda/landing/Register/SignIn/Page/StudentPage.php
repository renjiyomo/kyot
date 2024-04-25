<?php
include('tracking_db.php');
session_start();

if (!isset($_SESSION['user_name']) || !isset($_SESSION['user_id'])) {
  header('Location: /coda/landing/Register/SignIn/signin.php');
  exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT names FROM users WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

if ($result) {
  $user_row = mysqli_fetch_assoc($result);
  $user_name = $user_row['names'];
} else {
  $user_name = "User";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/student.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <title>CSD Faculty</title>
  
  <script>
	$(document).ready(function(){
		$(".profile .icon_wrap").click(function(){
		  $(this).parent().toggleClass("active");
		  $(".notifications").removeClass("active");
		});

		$(".notifications .icon_wrap").click(function(){
		  $(this).parent().toggleClass("active");
		   $(".profile").removeClass("active");
		});

		$(".show_all .link").click(function(){
		  $(".notifications").removeClass("active");
		  $(".popup").show();
		});

		$(".close").click(function(){
		  $(".popup").hide();
		});
	});
  </script>

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
        <a href="#prof">Professors</a>
      </div>

      <div class="navbar_right">
        <div class="notifications">

          
        </div>
         <div class="profile">
          <div class="icon_wrap">
            <img src="imahe/profile/icon.png" alt="profile_pic">
          </div>

          <div class="profile_dd">
            <ul class="profile_ul">
              <li class="profile_li">
                <a class="profile" href="#"><span class="picon"><i class="fas fa-user-alt"></i></span><?php echo $user_name; ?></a>
              </li>
              <li><a class="logout" href="logout.php"><span class="picon"><i class="fas fa-sign-out-alt"></i></span>Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
</nav>

<header class="itloog__container header__container" id="homealone">
  <div class="header__content">
    <h1>Computer Studies<br><h1 class="dp">Department</h1></h1>
  </div>
</header>

<header class="itloog__container header__search" id="homealone">
  <div class="header__content">
    <form action="" class="search-bar">
     <input type="text" placeholder="search name..">
     <button type="submit" i class="ri-search-line"></i></button>
    </form> 
  </div>
  <div class="header__image">
    <img src="imahe/torch.png" alt="header" />
  </div>
</header>

<div class="container" id="prof">
    <div class="row">
        <div class="tree">
            <h1>CSD FACULTY</h1>
            <ul>
                <li>
                    <div class="professor">
                    <div class="dropdown">
                        <a class="prof-mscs" href="portfolio.php?professor_id=1">
                          <img src="imahe/profile/prof12.png">
                          <span>
                            <?php
                               
                                $prof_query = "SELECT names FROM faculties WHERE faculty_id = 1"; 
                                $prof_result = mysqli_query($conn, $prof_query);
                                if ($prof_result && mysqli_num_rows($prof_result) > 0) {
                                    $prof_row = mysqli_fetch_assoc($prof_result);
                                    echo $prof_row['names'];
                                } else {
                                    echo "Professor 1";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                    $currentDayOfWeek = date("l");
                                    echo "Current Day of Week: " . $currentDayOfWeek;

                                    $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                  FROM schedules s 
                                                  JOIN rooms r ON s.room_id = r.room_id
                                                  WHERE s.user_id = 1 AND s.day_of_week = '$currentDayOfWeek'";
                                    $sched_result = mysqli_query($conn, $sched_query);

                                    if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                      while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                        $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                        $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                    
                                        echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                        echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                        echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                    }
                                    } else {
                                        echo "<li><a>No schedule found for today</a></li>";
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                </ul>
                <ul>
                <li>
                    <div class="professor">
                    <div class="dropdown">
                        <a class="prof-math" href="portfolio.php?professor_id=2">
                          <img src="imahe/profile/prof8.png">
                          <span>
                            <?php
                                
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 2";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 2";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                 date_default_timezone_set('Asia/Manila');
                                 
                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 2 AND s.day_of_week = '$currentDayOfWeek'";

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=3">
                          <img src="imahe/profile/prof5.png">
                          <span>
                            <?php
 
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 3"; 
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 3";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                   date_default_timezone_set('Asia/Manila');

                                    $currentDayOfWeek = date("l");
                                    echo "Current Day of Week: " . $currentDayOfWeek;

                                    $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                  FROM schedules s 
                                                  JOIN rooms r ON s.room_id = r.room_id
                                                  WHERE s.user_id = 3 AND s.day_of_week = '$currentDayOfWeek'";
                                    $sched_result = mysqli_query($conn, $sched_query);

                                    if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                      while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                        $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                        $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                    
                                        echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                        echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                        echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                    }
                                    } else {
                                        echo "<li><a>No schedule found for today</a></li>";
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=4">
                          <img src="imahe/profile/prof10.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 4";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 4";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 4 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=5">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 5";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 5";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                    $currentDayOfWeek = date("l");
                                    echo "Day of Week: " . $currentDayOfWeek;

                                    $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                  FROM schedules s 
                                                  JOIN rooms r ON s.room_id = r.room_id
                                                  WHERE s.user_id = 5 AND s.day_of_week = '$currentDayOfWeek'";

                                    $sched_result = mysqli_query($conn, $sched_query);

                                    if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                      while ($sched_row = mysqli_fetch_assoc($sched_result)) {

                                        $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                        $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                    
                                        echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                        echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                        echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                    }
                                    } else {
                                        echo "<li><a>No schedule found for today</a></li>";
                                    }
                                  ?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                </ul>
                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=6">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 6";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 6";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 6 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=7">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 7";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 7";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 7 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=8">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 8";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 8";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 8 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=9">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 9";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 9";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 9 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
              </ul>
                <ul>
                  <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=10">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 10";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 10";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 10 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=11">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 11";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 11";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 11 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=12">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 12";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 12";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo "Current Day of Week: " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 12 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                                  
                <li>
                    <div class="professor">
                    <div class="dropdown">
                    <a class="prof-mscs" href="portfolio.php?professor_id=13">
                          <img src="imahe/profile/prof9.png">
                          <span>
                            <?php
                                $prof_query2 = "SELECT names FROM faculties WHERE faculty_id = 13";
                                $prof_result2 = mysqli_query($conn, $prof_query2);
                                if ($prof_result2 && mysqli_num_rows($prof_result2) > 0) {
                                    $prof_row2 = mysqli_fetch_assoc($prof_result2);
                                    echo $prof_row2['names'];
                                } else {
                                    echo "Professor 13";
                                }
                            ?>
                          </span>
                        </a>
                 
                            <div class="dropdown-menu">
                                <ul>
                                <?php
                                  date_default_timezone_set('Asia/Manila');

                                  $currentDayOfWeek = date("l");
                                  echo " " . $currentDayOfWeek;

                                  $sched_query = "SELECT s.subject, s.start_time, s.end_time, r.room_name 
                                                FROM schedules s 
                                                JOIN rooms r ON s.room_id = r.room_id
                                                WHERE s.user_id = 13 AND s.day_of_week = '$currentDayOfWeek'";
                                  $sched_result = mysqli_query($conn, $sched_query);

                                  if ($sched_result && mysqli_num_rows($sched_result) > 0) {
                                    while ($sched_row = mysqli_fetch_assoc($sched_result)) {
                                        
                                      $start_time = date("h:ia", strtotime($sched_row['start_time']));
                                      $end_time = date("h:ia", strtotime($sched_row['end_time']));
                                  
                                      echo "<li><a>" . $sched_row['subject'] . "</a></li>";
                                      echo "<li><a>" . $start_time . "-" . $end_time . "</a></li>";
                                      echo "<li><a>" . $sched_row['room_name'] . "</a></li>";
                                  }
                                  } else {
                                      echo "<li><a>No schedule found for today</a></li>";
                                  }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>




<script>
    $(document).ready(function(){
        $(".prof-mscs, .prof-math").hover(function(){
            $(this).siblings(".dropdown-menu").toggle();
        });
    });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Find the "Professors" link
    var professorsLink = document.querySelector('a[href="#prof"]');

    // Add click event listener
    professorsLink.addEventListener("click", function(event) {
      event.preventDefault(); // Prevent default behavior of anchor tag
      var element = document.getElementById("prof");
      element.scrollIntoView({ behavior: "smooth" }); // Smoothly scroll to the element
    });
  });
</script>
</body>
</html>
