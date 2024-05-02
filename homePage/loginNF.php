<!DOCTYPE html>
<html>
<head>
  <title>TalkTandem | Login</title>
  <link rel="stylesheet" type="text/css" href="SignUp-login.css">
  <link rel="shortcut icon" href="Logo white .jpeg" type="image/x-icon">
</head>
<body>
  <div class="container">
    <h1>Login</h1>
    <form method="POST" action="loginN.php">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder="Enter your Email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
      </div>
     
      <input type="submit" value="Login">
      <h5>Don't have an account? <a href="SignUpN.php">SignUp</a></h5>

    </form>
  </div>
</body>
</html>