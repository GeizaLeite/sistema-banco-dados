<?php
include '../conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<p>Usuário excluído com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir: " . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>ID do usuário não fornecido.</p>";
}

$conn->close();
?>