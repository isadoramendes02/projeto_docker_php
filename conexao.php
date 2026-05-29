<?php

$host = "flixhub_db"; // Ou "db", dependendo do seu docker-compose.yml
$banco = "sistema";
$usuario = "root";
$senha = ""; // Substitua pela senha definida no Docker

try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$banco;charset=utf8",
        $usuario,
        $senha // Removida a vírgula que estava aqui
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão realizada com sucesso!"; 
} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}