<?php 

$host = "localhost";
$banco = "sistema";
$usuario = "root";
$senha = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$banco;charset=utf8",
    $usuario,
    $senha
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $erro) {

    echo "Erro na conexão: " . $erro->getMessage();
}

?>