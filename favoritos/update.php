<?php
session_start();
include '../conexao.php';

// Captura o ID do favorito de forma segura
$id = $_GET['id'] ?? $_POST['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Agora capturamos APENAS a observação vinda do formulário
    $observacao = $_POST['observacao'];

    // O SQL foi modificado para alterar SOMENTE a observação baseada no ID
    $sql = "UPDATE favoritos 
            SET observacao=:observacao 
            WHERE id=:id";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':observacao' => $observacao,
        ':id'         => $id
    ]);

    header("Location: read.php");
    exit;
}

// Busca os dados do favorito para mostrar na tela
$stmt = $conn->prepare("SELECT * FROM favoritos WHERE id=:id");
$stmt->execute([':id' => $id]);
$favorito = $stmt->fetch(PDO::FETCH_ASSOC);

// Se não achar o favorito, volta para a listagem por segurança
if (!$favorito) {
    header("Location: read.php");
    exit;
}

$fundos = [
    "../img/img2.jpg", "../img/img3.jpg", "../img/img4.jpg", "../img/img5.jpg",
    "../img/img6.jpg", "../img/img7.jpg", "../img/img8.jpg", "../img/img9.jpg",
    "../img/img10.jpg", "../img/img11.jpg", "../img/img12.jpg", "../img/img13.jpg",
    "../img/img14.jpg", "../img/img15.jpg", "../img/img16.jpg", "../img/img17.jpg",
];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Observação</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="create-body">

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

    <div class="create-container">
        <form method="POST" class="create-form">

            <h1>Editar Observação</h1>

            <input type="hidden" name="id" value="<?= $favorito['id'] ?>">

            <label>Título</label>
            <input type="text" value="<?= htmlspecialchars($favorito['titulo']) ?>" disabled style="background-color: rgba(255,255,255,0.08); color: #999; cursor: not-allowed;">

            <label>Tipo</label>
            <input type="text" value="<?= htmlspecialchars($favorito['tipo']) ?>" disabled style="background-color: rgba(255,255,255,0.08); color: #999; cursor: not-allowed;">

            <label>Sua Observação / Comentário</label>
            <textarea name="observacao" placeholder="Escreva um comentário sobre este título..."><?= htmlspecialchars($favorito['observacao']) ?></textarea>

            <button type="submit" class="btn-atualizar">Salvar Alterações</button>

            <a href="read.php" class="voltar">← Cancelar</a>

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