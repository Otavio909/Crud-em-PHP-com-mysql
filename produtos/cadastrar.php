
<?php
require_once "../config/conexao.php";

$mensagem = "";
$tipoMensagem = "";

$nome = "";
$descricao = "";
$preco = "";
$quantidade = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $descricao = trim($_POST["descricao"] ?? "");
    $preco = $_POST["preco"] ?? "";
    $quantidade = $_POST["quantidade"] ?? "";

    if (
        $nome === "" ||
        !is_numeric($preco) ||
        !ctype_digit((string) $quantidade) ||
        $preco < 0
    ) {
        $mensagem = "Preencha os campos corretamente!";
        $tipoMensagem = "erro";

    } else {

        $sql = "INSERT INTO produtos
                (nome, descricao, preco, quantidade)
                VALUES (?, ?, ?, ?)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            $nome,
            $descricao,
            $preco,
            $quantidade
        ]);

        $mensagem = "Produto cadastrado com sucesso!";
        $tipoMensagem = "sucesso";

        // Limpa os campos após cadastrar
        $nome = "";
        $descricao = "";
        $preco = "";
        $quantidade = "";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Cadastrar Produto</title>

    <link rel="stylesheet"
          href="../css/estilo.css">
</head>

<body>

<div class="container">

    <h1>Cadastrar Produto</h1>

    <?php if ($mensagem !== ""): ?>

        <div class="mensagem-<?= $tipoMensagem ?>">
            <?= htmlspecialchars($mensagem, ENT_QUOTES, "UTF-8") ?>
        </div>

    <?php endif; ?>

    <form method="POST" class="formulario">

        <div class="grupo-formulario">
            <label for="nome">Nome do produto</label>

            <input type="text"
                   id="nome"
                   name="nome"
                   maxlength="100"
                   required
                   value="<?= htmlspecialchars($nome, ENT_QUOTES, "UTF-8") ?>">
        </div>

        <div class="grupo-formulario">
            <label for="descricao">Descrição</label>

            <textarea id="descricao"
                      name="descricao"
                      rows="4"><?= htmlspecialchars($descricao, ENT_QUOTES, "UTF-8") ?></textarea>
        </div>

        <div class="grupo-formulario">
            <label for="preco">Preço (R$)</label>

            <input type="number"
                   id="preco"
                   name="preco"
                   step="0.01"
                   min="0"
                   required
                   value="<?= htmlspecialchars((string) $preco, ENT_QUOTES, "UTF-8") ?>">
        </div>

        <div class="grupo-formulario">
            <label for="quantidade">Quantidade</label>

            <input type="number"
                   id="quantidade"
                   name="quantidade"
                   min="0"
                   step="1"
                   required
                   value="<?= htmlspecialchars((string) $quantidade, ENT_QUOTES, "UTF-8") ?>">
        </div>

        <button type="submit" class="botao-salvar">
            Cadastrar Produto
        </button>

    </form>

    <p>
        <a href="listar.php">Voltar para a lista</a>
    </p>

</div>

</body>
</html>
