<?php
// Ativa a exibição de erros para ajudar na depuração
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o arquivo de conexão com o banco de dados
require_once '../conexao.php';

// Verifica se o formulário foi submetido usando o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Filtra e sanitiza os dados do formulário para segurança
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = $_POST['senha']; // Não sanitizar a senha diretamente
    $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $erro = null;
    $mensagem = null;

    // Validações básicas
    if (empty($nome)) {
        $erro = "O nome é obrigatório.";
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "O email é inválido.";
    } elseif (empty($senha)) {
        $erro = "A senha é obrigatória.";
    }

    // Se não houver erros de validação
    if (!$erro) {
        // Verifica se o email já existe no banco de dados
        $stmt_check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $erro = "Este email já está cadastrado.";
        } else {
            // Criptografa a senha antes de armazenar no banco de dados
            $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

            // Prepara a consulta SQL para evitar SQL injection
            $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($sql);
            $stmt_insert->bind_param("ssss", $nome, $email, $senha_criptografada, $tipo);

            // Executa a consulta de inserção
            if ($stmt_insert->execute()) {
                $mensagem = "Usuário cadastrado com sucesso!";
            } else {
                $erro = "Erro ao cadastrar o usuário: " . $stmt_insert->error;
            }

            // Fecha a declaração de inserção
            $stmt_insert->close();
        }

        // Fecha a declaração de verificação de email
        $stmt_check->close();
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h2>Cadastro de Usuário</h2>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <?php if (isset($mensagem)): ?>
        <p style="color: green;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="tipo">Tipo (opcional):</label><br>
        <input type="text" id="tipo" name="tipo"><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>