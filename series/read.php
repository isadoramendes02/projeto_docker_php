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

// MODIFICADO: Bloco de deleção em cascata adicionado aqui no topo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !isset($_POST['observacao'])) {
    // Verifica se o POST veio do botão de excluir (não do editar)
    // O formulário de excluir não aponta para outro arquivo, processa aqui mesmo
    $id = $_POST['id'];

    // 1. Busca o título da série antes de apagar
    $stmtBusca = $conn->prepare("SELECT titulo FROM series WHERE id = :id AND usuario_id = :usuario_id");
    $stmtBusca->execute([
        ':id' => $id,
        ':usuario_id' => $usuario_id
    ]);
    $serie = $stmtBusca->fetch(PDO::FETCH_ASSOC);

    if ($serie) {
        $titulo_serie = $serie['titulo'];

        // 2. Apaga as avaliações vinculadas ao ID desta série
        $stmtDelAval = $conn->prepare("DELETE FROM avaliacoes WHERE serie_id = :id AND usuario_id = :usuario_id");
        $stmtDelAval->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);

        // 3. Apaga os favoritos que possuem o mesmo título e tipo 'Serie'
        $stmtDelFav = $conn->prepare("
            DELETE FROM favoritos 
            WHERE titulo = :titulo 
            AND usuario_id = :usuario_id 
            AND (tipo = 'Serie' OR tipo = 'Série')
        ");
        $stmtDelFav->execute([
            ':titulo' => $titulo_serie,
            ':usuario_id' => $usuario_id
        ]);

        // 4. Apaga a série da tabela principal
        $stmt = $conn->prepare("DELETE FROM series WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);

        $_SESSION['mensagem'] = "Série e seus favoritos deletados com sucesso!";
    }

    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Séries</title>
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
        <h1>Series Disponiveis</h1>
        <div class="header-actions">
            <a href="create.php" class="btn-novo">Add Nova Série</a>
        </div>
    </div>

    <div class="movies-grid">

        <?php
        // MODIFICADO AQUI: Adicionado o ORDER BY id DESC para listar da série mais atualizada para baixo
        $stmt = $conn->prepare("SELECT * FROM series WHERE usuario_id = :usuario_id ORDER BY id DESC");
        $stmt->execute([':usuario_id' => $usuario_id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favoritado = false;

            if (!empty($row['titulo'])) {
                $stmtFav = $conn->prepare("
                    SELECT COUNT(*)
                    FROM favoritos
                    WHERE titulo = :titulo
                    AND tipo = 'Serie'
                    AND usuario_id = :usuario_id
                ");
                $stmtFav->execute([
                    ':titulo' => $row['titulo'],
                    ':usuario_id' => $usuario_id
                ]);
                $favoritado = $stmtFav->fetchColumn() > 0;
            }
        ?>

        <div class="movie-card">
            <div class="movie-poster">
                <img src="../uploads/<?php echo $row['imagem']; ?>" alt="Poster da Série">
            </div>

            <div class="movie-info">
                <h3>
                    <?php echo htmlspecialchars($row['titulo'] ?? ''); ?>
                    <a href="../favoritos/adicionar.php?titulo=<?php echo urlencode($row['titulo'] ?? ''); ?>&tipo=Serie&genero=<?php echo urlencode($row['genero'] ?? ''); ?>"
                    class="<?= $favoritado ? 'favorito' : '' ?>">★</a>
                </h3>

                <?php if (!empty($row['genero'])) { ?>
                    <p><b>Gênero:</b> <?php echo htmlspecialchars($row['genero']); ?></p>
                <?php } ?>

                <p><?php echo htmlspecialchars($row['descricao'] ?? ''); ?></p>

                <div class="movie-actions">

                <form action="update.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn-editar">Editar</button>
                </form>

                <form action="" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta série?');">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn-deletar-lista">Excluir</button>
                </form>

                <form action="../avaliacoes/create.php" method="POST">
                    <input type="hidden" name="serie_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" class="btn-novo">Avaliar</button>
                </form>

</div>
            </div>
        </div>

        <?php } ?>

    </div>
</div>
</body>
</html>
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
    document.body.style.backgroundImage = `url('${fundos[i]}')`;
    setInterval(() => {
        i = (i + 1) % fundos.length;
        document.body.style.backgroundImage = `url('${fundos[i]}')`;
    }, 5000);
</script>