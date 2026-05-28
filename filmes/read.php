<?php include '../conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Filmes</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body class="read-body">

    
    <nav class="navbar-sistema">
        <div class="navbar-logo">
            <a href="../principal.php">FlixHub</a>
        </div>

        <ul class="navbar-abas">
    <li>
        <a href="../principal.php" class="aba-item <?= strpos($_SERVER['REQUEST_URI'], 'principal') !== false ? 'ativa' : '' ?>">
            Início
        </a>
    </li>

    <li>
        <a href="read.php" class="aba-item <?= strpos($_SERVER['REQUEST_URI'], 'filmes') !== false ? 'ativa' : '' ?>">
            Filmes
        </a>
    </li>

    <li>
        <a href="../series/read.php" class="aba-item <?= strpos($_SERVER['REQUEST_URI'], 'series') !== false ? 'ativa' : '' ?>">
            Séries
        </a>
    </li>

    <li>
        <a href="../favoritos/read.php" class="aba-item <?= strpos($_SERVER['REQUEST_URI'], 'favoritos') !== false ? 'ativa' : '' ?>">
            Favoritos
        </a>
    </li>

    <li>
        <a href="../avaliacoes/read.php" class="aba-item <?= strpos($_SERVER['REQUEST_URI'], 'avaliacoes') !== false ? 'ativa' : '' ?>">
            Avaliações
        </a>
    </li>
</ul>
    </nav>

    <div class="catalog-container">

        <div class="catalog-header">
            <h1>Filmes Disponíveis</h1>

            <div class="header-actions">
                <a href="create.php" class="btn-novo">
                    Add Novo Filme
                </a>
            </div>
        </div>

        <div class="movies-grid">

            <?php
            $sql = "SELECT * FROM filmes";
            $result = $conn->query($sql);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                $stmtFav = $conn->prepare("
                    SELECT id
                    FROM favoritos
                    WHERE titulo = :titulo
                ");

                $stmtFav->execute([
                    ':titulo' => $row['titulo']
                ]);

                $favoritado = $stmtFav->fetch();
            ?>

                <div class="movie-card">

                    <div class="movie-poster">
                        <img src="../uploads/<?php echo $row['imagem']; ?>" alt="Poster do Filme">
                    </div>

                    <div class="movie-info">

                        <h3>
                            <?php echo $row['titulo']; ?>

                            <a href="../favoritos/adicionar.php?titulo=<?php echo urlencode($row['titulo']); ?>&tipo=Filme"
                                style="
                                    float:right;
                                    text-decoration:none;
                                    font-size:22px;
                                    color: <?php echo $favoritado ? 'gold' : '#888'; ?>;
                                ">
                                ★
                            </a>
                        </h3>

                        <p>
                            <?php echo $row['descricao']; ?>
                        </p>

                        <div class="movie-actions">

                            <a href="update.php?id=<?php echo $row['id']; ?>"
                                class="btn-editar">
                                Editar
                            </a>

                            <a href="delete.php?id=<?php echo $row['id']; ?>"
                                class="btn-deletar-lista">
                                Excluir
                            </a>

                            <a href="../avaliacoes/create.php?filme_id=<?php echo $row['id']; ?>"
                                class="btn-novo">
                                Avaliar
                            </a>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</body>
</html>