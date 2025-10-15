<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $username = trim($_POST['username']);
    $password = trim($_POST['password']);  

    if (!empty($username) && !empty($password)) {
            $username = mysqli_real_escape_string($conn, $username);

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);


            $checkQuery = "SELECT * FROM customer WHERE username = '$username'";
            $result = mysqli_query($conn, $checkQuery);

            if(mysqli_num_rows($result) > 0) {
                echo "Username already exists. Please choose a different username.";
            } else {
                $insertQuery = "INSERT INTO customer (username, password, registered_date, role) VALUES ('$username', '$hashedPassword', NOW(), 'customer')";
                if(mysqli_query($conn, $insertQuery)) {
                    echo "Registration successful!";
                      $_SESSION['username'] = $username;
                   header("Location: login.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
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
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/design.css">
</head>
<body>
    <header class="text-center py-3">
        <a href="index.php" style="text-decoration: none; font-size: 2rem; font-weight: bold;">PharmaSys</a>
    </header>

    <main>
        <div class="container mt-5" style="max-width: 400px;">
            <h2 class="mb-4 text-center" style="color: blue;">Sign Up</h2>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <div class="mb-3">
                    <label for="reg-username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="reg-username" name="username" placeholder="Enter username" required>
                </div>
                <div class="mb-3">
                    <label for="reg-password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="reg-password" name="password" placeholder="Enter password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            </form>
            <div class="text-center mt-3">
                <small>Already have an account? <a href="login.php">Log in</a></small>
            </div>
        </div>
    </main>

    <?php include("assets/css/footer.php"); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
