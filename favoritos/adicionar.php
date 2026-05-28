<?php

include '../conexao.php';

$titulo = $_GET['titulo'];

$stmt = $conn->prepare("
    SELECT *
    FROM filmes
    WHERE titulo = :titulo
");

$stmt->execute([
    ':titulo' => $titulo
]);

$filme = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "INSERT INTO favoritos (titulo, tipo, imagem)
        VALUES (:titulo, 'Filme', :imagem)";

$stmt = $conn->prepare($sql);

$stmt->execute([
    ':titulo' => $filme['titulo'],
    ':imagem' => $filme['imagem']
]);

header("Location: ../filmes/read.php");
exit;