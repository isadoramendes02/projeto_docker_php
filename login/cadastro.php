<?php 

// Inicia a sessão
session_start();

// Conexão com o banco
include '../conexao.php';

// Mensagem do sistema
$msg = "";

// Cadastro
if(isset($_POST['cadastrar'])){

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
    $sql->bindValue(":email", $email);
    $sql->execute();

    if($sql->rowCount() > 0){

        $msg = "Email já cadastrado!";

    } else {

        $insert = $conn->prepare("
            INSERT INTO usuarios(nome, email, senha)
            VALUES(:nome, :email, :senha)
        ");

        $insert->bindValue(":nome", $nome);
        $insert->bindValue(":email", $email);
        $insert->bindValue(":senha", $senha);

        if($insert->execute()){

            header("Location: login.php");
            exit;

        } else {

            $msg = "Erro ao cadastrar!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - FlixHub</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- FUNDO DINÂMICO -->
<div id="bg"></div>

<!-- CONTEÚDO -->
<div class="login-box">

    <h2>Cadastro</h2>

    <p style="color:red;">
        <?php echo $msg; ?>
    </p>

    <form method="POST">

        <input type="text" name="nome" placeholder="Nome" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="senha" placeholder="Senha" required>

        <button type="submit" name="cadastrar">
            Cadastrar
        </button>

    </form>

    <br>

    <a href="login.php">
        Ir para login
    </a>

</div>

<!-- SCRIPT DO FUNDO AUTOMÁTICO -->
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