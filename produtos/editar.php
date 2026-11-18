
<?php

require_once "../config/conexao.php";

// Recebe o ID pela URL
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    die("ID do produto inválido!");
}

// Busca o produto no banco
$sql = "SELECT * FROM produtos WHERE id = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado!");
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $descricao = trim($_POST["descricao"]);
    $preco = $_POST["preco"];
    $quantidade = $_POST["quantidade"];

    if (
        $nome === "" ||
        !is_numeric($preco) ||
        !is_numeric($quantidade) ||
        $preco < 0 ||
        $quantidade < 0
    ) {

        $mensagem = "Preencha os campos corretamente!";

    } else {

        // Atualiza o produto
        $sql = "UPDATE produtos SET
                nome = ?,
                descricao = ?,
                preco = ?,
                quantidade = ?
                WHERE id = ?";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $nome,
            $descricao,
            $preco,
            $quantidade,
            $id
        ]);

        // Volta para a listagem
        header("Location: listar.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>

    <h1>Editar Produto</h1>

    <?php if (isset($mensagem)): ?>
        <p><?= htmlspecialchars($mensagem) ?></p>
    <?php endif; ?>

    
<div class="container">

    <h1>Editar Produto</h1>

    <form method="POST" class="formulario">

        <div class="grupo-formulario">
            <label for="nome">Nome do produto</label>

            <input
                type="text"
                id="nome"
                name="nome"
                maxlength="100"
                value="<?= htmlspecialchars($produto['nome'], ENT_QUOTES, 'UTF-8') ?>"
                required
            >
        </div>

        <div class="grupo-formulario">
            <label for="descricao">Descrição</label>

            <textarea
                id="descricao"
                name="descricao"
                rows="4"
            ><?= htmlspecialchars($produto['descricao'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="grupo-formulario">
            <label for="preco">Preço (R$)</label>

            <input
                type="number"
                id="preco"
                name="preco"
                step="0.01"
                min="0"
                value="<?= htmlspecialchars((string) $produto['preco'], ENT_QUOTES, 'UTF-8') ?>"
                required
            >
        </div>

        <div class="grupo-formulario">
            <label for="quantidade">Quantidade</label>

            <input
                type="number"
                id="quantidade"
                name="quantidade"
                min="0"
                step="1"
                value="<?= (int) $produto['quantidade'] ?>"
                required
            >
        </div>

        <button type="submit" class="botao-salvar">
            Salvar Alterações
        </button>

    </form>

    <p>
        <a href="listar.php">Voltar para a lista</a>
    </p>

</div>


    <br>

    <a href="listar.php">Voltar para produtos</a>

</body>
</html>
