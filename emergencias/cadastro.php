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
    $segmento = filter_input(INPUT_POST, 'segmento', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // Verifica se o campo obrigatório foi preenchido
    if (empty($nome)) {
        $erro = "O nome da emergência é obrigatório.";
    } else {
        // Prepara a consulta SQL para evitar SQL injection
        $sql = "INSERT INTO emergencias (nome, segmento, telefone) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Vincula os parâmetros à declaração preparada
        $stmt->bind_param("sss", $nome, $segmento, $telefone);

        // Executa a consulta
        if ($stmt->execute()) {
            $mensagem = "Emergência cadastrada com sucesso!";
        } else {
            $erro = "Erro ao cadastrar a emergência: " . $stmt->error;
        }

        // Fecha a declaração
        $stmt->close();
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Emergência</title>
</head>
<body>
    <h2>Cadastrar Nova Emergência</h2>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <?php if (isset($mensagem)): ?>
        <p style="color: green;"><?php echo $mensagem; ?></p>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="segmento">Segmento:</label><br>
        <input type="text" id="segmento" name="segmento"><br><br>

        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone"><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>