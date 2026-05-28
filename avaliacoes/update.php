<?php
include '../conexao.php';

$id = $_GET['id'];

$stmt = $conn->prepare("
    SELECT a.id, a.nota, f.titulo
    FROM avaliacoes a
    JOIN filmes f ON f.id = a.filme_id
    WHERE a.id = :id
");

$stmt->execute([':id' => $id]);
$avaliacao = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nota = $_POST['nota'];

    $stmt = $conn->prepare("
        UPDATE avaliacoes
        SET nota = :nota
        WHERE id = :id
    ");

    $stmt->execute([
        ':nota' => $nota,
        ':id' => $id
    ]);

    header("Location: read.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Avaliação</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<div class="catalog-container">

    <div class="catalog-header">
        <h1>Editar: <?php echo $avaliacao['titulo']; ?></h1>
    </div>

    <div class="movies-grid">

        <div class="movie-card">

            <form method="POST">

                <div class="movie-info">

                    <select name="nota">
                        <option value="5">⭐⭐⭐⭐⭐</option>
                        <option value="4">⭐⭐⭐⭐</option>
                        <option value="3">⭐⭐⭐</option>
                        <option value="2">⭐⭐</option>
                        <option value="1">⭐</option>
                    </select>

                    <br><br>

                    <button class="btn-novo">Atualizar</button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>