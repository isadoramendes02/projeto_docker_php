<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario_id = $_SESSION['usuario_id'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    
    $imagem = $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $imagem);

    $sql = "INSERT INTO filmes (usuario_id, titulo, descricao, imagem) VALUES (:usuario_id, :titulo, :descricao, :imagem)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo'     => $titulo,
        ':descricao'  => $descricao,
        ':imagem'     => $imagem
    ]);

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Filme</title>
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

    <div class="create-container">
        <form method="POST" enctype="multipart/form-data" class="create-form">

            <h1>Adicionar</h1>

            <label for="titulo">Título</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descricao">Descrição</label>
            <textarea id="descricao" name="descricao" required></textarea>

            <label>Imagem</label>
            <input type="file" name="imagem" id="imagem" required style="display:none;">
            <label for="imagem" class="file-button">Escolher arquivo</label>

            <button type="submit">Salvar</button>

            <a href="read.php" class="voltar">← Voltar</a>

        </form>
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