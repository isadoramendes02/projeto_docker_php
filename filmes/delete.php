<?php
include '../conexao.php';

$id = $_GET['id'];

$sql = "DELETE FROM filmes WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $id]);

header("Location: read.php");
?>