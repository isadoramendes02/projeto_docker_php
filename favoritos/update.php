<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../conexao.php';

$usuario_id = $_SESSION['usuario_id'];

$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: read.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['observacao'])) {

    $stmt = $conn->prepare("
        UPDATE favoritos
        SET observacao = :observacao
        WHERE id = :id
        AND usuario_id = :usuario_id
    ");

    $stmt->execute([
        ':observacao' => $_POST['observacao'],
        ':id' => $id,
        ':usuario_id' => $usuario_id
    ]);

    $_SESSION['mensagem'] = "Favorito atualizado com sucesso!";

    header("Location: read.php");
    exit();
}

$stmt = $conn->prepare("
    SELECT *
    FROM favoritos
    WHERE id = :id
    AND usuario_id = :usuario_id
");

$stmt->execute([
    ':id' => $id,
    ':usuario_id' => $usuario_id
]);

$favorito = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$favorito) {
    header("Location: read.php");
    exit();
}

$fundos = [
    "../img/img2.jpg", "../img/img3.jpg", "../img/img4.jpg", "../img/img5.jpg",
    "../img/img6.jpg", "../img/img7.jpg", "../img/img8.jpg", "../img/img9.jpg",
    "../img/img10.jpg", "../img/img11.jpg", "../img/img12.jpg", "../img/img13.jpg",
    "../img/img14.jpg", "../img/img15.jpg", "../img/img16.jpg", "../img/img17.jpg",
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Observação</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="create-body">

<nav class="navbar-sistema">
    <div class="navbar-logo">FlixHub</div>
    <ul class="navbar-abas">
        <li><a href="../principal.php">Início</a></li>
        <li><a href="../filmes/read.php">Filmes</a></li>
        <li><a href="../series/read.php">Séries</a></li>
        <li><a href="../favoritos/read.php" class="ativa">Favoritos</a></li>
        <li><a href="../avaliacoes/read.php">Avaliações</a></li>
        <li><a href="../logout.php">Sair</a></li>
    </ul>
</nav>

<div class="create-container">
    <form method="POST" class="create-form">

        <h1>Editar Observação</h1>

        <input type="hidden" name="id" value="<?= $favorito['id'] ?>">

        <label>Título</label>
        <input type="text" value="<?= htmlspecialchars($favorito['titulo']) ?>" disabled>

        <label>Tipo</label>
        <input type="text" value="<?= htmlspecialchars($favorito['tipo']) ?>" disabled>

        <label>Sua Observação / Comentário</label>
        <textarea name="observacao"><?= htmlspecialchars($favorito['observacao'] ?? '') ?></textarea>

        <button type="submit" class="btn-atualizar">Salvar Alterações</button>

        <a href="read.php" class="voltar">← Cancelar</a>

    </form>
</div>

<script>
const fundos = <?php echo json_encode($fundos); ?>;
let i = 0;

if (fundos.length > 0) {
    document.body.style.backgroundImage = `url('${fundos[i]}')`;

    setInterval(() => {
        i = (i + 1) % fundos.length;
        document.body.style.backgroundImage = `url('${fundos[i]}')`;
    }, 5000);
}
</script>

</body>
</html>