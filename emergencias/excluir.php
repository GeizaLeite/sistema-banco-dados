<?php
include '../conexao.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM emergencias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Emergência excluída com sucesso!";
        // Redirecionar para a página de listagem (opcional, mas recomendado)
        // header("Location: listar.php");
        // exit();
    } else {
        echo "Erro ao excluir a emergência: " . $conn->error;
    }
} else {
    echo "ID da emergência não fornecido.";
}
?>