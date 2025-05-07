<!DOCTYPE html>
<html>
<head>
    <title>Cadastrar Atração</title>
</head>
<body>
    <h2>Cadastrar Nova Atração</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br>

        <label for="descricao">Descrição:</label><br>
        <textarea id="descricao" name="descricao" required></textarea><br>

        <label for="localizacao">Localização:</label><br>
        <input type="text" id="localizacao" name="localizacao"><br>

        <label for="horario_funcionamento">Horário de Funcionamento:</label><br>
        <input type="text" id="horario_funcionamento" name="horario_funcionamento"><br><br>

        <input type="submit" value="Cadastrar">
    </form>

    <?php
    include '../conexao.php'; // Inclui o arquivo de conexão

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $localizacao = $_POST["localizacao"];
        $horario_funcionamento = $_POST["horario_funcionamento"];

        $sql = "INSERT INTO atracoes (nome, descricao, localizacao, horario_funcionamento) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $descricao, $localizacao, $horario_funcionamento);

        if ($stmt->execute()) {
            echo "<p>Atração cadastrada com sucesso!</p>";
        } else {
            echo "<p>Erro ao cadastrar: " . $conn->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>