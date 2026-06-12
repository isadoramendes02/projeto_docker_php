<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: read.php");
    exit();
}


include '../conexao.php';


$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: read.php");
    exit();
}

try {
    $sql = "DELETE FROM filmes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);

    $_SESSION['mensagem'] = "Filme deletado com sucesso!";

    header("Location: read.php");
    exit();

} catch (PDOException $e) {
    echo "Erro ao deletar: " . $e->getMessage();
}
?>