<?php 

require
  CREATE TABLE IF NOT EXISTS compras (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    usuario_id INTEGER NOT NULL,
    produto_id INTEGER NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),  -- Supondo que você tenha uma tabela de usuários
    FOREIGN KEY (produto_id) REFERENCES produtos(id)