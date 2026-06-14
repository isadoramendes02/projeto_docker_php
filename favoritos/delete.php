<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'] ?? null;

    if (!$id) {
        header("Location: read.php");
        exit();
    }

    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("
        DELETE FROM favoritos 
        WHERE id = :id 
        AND usuario_id = :usuario_id
    ");

    $stmt->execute([
        ':id' => $id,
        ':usuario_id' => $usuario_id
    ]);

    $_SESSION['mensagem'] = "Favorito removido com sucesso!";

    header("Location: read.php");
    exit();
}