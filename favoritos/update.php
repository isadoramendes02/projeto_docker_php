<?php
include '../conexao.php';

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $observacao = $_POST['observacao'];

    $sql = "UPDATE favoritos
            SET titulo=:titulo,
                tipo=:tipo,
                observacao=:observacao
            WHERE id=:id";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':titulo' => $titulo,
        ':tipo' => $tipo,
        ':observacao' => $observacao,
        ':id' => $id
    ]);

    header("Location: read.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM favoritos WHERE id=:id");
$stmt->execute([':id' => $id]);

$favorito = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Favorito</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<div class="create-container">

    <form method="POST" class="create-form">

        <h1>Editar Favorito</h1>

        <input type="hidden" name="id" value="<?= $favorito['id'] ?>">

        <label>Título</label>
        <input
            type="text"
            name="titulo"
            value="<?= $favorito['titulo'] ?>"
            required
        >

        <label>Tipo</label>

        <select name="tipo" required>

            <option value="Filme"
            <?= $favorito['tipo'] == 'Filme' ? 'selected' : '' ?>>
                Filme
            </option>

            <option value="Série"
            <?= $favorito['tipo'] == 'Série' ? 'selected' : '' ?>>
                Série
            </option>

        </select>

        <label>Observação</label>

        <textarea name="observacao"><?= $favorito['observacao'] ?></textarea>

        <button type="submit">
            Salvar Alterações
        </button>

        <a href="read.php" class="voltar">
            ← Cancelar
        </a>

    </form>

</div>

</body>
</html>