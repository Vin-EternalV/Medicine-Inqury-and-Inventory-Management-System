<?php
session_start();
include 'db.php';  // MySQLi connection ($conn)

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$cart = $_SESSION['cart'];
$total_price = 0;
foreach ($cart as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = trim($_POST['address']);
    $payment_method = trim($_POST['payment_method']); // e.g. "Cash on Delivery" or "Card"

    if (!empty($address) && !empty($payment_method)) {
        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, address, payment_method, order_date) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("idss", $_SESSION['user_id'], $total_price, $address, $payment_method);

        if ($stmt->execute()) {
            $order_id = $stmt->insert_id;

            // Insert each cart item into order_items table
            $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            foreach ($cart as $product_id => $item) {
                $item_stmt->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
                $item_stmt->execute();

                // OPTIONAL: Decrease stock quantity
                $stock_stmt = $conn->prepare("UPDATE product SET stck_qty = stck_qty - ? WHERE Product_id = ?");
                $stock_stmt->bind_param("ii", $item['quantity'], $product_id);
                $stock_stmt->execute();
                $stock_stmt->close();
            }
            $item_stmt->close();

            // Clear cart
            unset($_SESSION['cart']);
            $message = "✅ Order placed successfully! Your order ID is #$order_id.";

            //notification
            $notif_stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
            $notif_message = "Your order #$order_id has been placed successfully!";
            $notif_stmt->bind_param("is", $_SESSION['user_id'], $notif_message);
            $notif_stmt->execute();
            $notif_stmt->close();

          // Get all admin user ids dynamically
        $admins_result = $conn->query("SELECT Customer_id FROM customer WHERE role = 'admin'");
        if ($admins_result && $admins_result->num_rows > 0) {
        while ($admin_row = $admins_result->fetch_assoc()) {
        $admin_id = $admin_row['Customer_id'];
        $admin_message = "New order #$order_id has been placed by User ID {$_SESSION['user_id']}.";
        $admin_notif = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
        $admin_notif->bind_param("is", $admin_id, $admin_message);
        $admin_notif->execute();
        $admin_notif->close();
            }
}

            header("Location: index.php");
            exit;
        } else {
            $message = "❌ Failed to place order. Please try again.";
        }
    } else {
        $message = "⚠️ Please fill out all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - PharmaSys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="text-center py-3">
        <a href="index.php" style="text-decoration: none; font-size: 2rem; font-weight: bold;">PharmaSys</a>
    </header>

    <div class="container my-4">
        <h1 class="text-primary mb-3">Checkout</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <?php if (!isset($order_id)): ?>
        <!-- Order summary -->
        <div class="card mb-4">
            <div class="card-header">Order Summary</div>
            <div class="card-body">
                <ul class="list-group mb-3">
                    <?php foreach ($cart as $item): ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <div>
                                <strong><?= htmlspecialchars($item['name']) ?></strong> x <?= $item['quantity'] ?>
                            </div>
                            <span>$<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
                        </li>
                    <?php endforeach; ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total</strong>
                        <span>$<?= number_format($total_price, 2) ?></span>
                    </li>
                </ul>

                <!-- Checkout Form -->
                <form method="POST">
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea name="address" id="address" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="form-select" required>
                            <option value="">Select...</option>
                            <option value="Cash on Delivery">Cash on Delivery</option>
                            <option value="Card">Credit/Debit Card</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Place Order</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <a href="cart.php" class="btn btn-secondary">← Back to Cart</a>
    </div>
</body>
</html>
