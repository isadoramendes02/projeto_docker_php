<?php
include '../conexao.php';

// Verifica se o ID foi passado
if (!isset($_GET['id'])) {
    header("Location: read.php");
    exit();
}

$id = $_GET['id'];

try {
    // Deleta o filme direto
    $sql = "DELETE FROM filmes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':id' => $id
    ]);

    // Redireciona de volta para a listagem
    header("Location: read.php");
    exit();

} catch (PDOException $e) {
    echo "Erro ao deletar: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Excluir Filme</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body class="delete-body">

    <div class="delete-container">
        <form method="POST" class="delete-form">
            
            <div class="warning-icon">⚠️</div>
            <h1>Tem a certeza?</h1>
            <p>Esta ação não pode ser desfeita. O filme será excluído permanentemente do banco de dados.</p>

            <div class="delete-buttons">
                <button type="submit" name="confirmar" class="btn-confirmar">Sim, Deletar</button>
                
                <a href="read.php" class="btn-cancelar">Cancelar</a>
            </div>

        </form>
    </div>

</body>
</html>