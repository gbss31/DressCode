<?php
session_start();
require_once 'db.php';

// Verifica se o ID do produto foi passado na URL
if (!isset($_GET['id'])) {
    header('Location: index.php');
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
    header('Location: index.php');
    exit;
}

// Atualiza o produto se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $descricao = $_POST['descricao'];
    $imagem = $_POST['imagem'];

    $stmt = $db->prepare("UPDATE produtos SET nome = ?, preco = ?, descricao = ?, imagem = ? WHERE id = ?");
    $stmt->bindValue(1, $nome);
    $stmt->bindValue(2, $preco);
    $stmt->bindValue(3, $descricao);
    $stmt->bindValue(4, $imagem);
    $stmt->bindValue(5, $id);
    $stmt->execute();

    header('Location: index.php');  // Redireciona após a atualização
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_pd.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Protest+Strike&display=swap" rel="stylesheet">
    
                            <title>Editar Produto - Loja de Roupas</title>
</head>
<body>

<h1>Editar Produto</h1>

<form action="edit_product.php?id=<?php echo $produto['id']; ?>" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
    <br>

    <label for="preco">Preço:</label>
    <input type="text" id="preco" name="preco" value="<?php echo htmlspecialchars($produto['preco']); ?>" required>
    

    <label for="descricao">Descrição:</label>
    <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
    <br>

    <label for="imagem">URL da Imagem:</label>
    <input type="text" id="imagem" name="imagem" value="<?php echo htmlspecialchars($produto['imagem']); ?>" required>

    <button type="submit">Salvar Alterações</button>
    </form>

    <div class="cancelarbt-container">
<a href="index.php" class = 'cancelarbt'> Cancelar</a>
    </div>
</body>
</html>
