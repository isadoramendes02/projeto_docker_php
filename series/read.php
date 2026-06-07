<?php
session_start();
include '../conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];


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
    <title>Séries</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>

<body class="read-body">

<nav class="navbar-sistema">
        <div class="navbar-logo">FlixHub</div>

        <ul class="navbar-abas">
            <li><a href="../principal.php" class="aba-item">Início</a></li>
            <li><a href="../filmes/read.php" class="aba-item">Filmes</a></li>
            <li><a href="../series/read.php" class="aba-item ativa">Séries</a></li>
            <li><a href="../favoritos/read.php" class="aba-item">Favoritos</a></li>
            <li><a href="../avaliacoes/read.php" class="aba-item">Avaliações</a></li>
            <li><a href="../logout.php" class="aba-item">Sair</a></li>
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
        $stmt = $conn->prepare("
            SELECT *
            FROM series
            WHERE usuario_id = :usuario_id
        ");

        $stmt->execute([
            ':usuario_id' => $usuario_id
        ]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $stmtFav = $conn->prepare("
                SELECT COUNT(*)
                FROM favoritos
                WHERE titulo = :titulo
                AND usuario_id = :usuario_id
            ");

            $stmtFav->execute([
                ':titulo' => $row['titulo'],
                ':usuario_id' => $usuario_id
            ]);

            $favoritado = $stmtFav->fetchColumn() > 0;
        ?>

        <div class="movie-card">

            <div class="movie-poster">
                <img src="../uploads/<?php echo $row['imagem']; ?>" alt="Poster da Série">
            </div>

            <div class="movie-info">

                <h3>
                    <?php echo htmlspecialchars($row['titulo']); ?>

                    <a href="../favoritos/adicionar.php?titulo=<?php echo urlencode($row['titulo']); ?>&tipo=Série&genero=<?php echo urlencode($row['genero'] ?? ''); ?>"
                    class="<?= $favoritado ? 'favorito' : '' ?>">
                        ★
                    </a>
                </h3>

                <?php if (!empty($row['genero'])) { ?>
                    <p>
                        <b>Gênero:</b> <?php echo htmlspecialchars($row['genero']); ?>
                    </p>
                <?php } ?>

                <p>
                    <?php echo htmlspecialchars($row['descricao']); ?>
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

                    <a href="../avaliacoes/create.php?serie_id=<?php echo $row['id']; ?>"
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

<script>
    const fundos = <?php echo json_encode($fundos); ?>;
    let i = 0;

    document.body.style.backgroundImage = `url('${fundos[i]}')`;

    setInterval(() => {
        i = (i + 1) % fundos.length;
        document.body.style.backgroundImage = `url('${fundos[i]}')`;
    }, 5000);
</script>