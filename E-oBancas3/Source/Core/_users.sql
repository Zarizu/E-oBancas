CREATE TABLE users (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  username varchar(45),
  email varchar(45),
  password varchar(45)
);

ALTER TABLE users ADD cash int(45) DEFAULT 0;
ALTER TABLE users ADD business int(45) DEFAULT 0;
ALTER TABLE users ADD boss BIT DEFAULT 0;

INSERT INTO users (id, username, email, password, business) VALUES
(3, 'Homem', 'homem@homem', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 4),
(4, 'Mulher', 'mulher@mulher', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 4);

INSERT INTO users (id, username, email, password, boss, business) VALUES
(5, 'Sol', 'sol@sol', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 1, 3),
(6, 'Lua', 'lua@lua', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 1, 3);



CREATE TABLE business (
  id int(11) AUTO_INCREMENT PRIMARY KEY,
  name varchar(45),
  slogan varchar(45)
);

ALTER TABLE business ADD founder varchar(45) DEFAULT '';
ALTER TABLE business ADD color varchar(45) DEFAULT 'white';
ALTER TABLE business ADD worth int(45) DEFAULT 0;

INSERT INTO business (id, name, slogan) VALUES
(3, 'Sistema Solar', 'Onde tem os planetas e tals'),
(4, 'Terra', 'Moradia da humanidade');

