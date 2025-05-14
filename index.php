<?php
session_start();
require_once 'config/database.php';

// Fetch featured articles
$stmt = $pdo->query("SELECT a.*, c.name as category_name, u.name as author_name 
                     FROM articles a 
                     JOIN categories c ON a.category_id = c.id 
                     JOIN users u ON a.author_id = u.id 
                     ORDER BY a.created_at DESC 
                     LIMIT 12");
$articles = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ink & Insight Magazine</title>
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
                    <li class="nav-item"><a href="index.php" class="nav-link active">HOME</a></li>
                    <li class="nav-item"><a href="categories.php" class="nav-link">CATEGORIES</a></li>
                    <li class="nav-item"><a href="services.php" class="nav-link">SERVICES</a></li>
                    <li class="nav-item"><a href="about.php" class="nav-link">ABOUT</a></li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <form class="search-form d-flex align-items-center">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                        <button type="submit" class="search-btn">
                           <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="logout.php" class="nav-link login-link">
                            <i class="bi bi-box-arrow-right me-2"></i>
                            <span>Logout</span>
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="nav-link ">
                            <i class="bi bi-person-circle me-2"></i>
                            <span>Login</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Featured Articles Grid -->
        <div class="container mt-4">
            <div class="row g-4">
                <!-- Loop through articles for the left, middle, and right columns -->
                <?php if (count($articles) >= 7): ?>
                 <!-- Left Column - Main Article -->
                 <div class="col-lg-4">
                    <article class="main-article">
                        <div class="article-hero tall">
                            <div class="article-meta">
                                <span class="article-date">12/04/2022</span>
                                <span class="article-tag">QUANTUM PHYSICS</span>
                            </div>
                            <div class="article-image">
                                <img src="Assets/Images/scientest.jpg" alt="a scientist using a microscope" class="img-fluid">
                            </div>
                            <h1 class="article-title">MASSIVE BLACK HOLES SHOWN TO ACT LIKE QUANTUM PARTICLES</h1>
                            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quasi libero ducimus aut optio, temporibus accusamus reiciendis asperiores animi perferendis dicta?</p>
                        </div>
                    </article>
                    
                    <article class="middle-article dark">
                        <h2>SOLVING THE FAINT-SUN PARADOX</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </article>
                    
                    <article class="middle-article red">
                        <h2>WHAT IS THE GEOMETRY OF THE UNIVERSE?</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco.</p>
                    </article>
                </div>
                <!-- Middle Column - Article -->
                <div class="col-lg-4">
                    <article class="text-article">
                        <div class="section-header">
                            <span class="date">12/04/2022</span>
                        </div>
                        <h2>THE QUANTUM NATURE OF SPACE AND TIME</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        <p class="highlight">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.</p>
                        <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit.</p>
                        <a href="article.php?id=117" class="read-more">READ MORE</a>
                    </article>
                </div>
                <!-- Right Column - Latest Articles -->
                <div class="col-lg-4">
                    <div class="latest-articles">
                        <div class="section-header">
                            <h2>THE MOST NEW</h2>
                            <span class="date">15/04/2025</span>
                        </div>
                        <article class="side-article">
                            <div class="article-image">
                                <img src="Assets/Images/chess.jpg" alt="chess" class="img-fluid">
                            </div>
                            <h3>THE SECRETS OF ZUGZWANG IN CHESS, MATHEMATICS & PIZZAS</h3>
                            <p>A new analysis of AI bosons suggests these particles are significantly heavier than predicted by the Standard Model of particle physics.</p>
                            <a href="article.php?id=118" class="read-more">READ MORE</a>
                        </article>
                        <div class="section-header">
                            <h2>THE MOST POPULAR</h2>
                            <span class="date">10/04/2025</span>
                        </div>
                        <article class="side-article">
                            <div class="article-image">
                                <img src="Assets/Images/genaticcode.JPG" alt="Glowing figure in motion against dark background" class="img-fluid">
                            </div>
                            <h3>SCIENTISTS HAVE DISCOVERED A NEW WAY TO ENGAGE IN THE SEASON'S PHYSICS</h3>
                            <p>A new study reveals groundbreaking insights into seasonal particle behavior, challenging our understanding of quantum mechanics.</p>
                            <a href="article.php?id=119" class="read-more">READ MORE</a>
                        </article>
                        <div class="section-header">
                            <h2>THE MOST DISCUSSED</h2>
                            <span class="date">15/11/2024</span>
                        </div>
                        <article class="side-article">
                            <div class="article-image">
                                <img src="Assets/Images/Psychology-Image.jpg" alt="Mathematical equations and formulas" class="img-fluid">
                            </div>
                            <h3>Unlocking Mental Clarity: The Transformative Power of Meditation in Psychology</h3>
                            <p>A new article explores how meditation transforms mental clarity by teaching the mind to observe thoughts without judgment. It highlights how regular practice can reduce stress and improve emotional well-being.</p>
                            <a href="article.php?id=120" class="read-more">READ MORE</a>
                        </article>
                    </div>
                </div>
                <!-- MASSIVE BLACK HOLES SHOWN TO ACT LIKE QUANTUM PARTICLES main article -->
                <?php endif; ?>
            </div>
        </div>
    </main>

    <div class="container latest-news-section">
        <header class="latest-news-header">
            <h1 class="latest-news-title">LATEST NEWS</h1>
            <div class="latest-news-separator"></div>
        </header>
        <div class="latest-news-grid">
            <div class="latest-main-article">
                <img src="Assets/Images/twowomenusingmicrospoe.jpg" alt="Scientists Confirm Curved Human Existence" />
                <div class="latest-main-article-overlay">
                    <h2 class="latest-main-article-title">SCIENTISTS CONFIRM CURVED HUMAN EXISTENCE</h2>
                    <p class="latest-main-article-content">
                        Researchers have found a set of clues for humans that conform with curvature. These clues come after years of research and excavation, where unique 
                        skeletal structures were discovered showing abnormal curves in the spine. Researchers believe this type of human had special physical abilities that 
                        allowed them to adapt to specific environments.
                    </p>
                </div>
            </div>
            <div class="latest-side-articles">
                <div class="latest-side-article">
                    <div class="latest-side-article-image" style="background-image: url('Assets/Images/gallium.jpg');"></div>
                    <div class="latest-side-article-content">
                        <h3 class="latest-side-article-title">What Could Explain the Gallium Anomaly?</h3>
                        <span class="latest-side-article-category">particle physics</span>
                    </div>
                </div>
                <div class="latest-side-article">
                    <div class="latest-side-article-image" style="background-image: url('Assets/Images/Math-img.jpg');"></div>
                    <div class="latest-side-article-content">
                        <h3 class="latest-side-article-title">An annotated bibliography for comparative prime number theory</h3>
                        <span class="latest-side-article-category">Number Theory</span>
                    </div>
                </div>
                <div class="latest-side-article">
                    <div class="latest-side-article-image" style="background-image: url('Assets/Images/tech-img.jpg');"></div>
                    <div class="latest-side-article-content">
                        <h3 class="latest-side-article-title">Understanding Social Media Addiction: A Deep Dive</h3>
                        <span class="latest-side-article-category">Technology</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <h2 class="newsletter-title">Stay Informed</h2>
            <p class="newsletter-description">Subscribe to our newsletter and get the latest insights in science, technology, and psychology delivered straight to your inbox.</p>
            <form class="newsletter-form" method="POST" action="subscribe.php">
                <input type="email" name="email" class="newsletter-input" placeholder="Enter your email address" required>
                <button type="submit" class="newsletter-submit">Subscribe</button>
            </form>
            <div class="recent-newsletters">
                <span class="recent-newsletters-title">Recent Newsletters</span>
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