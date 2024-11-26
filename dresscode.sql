-- Banco de Dados: DressCode
CREATE DATABASE IF NOT EXISTS DressCode;


-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    is_funcionario BOOLEAN DEFAULT FALSE,
);

-- Tabela de categorias
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL UNIQUE,
    descricao TEXT NULL,
 
);

-- Tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    imagem_url VARCHAR(255) NULL,
);

-- Tabela de compras
CREATE TABLE IF NOT EXISTS compras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    data_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela de itens da compra
CREATE TABLE IF NOT EXISTS itens_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_compra INT NOT NULL,
    id_produto INT NOT NULL,
    quantidade INT NOT NULL,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_compra) REFERENCES compras(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produtos(id) ON DELETE CASCADE
);

INSERT INTO usuarios (usuario, senha, is_funcionario) 
VALUES ('admin', MD5('12345'), TRUE),
       ('maria', MD5('senha123'), FALSE),
       ('joao', MD5('joao456'), FALSE);

INSERT INTO categorias (nome, descricao) 
VALUES ('Masculino', 'Roupas e acessórios masculinos'),
       ('Feminino', 'Roupas e acessórios femininos'),
       ('Acessórios', 'Bolsas, cintos e outros acessórios');

INSERT INTO produtos (nome, descricao, preco, imagem_url) 
VALUES ('Camiseta Preta', 'Camisa básica ', 115.99, 'https://citerol.vteximg.com.br/arquivos/ids/171585-1000-1000/IMG_1335.jpg?v=638157192635470000'),
       ('Camiseta  Branca', 'Camisa básica ', 115.99, 'https://images.tcdn.com.br/img/img_prod/699671/camiseta_ogochi_manga_curta_basica_masculina_6001001_branca_28587_1_691eaf9eaff1b4da84e36bca30a2bb4c.jpg'),
       ('Camiseta  Vermelha', 'Camisa básica ', 115.99, 'https://cdn.shoppub.io/cdn-cgi/image/w=1000,h=1000,q=80,f=auto/outlet360/media/migration/81d56f16a6981c4b56f4e10fc1b17e04dfe0c9f7/2204544974c081e4f64.jpg');

INSERT INTO compras (id_usuario, total) 
VALUES (1,  115.99),
       (2, 115.99),
       (3, 115.99);

INSERT INTO itens_compra (id_compra, id_produto, quantidade, preco_unitario) 
VALUES (1, 1, 1,  115.99),
       (2, 2, 1,  115.99),
       (3, 3, 2,  115.99);
