<?php
include '../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Séries</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

    <nav class="navbar-sistema">

        <div class="navbar-logo">
            <a href="#">FlixHub</a>
        </div>

        <ul class="navbar-abas">

    <li>
        <a href="../login/index.php" class="aba-item">Início</a>
    </li>

    <li>
        <a href="../filmes/read.php" class="aba-item">Filmes</a>
    </li>

    <li>
        <a href="../series/read.php" class="aba-item ativa">Séries</a>
    </li>

    <li>
        <a href="../favoritos/read.php" class="aba-item">Favoritos</a>
    </li>

    <li>
        <a href="../avaliacoes/read.php" class="aba-item">Avaliação</a>
    </li>

</ul>

    </nav>

    <div class="catalog-container">

        <div class="catalog-header">

            <h1>Séries Disponíveis</h1>

            <div class="header-actions">
                <a href="create.php" class="btn-novo">
                    Add Nova Série
                </a>
            </div>

        </div>

        <div class="movies-grid">

            <?php
            $sql = "SELECT * FROM series";
            $result = $conn->query($sql);

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            ?>

                <div class="movie-card">

                    <div class="movie-poster">
                        <img src="../uploads/<?php echo $row['imagem']; ?>" alt="">
                    </div>

                    <div class="movie-info">

                        <h3><?php echo $row['titulo']; ?></h3>

                        <p>
                            <?php echo $row['descricao']; ?>
                        </p>

                        <div class="movie-actions">

                            <a href="update.php?id=<?php echo $row['id']; ?>"
                                class="btn-editar">
                                Editar
                            </a>

                            <a href="delete.php?id=<?php echo $row['id']; ?>"
                                class="btn-deletar-lista"
                                onclick="return confirm('Deseja excluir esta série?')">
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