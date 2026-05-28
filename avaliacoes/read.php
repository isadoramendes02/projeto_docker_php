<?php
include '../conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Avaliações</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<nav class="navbar-sistema">

    <div class="navbar-logo">
        <a href="../principal.php">FlixHub</a>
    </div>

    <ul class="navbar-abas">

    <li>
        <a href="../login/index.php" class="aba-item">
            Início
        </a>
    </li>

    <li>
        <a href="../filmes/read.php" class="aba-item">
            Filmes
        </a>
    </li>

    <li>
        <a href="../series/read.php" class="aba-item">
            Séries
        </a>
    </li>

    <li>
        <a href="../favoritos/read.php" class="aba-item">
            Favoritos
        </a>
    </li>

    <li>
        <a href="../avaliacoes/read.php" class="aba-item ativa">
            Avaliações
        </a>
    </li>

</ul>

</nav>

<div class="catalog-container">

    <div class="catalog-header">
        <h1>Avaliações</h1>
    </div>

    <div class="movies-grid">

        <?php
        $sql = "
            SELECT 
                a.id,
                a.nota,
                f.titulo,
                f.imagem
            FROM avaliacoes a
            JOIN filmes f ON f.id = a.filme_id
        ";

        $result = $conn->query($sql);

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        ?>

            <div class="movie-card">

                <div class="movie-info">

                    <h3><?php echo $row['titulo']; ?></h3>

                    <!-- LINHA IMAGEM + ESTRELAS -->
                    <div class="rating-row">

                        <img src="../uploads/<?php echo $row['imagem']; ?>" class="mini-img">

                        <div class="stars">

                            <?php
                            $nota = $row['nota'];

                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $nota ? "⭐" : "☆";
                            }
                            ?>

                        </div>

                    </div>

                    <div class="movie-actions">

                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn-editar">
                            Editar
                        </a>

                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-deletar-lista">
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