<?php
function getDBConnection() {
    $db = new PDO('sqlite:./database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

try {
    $db = getDBConnection();
    // Adiciona a coluna is_funcionario à tabela usuarios
    $db->exec("ALTER TABLE usuarios ADD COLUMN is_funcionario BOOLEAN DEFAULT 0");
    echo "Coluna 'is_funcionario' adicionada com sucesso!";
} catch (PDOException $e) {
    echo "Erro ao alterar tabela: " . $e->getMessage();
}
?>
