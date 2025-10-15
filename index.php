
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PharmaSys</title>
  <link rel="stylesheet" href="assets/css/design.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


</head>
<body>
  <?php
include("assets/css/header.php");
include 'db.php'; 

$notif_count = 0;
if (isset($_SESSION['user_id'])) {
    $uid = (int)$_SESSION['user_id'];
    $notif_query = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = ? AND is_read = 0");
    $notif_query->bind_param("i", $uid);
    $notif_query->execute();
    $notif_query->bind_result($notif_count);
    $notif_query->fetch();
    $notif_query->close();
}
?>



<aside class="sidebar">
    <div class="icon"><a href="cart.php"><i class="bi bi-cart"></i></a></div>
    <div class="icon position-relative">
        <a href="notification.php"><i class="bi bi-bell"></i></a>
        <?php if ($notif_count > 0): ?>
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle">
                <?= $notif_count ?>
            </span>
        <?php endif; ?>
    </div>
</aside>

  <main id="home">
    <h1>PharmaSys<span class="reg-symbol">®</span></h1>
  </main>




 

   <section class="container my-5" id="Order">
    <h2>Medicine</h2>
    <hr>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    
 
   <?php
$query = "SELECT * FROM product";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0):
  while ($row = mysqli_fetch_assoc($result)):
?>
  <div class="col">
    <div class="card h-100 shadow-sm">
      <!-- You can add an image column to DB later -->
     <img src="<?= !empty($row['image']) ? 'assets/image/' . htmlspecialchars($row['image']) : 'assets/image/default.png' ?>" class="card-img-top" alt="Product Image">


      <div class="card-body">
        <h5 class="card-title text-primary"><?= htmlspecialchars($row['Product_name']) ?></h5>
        <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
        <p class="card-text">$<?= number_format($row['price'], 2) ?></p>
      </div>
      <div class="card-footer bg-transparent border-0">
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="cart.php?id=<?= $row['Product_id'] ?>" class="btn btn-success w-100 text-center">Add to Cart</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-success w-100 text-center">Add to Cart</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php
  endwhile;
else:
?>
  <p>No products available yet.</p>
<?php endif; ?>

    
    </div>

   

     
</section>


  <main>

    <section id="about" class="about-section container my-5 py-4">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h2 class="text-primary mb-3">About PharmaSys</h2>
      <p>
       PharmaSys® is your trusted partner in delivering high-quality pharmaceutical solutions tailored to meet the evolving needs of modern healthcare. We are committed to bridging the gap between
        innovation and patient care by providing reliable, affordable, and easily
         accessible medical products to individuals, healthcare providers, and institutions alike.
      </p>
      <p>
       Founded on the principles of integrity, excellence, and compassion, PharmaSys is more than just a platform — it's a healthcare ecosystem designed with people at its core. Whether you're a patient seeking trusted medication or a
        healthcare professional in need of dependable supply chains, PharmaSys delivers with precision and care.
      </p>
       <p>
       Our extensive catalog includes a wide range of pharmaceutical items, from everyday over-the-counter remedies to specialized treatments, all rigorously vetted to meet the highest quality and safety standards. We work closely with licensed manufacturers, distributors, and healthcare
        professionals to ensure that every product we offer is compliant, effective, and ethically sourced.
      </p>
    </div>
    <div class="col-md-6 text-center">
      <img src="assets/image/About pharmasys.webp " alt="About PharmaSys" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
    </div>
  </div>
</section>

  </main>

  
  <main>

    <section id="contact" class="contact-section container my-5 py-4">
  <div class="row">
    <div class="col-md-6">
      <h2 class="text-primary mb-3">Contact Us</h2>
      <p>Have questions, feedback, or need assistance? Reach out to our team — we're here to help you.</p>

      <ul class="list-unstyled mt-4">
        <li><strong>Email:</strong> support@pharmasys.com</li>
        <li><strong>Phone:</strong> +1 (800) 123-4567</li>
        <li><strong>Address:</strong> 123 Health Ave, MedCity, RX 10001</li>
      </ul>
    </div>

    <div class="col-md-6">
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Message</label>
          <textarea class="form-control" id="message" rows="4" placeholder="Type your message here..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
      </form>
    </div>
  </div>
</section>


    

  </main>
  

  <footer>
    <div class="navigator">
      <select>
        <option>Public</option>
        <option>Reports</option>
      </select>
      <select>
        <option>Option</option>
        <option>Legal</option>
      </select>
    </div>
    <div class="footer-branding">
      <div class="logo-icon small"></div>
      <span>Powered by PharmaSys</span>
    </div>
  </footer>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>



<?php

?>