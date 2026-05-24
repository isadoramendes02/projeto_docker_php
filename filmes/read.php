<?php include '../conexao.php'; ?>

<h1>Lista de Filmes</h1>

<a href="create.php">Novo Filme</a><br><br>

<?php
$sql = "SELECT * FROM filmes";
$result = $conn->query($sql);

while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    echo "<h3>{$row['titulo']}</h3>";
    echo "<p>{$row['descricao']}</p>";
    echo "<img src='../uploads/{$row['imagem']}' width='100'><br>";

    echo "<a href='update.php?id={$row['id']}'>Editar</a> | ";
    echo "<a href='delete.php?id={$row['id']}'>Excluir</a><hr>";
}
?>