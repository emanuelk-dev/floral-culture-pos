<?php include 'includes/db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Essence Fragrance – Elegance on Every Note</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>ESSENCE FRAGRANCE</h1>
      <p>Unveil the essence within .</p>
      <a href="#products" class="btn">Explore Scents</a>
    </div>
    <div class="hero-image">
      <!-- Replace with your actual hero image -->
      <img src="assets/images/hero-bottle.png" alt="Perfume Bottle">
    </div>
  </section>

  <!-- Products Section -->
  <section id="products" class="products">
    <h2>Featured Scents</h2>
    <div class="product-grid">
      <!-- Dummy boxes—replace with dynamic code/images later -->
      <div class="product-card"><img src="assets/images/p1.png"><h3>Scent One</h3></div>
      <div class="product-card"><img src="assets/images/p2.png"><h3>Scent Two</h3></div>
      <div class="product-card"><img src="assets/images/p3.png"><h3>Scent Three</h3></div>
    </div>
  </section>

  <!-- About Section -->
  <section class="about">
    <h2>Crafted with Passion</h2>
    <p>Every fragrance is a unique blend of meticulously selected notes, designed to evoke confidence and elegance.</p>
  </section>

  <!-- Testimonials Section -->
  <section class="testimonials">
    <h2>What Customers Say</h2>
    <div class="testimonial-grid">
      <div class="testimonial">
        <p>"Absolutely love the luxurious feel of Essence Fragrance!"</p>
        <span>— Jane Doe</span>
      </div>
      <div class="testimonial">
        <p>"My go-to scent shop—always impresses."</p>
        <span>— John Smith</span>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <p>&copy; <?php echo date("Y"); ?> Essence Fragrance. All rights reserved.</p>
  </footer>

</body>
</html>
