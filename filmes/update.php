<?php
include '../conexao.php';

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem']['name'];

    if ($imagem) {
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $imagem);

        $sql = "UPDATE filmes SET titulo=:titulo, descricao=:descricao, imagem=:imagem WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':imagem' => $imagem,
            ':id' => $id
        ]);
    } else {
        $sql = "UPDATE filmes SET titulo=:titulo, descricao=:descricao WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':id' => $id
        ]);
    }

    header("Location: read.php");
    exit;
}

// carregar dados
$stmt = $conn->prepare("SELECT * FROM filmes WHERE id = :id");
$stmt->execute([':id' => $id]);
$filme = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Filme</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body class="update-body">

    <div class="create-container"> 
        <form method="POST" enctype="multipart/form-data" class="create-form">
            
            <h1>Editar Filme</h1>

            <input type="hidden" name="id" value="<?= $filme['id'] ?>">

            <label>Título</label>
            <input type="text" name="titulo" value="<?= $filme['titulo'] ?>" required>

            <label>Descrição</label>
            <textarea name="descricao" required><?= $filme['descricao'] ?></textarea>

            <label>Imagem Atual</label>
            <div class="current-image-container">
                <img src="../uploads/<?= $filme['imagem'] ?>" class="update-preview-img">
            </div>

            <label>Nova Imagem (Opcional)</label> 
            <input type="file" name="imagem" id="imagem" style="display: none;">
            <label for="imagem" class="file-button">Escolher arquivo</label>

            <button type="submit" class="btn-atualizar">Salvar Alterações</button>

            <a href="read.php" class="voltar">← Cancelar</a>
            
        </form>
    </div>

</body>
</html>