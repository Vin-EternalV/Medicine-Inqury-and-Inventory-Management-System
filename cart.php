<?php
session_start();
include 'db_connect.php'; // Your DB connection file

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items for the logged-in user
$sql = "SELECT c.id as cart_id, p.name, p.description, p.image, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .cart-card img {
            height: 180px;
            object-fit: contain;
        }
        .quantity-input {
            width: 70px;
        }
        .submit-btn {
            max-width: 300px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4">Your Cart</h2>

    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info">
            Your cart is empty. <a href="products.php">Start shopping!</a>
        </div>
    <?php else: ?>
        <form action="submit_order.php" method="POST">
            <div class="row g-4">
                <?php
                $total = 0;
                foreach ($cart_items as $item):
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <div class="col-md-4">
                    <div class="card cart-card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars($item['description']) ?></p>
                            <p class="card-text"><strong>Price: </strong>$<?= number_format($item['price'], 2) ?></p>
                            <div class="d-flex align-items-center mb-2">
                                <label for="quantity_<?= $item['cart_id'] ?>" class="form-label me-2 mb-0">Quantity:</label>
                                <input
                                    type="number"
                                    id="quantity_<?= $item['cart_id'] ?>"
                                    name="quantities[<?= $item['cart_id'] ?>]"
                                    value="<?= $item['quantity'] ?>"
                                    min="1"
                                    class="form-control quantity-input"
                                />
                            </div>
                            <p class="card-text"><strong>Subtotal: </strong>$<?= number_format($subtotal, 2) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-4 text-end">
                <h4>Total: $<?= number_format($total, 2) ?></h4>
                <button type="submit" class="btn btn-success btn-lg submit-btn">Submit Order</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>