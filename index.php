<?php
session_start();  

require 'db.php';

$db = getDBConnection();


$db->exec("CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    preco REAL NOT NULL,
    descricao TEXT,
    imagem TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS compras (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario_id INTEGER NOT NULL,
    produto_id INTEGER NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id), 
    FOREIGN KEY (produto_id) REFERENCES produtos(id))");

$result = $db->query("SELECT * FROM produtos");


if (!$result) {
    die("Erro ao consultar o banco de dados: " . $db->lastErrorMsg());
}

if (isset($_POST['logoff'])) {
    $_SESSION['logado'] = false;
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css"> 
    <link rel="preconnect" href="https:/fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Protest+Strike&display=swap" rel="stylesheet">
    
                              <title>DressCode()</title>
</head>
<body>

<h1>Bem-vindo à DressCode()</h1>
<header>
    
<img src = "logo.png" alt="logo" class="logo">

<!-- botao para add roupas apenas para funcionario -->
<?php if (isset($_SESSION['logado']) && isset($_SESSION['is_funcionario']) && $_SESSION['is_funcionario']): ?>
    <a href="add_product.php">Adicionar Produto</a>
<?php endif; ?>


<h2>Produtos Disponíveis</h2>
<div class="produtos">
 
<?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?> 


        <div class="produto">
           
            <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
            <p class="preco"> R$<?php echo htmlspecialchars($row['preco']); ?></p>
            <p class="descricao"><?php echo htmlspecialchars($row['descricao']); ?></p>
            <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Imagem do produto">
            <a href="buy_product.php?id=<?php echo $row['id']; ?>">Comprar</a>
           
            <?php if (isset($_SESSION['logado']) && $_SESSION['is_funcionario']): ?>
                <a href="edit_product.php?id=<?php echo $row['id']; ?>">Editar</a>
                <form action="delete_product.php" method="POST" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" onclick="return confirm('Tem certeza que deseja remover este produto?');">Remover</button>

            </form>
                
                <?php endif; ?>

            </div>

                 <?php endwhile; ?>

           </div>

       <?php if (!isset($_SESSION['logado'])): ?> 
    <div class="header">
        <form action="login.php" method="get">
            <button type="submit" class="btn_login">Login</button> 
        </form>
    </div>
<?php endif ?>

<?php if (isset($_SESSION['logado']) && !isset($_SESSION['is_funcionario']) && !$_SESSION['is_funcionario']): ?>
    
    <div class="header"> 
        <form action="conta.php" method="get">
            <button type="submit" class="btn_conta">Conta</button>
        </form>
    </div>
<?php endif ?>

<?php if (isset($_SESSION['logado']) && isset($_SESSION['is_funcionario']) && $_SESSION['is_funcionario']): ?>

    <form action="logoff.php" method="post">
            <button type="submit" name="logoff" class="btn_logoff">Logoff</button>
    </form>

<?php endif; ?>
      
                
</body>
</html>
