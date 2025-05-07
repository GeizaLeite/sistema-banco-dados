<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Buscar os dados da atração no banco de dados
    $sql = "SELECT id, nome, descricao, localizacao, horario_funcionamento FROM atracoes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $atracao = $result->fetch_assoc();
    } else {
        echo "Atração não encontrada!";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $descricao = mysqli_real_escape_string($conn, $_POST["descricao"]);
    $localizacao = mysqli_real_escape_string($conn, $_POST["localizacao"]);
    $horario_funcionamento = mysqli_real_escape_string($conn, $_POST["horario_funcionamento"]);

    // Atualizar os dados da atração no banco de dados
    $sql = "UPDATE atracoes SET nome = ?, descricao = ?, localizacao = ?, horario_funcionamento = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $descricao, $localizacao, $horario_funcionamento, $id);

    if ($stmt->execute()) {
        echo "Atração atualizada com sucesso!";
        // Redirecionar para a página de listagem ou exibir uma mensagem de sucesso
    } else {
        echo "Erro ao atualizar a atração: " . $conn->error;
    }
} else {
    echo "Requisição inválida.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editar Atração</title>
</head>

<body>
    <h2>Editar Atração</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $atracao['id']; ?>">

        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" value="<?php echo $atracao['nome']; ?>" required><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" rows="4" cols="50"><?php echo $atracao['descricao']; ?></textarea><br>

        <label for="localizacao">Localização:</label><br>
        <input type="text" id="localizacao" name="localizacao" value="<?php echo $atracao['localizacao']; ?>"><br>

        <label for="horario_funcionamento">Horário de Funcionamento:</label><br>
        <input type="text" id="horario_funcionamento" name="horario_funcionamento"
            value="<?php echo $atracao['horario_funcionamento']; ?>"><br><br>

        <input type="submit" value="Atualizar">
    </form>
</body>

</html>