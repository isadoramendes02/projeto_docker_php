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