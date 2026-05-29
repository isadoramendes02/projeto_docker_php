<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>FlixHub - Início</title>
    <link rel="stylesheet" href="css/index.css">
</head>

<body class="dashboard-page">

<!-- Imagem de fundo -->
<img src="login/img/fundo20.png" class="bg">

<!-- Navbar -->
<nav class="navbar-sistema">

    <div class="navbar-logo">
        <h1><a href="principal.php">FlixHub</a></h1>
    </div>

    <ul class="navbar-abas">

    <li>
        <a href="principal.php" class="aba-item ativa">Início</a>
    </li>

    <li>
        <a href="filmes/read.php" class="aba-item">Filmes</a>
    </li>

    <li>
        <a href="series/read.php" class="aba-item">Séries</a>
    </li>

    <li>
        <a href="favoritos/read.php" class="aba-item">Favoritos</a>
    </li>

    <li>
        <a href="avaliacoes/read.php" class="aba-item">Avaliações</a>
    </li>

</ul>
</nav>

<!-- Conteúdo principal -->
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

</body>
</html>