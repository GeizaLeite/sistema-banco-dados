<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT id, nome, segmento, telefone FROM emergencias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $emergencia = $result->fetch_assoc();
    } else {
        echo "Emergência não encontrada!";
        exit;
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST["nome"];
    $segmento = $_POST["segmento"];
    $telefone = $_POST["telefone"];

    $sql = "UPDATE emergencias SET nome = ?, segmento = ?, telefone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $segmento, $telefone, $id);

    if ($stmt->execute()) {
        echo "Emergência atualizada com sucesso!";
        // Redirecionar para a página de listagem ou exibir uma mensagem de sucesso
    } else {
        echo "Erro ao atualizar a emergência: " . $conn->error;
    }
} else {
    echo "Requisição inválida.";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Emergência</title>
</head>
<body>
    <h2>Editar Emergência</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $emergencia['id']; ?>">

        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" value="<?php echo $emergencia['nome']; ?>" required><br>

        <label for="segmento">Segmento:</label><br>
        <input type="text" id="segmento" name="segmento" value="<?php echo $emergencia['segmento']; ?>"><br>

        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone" value="<?php echo $emergencia['telefone']; ?>"><br><br>

        <input type="submit" value="Atualizar">
    </form>
</body>
</html>