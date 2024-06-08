<?php
session_start();

require 'database.php'; // Veritabanı bağlantısını içerir

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$coinId = $_POST['coin_id']; // AJAX'tan gelen coin ID'si
$coinName = $_POST['coin_name']; // AJAX'tan gelen coin name
$action = $_POST['action']; // 'add' veya 'remove' eylemi

// Veritabanında bu coin zaten favorilerde mi kontrol et
$query = $pdo->prepare("SELECT * FROM favorites WHERE user_id = ? AND coin_id = ?");
$query->execute([$user_id, $coinId]);
$exists = $query->fetch();

if ($exists) {
    // Favorilerden çıkar
    $query = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND coin_id = ?");
    $query->execute([$user_id, $coinId]);
    echo json_encode(['status' => 'success', 'message' => 'Removed from favorites']);
} else {
    // Favorilere ekle
    $query = $pdo->prepare("INSERT INTO favorites (user_id, coin_id, coin_name) VALUES (?, ?, ?)");
    $query->execute([$user_id, $coinId, $coinName]);
    echo json_encode(['status' => 'success', 'message' => 'Added to favorites']);
}
?>
