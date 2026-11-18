<?php
require_once "../config/conexao.php";


$busca = trim($_GET["busca"] ?? "");


if ($busca !== "") {


    $sql = "SELECT * FROM produtos
            WHERE nome LIKE ?
            ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(["%" . $busca . "%"]);

} else {


    $sql = "SELECT * FROM produtos
            ORDER BY id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="../css/estilo.css">

</head>

<body>

    <div class="container">

        <h1>Lista de Produtos</h1>

        <form method="GET" class="formulario-busca">

            <input type="text" name="busca" placeholder="Pesquisar produto pelo nome..."
                value="<?= htmlspecialchars($busca, ENT_QUOTES, 'UTF-8') ?>">

            <button type="submit" class="botao">
                Buscar
            </button>

            <a href="listar.php" class="botao-limpar">
                Limpar
            </a>

        </form>


        <a href="cadastrar.php" class="botao">
            + Cadastrar Produto
        </a>

        <div class="tabela-container">

            <table class="tabela">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Cadastro</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($produtos) > 0): ?>

                        <?php foreach ($produtos as $produto): ?>

                            <tr>
                                <td>
                                    <?= (int) $produto["id"] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $produto["nome"],
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $produto["descricao"] ?? "",
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>
                                </td>

                                <td>
                                    R$ <?= number_format(
                                        $produto["preco"],
                                        2,
                                        ",",
                                        "."
                                    ) ?>
                                </td>

                                <td>
                                    <?= (int) $produto["quantidade"] ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        $produto["data_cadastro"],
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>
                                </td>

                                <td>
                                    <div class="acoes">

                                        <a class="botao-editar" href="editar.php?id=<?= (int) $produto["id"] ?>">
                                            Editar
                                        </a>

                                        <form method="POST" action="excluir.php"
                                            onsubmit="return confirm('Deseja realmente excluir este produto?');">

                                            <input type="hidden" name="id" value="<?= (int) $produto["id"] ?>">

                                            <button type="submit" class="botao-excluir">
                                                Excluir
                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="7" style="text-align: center;">

                                <?php if ($busca !== ""): ?>

                                    Nenhum produto encontrado para:
                                    <strong>
                                        <?= htmlspecialchars($busca, ENT_QUOTES, "UTF-8") ?>
                                    </strong>

                                <?php else: ?>

                                    Nenhum produto cadastrado.

                                <?php endif; ?>

                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>
            </table>

        </div>

        <p>
            <a href="../index.php">
                Voltar ao início
            </a>
        </p>

    </div>

</body>

</html>