-- Mini Sistema de Gestão de Produtos
-- Banco de Dados: sistema_gestao
-- Desenvolvido por Leonardo Estevão Alves — RA: 00250458-1

CREATE DATABASE IF NOT EXISTS sistema_gestao;
USE sistema_gestao;

-- Tabela de Usuários
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(64) NOT NULL, -- SHA-256 hash
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Fornecedores
CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    contact VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Produtos
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    supplier_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Itens da Cesta (Carrinho)
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_product (user_id, product_id) -- Garante 1 unidade por produto por usuário
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserção de dados iniciais para teste
INSERT INTO suppliers (name, contact) VALUES 
('Fornecedor Alpha', 'contato@alpha.com'),
('Fornecedor Beta', 'contato@beta.com');

INSERT INTO products (name, price, supplier_id) VALUES 
('Notebook Gamer', 4500.00, 1),
('Mouse Sem Fio', 120.00, 1),
('Monitor 4K', 2100.00, 2),
('Teclado Mecânico', 350.00, 2);
