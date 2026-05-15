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


<?php

$fundos = [
    "img/img1.png",
    "img/img2.png",
    "img/img3.png",
    "img/img4.png"
];

$fundo = $fundos[array_rand($fundos)];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url('<?php echo $fundo; ?>');">

<div class="container">

<img src="img/logo.png" class="logo">

<div class="login-box">



<h2>Login</h2>

<p><?php echo $msg; ?></p>

<form method="POST">

    <input type="email" name="email" placeholder="Email">

    <input type="password" name="senha" placeholder="Senha">

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

</body>
</html>