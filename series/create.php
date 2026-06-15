<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../conexao.php';

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['titulo'])) {

    $titulo = $_POST['titulo'];

    $genero = $_POST['genero'] ?? '';

    $descricao = $_POST['descricao'];
    $imagem = $_FILES['imagem']['name'] ?? '';


    $verifica = $conn->prepare("
        SELECT COUNT(*)
        FROM series
        WHERE titulo = :titulo
        AND usuario_id = :usuario_id
    ");

    $verifica->execute([
        ':titulo' => $titulo,
        ':usuario_id' => $usuario_id
    ]);

    if ($verifica->fetchColumn() > 0) {
        $_SESSION['mensagem'] = "Esta série já existe!";
        header("Location: read.php");
        exit();
    }

    if ($imagem) {
        move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $imagem);
    }

    $sql = "
        INSERT INTO series (usuario_id, titulo, genero, descricao, imagem)
        VALUES (:usuario_id, :titulo, :genero, :descricao, :imagem)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo'     => $titulo,
        ':genero'     => $genero,
        ':descricao'  => $descricao,
        ':imagem'     => $imagem
    ]);

    $_SESSION['mensagem'] = "Série adicionada com sucesso!";

    header("Location: read.php");
    exit();
}
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
    <title>Nova Série</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>

<body>

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

<div class="create-container">

    <form method="POST" enctype="multipart/form-data" class="create-form">

        <h1>Nova Série</h1>

        <label>Título</label>
        <input type="text" name="titulo" required>

        <label for="genero">Gênero</label>
        <select id="genero" name="genero" required>
            <option value="" disabled selected>Selecione o Gênero</option>
            <option value="Ação">Ação</option>
            <option value="Aventura">Aventura</option>
            <option value="Animação">Animação</option>
            <option value="Comédia">Comédia</option>
            <option value="Drama">Drama</option>
            <option value="Ficção Científica">Ficção Científica</option>
            <option value="Terror">Terror</option>
            <option value="Suspense">Suspense</option>
            <option value="Romance">Romance</option>
            <option value="Fantasia">Fantasia</option>
        </select>

        <label>Descrição</label>
        <textarea name="descricao" required></textarea>

        <label>Imagem</label>

        <input type="file" name="imagem" id="imagem" required class="file-input">

        <label for="imagem" class="file-button">Escolher arquivo</label>

        <button type="submit">Salvar</button>

        <a href="read.php" class="voltar">← Voltar</a>

    </form>

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