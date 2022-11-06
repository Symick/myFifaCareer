<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en" id="top-window">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles/reset.css" />
    <link rel="stylesheet" href="styles/style.css" />
    <link rel="icon" href="img/logo.png" />

     <!-- get Font-awesome -->
    <script src="https://kit.fontawesome.com/045f11e82e.js" crossorigin="anonymous"></script>
    
    <script src="scripts/logo-spinner.js" defer></script>
    <script src="scripts/password-check.js" defer></script>
    <title>Sign-up</title>
  </head>
  <body class="sign-up-body">
    <header class="header">
      <!-- div left is made to make sure logo stays in the middle with flexbox -->
      <div class="left"></div>
      <div class="logo">
        <a href="#top-window"
          ><img src="img/logo.png" alt="Logo MyFIFAcareer"
        /></a>
      </div>
      <nav class="nav-menu" data-nav-page="sign-up">
        <ul>
          <li>
            <a href="index.php"> 
              <i class="fa-solid fa-house"></i><span class="home-link-text">Home</span>
            </a>
          </li>
        </ul>
      </nav>
    </header>
    <main class="sign-up-form">
      <div class="sign-up-form-container">
        <div class="sign-up-clip-path-container">
          <h1 class="sign-up-title">Sign-up!</h1>
          <form action="back-end/sign-up-back-end.php" method="post">
            <div class="sign-up-div two-input-container">
              <input type="text" name="name" placeholder="Full name ..." required>
              <input type="text" name="username" placeholder="Username ..." required>
            </div>
            <div class="sign-up-div email-container">
              <input type="email" name="email" placeholder="Email..." required>
            </div>
            <div class="sign-up-div password-container">
              <div class="password-checklist-container">
                <input type="password" name="password" placeholder="Password..." required id="password">
                <ul class="list">
                  <li class="list-item" data-check="length">
                    <i class="fa-solid fa-circle-xmark"></i>                      
                    Password is at least 8 Characters long
                  </li>
                  <li class="list-item" data-check="lower"> 
                    <i class="fa-solid fa-circle-xmark"></i>  
                    Password contains at least one lowercase letter
                  </li>
                  <li class="list-item" data-check="upper">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Password contains at least one uppercase letter
                  </li>
                  <li class="list-item" data-check="number">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Password contains at least one number
                  </li>
                  <li class="list-item" data-check="symbol">
                    <i class="fa-solid fa-circle-xmark"></i>                     
                     Password contains at least one of the following symbols: 
                     ! @ # $ % ^ &amp; * ? . , + _ -
                  </li>
                </ul>
               </div>
               <input type="password" name="repeat-password" placeholder="Repeat your Password ..." required>
            </div>                                                                                                            
            <button type="submit" name="sign-up-submit" class="btn sign-up-button">
              <i class="fas fa-sign-in-alt"></i>
              Sign-up!
            </button>
            <div class="error-display"> 
              <?php
              if (isset($_SESSION['error'])) { 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
              }
              if(isset($_SESSION['created'])) {
                echo $_SESSION['created'];
                unset($_SESSION['created']);
              }
              ?>
            </div>
          </form>
        </div>
      </div>
    </main>
  </body>
</html>
