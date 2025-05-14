<?php
session_start();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | Ink & Insight Magazine</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link href="Assets/bootstrap-5.3.4-dist/bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="Assets/bootstrap-5.3.4-dist/bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a href="index.php" class="navbar-brand">Ink & Insight</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a href="index.php" class="nav-link">HOME</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link">CATEGORIES</a></li>
                    <li class="nav-item"><a href="services.php" class="nav-link">SERVICES</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link active">ABOUT</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <form class="search-form d-flex align-items-center">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        <button type="submit" class="search-btn">
                           <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <a href="#" class="nav-link">
                        <i class="bi bi-person-circle me-2"></i>
                        <span>Login</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="about-section">
        <div class="container">
            <h1 class="about-title">About Us</h1>
            <p class="about-tagline">Chasing Truths Across Time and Space.</p>
            <div class="about-content">
                <p>At <span class="about-site">Ink & Insight Magazine</span>, we believe that science should be accessible, exciting, and inspiring for everyone.</p>
                <p>Our mission is to bridge the gap between cutting-edge research and curious minds by delivering well-crafted, easy-to-understand articles on physics, biology, technology, space exploration, and more.</p>
                <p>Founded by a team of passionate science writers, educators, and enthusiasts, <span class="about-site">Ink & Insight Magazine</span> is your go-to source for accurate and engaging science journalism.</p>
                <p>Whether you're a student, a professional, or simply a lifelong learner, we invite you to explore the wonders of the universe with us — one article at a time.</p>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <nav class="footer-nav">
            <div class="footer-links">
                <a href="about.php">About Us</a>
                <span class="footer-separator">|</span>
                <a href="contact.php">Contact</a>
                <span class="footer-separator">|</span>
                <a href="privacy.php">Privacy Policy</a>
                <span class="footer-separator">|</span>
                <a href="terms.php">Terms of Use</a>
            </div>
        </nav>
        <div class="footer-info">
            <p class="copyright">&copy; 2024 Ink & Insight Magazine. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
