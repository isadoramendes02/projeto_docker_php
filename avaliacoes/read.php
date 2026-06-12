<?php
session_start();
include '../conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
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
    <title>Avaliações</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="read-body">
<?php

if (isset($_SESSION['mensagem'])) {
    echo '<div id="mensagem-sucesso" class="mensagem-sucesso">' . $_SESSION['mensagem'] . '</div>';
    unset($_SESSION['mensagem']);
}
?>

<nav class="navbar-sistema">
    <div class="navbar-logo">
        FlixHub
    </div>

    <ul class="navbar-abas">
        <li><a href="../principal.php" class="aba-item">Início</a></li>
        <li><a href="../filmes/read.php" class="aba-item">Filmes</a></li>
        <li><a href="../series/read.php" class="aba-item">Séries</a></li>
        <li><a href="../favoritos/read.php" class="aba-item">Favoritos</a></li>
        <li><a href="../avaliacoes/read.php" class="aba-item ativa">Avaliações</a></li>
        <li><a href="../logout.php" class="aba-item">Sair</a></li>
    </ul>
</nav>

<div class="catalog-container">

    <div class="catalog-header">
        <h1>Avaliar</h1>
    </div>

    <div class="movies-grid">

        <?php
        $stmt = $conn->prepare("
            SELECT 
                avaliacoes.id,
                avaliacoes.nota,
                filmes.titulo,
                filmes.imagem,
                'Filme' AS tipo
            FROM avaliacoes
            JOIN filmes ON filmes.id = avaliacoes.filme_id
            WHERE avaliacoes.usuario_id = :usuario_id

            UNION

            SELECT 
                avaliacoes.id,
                avaliacoes.nota,
                series.titulo,
                series.imagem,
                'Série' AS tipo
            FROM avaliacoes
            JOIN series ON series.id = avaliacoes.serie_id
            WHERE avaliacoes.usuario_id = :usuario_id

            ORDER BY id DESC
        ");

        $stmt->execute([':usuario_id' => $usuario_id]);

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
                    <img src="../uploads/<?php echo $row['imagem']; ?>" class="mini-img">

                    <div class="stars">
                        <?php
                        for ($i = 1; $i <= 5; $i++) {
                            echo ($i <= $row['nota']) ? "⭐" : "☆";
                        }
                        ?>
                    </div>
                </div>

                    <div class="movie-actions">

                    <form class="form-inline" action="update.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn-editar">Editar</button>
                    </form>

                    <form class="form-inline" action="delete.php" method="POST" onsubmit="return confirm('Tem certeza?');">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn-deletar-lista">Excluir</button>
                    </form>

            </div>

            </div>
        </div>

        <?php } ?>

    </div>
</div>

<script>
setTimeout(() => {
    const mensagem = document.getElementById('mensagem-sucesso');

    if (mensagem) {
        mensagem.style.transition = 'opacity 0.5s';
        mensagem.style.opacity = '0';

        setTimeout(() => {
            mensagem.remove();
        }, 500);
    }
}, 4000); 
</script>

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