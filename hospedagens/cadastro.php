<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = mysqli_real_escape_string($conn, $_POST["nome"]);
    $endereco = mysqli_real_escape_string($conn, $_POST["endereco"]);
    $telefone = mysqli_real_escape_string($conn, $_POST["telefone"]);
    $capacidade = mysqli_real_escape_string($conn, $_POST["capacidade"]);

    $sql = "INSERT INTO hospedagens (nome, endereco, telefone, capacidade) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $endereco, $telefone, $capacidade);

    if ($stmt->execute()) {
        echo "<p>Hospedagem cadastrada com sucesso!</p>";
    } else {
        echo "<p>Erro ao cadastrar hospedagem: " . $conn->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Hospedagem</title>
</head>
<body>
    <h2>Cadastrar Nova Hospedagem</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br>

        <label for="endereco">Endereço:</label><br>
        <input type="text" id="endereco" name="endereco" required><br>

        <label for="telefone">Telefone:</label><br>
        <input type="text" id="telefone" name="telefone"><br>

        <label for="capacidade">Capacidade:</label><br>
        <input type="number" id="capacidade" name="capacidade"><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>
</html>