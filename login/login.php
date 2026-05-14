<?php 

session_start();

include("conexao.php");

$msg = "";

if (isset($_POST['login'])){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");

    $sql->bindValue(":email", $email);
    $sql->execute();

    if ( $sql->rowCount() > 0 ){

        $usuario = $sql->fetch(PDO::FETCH_ASSOC);
    
        if(password_verify($senha, $usuario['senha'])){
            $_SESSION['nome'] = $usuario['nome'];

            header("Location: painel.php");
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
    <title>Login</title>
</head>
<body>
    <p><?php echo $msg; ?></p>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <br><br>

        <input type="password" name="senha" placeholder="Senha" required>

        <br><br>

        <button type="submit" name="login">
            Entrar
        </button>
    </form>

    <br>

    <a href="cadastro.php">
        Ir para cadastro
    </a>

</body>
</html>