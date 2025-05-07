<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'conexao.php'; // Supondo que conexao.php está na mesma pasta que login.php

session_start(); // Inicia a sessão (deve ser chamada antes de qualquer saída HTML)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $senha = $_POST["senha"];

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario["senha"])) {
            // Autenticação bem-sucedida!
            // Iniciar sessão, definir cookies, redirecionar para a página principal, etc.
            $_SESSION['usuario_id'] = $usuario['id']; // Define a variável de sessão
            $_SESSION['usuario_nome'] = $usuario['nome']; // Exemplo: Salvar o nome do usuário

            header("Location: pagina_principal.php"); // Redireciona para a página principal
            exit(); // Encerra a execução do script para garantir o redirecionamento
        } else {
            // Senha incorreta
            $erro = "Senha incorreta!";
        }
    } else {
        // Usuário não encontrado
        $erro = "Usuário não encontrado!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <?php if (isset($erro)) { ?>
        <p style="color:red;"><?php echo $erro; ?></p>
    <?php } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>

</html>