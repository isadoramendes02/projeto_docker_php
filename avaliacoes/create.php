<?php
include '../conexao.php';

$filme_id = $_GET['filme_id'];

$stmt = $conn->prepare("SELECT * FROM filmes WHERE id = :id");
$stmt->execute([':id' => $filme_id]);
$filme = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nota = $_POST['nota'];

    $stmt = $conn->prepare("
        INSERT INTO avaliacoes (filme_id, nota)
        VALUES (:filme_id, :nota)
    ");

    $stmt->execute([
        ':filme_id' => $filme_id,
        ':nota' => $nota
    ]);

    header("Location: read.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliar Filme</title>
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
        <h1>Avaliar: <?php echo $filme['titulo']; ?></h1>
    </div>

    <div class="movies-grid">

        <div class="movie-card">

            <form method="POST">

                <div class="movie-info">

                    <p><strong>Filme:</strong> <?php echo $filme['titulo']; ?></p>

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