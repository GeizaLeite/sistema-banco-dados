<?php
include '../conexao.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM atracoes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Atração excluída com sucesso!";
    } else {
        echo "Erro ao excluir a atração: " . $conn->error;
    }

    // Redirecionar para a página de listagem (opcional, mas recomendado)
    // header("Location: listar.php");
    // exit();

} else {
    echo "ID da atração não fornecido.";
}
?>