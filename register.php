<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>

 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/design.css">

</head>
<body  >

     <header class="text-center py-3">
    <a href="index.php"  style="text-decoration: none; font-size: 2rem; font-weight: bold;">pharmasys
    </a>
  </header>


      <main>
        <div class="container mt-5" style="max-width: 400px;">
  <h2 class="mb-4 text-center"  style="color: blue">Sign In</h2>
  <form>
    <div class="mb-3">
      <label for="login-username" class="form-label">Username</label>
      <input type="text" class="form-control" id="login-username" placeholder="Enter username" required>
    </div>
    
    <div class="mb-3">
      <label for="login-password" class="form-label">Password</label>
      <input type="password" class="form-control" id="login-password" placeholder="Enter password" required>
    </div>
    
    <button type="submit" class="btn btn-primary w-100">Sign In</button>
  </form>
  
  <div class="text-center mt-3">
    <small>Already have an account? <a href="login.php">Log in</a></small>
  </div>
</div>

    </main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>


<?php
    include("assets/css/footer.php");
?>