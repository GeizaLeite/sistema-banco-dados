<!DOCTYPE html>
<html>

<head>
    <title>Listar Usuários</title>
</head>

<body>
    <h2>Lista de Usuários</h2>
    <ul id="lista-usuarios">
        <?php
        include '../conexao.php';

        $sql = "SELECT * FROM usuarios";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["nome"] . " - " . $row["email"] . " (" . $row["tipo"] . ")</li>";
            }
        } else {
            echo "<li>Nenhum usuário cadastrado.</li>";
        }

        $conn->close();
        ?>
    </ul>
</body>

</html>