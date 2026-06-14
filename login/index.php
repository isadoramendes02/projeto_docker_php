<?php 

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
    <title>FlixHub</title>

    <link rel="stylesheet" href="../css/stylecrud.css">
</head>

<body class="home">
    <nav class="navbar">
    <div class="logo">FlixHub</div>
    <div class="nav-actions">
        <a href="login.php" class="btn-entrar">Entrar</a>
    </div>
</nav>

<div id="fundo-dinamico"></div>

<div class="home-box">

    <h1>Bem-vindo ao FlixHub</h1>

    <p>
        Avalie filmes e séries em uma plataforma moderna.
    </p>

    <div class="buttons">

        <div class="btn-box">
            <a href="login.php" class="home-btn">
                Login
            </a>

            <span>
                Acessar conta
            </span>
        </div>

        <div class="btn-box">
            <a href="cadastro.php" class="home-btn">
                Cadastro
            </a>

            <span>
                Criar conta
            </span>
        </div>

    </div>
</div>

<script>
        const fundos = <?php echo json_encode($fundos); ?>;
        let i = 0;

        if (fundos.length > 0) {
            const elFundo = document.getElementById('fundo-dinamico');
            if (elFundo) {
                elFundo.style.backgroundImage = `url('${fundos[i]}')`;
                setInterval(() => {
                    i = (i + 1) % fundos.length;
                    elFundo.style.backgroundImage = `url('${fundos[i]}')`;
                }, 5000);
            }
        }
    </script>

</body>
</html>