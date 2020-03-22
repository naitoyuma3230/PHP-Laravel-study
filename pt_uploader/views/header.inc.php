<header>
  <div class="header-container mx-5">
    <p><?php if(isset($_SESSION['me'])) { echo $_SESSION['me']->email . "  ログイン済みです";}?></p>
    <div class="header-right">
      <a href="index.php">Home</a>
      <a href="login.php">Log In</a>
      <a href="signup.php">Sign Up</a>
      <a href="logout.php" >Log Out</a>
    </div>
  </div>
</header>
