<?php
session_start();
require '../includes/db.php';

$nome = $_POST['name'];
$senha = $_POST['password'];

$stmt = $pdo->prepare("SELECT * FROM usuario WHERE nome = ? AND ativo = 1");
$stmt->execute([$nome]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['perfil'] = $user['perfil'];
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
