<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../conexao.php';

$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: read.php");
    exit();
}

$stmt = $conn->prepare("DELETE FROM favoritos WHERE id = :id");
$stmt->execute([':id' => $id]);

$_SESSION['mensagem'] = "Favorito removido com sucesso!";

header("Location: read.php");
exit();