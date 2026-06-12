<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login/index.php");
    exit;
}

$fundos = [
    "img/img2.jpg",
    "img/img3.jpg",
    "img/img4.jpg",
    "img/img5.jpg",
    "img/img6.jpg",
    "img/img7.jpg",
    "img/img8.jpg",
    "img/img9.jpg",
    "img/img10.jpg",
    "img/img11.jpg",
    "img/img12.jpg",
    "img/img13.jpg",
    "img/img14.jpg",
    "img/img15.jpg",
    "img/img16.jpg",
    "img/img17.jpg",
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>FlixHub - Início</title>
    <link rel="stylesheet" href="css/stylecrud.css">
</head>
<body class="dashboard-page">

    <nav class="navbar-sistema">
        <div class="navbar-logo">
            <a href="principal.php">FlixHub</a>
        </div>
        <ul class="navbar-abas">
            <li><a href="principal.php" class="aba-item ativa">Início</a></li>
            <li><a href="filmes/read.php" class="aba-item">Filmes</a></li>
            <li><a href="series/read.php" class="aba-item">Séries</a></li>
            <li><a href="favoritos/read.php" class="aba-item">Favoritos</a></li>
            <li><a href="avaliacoes/read.php" class="aba-item">Avaliações</a></li>
            <li><a href="logout.php" class="aba-item">Sair</a></li>
        </ul>
    </nav>

    <div class="dashboard">
        <h1>Bem-vindo ao FlixHub</h1>
        <p>Escolha uma opção abaixo para acessar o sistema</p>

        <div class="cards-grid">
            <a href="filmes/read.php" class="card">🎬 Filmes</a>
            <a href="series/read.php" class="card">📺 Séries</a>
            <a href="favoritos/read.php" class="card">❤️ Favoritos</a>
            <a href="avaliacoes/read.php" class="card">⭐ Avaliações</a>
        </div>
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