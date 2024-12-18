<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plot Twist</title>
  <link rel="stylesheet" href="../assets/css/login.css">
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">

</head>

<body>
  <div class="container">
    <!-- Left Section -->
    <div class="left-section">
      <div class="content">
        <img src="../assets/images/booktree.jpeg" alt="Desert Landscape" class="background-image">
        <p class="caption">Capturing Moments, <br> Creating Memories</p>
        <div class="slider-dots">
          <span> <img src="../assets/images/booktree.jpeg" alt="Desert Landscape" class="background-image"></span>
          <span class="active"></span>
        </div>
      </div>
    </div>

    <!-- Right Section -->
    <div class="right-section">
      <div class="form-container">
        <h1>PLOT TWIST</h1>
        <h2>Sign In</h2>

        <form>

          <input type="email" id="useremail" placeholder="Email" required>
          <span id="emailError" class="error-message"></span>

          <div class="password-field">
            <input type="password" id="userpassword" placeholder="Enter your password" required>
            <span id="passwordError" class="error-message"></span>
          </div>

          <div class="checkbox">
            <p class="right-text">Don't have an account? <a href="SignUp.php">Sign Up</a></p>
          </div>

          <button type="button" onclick="return validateform()" class="create-account-button">Sign in</button>
        </form>

      </div>
    </div>
  </div>
  <script src="../assets/js/sweetalert2.min.js"></script>
  <script src="../assets/js/login.js"></script>
</body>

</html>