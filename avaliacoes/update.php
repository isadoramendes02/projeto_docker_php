<?php
include '../conexao.php';

// Garante que o ID foi passado na URL, senão volta para a listagem
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: read.php");
    exit;
}

// Consulta inteligente: busca o título seja de Filme OU de Série
$stmt = $conn->prepare("
    SELECT a.id, a.nota, f.titulo AS filme_titulo, s.titulo AS serie_titulo
    FROM avaliacoes a
    LEFT JOIN filmes f ON f.id = a.filme_id
    LEFT JOIN series s ON s.id = a.serie_id
    WHERE a.id = :id
");

$stmt->execute([':id' => $id]);
$avaliacao = $stmt->fetch(PDO::FETCH_ASSOC);

// SE A AVALIAÇÃO NÃO EXISTIR NO BANCO, REDIRECIONA (Evita o erro de tipo bool)
if (!$avaliacao) {
    header("Location: read.php");
    exit;
}

// Define o título correto para exibir na tela (filme ou série)
$titulo_exibicao = $avaliacao['filme_titulo'] ?? $avaliacao['serie_titulo'] ?? 'Item Desconhecido';

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
        <h1>Editar: <?php echo htmlspecialchars($titulo_exibicao); ?></h1>
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