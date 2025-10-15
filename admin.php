<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
    header('Location: login.php'); 
    exit; 
}

include 'db.php';  // This should now provide $conn as a MySQLi connection

//notification for admin
$admin_id = $_SESSION['user_id']; // the currently logged-in admin
$notif_query = $conn->prepare("SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 10");
$notif_query->bind_param("i", $admin_id);
$notif_query->execute();
$notif_result = $notif_query->get_result();

$message = '';

// Create
if (isset($_POST['action']) && $_POST['action'] == 'create') {
   
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

  $image_name = null;

if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = 'assets/image/';
    // Use original filename
    $image_name = basename($_FILES['image']['name']); 
    
    $target_file = $target_dir . $image_name;
    
    // Move uploaded file to target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        // File uploaded successfully, $image_name will be saved in DB as is
    } else {
        // Handle upload error if needed
        $image_name = null;
    }
} else {
    $image_name = null;
}


    
       $stmt = mysqli_prepare($conn, "INSERT INTO product (Product_name, description, image, price, stck_qty) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssdi", $name, $desc, $image_name, $price, $stock);  // s: string, s: string, d: double, i: integer
    $success = mysqli_stmt_execute($stmt);
    if ($success) $message = 'Added!';
    mysqli_stmt_close($stmt);
}

// Update
if (isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // First, get current image filename from DB to preserve if no new image is uploaded
    $stmt = mysqli_prepare($conn, "SELECT image FROM product WHERE Product_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $current_image = $row ? $row['image'] : null;
    mysqli_stmt_close($stmt);

    $image_name = $current_image;  // default to current image

    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = 'assets/image/';
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Failed upload, keep old image
            $image_name = $current_image;
        } else {
            // Optionally: delete old image file here if you want to clean up
        }
    }

    // Now update including image
    $stmt = mysqli_prepare($conn, "UPDATE product SET Product_name=?, description=?, image=?, price=?, stck_qty=? WHERE Product_id=?");
    mysqli_stmt_bind_param($stmt, "sssdii", $name, $desc, $image_name, $price, $stock, $id);
    $success = mysqli_stmt_execute($stmt);
    if ($success) $message = 'Updated!';
    mysqli_stmt_close($stmt);
}


// Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE Product_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);  // i: integer
    $success = mysqli_stmt_execute($stmt);
    if ($success) $message = 'Deleted!';
    mysqli_stmt_close($stmt);
}

// Read all
$products = [];
$result = mysqli_query($conn, "SELECT * FROM product");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
    mysqli_free_result($result);  // Free the result set
}

// Read for edit
$edit = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM product WHERE Product_id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);  // i: integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);  // Get the result set
    $edit = mysqli_fetch_assoc($result);  // Fetch the row
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin CRUD</title>
    <link rel="stylesheet" href="assets/css/design.css">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
</head>
<body>
     <header class="text-center py-3">
        <a href="index.php" style="text-decoration: none; font-size: 2rem; font-weight: bold;">PharmaSys</a>
    </header>

    <div class="container my-0">
        <h1>Admin: Manage Products</h1>
        <?php if ($message): ?><p class="alert alert-success"><?= $message ?></p><?php endif; ?>

        <!-- Simple Form (Create or Edit) -->

        
    <!-- submit button -->
</form>
        <form method="POST" enctype="multipart/form-data" class="mb-4 p-3 border">
    <input type="hidden" name="action" value="<?= $edit ? 'update' : 'create' ?>">
    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $edit['Product_id'] ?>">
    <?php endif; ?>

    <div class="mb-2">
        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($edit['Product_name'] ?? '') ?>" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Description:</label>
        <input type="text" name="desc" value="<?= htmlspecialchars($edit['description'] ?? '') ?>" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Price:</label>
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($edit['price'] ?? '') ?>" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Stock:</label>
        <input type="number" name="stock" value="<?= htmlspecialchars($edit['stck_qty'] ?? '') ?>" class="form-control" required>
    </div>

    <div class="mb-2">
        <label>Image:</label>
        <input type="file" name="image" class="form-control" <?= $edit ? '' : 'required' ?>>
        <?php if ($edit && $edit['image']): ?>
            <img src="assets/image/<?= htmlspecialchars($edit['image']) ?>" alt="Current Image" style="max-width:100px; margin-top:5px;">
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Add' ?></button>
    <?php if ($edit): ?>
        <a href="admin.php" class="btn btn-secondary">Cancel</a>
    <?php endif; ?>
</form>


        <!-- Simple List (Read + Delete/Edit) -->
        <h3>Products</h3>
        <?php foreach ($products as $p): ?>
            <div class="border p-2 mb-2">
                <strong><?= $p['Product_name'] ?></strong> - <?= $p['description'] ?> - Price: $<?= $p['price'] ?> - Stock: <?= $p['stck_qty'] ?>
                <a href="admin.php?edit=<?= $p['Product_id'] ?>" class="btn btn-sm btn-info">Edit</a>
                <a href="admin.php?delete=<?= $p['Product_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</a>
            </div>
        <?php endforeach; ?>
        <?php if (empty($products)): ?><p>No products.</p><?php endif; ?>
        <a href="index.php" class="btn btn-primary mt-3">Back to Home</a>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>