<!DOCTYPE html>
<html>

<head>
    <title>Editar Hospedagem</title>
</head>

<body>

    <?php
    include '../conexao.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM hospedagens WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $hospedagem = $result->fetch_assoc();
            ?>

            <h2>Editar Hospedagem</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="id" value="<?php echo $hospedagem['id']; ?>">

                <label for="nome">Nome:</label><br>
                <input type="text" id="nome" name="nome" value="<?php echo $hospedagem['nome']; ?>" required><br>

                <label for="endereco">Endereço:</label><br>
                <input type="text" id="endereco" name="endereco" value="<?php echo $hospedagem['endereco']; ?>"><br>

                <label for="telefone">Telefone:</label><br>
                <input type="text" id="telefone" name="telefone" value="<?php echo $hospedagem['telefone']; ?>"><br>

                <label for="capacidade">Capacidade:</label><br>
                <input type="number" id="capacidade" name="capacidade" value="<?php echo $hospedagem['capacidade']; ?>"><br><br>

                <input type="submit" value="Atualizar">
            </form>

            <?php
        } else {
            echo "<p>Hospedagem não encontrada.</p>";
        }
        $stmt->close();
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $nome = $_POST["nome"];
        $endereco = $_POST["endereco"];
        $telefone = $_POST["telefone"];
        $capacidade = $_POST["capacidade"];

        $sql = "UPDATE hospedagens SET nome=?, endereco=?, telefone=?, capacidade=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $nome, $endereco, $telefone, $capacidade, $id);

        if ($stmt->execute()) {
            echo "<p>Hospedagem atualizada com sucesso!</p>";
        } else {
            echo "<p>Erro ao atualizar: " . $conn->error . "</p>";
        }
        $stmt->close();
    }

    $conn->close();
    ?>

</body>

</html>