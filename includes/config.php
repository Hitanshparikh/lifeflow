<?php
// LifeFlow Configuration File
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'lifeflow');

// Site Configuration
define('SITE_NAME', 'LifeFlow');
define('SITE_URL', 'http://localhost/lifeflow');
define('SITE_EMAIL', 'contact@lifeflow.com');

// Security
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set default language if not set
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en';
}

// Database Connection
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}
?>
