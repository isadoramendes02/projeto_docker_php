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

<h1>Editar Filme</h1>

<form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $filme['id'] ?>">

    Título:<br>
    <input type="text" name="titulo" value="<?= $filme['titulo'] ?>"><br><br>

    Descrição:<br>
    <textarea name="descricao"><?= $filme['descricao'] ?></textarea><br><br>

    <img src="../uploads/<?= $filme['imagem'] ?>" width="100"><br><br>

    Nova imagem:<br>
    <input type="file" name="imagem"><br><br>

    <button type="submit">Atualizar</button>
</form>