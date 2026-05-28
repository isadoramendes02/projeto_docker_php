<?php 

// Inicia sessão do usuário
session_start();

// Conexão com o banco de dados
include '../conexao.php';

// Mensagem do sistema (erro ou sucesso)
$msg = "";

// Verifica envio do formulário de login
if (isset($_POST['login'])) {

    // Recebe dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Busca usuário pelo email
    $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $sql->bindValue(":email", $email);
    $sql->execute();

    // Verifica se encontrou usuário
    if ($sql->rowCount() > 0) {

        // Pega dados do usuário
        $usuario = $sql->fetch(PDO::FETCH_ASSOC);

        // Verifica senha
        if (password_verify($senha, $usuario['senha'])) {

            // Salva dados na sessão
            $_SESSION['nome'] = $usuario['nome'];
            $_SESSION['email'] = $usuario['email'];

            // Redireciona para página principal
            header("Location: ../principal.php");
            exit;

        } else {
            // Senha incorreta
            $msg = "Senha incorreta!";
        }

    } else {
        // Usuário não encontrado
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

    <!-- CSS externo -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- Fundo dinâmico -->
<div id="bg"></div>

<!-- Container principal -->
<div class="container">

    <!-- Caixa de login -->
    <div class="login-box">

        <!-- Título -->
        <h2>Login</h2>

        <!-- Mensagem do sistema -->
        <p class="msg">
            <?php echo $msg; ?>
        </p>

        <!-- Formulário de login -->
        <form method="POST">

            <!-- Email -->
            <input type="email" name="email" placeholder="Email" required>

            <!-- Senha -->
            <input type="password" name="senha" placeholder="Senha" required>

            <!-- Botão de envio -->
            <button type="submit" name="login">
                Entrar
            </button>

        </form>

        <!-- Link para cadastro -->
        <br>

        <a href="cadastro.php">
            Ir para cadastro
        </a>

    </div>

</div>

<!-- Script de fundo automático -->
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

// Índice do fundo atual
let index = 0;

// Elemento do fundo
const bg = document.getElementById("bg");

// Função para trocar fundo
function trocarFundo() {
    bg.style.backgroundImage = `url('${fundos[index]}')`;
    index = (index + 1) % fundos.length;
}

// Inicia e repete troca automática
trocarFundo();
setInterval(trocarFundo, 5000);
</script>

</body>
</html>