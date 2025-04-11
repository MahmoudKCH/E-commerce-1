<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login and Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700;900&display=swap" rel="stylesheet">
  <link href="assets/css/account.css" rel="stylesheet">
</head>
<body>
  <div class="main-wrapper">
    <!-- Register Form Section -->
    <div class="form-section">
      <div class="form-container">
        <h3>Sign up</h3>
        <form id="registerForm">
          <div class="form-group">
            <label for="fullName">Full Name</label>
            <input type="text" id="fullName" required placeholder="Enter Your Name">
          </div>
          <div class="form-group">
            <label for="emailAddress">Email Address</label>
            <input type="email" id="emailAddress" required placeholder="Enter Your Email">
          </div>
          <div class="form-group">
            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" required placeholder="Enter Password">
          </div>
          <div class="form-group">
            <div class="form-check">
              <input type="checkbox" id="agree" name="agree">
              <label for="agree">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a>.</label>
            </div>
          </div>
          <button class="btn" type="submit">Sign Up</button>
        </form>
        <p class="text-muted" style="margin-top: 15px; text-align: right;">Already a member? <a href="#" style="color: #007bff; text-decoration: none;">Sign in now</a></p>
      </div>
    </div>

    <!-- Welcome Text Section -->
    <div class="welcome-section">
      <div class="logo">
        <a href="index.html"><img src="images/logo.png" alt="Logo"></a>
      </div>
      <div class="welcome-text">
        <h1>Best Deals, Best Prices, Fast Delivery</h1>
        <p>Consoles, Games, Accessories, Electronics, Phones</p>
      </div>
    </div>
  </div>
</body>
</html>
