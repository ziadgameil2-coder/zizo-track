CREATE DATABASE secure_lab;
USE secure_lab;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL,
  role VARCHAR(10) NOT NULL
);

INSERT INTO users (username, password, role) VALUES
('user1','pass1','user'),
('user2','pass2','user'),
('user3','pass3','user'),
('admin1','admin123','admin'),
('user4','pass4','user'),
('user5','pass5','user');
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  owner_id INT NOT NULL,
  product_name VARCHAR(50) NOT NULL,
  price INT NOT NULL
);

INSERT INTO products (owner_id, product_name, price) VALUES
(1,'Keyboard',120),
(2,'Mouse',50),
(3,'Monitor',300),
(4,'Laptop',1000),
(5,'Headphones',80),
(6,'USB Drive',20);