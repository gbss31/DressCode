<?php
session_start();
require_once 'db.php';

// Verifica se o ID do produto foi passado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $db = getDBConnection();
    $stmt = $db->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bindValue(1, $id);
    $stmt->execute();
}

// Redireciona após a remoção
header('Location: index.php');
exit;
?>
