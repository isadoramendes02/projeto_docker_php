<?php 

include("conexao.php");

$msg = "";

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

        $insert = $conn->prepare("INSERT INTO usuarios(nome,  email, senha)
        VALUES(:nome, :email, :senha)");

        $insert->bindValue(":nome", $nome);
        $insert->bindValue(":email", $email);
        $insert->bindValue(":senha", $senha);

        if($insert->execute()){

            header("Location:login.php");
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
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>

<div class="login-box">

<h2>Cadastro</h2>

<p><?php echo $msg; ?></p>

<form method="POST">

    <input type="text" name="nome" placeholder="Nome" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" name="senha" placeholder="Senha" required><br><br>

    <button type="submit" name="cadastrar">
        Cadastrar
    </button>

</form>

<br>

<a href="login.php">
    Ir para login
</a>

</div>

</body>
</html>