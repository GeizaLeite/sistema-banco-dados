<!DOCTYPE html>
<html>

<head>
    <title>Editar Usuário</title>
</head>

<body>

    <?php
    include '../conexao.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            ?>

            <h2>Editar Usuário</h2>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

                <label for="nome">Nome:</label><br>
                <input type="text" id="nome" name="nome" value="<?php echo $usuario['nome']; ?>" required><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>

                <label for="tipo">Tipo:</label><br>
                <select id="tipo" name="tipo">
                    <option value="admin" <?php if ($usuario['tipo'] == 'admin') echo 'selected'; ?>>Administrador</option>
                    <option value="comum" <?php if ($usuario['tipo'] == 'comum') echo 'selected'; ?>>Comum</option>
                </select><br><br>

                <input type="submit" value="Atualizar">
            </form>

            <?php
        } else {
            echo "<p>Usuário não encontrado.</p>";
        }
        $stmt->close();
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $tipo = $_POST["tipo"];

        $sql = "UPDATE usuarios SET nome=?, email=?, tipo=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nome, $email, $tipo, $id);

        if ($stmt->execute()) {
            echo "<p>Usuário atualizado com sucesso!</p>";
        } else {
            echo "<p>Erro ao atualizar: " . $conn->error . "</p>";
        }
        $stmt->close();
    }

    $conn->close();
    ?>

</body>

</html>