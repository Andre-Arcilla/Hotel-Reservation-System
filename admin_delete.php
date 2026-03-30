<?php
    // delete_booking.php
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'hotelsogo_db';
    $dbHost = 'localhost';

    try {
        $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;", $dbUser, $dbPass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $stmt = $pdo->prepare("DELETE FROM reservations WHERE id = ?");
            $stmt->execute([$id]);
        }

        // Redirect back to the admin page
        header("Location: hotelsogo-admin.php?page=booking&status=deleted");
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
?>