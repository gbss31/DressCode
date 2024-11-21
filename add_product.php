<?php
require 'db.php';
session_start();
if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDBConnection();
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];

    $stmt = $db->prepare("INSERT INTO produtos (nome, preco, descricao, imagem) VALUES (?, ?, ?, ?)");
    $stmt->bindValue(1, $nome);
    $stmt->bindValue(2, $preco);
    $stmt->bindValue(3, $descricao);
    $stmt->bindValue(4, $imagem);
    $stmt->execute();

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tests.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Protest+Strike&display=swap" rel="stylesheet">
    <title>Adicionar Produto</title>
</head>
<body>
    <h1>Adicionar Novo Produto</h1>
    <form action="add_product.php" method="POST">
        <label for="nome">Nome do Produto:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="preco">Preço:</label>
        <input type="number" step="0.01" id="preco" name="preco" required>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" required></textarea>

        <label for="imagem">URL da Imagem:</label>
        <input type="text" id="imagem" name="imagem" required>

        <button type="submit">Adicionar Produto</button>
    </form>
</body>
</html>
