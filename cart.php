<?php
session_start();
include 'db.php';  // Now uses MySQLi connection ($conn)

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Handle adding to cart (from index.php ?id=)
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM product WHERE Product_id = ? AND stck_qty > 0");
    $stmt->bind_param("i", $product_id);  // "i" means the parameter is an integer
    $stmt->execute();
    $result = $stmt->get_result();  // Get the result set
    $product = $result->fetch_assoc();  // Fetch as associative array
    
    if ($product) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['Product_name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
        $message = 'Item added to cart!';
    } else {
        $message = 'Product not available.';
    }
}

// Handle updates/removals
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['quantity'] as $id => $qty) {
            if ($qty > 0 && isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]['quantity'] = (int)$qty;
            } else {
                unset($_SESSION['cart'][$id]);
            }
        }
        $message = 'Cart updated!';
    } elseif (isset($_POST['remove_id'])) {
        $remove_id = (int)$_POST['remove_id'];
        unset($_SESSION['cart'][$remove_id]);
        $message = 'Item removed!';
    }
}

// Calculate totals
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$total_items = array_sum(array_column($cart, 'quantity'));
$total_price = 0;
foreach ($cart as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - PharmaSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/design.css">
    <style>
        .cart-table { margin-top: 20px; }
        .cart-table img { width: 50px; height: 50px; object-fit: cover; }
    </style>
</head>
<body>
    <header class="text-center py-3">
        <a href="index.php" style="text-decoration: none; font-size: 2rem; font-weight: bold;">PharmaSys</a>
    </header>

    <div class="container my-0">
        <h1 class="text-primary mb-3">Shopping Cart</h1>
        
        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (empty($cart)): ?>
            <div class="text-center py-4">
                <p>Your cart is empty. <a href="index.php">Shop now</a>.</p>
            </div>
        <?php else: ?>
            <form method="POST">
                <table class="table table-striped cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $id => $item): ?>
                            <tr>
                                <td>
                                    <img src="assets/image/<?= htmlspecialchars($item['name']) ?>.jpg" alt="<?= htmlspecialchars($item['name']) ?>" class="me-2">  <!-- Adjust image naming if needed -->
                                    <?= htmlspecialchars($item['name']) ?>
                                </td>
                                <td>$<?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <input type="number" name="quantity[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="1" class="form-control w-50 d-inline">
                                </td>
                                <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                <td>
                                    <button type="submit" name="remove_id" value="<?= $id ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remove?')">Remove</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <button type="submit" name="update" class="btn btn-secondary">Update Cart</button>
                        <a href="index.php" class="btn btn-primary ms-2">Continue Shopping</a>
                    </div>
                    <div class="col-auto">
                        <h4>Total: <?= $total_items ?> items | $<?= number_format($total_price, 2) ?></h4>
                        <a href="checkout.php" class="btn btn-success">Checkout</a>  <!-- Placeholder -->
                    </div>
                </div>
            </form>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>