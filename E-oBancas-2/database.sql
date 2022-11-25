CREATE TABLE users (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  username varchar(45),
  email varchar(45),
  password varchar(45)
);

ALTER TABLE users ADD cash int(45) DEFAULT 0;
ALTER TABLE users ADD business BIT DEFAULT 0;
ALTER TABLE users ADD title varchar(45) DEFAULT '';

INSERT INTO users (id, username, email, password) VALUES
(3, 'Homem', 'homem@homem', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau'),
(4, 'Mulher', 'mulher@mulher', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu');

INSERT INTO users (id, username, email, password, business, title) VALUES
(5, 'Sol', 'sol@sol', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 1,'Sistema Solar'),
(6, 'Lua', 'lua@lua', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 1, 'Órbita');
