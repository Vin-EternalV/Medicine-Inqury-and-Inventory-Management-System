
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
      <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="admin.php" class="btn btn-warning">Add product</a>
<?php endif; ?>
    </nav>
   <form class="search-container" method="GET" action="search.php">
  <input type="text" name="query" placeholder="Search...">
  <button type="submit" class="search-button">Search</button>
</form>
  <?php if (isset($_SESSION['user_id'])): ?>
  <!-- Show profile icon and logout if logged in -->
  <a href="profile.php" id="profile" class="d-flex align-items-center gap-2">
    <img src="assets/image/heart-png-38780.png" alt="Profile" style="width: 30px; height: 30px; border-radius: 50%;">
    <span><?= htmlspecialchars($_SESSION['username']) ?></span>
  </a>
  <a href="logout.php" id="logout" class="btn btn-outline-secondary btn-sm ms-2" >Log Out</a>
<?php else: ?>
  <!-- Show Log In button if NOT logged in -->
 <a href="login.php" class="primary-button">Sign In</a>
   
  </button>
<?php endif; ?>

  </header>

