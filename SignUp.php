<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plot Twist</title>
  <link rel="stylesheet" href="../assets/css/login.css">
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
          <span></span>
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
          <div class="name-inputs">
            <input type="text" placeholder="First name" required>
          </div>
          <div class="name-inputs">
            <input type="text" placeholder="Last name" required>
          </div>
          <input type="email" placeholder="Email" required>
          <div class="password-field">
            <input type="password" placeholder="Enter your password" required>
          </div>
          <div class="password-field">
            <input type="password" placeholder="Confirm your password" required>
          </div>
          <div class="checkbox">
            <input type="checkbox" id="terms" required>
            <label class="left-text" for="terms">I agree to the <a href="#">Terms & Conditions</a></label><br>
            <p class="right-text">Already have an account? <a href="SignUp.php">Log in</a></p>
            </div>
          <div>
            
          </div> 
          <button type="submit" class="create-account-button">Create account</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
