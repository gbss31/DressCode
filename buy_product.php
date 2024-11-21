<?php
session_start();
require_once 'db.php';

/*if (!isset($_SESSION['logado'])) {
    header('Location: login.php');
    exit;
}*/

// Verifica se o ID do produto foi passado na URL
if (!isset($_GET['id'])) {
    header('Location: index.php');  // Redireciona se não houver ID
    exit;
}

$id = $_GET['id'];
$db = getDBConnection();
$stmt = $db->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bindValue(1, $id);
$stmt->execute();

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

// Verifica se o produto existe
if (!$produto) {
    header('Location: index.php');  // Redireciona se o produto não for encontrado
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="productedt.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Protest+Strike&display=swap" rel="stylesheet">
    
                     <title><?php echo htmlspecialchars($produto['nome']); ?> - Loja de Roupas</title>
</head>
<body>

<h1><?php echo htmlspecialchars($produto['nome']); ?></h1>

<div class="produto-detalhes">
    <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Imagem do produto">
    <h2>Preço: R$ <?php echo htmlspecialchars($produto['preco']); ?></h2>
    <p><?php echo htmlspecialchars($produto['descricao']); ?></p>

    <form action="finaliz_compra.php" method="POST">
        <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
        <button type="submit">Finalizar Compra</button>
    </form>

    <a href="index.php">Voltar para a Loja</a>
</div>

</body>
</html>
