
<?php
require_once "config/conexao.php";

// 1. Total de produtos cadastrados
$sql = "SELECT COUNT(*) FROM produtos";
$stmt = $pdo->query($sql);
$totalProdutos = (int) $stmt->fetchColumn();

// 2. Produtos com estoque baixo (1 a 5)
$sql = "SELECT COUNT(*) FROM produtos
        WHERE quantidade BETWEEN 1 AND 5";

$stmt = $pdo->query($sql);
$estoqueBaixo = (int) $stmt->fetchColumn();

// 3. Produtos sem estoque
$sql = "SELECT COUNT(*) FROM produtos
        WHERE quantidade = 0";

$stmt = $pdo->query($sql);
$semEstoque = (int) $stmt->fetchColumn();

// 4. Valor total do estoque
$sql = "SELECT COALESCE(
            SUM(preco * quantidade), 0
        ) FROM produtos";

$stmt = $pdo->query($sql);
$valorEstoque = (float) $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Sistema de Produtos</title>

    <link rel="stylesheet" href="css/estilo.css">
</head>

<body>

<div class="container">

    <h1>Painel de Controle</h1>

    <p class="subtitulo">
        Sistema de Gerenciamento de Produtos'
    </p>

    <div class="dashboard">

        <div class="card card-azul">
            <h3>Total de Produtos</h3>
            <p><?= $totalProdutos ?></p>
        </div>

        <div class="card card-amarelo">
            <h3>Estoque Baixo</h3>
            <p><?= $estoqueBaixo ?></p>
        </div>

        <div class="card card-vermelho">
            <h3>Sem Estoque</h3>
            <p><?= $semEstoque ?></p>
        </div>

        <div class="card card-verde">
            <h3>Valor Total do Estoque</h3>

            <p>
                R$ <?= number_format(
                    $valorEstoque,
                    2,
                    ",",
                    "."
                ) ?>
            </p>
        </div>

    </div>

    <div class="menu">

        <a href="produtos/cadastrar.php"
           class="botao">
            Cadastrar Produto
        </a>

        <a href="produtos/listar.php"
           class="botao">
            Listar Produtos
        </a>

    </div>

</div>

</body>
</html>
