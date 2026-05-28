<?php
include '../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Favoritos</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<nav class="navbar-sistema">

    <div class="navbar-logo">
        <a href="../principal.php">FlixHub</a>
    </div>

    <ul class="navbar-abas">

    <li>
        <a href="../login/index.php" class="aba-item">Início</a>
    </li>

    <li>
        <a href="../filmes/read.php" class="aba-item">Filmes</a>
    </li>

    <li>
        <a href="../series/read.php" class="aba-item">Séries</a>
    </li>

    <li>
        <a href="../favoritos/read.php" class="aba-item ativa">Favoritos</a>
    </li>

    <li>
        <a href="../avaliacoes/read.php" class="aba-item">Avaliação</a>
    </li>

</ul>

</nav>

<div class="catalog-container">

    <div class="catalog-header">
        <h1>Meus Favoritos</h1>

        <div class="header-actions">
            <a href="create.php" class="btn-novo">
                Add Favorito
            </a>
        </div>
    </div>

    <div class="movies-grid">

        <?php
        $sql = "SELECT * FROM favoritos";
        $result = $conn->query($sql);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>

            <div class="movie-card">

                <?php if (!empty($row['imagem'])) { ?>
                    <div class="movie-poster">
                        <img src="../uploads/<?php echo $row['imagem']; ?>" alt="Poster">
                    </div>
                <?php } ?>

                <div class="movie-info">

                    <h3><?php echo $row['titulo']; ?></h3>

                    <p>
                        <strong>Tipo:</strong>
                        <?php echo $row['tipo']; ?>
                    </p>

                    <?php if (!empty($row['observacao'])) { ?>
                        <p><?php echo $row['observacao']; ?></p>
                    <?php } ?>

                    <div class="movie-actions">

                        <a href="update.php?id=<?php echo $row['id']; ?>"
                            class="btn-editar">
                            Editar
                        </a>

                        <a href="delete.php?id=<?php echo $row['id']; ?>"
                            class="btn-deletar-lista">
                            Excluir
                        </a>

                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

</body>
</html>