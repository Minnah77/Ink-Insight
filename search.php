<?php
session_start();
require_once 'config/database.php';

$search_results = [];
$search_query = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['q'])) {
    $search_query = trim($_GET['q']);
    
    if (!empty($search_query)) {
        // Search in articles table
        $stmt = $pdo->prepare("
            SELECT * FROM articles 
            WHERE title LIKE ? 
            OR content LIKE ? 
            OR excerpt LIKE ?
            ORDER BY created_at DESC
        ");
        
        $search_term = "%{$search_query}%";
        $stmt->execute([$search_term, $search_term, $search_term]);
        $search_results = $stmt->fetchAll();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results | Ink & Insight Magazine</title>
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
                    <li class="nav-item"><a href="about.php" class="nav-link">ABOUT</a></li>
                </ul>
                <form class="search-form" action="search.php" method="GET">
                    <input type="text" name="q" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <a href="login.php" class="login-link">
                    <i class="bi bi-person"></i>
                    <span>LOGIN</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="search-results">
            <h1 class="search-title">Search Results</h1>
            
            <?php if (!empty($search_query)): ?>
                <p class="search-query">Showing results for: "<?php echo htmlspecialchars($search_query); ?>"</p>
            <?php endif; ?>

            <?php if (empty($search_results)): ?>
                <div class="no-results">
                    <p>No results found for your search.</p>
                </div>
            <?php else: ?>
                <div class="results-grid">
                    <?php foreach ($search_results as $article): ?>
                        <div class="search-result-item">
                            <h2 class="result-title">
                                <a href="article.php?id=<?php echo $article['id']; ?>">
                                    <?php echo htmlspecialchars($article['title']); ?>
                                </a>
                            </h2>
                            <div class="result-meta">
                                <span class="result-date">
                                    <?php echo date('F j, Y', strtotime($article['created_at'])); ?>
                                </span>
                            </div>
                            <p class="result-excerpt">
                                <?php echo htmlspecialchars(substr($article['excerpt'], 0, 200)) . '...'; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
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