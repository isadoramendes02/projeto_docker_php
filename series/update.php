<?php
include '../conexao.php';

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem']['name'];

    if ($imagem) {
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $imagem);

        $sql = "UPDATE series
                SET titulo=:titulo,
                    descricao=:descricao,
                    imagem=:imagem
                WHERE id=:id";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':imagem' => $imagem,
            ':id' => $id
        ]);
    } else {

        $sql = "UPDATE series
                SET titulo=:titulo,
                    descricao=:descricao
                WHERE id=:id";

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

$stmt = $conn->prepare("SELECT * FROM series WHERE id = :id");
$stmt->execute([':id' => $id]);
$serie = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Série</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body class="update-body">

<div class="create-container">

    <form method="POST" enctype="multipart/form-data" class="create-form">

        <h1>Editar Série</h1>

        <input type="hidden" name="id" value="<?= $serie['id'] ?>">

        <label>Título</label>
        <input type="text" name="titulo"
               value="<?= $serie['titulo'] ?>" required>

        <label>Descrição</label>
        <textarea name="descricao" required><?= $serie['descricao'] ?></textarea>

        <label>Imagem Atual</label>
        <div class="current-image-container">
            <img src="../uploads/<?= $serie['imagem'] ?>"
                 class="update-preview-img">
        </div>

        <label>Nova Imagem (Opcional)</label>

        <input type="file"
                name="imagem"
                id="imagem"
                style="display:none;">

        <label for="imagem" class="file-button">
            Escolher arquivo
        </label>

        <button type="submit" class="btn-atualizar">
            Salvar Alterações
        </button>

        <a href="read.php" class="voltar">
            ← Cancelar
        </a>

    </form>

</div>

</body>
</html>