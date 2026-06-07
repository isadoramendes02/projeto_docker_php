<?php
include '../conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $titulo = $_POST['titulo'];
    $tipo = $_POST['tipo'];
    $genero = $_POST['genero']; // <-- CAPTURA O GÊNERO SELECIONADO
    $observacao = $_POST['observacao'];

    // Adicionado 'genero' na estrutura do INSERT
    $sql = "INSERT INTO favoritos
            (titulo, tipo, genero, observacao)
            VALUES
            (:titulo, :tipo, :genero, :observacao)";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':titulo'     => $titulo,
        ':tipo'       => $tipo,
        ':genero'     => $genero, // <-- ENVIA PARA O BANCO DE DADOS
        ':observacao' => $observacao
    ]);

    header("Location: read.php");
    exit;
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

<link rel="stylesheet" href="../css/stylecrud.css">

<nav class="navbar-sistema">
        <div class="navbar-logo">FlixHub</div>

        <ul class="navbar-abas">
            <li><a href="../principal.php" class="aba-item">Início</a></li>
            <li><a href="../filmes/read.php" class="aba-item">Filmes</a></li>
            <li><a href="../series/read.php" class="aba-item ">Séries</a></li>
            <li><a href="../favoritos/read.php" class="aba-item ativa">Favoritos</a></li>
            <li><a href="../avaliacoes/read.php" class="aba-item">Avaliações</a></li>
            <li><a href="../logout.php" class="aba-item">Sair</a></li>
        </ul>
</nav>

<div class="create-container">
    <form method="POST" class="create-form">

        <h1>Novo Favorito</h1>

        <label>Título</label>
        <input type="text" name="titulo" required>

        <label>Tipo</label>
        <select name="tipo" required>
            <option value="Filme">Filme</option>
            <option value="Série">Série</option>
        </select>

        <label>Gênero</label>
        <select name="genero" required>
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

        <label>Observação</label>
        <textarea name="observacao"></textarea>

        <button type="submit">
            Salvar
        </button>

        <a href="read.php" class="voltar">
            ← Voltar
        </a>

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