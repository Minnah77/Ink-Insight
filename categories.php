<?php
session_start();
require_once 'config/database.php';

// Get all categories
$categories_stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
$categories = $categories_stmt->fetchAll();

// Get selected category from URL
$selected_category = $_GET['category'] ?? 'all';

// Prepare the articles query
if ($selected_category === 'all') {
    $articles_stmt = $pdo->prepare("
        SELECT a.*, c.name as category_name, u.name as author_name 
        FROM articles a 
        JOIN categories c ON a.category_id = c.id 
        JOIN users u ON a.author_id = u.id 
        ORDER BY a.created_at DESC
    ");
    $articles_stmt->execute();
} else {
    $articles_stmt = $pdo->prepare("
        SELECT a.*, c.name as category_name, u.name as author_name 
        FROM articles a 
        JOIN categories c ON a.category_id = c.id 
        JOIN users u ON a.author_id = u.id 
        WHERE c.slug = ?
        ORDER BY a.created_at DESC
    ");
    $articles_stmt->execute([$selected_category]);
}

$articles = $articles_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories | Ink & Insight Magazine</title>
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
                    <li class="nav-item"><a href="categories.php" class="nav-link active">CATEGORIES</a></li>
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
                        <a href="login.php" class="nav-link">
                            <i class="bi bi-person-circle me-2"></i>
                            <span>Login</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <section class="categories-hero-section">
        <div class="container">
            <h1 class="categories-title">Explore Categories</h1>
            <nav class="categories-nav-bar">
                <ul class="categories-nav-list">
                    <li class="categories-nav-item">
                        <a href="categories.php" class="categories-nav-link <?php echo $selected_category === 'all' ? 'active' : ''; ?>">All</a>
                    </li>
                    <?php foreach ($categories as $category): ?>
                    <li class="categories-nav-item">
                        <a href="categories.php?category=<?php echo htmlspecialchars($category['slug']); ?>" 
                           class="categories-nav-link <?php echo $selected_category === $category['slug'] ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </div>
    </section>

    <div class="category-section">
        <div class="category-grid">
            <?php $i = 0; foreach ($articles as $article): ?>
            <?php
                $cardClass = '';
                if ($i === 0 || $i === 3 || $i === 5) $cardClass = ' category-card--black';
                if ($i === 2 || $i === 9) $cardClass = ' category-card--red';
            ?>
            <div class="category-card<?php echo $cardClass; ?>">
                <div class="category-card__content">
                    <h3 class="category-card__title">
                        <a href="article.php?id=<?php echo $article['id']; ?>" class="text-decoration-none" style="color: inherit;">
                            <?php echo htmlspecialchars($article['title']); ?>
                        </a>
                    </h3>
                    <p class="category-card__author">By <?php echo htmlspecialchars($article['author_name']); ?></p>
                </div>
                <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="category-card__image">
            </div>
            <?php $i++; endforeach; ?>
        </div>
    </div>

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