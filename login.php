<?php
session_start();
require_once 'db.php';

if (isset($_SESSION['logado'])) {
    header('Location: index.php');   
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $db = getDBConnection();
   
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bindValue(1, $usuario);
    $stmt->execute();
    $usuario_bd = $stmt->fetch(PDO::FETCH_ASSOC);
    
  
    if ($usuario_bd && password_verify($senha, $usuario_bd['senha'])) {
        $_SESSION['logado'] = true;
        $_SESSION['is_funcionario'] = $usuario_bd['is_funcionario']; 
        $_SESSION['usuario_id'] = $usuario_bd['id']; 
        header('Location: index.php');
        exit;
    } 
    // Verificação do login do admin
    else if ($usuario == 'admin' && $senha == '12345') {
        $_SESSION['logado'] = true;
        $_SESSION['is_funcionario'] = true;
        $_SESSION['usuario_id'] = 0; 
        header('Location: index.php');
        exit;
    } else {  
        $erro = "Usuário ou senha incorretos!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Protest+Strike&display=swap" rel="stylesheet">
    <title>Login - Loja de Roupas</title>
</head>
<body>

<h1>Login</h1>
<?php if (isset($erro)): ?>
    <p class="erro-msg" style="color:red;"><?php echo $erro; ?></p>
<?php endif; ?>
<form action="login.php" method="POST">
    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario" required>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>
    <button type="submit">Login</button>
</form>

<p class="registro-link">Não tem uma conta? <a href="register.php">Cadastre-se aqui</a>.</p>

</body>
</html>
