<?php
include '../conexao.php';

$id = $_GET['id'] ?? $_POST['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $genero = $_POST['genero']; // <-- NOVO: CAPTURA O GÊNERO ATUALIZADO
    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem']['name'];

    if ($imagem) {
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $imagem);

        // Adicionado ":genero" na Query com imagem
        $sql = "UPDATE filmes SET titulo=:titulo, genero=:genero, descricao=:descricao, imagem=:imagem WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':genero' => $genero, // <-- NOVO: SALVA NO BANCO
            ':descricao' => $descricao,
            ':imagem' => $imagem,
            ':id' => $id
        ]);
    } else {
        // Adicionado ":genero" na Query sem alteração de imagem
        $sql = "UPDATE filmes SET titulo=:titulo, genero=:genero, descricao=:descricao WHERE id=:id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':titulo' => $titulo,
            ':genero' => $genero, // <-- NOVO: SALVA NO BANCO
            ':descricao' => $descricao,
            ':id' => $id
        ]);
    }

    header("Location: read.php");
    exit;
}

// carregar dados
$stmt = $conn->prepare("SELECT * FROM filmes WHERE id = :id");
$stmt->execute([':id' => $id]);
$filme = $stmt->fetch(PDO::FETCH_ASSOC);


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
    <title>Editar Filme</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="update-body">

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

    <div class="create-container"> 
        <form method="POST" enctype="multipart/form-data" class="create-form">
            
            <h1>Editar Filme</h1>

            <input type="hidden" name="id" value="<?= $filme['id'] ?>">

            <label>Título</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($filme['titulo']) ?>" required>

            <label for="genero">Gênero</label>
            <select id="genero" name="genero" required>
                <option value="" disabled>Selecione o Gênero</option>
                <option value="Ação" <?= $filme['genero'] == 'Ação' ? 'selected' : '' ?>>Ação</option>
                <option value="Aventura" <?= $filme['genero'] == 'Aventura' ? 'selected' : '' ?>>Aventura</option>
                <option value="Animação" <?= $filme['genero'] == 'Animação' ? 'selected' : '' ?>>Animação</option>
                <option value="Comédia" <?= $filme['genero'] == 'Comédia' ? 'selected' : '' ?>>Comédia</option>
                <option value="Drama" <?= $filme['genero'] == 'Drama' ? 'selected' : '' ?>>Drama</option>
                <option value="Ficção Científica" <?= $filme['genero'] == 'Ficção Científica' ? 'selected' : '' ?>>Ficção Científica</option>
                <option value="Terror" <?= $filme['genero'] == 'Terror' ? 'selected' : '' ?>>Terror</option>
                <option value="Suspense" <?= $filme['genero'] == 'Suspense' ? 'selected' : '' ?>>Suspense</option>
                <option value="Romance" <?= $filme['genero'] == 'Romance' ? 'selected' : '' ?>>Romance</option>
                <option value="Fantasia" <?= $filme['genero'] == 'Fantasia' ? 'selected' : '' ?>>Fantasia</option>
            </select>

            <label>Descrição</label>
            <textarea name="descricao" required><?= htmlspecialchars($filme['descricao']) ?></textarea>

            <label>Imagem Atual</label>
            <div class="current-image-container">
                <img src="../uploads/<?= $filme['imagem'] ?>" class="update-preview-img">
            </div>

            <label>Nova Imagem (Opcional)</label> 
            <input type="file" name="imagem" id="imagem" style="display: none;">
            <label for="imagem" class="file-button">Escolher arquivo</label>

            <button type="submit" class="btn-atualizar">Salvar Alterações</button>

            <a href="read.php" class="voltar">← Cancelar</a>
            
        </form>
    </div>

</body>
</html>

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