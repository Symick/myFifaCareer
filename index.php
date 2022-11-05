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
    
    <!-- Download font-families, montserrat and comfortaa -->
    <link
      href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;700&display=swap"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,400;0,700;1,400&display=swap"
      rel="stylesheet"
    />
    <!-- get Font-awesome -->
    <script src="https://kit.fontawesome.com/045f11e82e.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="styles/style.css" />
    <link rel="icon" href="img/logo.png" />

    <!-- scripts -->
    <script src="scripts/show-password.js" defer></script>
    <script src="scripts/about-us-intersector.js" defer></script>
    <script src="scripts/logo-spinner.js" defer></script>
    <script src="scripts/hamburgerMenu.js" defer></script>
    <title>My Fifa Career</title>
  </head>
  <body>
    <header class="header">
      <!-- div left is made to make sure logo stays in the middle with flexbox -->
      <div class="left"></div>
      <div class="logo">
        <a href="#top-window"
          ><img src="img/logo.png" alt="Logo MyFIFAcareer"
        /></a>
      </div>
      <nav class="nav-menu">
        <ul>
          <li><a href="#about-us">about us</a></li>
          <li><a href="./sign-up.php">sign-up</a></li>
          <li class="login" id="login">
            <a href="#" >log in</a>
            <div class="login-form">
              <form action="back-end/login-back-end.php" method="post">
                <label for="username">Username</label>
                <input
                  type="text"
                  name="username"
                  required
                />
                <label for="password">Password</label>
                <div class="login--password-wrapper">
                  <input type="password" name="password" id="password" required />
                  <i class="far fa-eye-slash" id="eye"></i>
                </div>
                <button type="submit" name="login-submit" class="btn login-btn">
                  Log in!
                </button>
                <div class="error-display">
                <?php
                // check if there is an error and display that error
                if (isset($_SESSION['error'])) { 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                }
                ?>
                </div>
              </form>
            </div>
          </li>
          <li><a href="#contact-us">contact</a></li>
        </ul>
      </nav>
      <div class="hamburger-menu">
        <span class="hamburger-menu--icon"></span>
      </div>
    </header>
    <main>
      <section class="welcome">
        <div class="wrapper">
          <div class="welcome-left">
            <h1 class="welcome-title">Welcome to MyFIFAcareer</h1>
            <p class="welcome-text">
              MyFIFAcareer is a website where you can track and store your
              careermode progress.
            </p>
            <a href="./sign-up.php" class="btn sign-up-btn">Get started now!</a>
          </div>
          <div class="welcome-right">
            <div class="slider">
              <figure>
                <img src="img/FIFA_17_cover.jpeg" alt="FIFA 17 cover" />
                <img src="img/FIFA18cover.png" alt="FIFA 18 cover" />
                <img src="img/FIFA_19_cover.jpg" alt="FIFA 19 cover" />
                <img src="img/FIFA_20_cover.jpg" alt="FIFA 20 cover" />
                <img src="img/FIFA_21_Cover.jpg" alt="FIFA 21 cover" />
                <img src="img/FIFA_22_Cover.jpg" alt="FIFA 22 cover" />
                <img src="img/FIFA_17_cover.jpeg" alt="FIFA 17 cover" />
              </figure>
            </div>
          </div>
        </div>
      </section>
      <div class="wrapper">
        <section class="how-does-it-work">
          <h2 class="title">How does our website work</h2>
          <div class="grid-container">
            <div class="grid-item">
              <h3 class="grid-title">step 1:</h3>
              <img src="img/hdiw/step1.png" alt="photo step 1" />
              <p class="grid-text">
                Create your account using the sign-up buttons found across our
                website
              </p>
            </div>
            <div class="grid-item">
              <h3 class="grid-title">step 2:</h3>
              <img src="img/hdiw/step1.png" alt="photo step 1" />
              <p class="grid-text">Login with the account you just created</p>
            </div>
            <div class="grid-item">
              <h3 class="grid-title">step 3:</h3>
              <img src="img/hdiw/step1.png" alt="photo step 1" />
            </div>
            <div class="grid-item">
              <h3 class="grid-title">step 4:</h3>
              <img src="img/hdiw/step1.png" alt="photo step 1" />
            </div>
            <div class="grid-item">
              <h3 class="grid-title">step 5:</h3>
              <img src="img/hdiw/step1.png" alt="photo step 1" />
            </div>
            <div class="grid-item">
              <h3 class="grid-title">step 6:</h3>
              <img src="img/hdiw/step1.png" alt="photo step 1" />
            </div>
          </div>
        </section>
      </div>
    </main>
    <footer class="about-us" id="about-us">
      <div class="clip-path-container">
        <div class="about-us-wrapper">
          <h2 class="title">about us</h2>
          <p class="about-us-text">
            We at MyFIFAcareer are inspired to become the most popular website
            too track your FIFA careermode and ultimate team player stats. For
            all the nerds out there wanting to know which player was your club
            top scorer or top assister, MyFIFAcareer is the website to use.
          </p>
          <blockquote class="quote-owner">
            After using excel to track my statstracker for years being frustrated at how it
            looked, I decided to take matter into my own hands and created
            MyFIFAcareer. Now im still using MyFIFAcareer for my stats tracking.
          </blockquote>
          <div class="owner-name">julian Kruithof, founder MyFIFAcareer</div>
        </div>
        <div class="contact-us--wrapper">
          <h2 class="title" id="contact-us">contact us</h2>
          <p class="contact-us-text">
            If there are any questions or bugs found, please contact us at this
            email address:
          </p>
          <address>MyFIFAcareer@gmail.com</address>
        </div>
      </div>
    </footer>
  </body>
</html>
