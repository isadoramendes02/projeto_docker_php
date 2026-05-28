<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $observacao = $_POST['observacao'];

    $sql = "INSERT INTO favoritos
            (titulo, tipo, observacao)
            VALUES
            (:titulo, :tipo, :observacao)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':titulo' => $titulo,
        ':tipo' => $tipo,
        ':observacao' => $observacao
    ]);

    header("Location: read.php");
    exit;
}
?>

<link rel="stylesheet" href="../css/index.css">

<div class="create-container">
    <form method="POST" class="create-form">

        <h1>Novo Favorito</h1>

        <label>Título</label>
        <input type="text" name="titulo" required>

        <label>Tipo</label>
        <select name="tipo" required>
            <option value="Filme">Filme</option>
            <option value="Série">Série</option>
        </select>

        <label>Observação</label>
        <textarea name="observacao"></textarea>

        <button type="submit">
            Salvar
        </button>

        <a href="read.php" class="voltar">
            ← Voltar
        </a>

    </form>
</div>