<?php

session_start();

// Conexão com o banco
include '../conexao.php';

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $usuario_id = $_SESSION['usuario_id'];

    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];

    // Upload da imagem
    $imagem = $_FILES['imagem']['name'];
    move_uploaded_file($_FILES['imagem']['tmp_name'], "../uploads/" . $imagem);

    // Inserção no banco
    $sql = "
        INSERT INTO filmes (
            usuario_id,
            titulo,
            descricao,
            imagem
        )
        VALUES (
            :usuario_id,
            :titulo,
            :descricao,
            :imagem
        )
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => $titulo,
        ':descricao' => $descricao,
        ':imagem' => $imagem
    ]);

    header("Location: read.php");
    exit();
}

// Lista de fundos
$fundos = [
    "../login/img/img1.1.png",
    "../login/img/img1.2.png",
    "../login/img/img1.3.png",
    "../login/img/img1.4.png",
    "../login/img/img1.5.png",
    "../login/img/img1.6.png",
    "../login/img/img1.7.png",
    "../login/img/img1.8.png",
    "../login/img/img1.9.png"
];

?>

<link rel="stylesheet" href="../css/index.css">

<div class="create-container">

    <form method="POST" enctype="multipart/form-data" class="create-form">

        <h1>Adicionar</h1>

        <label>Título</label>
        <input type="text" name="titulo" required>

        <label>Descrição</label>
        <textarea name="descricao" required></textarea>

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

document.body.style.backgroundImage = `url('${fundos[i]}')`;

setInterval(() => {
    i = (i + 1) % fundos.length;
    document.body.style.backgroundImage = `url('${fundos[i]}')`;
}, 5000);
</script>