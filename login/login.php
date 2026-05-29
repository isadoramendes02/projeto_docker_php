<?php

// Inicia sessão do usuário
session_start();

// Conexão com o banco de dados
include '../conexao.php';

// Mensagem do sistema
$msg = "";

// Verifica envio do formulário
if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca usuário pelo email
    $sql = $conn->prepare("
        SELECT *
        FROM usuarios
        WHERE email = :email
    ");

    $sql->bindValue(":email", $email);
    $sql->execute();

    if ($sql->rowCount() > 0) {

        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senha, $usuario['senha'])) {

            // SALVA O ID DO USUÁRIO
            $_SESSION['usuario_id'] = $usuario['id'];

            // DADOS DO USUÁRIO
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];

            header("Location: ../principal.php");
            exit;

        } else {

            $msg = "Senha incorreta!";

        }

    } else {

        $msg = "Usuário não encontrado!";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FlixHub</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div id="bg"></div>

<div class="container">

    <div class="login-box">

        <h2>Login</h2>

        <p class="msg">
            <?php echo $msg; ?>
        </p>

        <form method="POST">

            <input
                type="email"
                name="email"
                placeholder="Email"
                required
            >

            <input
                type="password"
                name="senha"
                placeholder="Senha"
                required
            >

            <button type="submit" name="login">
                Entrar
            </button>

        </form>

        <br>

        <a href="cadastro.php">
            Ir para cadastro
        </a>

    </div>

</div>

<script>

const fundos = [
    "img/img1.1.png",
    "img/img1.2.png",
    "img/img1.3.png",
    "img/img1.4.png",
    "img/img1.5.png",
    "img/img1.6.png",
    "img/img1.7.png",
    "img/img1.8.png",
    "img/img1.9.png"
];

let index = 0;

const bg = document.getElementById("bg");

function trocarFundo() {

    bg.style.backgroundImage = `url('${fundos[index]}')`;

    index = (index + 1) % fundos.length;
}

trocarFundo();

setInterval(trocarFundo, 5000);

</script>

</body>
</html>