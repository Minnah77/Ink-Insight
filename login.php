<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid email or password";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ink & Insight Magazine</title>
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
                    <input type="text" name="q" placeholder="Search...">
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

    <div class="login-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="login-card">
                        <div class="card-body">
                            <h2 class="login-title">Welcome Back</h2>
                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
                            <?php endif; ?>
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                            <form method="POST" action="" class="login-form">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn login-btn">Login</button>
                                </div>
                            </form>
                            <div class="register-link">
                                <p>Don't have an account? <a href="register.php">Register here</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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