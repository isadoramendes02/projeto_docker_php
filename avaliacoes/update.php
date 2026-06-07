<?php
session_start();
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
        ':id'   => $id
    ]);

    header("Location: read.php");
    exit;
}

$fundos = [
    "../img/img2.jpg",
    "../img/img3.jpg",
    "../img/img4.jpg",
    "../img/img5.jpg",
    "../img/img6.jpg",
    "../img/img7.jpg",
    "../img/img8.jpg",
    "../img/img9.jpg",
    "../img/img10.jpg",
    "../img/img11.jpg",
    "../img/img12.jpg",
    "../img/img13.jpg",
    "../img/img14.jpg",
    "../img/img15.jpg",
    "../img/img16.jpg",
    "../img/img17.jpg",
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Avaliação</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="create-body">
    
    <nav class="navbar-sistema">
        <div class="navbar-logo">
            <a href="../principal.php">FlixHub</a>
        </div>
        <ul class="navbar-abas">
            <li><a href="../principal.php" class="aba-item">Início</a></li>
            <li><a href="../filmes/read.php" class="aba-item">Filmes</a></li>
            <li><a href="../series/read.php" class="aba-item">Séries</a></li>
            <li><a href="../favoritos/read.php" class="aba-item">Favoritos</a></li>
            <li><a href="../avaliacoes/read.php" class="aba-item ativa">Avaliações</a></li>
            <li><a href="../logout.php" class="aba-item">Sair</a></li>
        </ul>
    </nav>

    <div class="create-container">
        <form method="POST" class="create-form">

            <h1>Editar Avaliação</h1>
            
            <p class="item-avaliacao-texto">
                <strong>Item:</strong> <?php echo htmlspecialchars($titulo_exibicao); ?>
            </p>

            <label>Nova Nota</label>
            <select name="nota" required>
                <option value="5" <?= $avaliacao['nota'] == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                <option value="4" <?= $avaliacao['nota'] == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                <option value="3" <?= $avaliacao['nota'] == 3 ? 'selected' : '' ?>>⭐⭐⭐</option>
                <option value="2" <?= $avaliacao['nota'] == 2 ? 'selected' : '' ?>>⭐⭐</option>
                <option value="1" <?= $avaliacao['nota'] == 1 ? 'selected' : '' ?>>⭐</option>
            </select>

            <button type="submit" class="btn-atualizar">Atualizar</button>

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