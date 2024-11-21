<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDBConnection();
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $is_funcionario = isset($_POST['is_funcionario']) ? 1 : 0;


    
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bindValue(1, $usuario);
    $stmt->execute();
    $usuario_existente = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($usuario_existente) {
        $erro = "Usuário já existe! Tente outro.";
    } 
    else
    {
    
        $stmt = $db->prepare("INSERT INTO usuarios (usuario, senha, is_funcionario) VALUES (?, ?, ?)");
        $stmt->bindValue(1, $usuario);
        $stmt->bindValue(2, password_hash($senha, PASSWORD_DEFAULT));
        $stmt->bindValue(3, $is_funcionario);
        $stmt->execute();

        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="teste.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Protest+Strike&display=swap" rel="stylesheet">
    <title>Registro - Loja de Roupas</title>
</head>
<body>

<h1>Registro</h1>
<?php if (isset($erro)): ?>
    <p style="color:red;"><?php echo $erro; ?></p>
<?php endif; ?>
<form action="register.php" method="POST">
    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario" required>
    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required>

 <!--     <label for="is_funcionario">É funcionário?</label>
          <input type="checkbox" id="is_funcionario" name="is_funcionario">  -->

          <button type="submit">Cadastrar</button>     
        
</form>

  <p class = "login-link" > Já tem um cadastro? <a href="login.php" > Faça login. </a> </p>


</body>
</html>
