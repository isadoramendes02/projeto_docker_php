<?php
session_start();


if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../conexao.php';

$usuario_id = $_SESSION['usuario_id'];


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];


    $stmt = $conn->prepare("DELETE FROM series WHERE id = :id AND usuario_id = :usuario_id");

    $stmt->execute([
        ':id' => $id,
        ':usuario_id' => $usuario_id
    ]);

    $_SESSION['mensagem'] = "Série deletada com sucesso!";
}


header("Location: read.php");
exit();
?>