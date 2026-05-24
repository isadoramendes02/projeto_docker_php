<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    $imagem = $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $imagem);

    $sql = "INSERT INTO filmes (titulo, descricao, imagem) VALUES (:titulo, :descricao, :imagem)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':descricao' => $descricao,
        ':imagem' => $imagem
    ]);

    header("Location: read.php");
}
?>

<link rel="stylesheet" href="../css/style.css">

<div class="create-container">
    <form method="POST" enctype="multipart/form-data" class="create-form">
        
        <h1>Novo Filme</h1>

        <label>Título</label>
        <input type="text" name="titulo" required>

        <label>Descrição</label>
        <textarea name="descricao" required></textarea>

        <label>Imagem</label>
        <input type="file" name="imagem" required>

        <button type="submit">Salvar</button>

        <a href="read.php" class="voltar">← Voltar</a>

    </form>
</div>