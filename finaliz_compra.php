<?php
require 'db.php';
session_start();

$db = getDBConnection();

// Verifique se o usuário está logado
if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_SESSION['usuario_id'])) {
    die('Erro: ID do usuário não especificado.');
}

$usuario_id = $_SESSION['usuario_id'];


if (!isset($_POST['produto_id'])) {
    die('Erro: ID do produto não especificado.');
}

$produto_id = $_POST['produto_id'];


$sql = "INSERT INTO compras (usuario_id, produto_id) VALUES (:usuario_id, :produto_id)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':usuario_id', $usuario_id, PDO::PARAM_INT);
$stmt->bindParam(':produto_id', $produto_id, PDO::PARAM_INT);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="finaliza_compra.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <title>Finalizar Compra</title>
</head>
<body>
    <h1>Finalizar Compra</h1>
    <form action="sucesso.php" method="POST">
        <h2>Informações de Pagamento</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="cartao">Número do Cartão:</label>
        <input type="text" maxlength="20" id="cartao" name="cartao" required>

        <label for="data_validade">Data de Validade:</label>
        <input type="month" id="data_validade" name="data_validade" required placeholder="MM/AA">

        <label for="cvv">CVV:</label>
        <input type="number" maxlength="3" id="cvv" name="cvv" required>

        <input type="hidden" name="produto_id" value="<?php echo htmlspecialchars($produto_id); ?>">

        <br>

        <button type="submit">Finalizar Compra</button>
    </form>
</body>
</html>
