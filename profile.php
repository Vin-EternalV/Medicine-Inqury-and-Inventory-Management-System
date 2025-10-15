<?php
session_start();
include 'db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user info from DB
$user_id = $_SESSION['user_id'];

// Escape to prevent SQL injection just in case
$user_id = mysqli_real_escape_string($conn, $user_id);

$query = "SELECT username, registered_date FROM customer WHERE Customer_id = '$user_id' LIMIT 1";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) != 1) {
    // Something went wrong or user not found
    echo "User not found.";
    exit();
}

$user = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profile - PharmaSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/design.css" />
</head>
<body>
    <header class="text-center py-3">
        <a href="index.php" style="text-decoration: none; font-size: 2rem; font-weight: bold;">PharmaSys</a>
    </header>

   <main class="container" style="max-width: 600px; padding-top: 20px;">
  <h2 class="mb-4">Your Profile</h2>

  <div class="card p-4 shadow-sm" style="max-width: 350px;">
    <div class="d-flex align-items-center mb-4">
      <img src="assets/image/heart-png-38780.png" alt="Profile" class="rounded-circle me-3" style="width: 60px; height: 60px;">
      <h4 class="mb-0"><?= htmlspecialchars($user['username']) ?></h4>
    </div>

    <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Registered on:</strong> <?= date('F j, Y', strtotime($user['registered_date'])) ?></p>

    <div class="mt-4">
      <a href="logout.php" class="btn btn-danger me-2">Log Out</a>
      <a href="index.php" class="btn btn-secondary">Back to Home</a>
    </div>
  </div>
</main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
