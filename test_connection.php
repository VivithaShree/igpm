<?php
try {
    require_once 'config/database.php';
    
    if ($pdo) {
        echo "Successfully connected to the database!<br>";
        echo "Database name: " . $pdo->query('select database()')->fetchColumn();
    }
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>