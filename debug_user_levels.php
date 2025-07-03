<?php

// Debug script untuk cek data user dan level
try {
    require_once 'vendor/autoload.php';
    
    // Load environment
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    
    // Setup database connection manually
    $host = $_ENV['DB_HOST'];
    $dbname = $_ENV['DB_DATABASE'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    echo "=== DEBUG USER LEVELS ===" . PHP_EOL;
    
    // Cek struktur tabel users
    echo "Struktur tabel users:" . PHP_EOL;
    $stmt = $pdo->query("DESCRIBE users");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- {$row['Field']}: {$row['Type']}" . PHP_EOL;
    }
    
    echo PHP_EOL . "Data users:" . PHP_EOL;
    $stmt = $pdo->query("SELECT id, name, email, id_level FROM users LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id']}, Name: {$row['name']}, Email: {$row['email']}, Level: " . ($row['id_level'] ?? 'NULL') . PHP_EOL;
    }
    
    echo PHP_EOL . "Data levels:" . PHP_EOL;
    $stmt = $pdo->query("SELECT * FROM tbl_level LIMIT 5");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $id_level = $row['id_level'] ?? $row['id'] ?? 'N/A';
        $level = $row['level'] ?? 'N/A';
        echo "ID Level: {$id_level}, Level: {$level}" . PHP_EOL;
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
