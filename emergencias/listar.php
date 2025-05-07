<!DOCTYPE html>
<html>
<head>
    <title>Listar Emergências</title>
</head>
<body>
    <h2>Lista de Emergências</h2>

    <?php
    include '../conexao.php';

    $sql = "SELECT id, nome, segmento, telefone FROM emergencias";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nome</th><th>Segmento</th><th>Telefone</th><th>Ações</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['segmento'] . "</td>";
            echo "<td>" . $row['telefone'] . "</td>";
            echo "<td><a href='editar.php?id=" . $row['id'] . "'>Editar</a> | <a href='excluir.php?id=" . $row['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Nenhuma emergência cadastrada.</p>";
    }

    $conn->close();
    ?>

    <p><a href='cadastro.php'>Cadastrar Nova Emergência</a></p>
</body>
</html>