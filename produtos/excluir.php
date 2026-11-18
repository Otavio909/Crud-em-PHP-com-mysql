
<?php
require_once "../config/conexao.php";

// Recebe o ID enviado pelo formulário
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

// Verifica se o ID é válido
if (!$id || $id <= 0) {
    die("ID do produto inválido!");
}

// Exclui o produto do banco de dados
$sql = "DELETE FROM produtos WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

// Volta para a listagem
header("Location: listar.php");
exit;
?>
