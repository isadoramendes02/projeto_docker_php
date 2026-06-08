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

    $stmt = $conn->prepare("SELECT * FROM filmes WHERE id = :id");
} elseif (isset($_GET['serie_id'])) {
    $id = $_GET['serie_id'];
    $tipo = 'serie';

    $stmt = $conn->prepare("SELECT * FROM series WHERE id = :id");
} else {
    die("Item não encontrado.");
}

$stmt->execute([':id' => $id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
    die("Item não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nota = $_POST['nota'];

    if ($tipo == 'filme') {
        $stmt = $conn->prepare("INSERT INTO avaliacoes (filme_id, nota, usuario_id) VALUES (:filme_id, :nota, :usuario_id)");
        $stmt->execute([
            ':filme_id'   => $id,
            ':nota'       => $nota,
            ':usuario_id' => $usuario_id
        ]);
    } else {
        $stmt = $conn->prepare("INSERT INTO avaliacoes (serie_id, nota, usuario_id) VALUES (:serie_id, :nota, :usuario_id)");
        $stmt->execute([
            ':serie_id'   => $id,
            ':nota'       => $nota,
            ':usuario_id' => $usuario_id
        ]);
    }

    header("Location: read.php");
    exit();
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
    <title>Avaliar</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="create-body">

    <nav class="navbar-sistema">
        <div class="navbar-logo">FlixHub</div>
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

            <h1>Avaliar</h1>

            <p>
                <strong><?php echo ucfirst($tipo); ?>:</strong>
                <?php echo $item['titulo']; ?>
            </p>

            <label>Nota</label>
            <select name="nota" required>
                <option value="5">⭐⭐⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="2">⭐⭐</option>
                <option value="1">⭐</option>
            </select>
            <button type="submit" class="btn-atualizar">Enviar Avaliação</button>

            <a href="../filmes/read.php" class="voltar">← Cancelar</a>

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