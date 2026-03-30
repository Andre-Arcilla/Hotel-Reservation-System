<?php
    // 1. Connection
    $pdo = new PDO("mysql:host=localhost;dbname=hotelsogo_db;", 'root', '');

    // 2. The Logic
    if (isset($_POST['id']) && isset($_POST['status'])) {
        
        // This is the line that actually changes the database
        $stmt = $pdo->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $stmt->execute([$_POST['status'], $_POST['id']]);
        
        echo "Done"; 
    }
?>