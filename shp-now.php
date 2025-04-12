<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login and Register</title>
  <link href="assets/css/account.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="main-wrapper">
    <!-- Register Form Section -->
    <div class="form-section">
      <div class="form-container">
        <h3>Create Your Account</h3>
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
            <input type="password" id="loginPassword" required placeholder="Create a Password">
          </div>
          <div class="form-check">
            <input type="checkbox" id="agree" name="agree" required>
            <label for="agree">I agree to the <a href="#">Terms</a> and <a href="#">Privacy Policy</a></label>
          </div>
          <button class="btn" type="submit">Sign Up</button>
        </form>
        <p class="text-muted">Already have an account? <a href="#">Sign in</a></p>
      </div>
    </div>

    <!-- Welcome Text Section -->
    <div class="welcome-section">
      <div class="logo">
        <a href="index.html"><img src="images/AppLOGO2.png" alt="Logo"></a>
      </div>
      <div class="welcome-text">
        <h1>Best Deals, Best Prices, Fast Delivery</h1>
        <p>Discover the latest consoles, games, accessories, electronics and phones at unbeatable prices with lightning-fast delivery.</p>
      </div>
    </div>
  </div>
</body>
</html>