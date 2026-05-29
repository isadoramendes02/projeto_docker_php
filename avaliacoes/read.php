<?php
session_start();
include '../conexao.php';

$usuario_id = $_SESSION['usuario_id'];
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
            <a href="../principal.php" class="aba-item">
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
        <li>
            <a href="../logout.php" class="aba-item">
                Sair
            </a>
        </li>

    </ul>

</nav>

<div class="catalog-container">

    <div class="catalog-header">
        <h1>Minhas Avaliações</h1>
    </div>

    <div class="movies-grid">

        <?php

        $stmt = $conn->prepare("

            SELECT
                a.id,
                a.nota,
                f.titulo,
                f.imagem,
                'Filme' AS tipo
            FROM avaliacoes a
            JOIN filmes f ON f.id = a.filme_id
            WHERE a.usuario_id = :usuario_id

            UNION

            SELECT
                a.id,
                a.nota,
                s.titulo,
                s.imagem,
                'Série' AS tipo
            FROM avaliacoes a
            JOIN series s ON s.id = a.serie_id
            WHERE a.usuario_id = :usuario_id

            ORDER BY id DESC

        ");

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>

            <div class="movie-card">

                <div class="movie-info">

                    <h3><?php echo $row['titulo']; ?></h3>

                    <p>
                        <strong>Tipo:</strong>
                        <?php echo $row['tipo']; ?>
                    </p>

                    <div class="rating-row">

                        <img
                            src="../uploads/<?php echo $row['imagem']; ?>"
                            class="mini-img"
                            alt="<?php echo $row['titulo']; ?>"
                        >

                        <div class="stars">

                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo ($i <= $row['nota']) ? "⭐" : "☆";
                            }
                            ?>

                        </div>

                    </div>

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