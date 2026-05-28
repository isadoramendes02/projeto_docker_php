<?php
include '../conexao.php';

$id = $_GET['id'];

$stmt = $conn->prepare(
    "DELETE FROM favoritos WHERE id = :id"
);

$stmt->execute([
    ':id' => $id
]);

header("Location: read.php");
exit;