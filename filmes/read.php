<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

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

// MODIFICADO APENAS O BLOCO DE DELEÇÃO ABAIXO
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];

    // 1. Busca o título do filme antes de deletar (necessário para os favoritos antigos)
    $stmtBusca = $conn->prepare("SELECT titulo FROM filmes WHERE id = :id AND usuario_id = :usuario_id");
    $stmtBusca->execute([
        ':id' => $id,
        ':usuario_id' => $usuario_id
    ]);
    $filme = $stmtBusca->fetch(PDO::FETCH_ASSOC);

    if ($filme) {
        $titulo_filme = $filme['titulo'];

        // 2. Apaga as avaliações vinculadas ao ID deste filme
        $stmtDelAval = $conn->prepare("DELETE FROM avaliacoes WHERE filme_id = :id AND usuario_id = :usuario_id");
        $stmtDelAval->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);

        // 3. Apaga os favoritos que possuem o mesmo título (funciona para dados velhos e novos)
        $stmtDelFav = $conn->prepare("DELETE FROM favoritos WHERE titulo = :titulo AND usuario_id = :usuario_id AND tipo = 'Filme'");
        $stmtDelFav->execute([
            ':titulo' => $titulo_filme,
            ':usuario_id' => $usuario_id
        ]);

        // 4. Por fim, apaga o filme da tabela principal
        $stmt = $conn->prepare("DELETE FROM filmes WHERE id = :id AND usuario_id = :usuario_id");
        $stmt->execute([
            ':id' => $id,
            ':usuario_id' => $usuario_id
        ]);

        $_SESSION['mensagem'] = "Filme e suas dependências deletados com sucesso!";
    }

    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Filmes</title>
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
        <li><a href="read.php" class="aba-item ativa">Filmes</a></li>
        <li><a href="../series/read.php" class="aba-item">Séries</a></li>
        <li><a href="../favoritos/read.php" class="aba-item">Favoritos</a></li>
        <li><a href="../avaliacoes/read.php" class="aba-item">Avaliações</a></li>
        <li><a href="../logout.php" class="aba-item">Sair</a></li>
    </ul>
</nav>

<div class="catalog-container">
    <div class="catalog-header">
        <h1>Filmes Disponiveis</h1>
        <div class="header-actions">
            <a href="create.php" class="btn-novo">Add Novo Filme</a>
        </div>
    </div>

    <div class="movies-grid">

        <?php
        // MODIFICADO AQUI: Adicionado o ORDER BY id DESC para listar do mais atualizado para baixo
        $stmt = $conn->prepare("SELECT * FROM filmes WHERE usuario_id = :usuario_id ORDER BY id DESC");
        $stmt->execute([':usuario_id' => $usuario_id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favoritado = false;

            if (!empty($row['titulo'])) {
                $stmtFav = $conn->prepare("
                    SELECT COUNT(*) 
                    FROM favoritos 
                    WHERE titulo = :titulo 
                    AND tipo = 'Filme' 
                    AND usuario_id = :usuario_id
                    AND titulo IS NOT NULL
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
                <img src="../uploads/<?php echo $row['imagem']; ?>" alt="Poster">
            </div>

            <div class="movie-info">

                <h3>
                    <?php echo htmlspecialchars($row['titulo'] ?? ''); ?>
                    <a href="../favoritos/adicionar.php?titulo=<?php echo urlencode($row['titulo'] ?? ''); ?>&tipo=Filme&genero=<?php echo urlencode($row['genero'] ?? ''); ?>" class="<?= $favoritado ? 'favorito' : '' ?>">★</a>
                </h3>

                <?php if (!empty($row['genero'])) { ?>
                    <p><b>Gênero:</b> <?php echo htmlspecialchars($row['genero']); ?></p>
                <?php } ?>

                <p><?php echo htmlspecialchars($row['descricao'] ?? ''); ?></p>

                <div class="movie-actions">

                    <form action="update.php" method="POST" style="display:inline;">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" class="btn-editar">Editar</button>
                    </form>

                    <form method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');" style="display:inline;">
                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn-deletar-lista">Excluir</button>
                    </form>

                    <form action="../avaliacoes/create.php" method="POST" style="display:inline;">
                        <input type="hidden" name="filme_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn-novo">Avaliar</button>
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