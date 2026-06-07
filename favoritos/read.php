<?php
session_start();
include '../conexao.php';

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
    <title>Favoritos</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="read-body">

    <nav class="navbar-sistema">
        <div class="navbar-logo">FlixHub</div>

        <ul class="navbar-abas">
            <li><a href="../principal.php" class="aba-item">Início</a></li>
            <li><a href="../filmes/read.php" class="aba-item">Filmes</a></li>
            <li><a href="../series/read.php" class="aba-item">Séries</a></li>
            <li><a href="../favoritos/read.php" class="aba-item ativa">Favoritos</a></li>
            <li><a href="../avaliacoes/read.php" class="aba-item">Avaliações</a></li>
            <li><a href="../logout.php" class="aba-item">Sair</a></li>
        </ul>
    </nav>

    <div class="catalog-container">
        <div class="catalog-header">
            <h1>Meus Favoritos</h1>
            <div class="header-actions"></div>
        </div>

        <div class="movies-grid">
            <?php
            $stmt = $conn->prepare("SELECT * FROM favoritos WHERE usuario_id = :usuario_id");
            $stmt->execute([':usuario_id' => $usuario_id]);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="movie-card card-favoritos">
                <?php if (!empty($row['imagem'])) { ?>
                <div class="movie-poster">
                    <img src="../uploads/<?php echo $row['imagem']; ?>" alt="Poster">
                </div>
                <?php } ?>

                <div class="movie-info">
                    <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
                    
                    <p>
                        <strong>Tipo:</strong> 
                        <?php echo htmlspecialchars($row['tipo']); ?>
                    </p>

                    <?php if (!empty($row['genero'])) { ?>
                    <p>
                        <strong>Gênero:</strong> 
                        <?php echo htmlspecialchars($row['genero']); ?>
                    </p>
                    <?php } ?>

                    <?php if (!empty($row['observacao'])) { ?>
                        <p><strong>Observação:</strong> <?php echo htmlspecialchars($row['observacao']); ?></p>
                    <?php } ?>

                    <div class="movie-actions">
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn-editar">Editar</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-deletar-lista">Excluir</a>
                    </div>
                </div>
            </div>
            <?php } ?>
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