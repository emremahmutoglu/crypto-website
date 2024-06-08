<?php
session_start();
require '../database.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);
$coin_id = $input['coin_id'];
$coin_name = $input['coin_name'];
$action = $input['action'];

if ($action == 'add') {
    $stmt = $pdo->prepare("INSERT INTO favorites (user_id, coin_id, coin_name) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE created_at = CURRENT_TIMESTAMP");
    $stmt->execute([$user_id, $coin_id, $coin_name]);
} elseif ($action == 'remove') {
    $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = ? AND coin_id = ?");
    $stmt->execute([$user_id, $coin_id]);
}

echo json_encode(['status' => 'success']);
?>
