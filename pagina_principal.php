<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php"); // Redireciona para a página de login se não estiver logado
    exit();
}

// Se o usuário estiver logado, exibe a página principal
?>

<!DOCTYPE html>
<html>
<head>
    <title>Página Principal</title>
</head>
<body>
    <h2>Bem-vindo, <?php echo $_SESSION['usuario_nome'] ?? 'Visitante'; ?>!</h2>
    <p>Esta é a página principal. Você está logado.</p>
    <a href="logout.php">Sair</a>
</body>
</html>