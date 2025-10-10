
<?php

session_start();
?>
    <header >
    <div class="logo">
      <div class="logo-icon"></div>
      <span>PharmaSys</span>
    </div>
    <nav>
      <a href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
   <form class="search-container" method="GET" action="search.php">
  <input type="text" name="query" placeholder="Search...">
  <button type="submit" class="search-button">Search</button>
</form>
  <?php if (isset($_SESSION['user_id'])): ?>
  <!-- Show profile icon and logout if logged in -->
  <a href="profile.php" class="d-flex align-items-center gap-2">
    <img src="assets/image/profile-icon.png" alt="Profile" style="width: 30px; height: 30px; border-radius: 50%;">
    <span><?= htmlspecialchars($_SESSION['username']) ?></span>
  </a>
  <a href="logout.php" class="btn btn-outline-secondary btn-sm ms-2">Log Out</a>
<?php else: ?>
  <!-- Show Log In button if NOT logged in -->
  <button type="button" class="primary-button" ><a href="login.php" class="btn btn-primary" >Sign In</a>
   
  </button>
<?php endif; ?>

  </header>

<?php


?>