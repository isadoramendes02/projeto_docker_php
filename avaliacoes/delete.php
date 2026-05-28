<?php
include '../conexao.php';

if (!isset($_GET['id'])) {
    header("Location: read.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM avaliacoes WHERE id = :id");
$stmt->execute([':id' => $id]);

header("Location: read.php");
exit;