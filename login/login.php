<?php
session_start();

include '../conexao.php';

$msg = "";

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

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
        
            $_SESSION['usuario_id'] = $usuario['id'];

        
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
    <title>Login - FlixHub</title>
    <link rel="stylesheet" href="../css/stylecrud.css">
</head>
<body class="login-body">

    <div class="container">
        <div class="login-box">

            <h1>Login</h1>

            <?php if (!empty($msg)): ?>
                <p class="msg"><?php echo $msg; ?></p>
            <?php endif; ?>

            <form method="POST">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit" name="login">Entrar</button>
            </form>

            <a href="cadastro.php">Não tem uma conta? Cadastre-se</a>

        </div>
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