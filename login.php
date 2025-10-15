<?php

session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
         $username = mysqli_real_escape_string($conn, $username);

        $query = "SELECT * FROM customer WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($conn, $query);

            if(mysqli_num_rows($result) == 1) {
                $user = mysqli_fetch_assoc($result);

                
            if(password_verify($password, $user['password'])) {
            

                $_SESSION['username'] = $user['username'];
                 $_SESSION['user_id'] = $user['Customer_id'];
                 $_SESSION['role'] = $user['role'];
             header("Location: index.php");
             exit();
            } else {
                  $error = "Invalid username or password.";
                
            }
         } else {
          $error = "Invalid username or password.";
        
         }

    } else {
        $error = 'Please fill in all fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/design.css">
</head>
<body>
    <header class="text-center py-3">
        <a href="index.php" style="text-decoration: none; font-size: 2rem; font-weight: bold;">PharmaSys</a>
    </header>

    <main>
        <div class="container mt-5" style="max-width: 400px;">
            <h2 class="mb-4 text-center" style="color: blue;">Log In</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
                <div class="mb-3">
                    <label for="login-username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="login-username" name="username" placeholder="Enter username" required>
                </div>
                <div class="mb-3">
                    <label for="login-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign In</button>
            </form>
            <div class="text-center mt-3">
                <small>Don't have an account? <a href="register.php">Sign up</a></small>
            </div>
        </div>
    </main>

    <?php include("assets/css/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
