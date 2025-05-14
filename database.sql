-- Create the database
CREATE DATABASE IF NOT EXISTS ink_insight;
USE ink_insight;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    bio TEXT,
    profile_image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    slug VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

-- Create articles table
CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    content TEXT NOT NULL,
    image VARCHAR(255),
    category_id INT,
    author_id INT,
    tags VARCHAR(255),
    reading_time INT DEFAULT 5,
    views INT DEFAULT 0,
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (author_id) REFERENCES users(id)
);

-- Create comments table
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT,
    user_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Insert sample categories
INSERT INTO categories (name, slug, description) VALUES
('Physics', 'physics', 'Articles about physics and related sciences'),
('Biology', 'biology', 'Articles about biology and life sciences'),
('Chemistry', 'chemistry', 'Articles about chemistry and chemical processes'),
('Computer Science', 'computer-science', 'Articles about computer science and technology'),
('Mathematics', 'mathematics', 'Articles about mathematics and mathematical concepts'),
('Astronomy', 'astronomy', 'Articles about astronomy and space'),
('Psychology', 'psychology', 'Articles about psychology and human behavior'),
('Earth Science', 'earth-science', 'Articles about earth sciences and geology');

-- Insert sample user (password: password123)
INSERT INTO users (name, email, password, bio, profile_image) VALUES
('Admin User', 'admin@inkinsight.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 
'Experienced science writer and researcher with a passion for making complex scientific concepts accessible to everyone.', 
'Assets/Images/author-profile.jpg'); 