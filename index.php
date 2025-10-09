<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PharmaSys</title>
  <link rel="stylesheet" href="assets/css/design.css">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
  <header >
    <div class="logo">
      <div class="logo-icon"></div>
      <span>PharmaSys</span>
    </div>
    <nav>
      <a href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </nav>
    <div class="search-container">
      <input type="text" placeholder="Search...">
      <button class="search-button">search</button>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#signInModal">
 Log in
</button>

  </header>

  <aside class="sidebar">
    <div class="icon"></div>
    <div class="icon"></div>
    <div class="icon"></div>
    <div class="icon"></div>
  </aside>

  <main id="home">
    <h1>PharmaSys<span class="reg-symbol">®</span></h1>
  </main>



<!-- Log In Modal -->
<div class="modal fade" id="signInModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="signInModalLabel">Log In</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" required>
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" required>
          </div>
          
          <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
        <div class="text-center mt-3">
          <small>Don't have an account? 
                <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal" data-bs-dismiss="modal">
                Sign up
                </a>
          </small>
        </div>
      </div>
    </div>
  </div>
</div>



<!-- Sign In Modal -->
<div class="modal fade" id="signUpModal" tabindex="-1" aria-labelledby="signInModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="signInModalLabel">Sign In</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Create new username" required>
          </div>
          
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Create new password" required>
          </div>
          
          <button type="submit" class="btn btn-primary w-100">Sign In</button>
        </form>
      </div>
      
    </div>
  </div>
</div>


 

   <section class="container my-5" id="Order">
    <h2>Medicine</h2>
    <hr>
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
    
    <!-- Product 1 -->
    <div class="col">
      <div class="card h-100 shadow-sm">
        <img src="assets/image/paracetex.jpg" class="card-img-top" alt="Product Image">
        <div class="card-body">
          <h5 class="card-title text-primary">Paracetex 500mg</h5>
          <p class="card-text">Fast-acting paracetamol tablets for headache, fever, and minor pain relief..</p>
        </div>
        <div class="card-footer bg-transparent border-0">
          <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#signInModal">Add to Cart</button>
        </div>
      </div>
    </div>

    <!-- Product 2 -->
    <div class="col">
      <div class="card h-100 shadow-sm">
        <img src="assets/image/amoxymed.jpg" class="card-img-top" alt="Product Image">
        <div class="card-body">
          <h5 class="card-title text-primary">AmoxyMed 250mg</h5>
          <p class="card-text">Broad-spectrum antibiotic for respiratory and bacterial infections. Prescription required.</p>
        </div>
        <div class="card-footer bg-transparent border-0">
          <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#signInModal">Add to Cart</button>
        </div>
      </div>
    </div>

    <!-- Product 3 -->
    <div class="col">
      <div class="card h-100 shadow-sm">
        <img src="assets/image/Cardiocare.png" class="card-img-top" alt="Product Image">
        <div class="card-body">
          <h5 class="card-title text-primary">CardioCare 10mg</h5>
          <p class="card-text">Maintains healthy blood pressure and supports cardiovascular health. Prescribed only.</p>
        </div>
        <div class="card-footer bg-transparent border-0">
          <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#signInModal">Add to Cart</button>
        </div>
      </div>
    </div>

   

     
</section>


  <main>

    <section id="about" class="about-section container my-5 py-4">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h2 class="text-primary mb-3">About PharmaSys</h2>
      <p>
        PharmaSys® is your trusted partner in delivering quality pharmaceutical solutions. We aim to bridge the gap between innovation and healthcare by offering reliable, affordable, and accessible medical products.
      </p>
      <p>
        Our platform is designed with both patients and providers in mind, ensuring seamless access to a wide range of pharmaceutical items — all backed by stringent quality standards and prompt delivery.
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
