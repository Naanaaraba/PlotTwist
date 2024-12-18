<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plot Twist</title>
  <link rel="stylesheet" href="../assets/css/SignUp.css">
  <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
</head>

<body>
  <div class="container">
    <div class="left-section">
      <div class="content">
        <img src="../assets/images/booktree.jpeg" alt="Desert Landscape" class="background-image">
        <p class="caption">Capturing Moments, <br> Creating Memories</p>
        <div class="slider-dots">
          <span> <img src="../assets/images/booktree.jpeg" alt="Desert Landscape" class="background-image"></span>
          <span></span>
          <span class="active"></span>
        </div>
      </div>
    </div>

    <div class="right-section">
      <div class="form-container">
        <h1>PLOT TWIST</h1>
        <h2>Sign Up</h2>

        <form>
          <div class="name-inputs">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <span id="usernameError" class="error-message"></span>
          </div>
          <input type="email" id="useremail" name="email" placeholder="Email" required>
          <span id="emailError" class="error-message"></span>
          <div class="password-field">
            <input type="password" id="userpassword" name="password" placeholder="Enter your password" required>
            <span id="passwordError" class="error-message"></span>
          </div>
          <div class="password-field">
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm your password" required>
            <span id="confirmError" class="error-message"></span>
          </div>
          <div class="checkbox">
            <input type="checkbox" id="terms" required>
            <label class="left-text" for="terms">I agree to the <a href="#">Terms & Conditions</a></label><br>
            <p class="right-text">Already have an account? <a href="login.php">Log in</a></p>
          </div>

          <button type="button" onclick="validateform()" name="signUpButton" class="create-account-button">Create account</button>
        </form>
      </div>
    </div>
  </div>

  <script src="../assets/js/sweetalert2.min.js"></script>
  <script src="../assets/js/signup.js"></script>
</body>

</html>