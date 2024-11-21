<?php
session_start();
require_once 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
    exit;
}

// Obtém o ID do usuário da sessão
$usuario_id = $_SESSION['usuario_id'];

$db = getDBConnection();

// Consulta para obter as informações do usuário
$stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bindValue(1, $usuario_id);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o usuário foi encontrado
if (!$usuario) {
    die("Usuário não encontrado.");
}

// Consulta para obter as compras recentes do usuário, incluindo o nome dos produtos
$stmt = $db->prepare("
    SELECT compras.id AS compra_id, produtos.nome AS produto_nome 
    FROM compras 
    JOIN produtos ON compras.produto_id = produtos.id 
    WHERE compras.usuario_id = ?
");
$stmt->bindValue(1, $usuario_id);
$stmt->execute();
$compras = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="conta.css">
    <link rel="preconnect" href="https:/fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Protest+Strike&display=swap" rel="stylesheet">
    <title>Conta - Loja de Roupas</title>
</head>
<body>

<h1>Bem-vindo(a), <?php echo htmlspecialchars($usuario['usuario']); ?>!</h1>

<img src = "logo.png" alt="logo" class="logo">

<h2>Suas compras Recentes</h2>

<?php if (count($compras) > 0): ?>
    <ul>
        <?php foreach ($compras as $compra): ?>
            <li>Compra ID: <?php echo htmlspecialchars($compra['compra_id']); ?> - Produto: <?php echo htmlspecialchars($compra['produto_nome']); ?></li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
   <div class ="nadacp"> <p>Você não realizou nenhuma compra recente.</p> </div>
<?php endif; ?>

        <div class="header">
        <form action="index.php" method="get">
            <button type="submit" class="btn_voltar">Voltar</button> 
        </form>
        </div>

        <form action="logoff.php" method="post">
            <button type="submit" name="logoff" class="btn_logoff">Logoff</button>
        </form>

</body>
</html>
