<!DOCTYPE html>
<html>

<head>
    <title>Listar Hospedagens</title>
</head>

<body>
    <h2>Lista de Hospedagens</h2>
    <ul id="lista-hospedagens">
        <?php
        include '../conexao.php';

        $sql = "SELECT * FROM hospedagens";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row["nome"] . " - " . $row["endereco"] . "</li>";
            }
        } else {
            echo "<li>Nenhuma hospedagem cadastrada.</li>";
        }

        $conn->close();
        ?>
    </ul>
</body>

</html>