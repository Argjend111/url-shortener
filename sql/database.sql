CREATE DATABASE url_shortener;
USE url_shortener;

CREATE TABLE links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_url TEXT NOT NULL,
    short_code VARCHAR(10) NOT NULL UNIQUE,
    clicks INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NULL
);

CREATE TABLE expirations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    minutes INT NOT NULL,
    label VARCHAR(50) NOT NULL
);
