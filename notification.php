<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch notifications
$stmt = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Mark as read
$conn->query("UPDATE notifications SET is_read = 1 WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Notifications - PharmaSys</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container my-5">
    <h2>Your Notifications</h2>
    <hr>

    <?php if ($result->num_rows > 0): ?>
      <ul class="list-group">
        <?php while ($row = $result->fetch_assoc()): ?>
          <li class="list-group-item d-flex justify-content-between">
            <?= htmlspecialchars($row['message']) ?>
            <small class="text-muted"><?= $row['created_at'] ?></small>
          </li>
        <?php endwhile; ?>
      </ul>
    <?php else: ?>
      <p>No notifications yet.</p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
  </div>
</body>
</html>
