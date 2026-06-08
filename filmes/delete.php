<?php
include '../conexao.php';

if (!isset($_GET['id'])) {
    header("Location: read.php");
    exit();
}

$id = $_GET['id'];

try {
    $sql = "DELETE FROM filmes WHERE id = :id";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->execute([
        ':id' => $id
    ]);

    header("Location: read.php");
    exit();

} catch (PDOException $e) {
    echo "Erro ao deletar: " . $e->getMessage();
}
?>