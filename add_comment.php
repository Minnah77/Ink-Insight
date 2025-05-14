<?php
session_start();
require_once 'config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $article_id = $_POST['article_id'] ?? null;
    $content = $_POST['content'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Validate input
    if (!$article_id || empty($content)) {
        $_SESSION['error'] = 'Please fill in all fields.';
        header('Location: article.php?id=' . $article_id);
        exit();
    }

    try {
        // Insert comment
        $stmt = $pdo->prepare("INSERT INTO comments (article_id, user_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$article_id, $user_id, $content]);

        $_SESSION['success'] = 'Comment added successfully!';
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error adding comment. Please try again.';
    }

    // Redirect back to article
    header('Location: article.php?id=' . $article_id);
    exit();
} else {
    // If not POST request, redirect to home
    header('Location: index.php');
    exit();
} 