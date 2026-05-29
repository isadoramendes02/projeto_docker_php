<?php

session_start();
include '../conexao.php';

$usuario_id = $_SESSION['usuario_id'];

$titulo = $_GET['titulo'];
$tipo = $_GET['tipo'];

if ($tipo == 'Filme') {

    $stmt = $conn->prepare("
        SELECT *
        FROM filmes
        WHERE titulo = :titulo
    ");

    $stmt->execute([
        ':titulo' => $titulo
    ]);

    $item = $stmt->fetch(PDO::FETCH_ASSOC);

} else {

    $stmt = $conn->prepare("
        SELECT *
        FROM series
        WHERE titulo = :titulo
    ");

    $stmt->execute([
        ':titulo' => $titulo
    ]);

    $item = $stmt->fetch(PDO::FETCH_ASSOC);

}

if (!$item) {
    die("Item não encontrado.");
}

/* evita favoritos duplicados */
$stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM favoritos
    WHERE titulo = :titulo
    AND usuario_id = :usuario_id
");

$stmt->execute([
    ':titulo' => $item['titulo'],
    ':usuario_id' => $usuario_id
]);

$jaExiste = $stmt->fetchColumn();

if ($jaExiste == 0) {

    $sql = "
        INSERT INTO favoritos (
            usuario_id,
            titulo,
            tipo,
            imagem
        )
        VALUES (
            :usuario_id,
            :titulo,
            :tipo,
            :imagem
        )
    ";

    $stmt = $conn->prepare($sql);

    $stmt->execute([
        ':usuario_id' => $usuario_id,
        ':titulo' => $item['titulo'],
        ':tipo' => $tipo,
        ':imagem' => $item['imagem']
    ]);
}

if ($tipo == 'Filme') {
    header("Location: ../filmes/read.php");
} else {
    header("Location: ../series/read.php");
}

exit;