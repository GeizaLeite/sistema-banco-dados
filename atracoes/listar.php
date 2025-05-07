<!DOCTYPE html>
<html>
<head>
    <title>Listar Atrações</title>
</head>
<body>
    <h2>Lista de Atrações</h2>
   <table id="tabela-atracoes">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Localização</th>
            <th>Horário de Funcionamento</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include '../conexao.php';
        $sql = "SELECT * FROM atracoes";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["nome"] . "</td>";
                echo "<td>" . $row["descricao"] . "</td>";
                echo "<td>" . $row["localizacao"] . "</td>";
                echo "<td>" . $row["horario_funcionamento"] . "</td>";
                echo "<td>";
                echo "<a href='editar.php?id=" . $row["id"] . "'>Editar</a> | ";
                echo "<a href='excluir.php?id=" . $row["id"] . "' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhuma atração cadastrada.</td></tr>";
        }

        $conn->close();
        ?>
    </tbody>
</table>
    </ul>
</body>
</html>