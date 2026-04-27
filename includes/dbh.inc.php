<?php
require_once __DIR__ . '/config_env.php';

// Load .env file from project root
loadEnv(__DIR__ . '/../.env');

$host    = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port    = $_ENV['DB_PORT'] ?? '3307';
$dbname  = $_ENV['DB_NAME'] ?? '';
$dbuser  = $_ENV['DB_USER'] ?? 'root';
$dbpass  = $_ENV['DB_PASS'] ?? '';
$charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass, $options);
} catch (PDOException $e) {
    die("❌ Connection failed: " . $e->getMessage());
}
