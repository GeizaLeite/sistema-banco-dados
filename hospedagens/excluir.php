<?php
include '../conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM hospedagens WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<p>Hospedagem excluída com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir: " . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>ID da hospedagem não fornecido.</p>";
}

$conn->close();
?>