<?php
session_start();
include '../conexao.php';

$usuario_id = $_SESSION['usuario_id'];

$id = null;
$item = null;
$tipo = '';

if (isset($_GET['filme_id'])) {

    $id = $_GET['filme_id'];
    $tipo = 'filme';

    $stmt = $conn->prepare("
        SELECT *
        FROM filmes
        WHERE id = :id
    ");

} elseif (isset($_GET['serie_id'])) {

    $id = $_GET['serie_id'];
    $tipo = 'serie';

    $stmt = $conn->prepare("
        SELECT *
        FROM series
        WHERE id = :id
    ");

} else {

    die("Item não encontrado.");

}

$stmt->execute([
    ':id' => $id
]);

$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Item não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nota = $_POST['nota'];

    if ($tipo == 'filme') {

        $stmt = $conn->prepare("
            INSERT INTO avaliacoes (
                filme_id,
                nota,
                usuario_id
            )
            VALUES (
                :filme_id,
                :nota,
                :usuario_id
            )
        ");

        $stmt->execute([
            ':filme_id' => $id,
            ':nota' => $nota,
            ':usuario_id' => $usuario_id
        ]);

    } else {

        $stmt = $conn->prepare("
            INSERT INTO avaliacoes (
                serie_id,
                nota,
                usuario_id
            )
            VALUES (
                :serie_id,
                :nota,
                :usuario_id
            )
        ");

        $stmt->execute([
            ':serie_id' => $id,
            ':nota' => $nota,
            ':usuario_id' => $usuario_id
        ]);

    }

    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliar</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<nav class="navbar-sistema">
    <div class="navbar-logo">
        <a href="../principal.php">FlixHub</a>
    </div>
</nav>

<div class="catalog-container">

    <div class="catalog-header">
        <h1>Avaliar: <?php echo $item['titulo']; ?></h1>
    </div>

    <div class="movies-grid">

        <div class="movie-card">

            <form method="POST">

                <div class="movie-info">

                    <p>
                        <strong><?php echo ucfirst($tipo); ?>:</strong>
                        <?php echo $item['titulo']; ?>
                    </p>

                    <label>Nota:</label>
                    <br>

                    <select name="nota" required>
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>

                    <br><br>

                    <button type="submit" class="btn-novo">
                        Enviar Avaliação
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>