<?php
session_start();
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$article_id = $_GET['id'];

// Update view count
$pdo->prepare("UPDATE articles SET views = views + 1 WHERE id = ?")->execute([$article_id]);

// Get article details
$stmt = $pdo->prepare("SELECT a.*, c.name as category_name, c.slug as category_slug, 
                              u.name as author_name, u.bio as author_bio, u.profile_image as author_image
                       FROM articles a 
                       JOIN categories c ON a.category_id = c.id 
                       JOIN users u ON a.author_id = u.id 
                       WHERE a.id = ?");
$stmt->execute([$article_id]);
$article = $stmt->fetch();

if (!$article) {
    header("Location: index.php");
    exit();
}

// Get related articles
$related_stmt = $pdo->prepare("SELECT a.*, c.name as category_name, u.name as author_name
                              FROM articles a 
                              JOIN categories c ON a.category_id = c.id 
                              JOIN users u ON a.author_id = u.id 
                              WHERE a.category_id = ? AND a.id != ?
                              ORDER BY a.created_at DESC LIMIT 3");
$related_stmt->execute([$article['category_id'], $article_id]);
$related_articles = $related_stmt->fetchAll();

// Get comments
$comments_stmt = $pdo->prepare("SELECT c.*, u.name as user_name, u.profile_image
                               FROM comments c
                               JOIN users u ON c.user_id = u.id
                               WHERE c.article_id = ?
                               ORDER BY c.created_at DESC");
$comments_stmt->execute([$article_id]);
$comments = $comments_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($article['title']); ?> | Ink & Insight Magazine</title>
    <link rel="stylesheet" href="CSS/style.css">
    <link href="Assets/bootstrap-5.3.4-dist/bootstrap-5.3.4-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="Assets/bootstrap-5.3.4-dist/bootstrap-5.3.4-dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .article-header {
            background-color: #f8f9fa;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        .article-meta {
            display: flex;
            gap: 1rem;
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .article-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 0;
        }
        .article-image {
            margin: 2rem 0;
        }
        .article-image img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .article-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #333;
        }
        .article-tags {
            margin: 2rem 0;
        }
        .tag {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background-color: #e9ecef;
            border-radius: 20px;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #495057;
        }
        .author-bio {
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            margin: 3rem 0;
        }
        .author-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .related-articles {
            margin: 3rem 0;
        }
        .related-article-card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
        }
        .related-article-card:hover {
            transform: translateY(-5px);
        }
        .related-article-image {
            height: 200px;
            object-fit: cover;
        }
        .comments-section {
            margin: 3rem 0;
        }
        .comment {
            border-bottom: 1px solid #dee2e6;
            padding: 1rem 0;
        }
        .comment-user-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .social-share {
            display: flex;
            gap: 1rem;
            margin: 2rem 0;
        }
        .social-share a {
            color: #6c757d;
            font-size: 1.5rem;
            transition: color 0.2s;
        }
        .social-share a:hover {
            color: #0d6efd;
        }
    </style>
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

    <article class="article-content">
        <div class="article-header">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <span class="article-category"><?php echo htmlspecialchars($article['category_name']); ?></span>
                        <h1 class="article-title"><?php echo htmlspecialchars($article['title']); ?></h1>
                        <div class="article-meta">
                            <span><i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($article['author_name']); ?></span>
                            <span><i class="bi bi-calendar"></i> <?php echo date('F j, Y', strtotime($article['created_at'])); ?></span>
                            <span><i class="bi bi-clock"></i> <?php echo $article['reading_time']; ?> min read</span>
                            <span><i class="bi bi-eye"></i> <?php echo $article['views']; ?> views</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <?php if ($article['image']): ?>
                    <div class="article-image">
                        <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="<?php echo htmlspecialchars($article['title']); ?>" class="img-fluid">
                    </div>
                    <?php endif; ?>

                    <div class="article-body">
                        <?php 
                        $content = trim(strip_tags($article['content']));
                        if (strlen($content) < 300) {
                            echo $content . '<br><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.<br><br>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.';
                        } else {
                            echo $article['content'];
                        }
                        ?>
                    </div>

                    <div class="article-tags">
                        <?php
                        $tags = explode(',', $article['tags']);
                        foreach ($tags as $tag): ?>
                            <span class="tag"><?php echo htmlspecialchars(trim($tag)); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="social-share">
                        <a href="#" onclick="shareOnFacebook()"><i class="bi bi-facebook"></i></a>
                        <a href="#" onclick="shareOnTwitter()"><i class="bi bi-twitter"></i></a>
                        <a href="#" onclick="shareOnLinkedIn()"><i class="bi bi-linkedin"></i></a>
                        <a href="#" onclick="copyLink()"><i class="bi bi-link-45deg"></i></a>
                    </div>

                    <div class="author-bio">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <img src="<?php echo htmlspecialchars($article['author_image']); ?>" alt="<?php echo htmlspecialchars($article['author_name']); ?>" class="author-image">
                            </div>
                            <div class="col">
                                <h3><?php echo htmlspecialchars($article['author_name']); ?></h3>
                                <p><?php echo htmlspecialchars($article['author_bio']); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($related_articles)): ?>
                    <div class="related-articles" style="margin: 3rem 0;">
                        <h2>Related Articles</h2>
                        <div class="row" style="gap: 32px;">
                            <?php foreach ($related_articles as $related): ?>
                            <div class="col-12" style="display: flex;">
                                <div class="related-article-card" style="width: 100%; max-width: 900px; margin: 0 auto; border: 1px solid #cc0000; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 16px 0 rgba(204,0,0,0.10); display: flex; flex-direction: row; align-items: stretch;">
                                    <img src="<?php echo htmlspecialchars($related['image']); ?>" alt="<?php echo htmlspecialchars($related['title']); ?>" class="related-article-image" style="height: 100%; min-height: 180px; object-fit: cover; width: 260px; flex-shrink: 0; display: block;">
                                    <div class="p-4" style="flex: 1 1 auto; display: flex; flex-direction: column; justify-content: center;">
                                        <h4 style="font-size: 1.3rem; font-weight: 700; color: #222; margin-bottom: 0.5rem; min-height: 48px;"><?php echo htmlspecialchars($related['title']); ?></h4>
                                        <p class="text-muted" style="font-size: 1.05rem; margin-bottom: 1rem;">By <?php echo htmlspecialchars($related['author_name']); ?></p>
                                        <a href="article.php?id=<?php echo $related['id']; ?>" class="btn" style="background: #cc0000; color: #fff; font-weight: 600; border-radius: 20px; padding: 0.5rem 1.5rem; align-self: flex-start;">Read More</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="comments-section">
                        <h2>Comments</h2>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <form method="POST" action="add_comment.php" class="mb-4">
                                <input type="hidden" name="article_id" value="<?php echo $article_id; ?>">
                                <div class="mb-3">
                                    <textarea class="form-control" name="content" rows="3" placeholder="Write a comment..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </form>
                        <?php else: ?>
                            <p>Please <a href="login.php">login</a> to post a comment.</p>
                        <?php endif; ?>

                        <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <div class="d-flex gap-3">
                                <img src="<?php echo htmlspecialchars($comment['profile_image']); ?>" alt="<?php echo htmlspecialchars($comment['user_name']); ?>" class="comment-user-image">
                                <div>
                                    <h5><?php echo htmlspecialchars($comment['user_name']); ?></h5>
                                    <p class="text-muted"><?php echo date('F j, Y', strtotime($comment['created_at'])); ?></p>
                                    <p><?php echo htmlspecialchars($comment['content']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </article>

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

    <script>
        function shareOnFacebook() {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href));
        }

        function shareOnTwitter() {
            window.open('https://twitter.com/intent/tweet?url=' + encodeURIComponent(window.location.href) + '&text=' + encodeURIComponent(document.title));
        }

        function shareOnLinkedIn() {
            window.open('https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(window.location.href) + '&title=' + encodeURIComponent(document.title));
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href);
            alert('Link copied to clipboard!');
        }
    </script>
</body>
</html> 