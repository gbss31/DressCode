<?php
session_start();

// Verifique se o usuário está logado
if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sucesso.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <title>Compra Concluída</title>
</head>
<body>
    <div class="container">
        <h1>Compra Concluída com Sucesso!</h1>
        <p>Obrigado pela sua compra. Seu pedido está sendo processado e você receberá um e-mail de confirmação em breve.</p>
        <a href="index.php" class="btn">Voltar à Página Inicial</a>
    </div>
</body>
</html>
