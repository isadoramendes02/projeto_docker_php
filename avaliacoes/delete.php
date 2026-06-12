<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_POST['id'])) {
        header("Location: read.php");
        exit();
    }

    $id = $_POST['id'];
    $usuario_id = $_SESSION['usuario_id'];

    $stmt = $conn->prepare("
        DELETE FROM avaliacoes 
        WHERE id = :id 
        AND usuario_id = :usuario_id
    ");

    $stmt->execute([
        ':id' => $id,
        ':usuario_id' => $usuario_id
    ]);

    $_SESSION['mensagem'] = "Avaliação removida com sucesso!";

    header("Location: read.php");
    exit();
}
