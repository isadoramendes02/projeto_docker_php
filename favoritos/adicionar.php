<?php

session_start();
include '../conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login/login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$titulo = $_GET['titulo'] ?? '';
$tipo = $_GET['tipo'] ?? '';

if ($tipo == 'Filme') {
    $stmt = $conn->prepare("
        SELECT *
        FROM filmes
        WHERE titulo = :titulo
    ");
    $stmt->execute([':titulo' => $titulo]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $stmt = $conn->prepare("
        SELECT *
        FROM series
        WHERE titulo = :titulo
    ");
    $stmt->execute([':titulo' => $titulo]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$item) {
    die("Item não encontrado.");
}

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

    // ADICIONADO: Mensagem de sucesso ao favoritar
    if ($tipo == 'Filme') {
        $_SESSION['mensagem'] = "Filme favoritado com sucesso!";
    } else {
        $_SESSION['mensagem'] = "Série favoritada com sucesso!";
    }
} else {
    // ADICIONADO: Se já existia, agora remove (desfavorita) e avisa o usuário
    $stmtDelete = $conn->prepare("
        DELETE FROM favoritos 
        WHERE titulo = :titulo 
        AND usuario_id = :usuario_id 
        AND tipo = :tipo
    ");
    $stmtDelete->execute([
        ':titulo' => $item['titulo'],
        ':usuario_id' => $usuario_id,
        ':tipo' => $tipo
    ]);

    if ($tipo == 'Filme') {
        $_SESSION['mensagem'] = "Filme removido dos favoritos!";
    } else {
        $_SESSION['mensagem'] = "Série removida dos favoritos!";
    }
}

if ($tipo == 'Filme') {
    header("Location: ../filmes/read.php");
} else {
    header("Location: ../series/read.php");
}

exit;