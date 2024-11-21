<?php
// db.php
function getDBConnection() {
    $db = new PDO('sqlite:./database.db');  // Substitua o caminho pelo correto
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilita modo de erro
    return $db;
}




?>

