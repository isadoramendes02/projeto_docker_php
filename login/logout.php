<?php 

// Inicia a sessão (necessário para poder encerrá-la)
session_start();

// Destroi todos os dados da sessão (faz logout do usuário)
session_destroy();

// Redireciona o usuário de volta para a tela de login
header("Location: login.php");
exit;

?>