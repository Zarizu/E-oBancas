CREATE TABLE `Funcionarios` (
  `idF` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `usersName` varchar(255) NOT NULL,
  `usersEmail` varchar(255) NOT NULL,
  `usersPwd` varchar(255) NOT NULL,
  `usersSaldo` int(255) NOT NULL,
  `usersEmpresa` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `Funcionarios` ADD `type` varchar(255) DEFAULT 'funcionario';


INSERT INTO `Funcionarios` (`idF`, `usersName`, `usersEmail`, `usersPwd`, `usersSaldo`, `usersEmpresa`) VALUES
(3, 'Homem', 'homem@homem', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 0, 3),
(4, 'Mulher', 'mulher@mulher', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 0, 4),
(5, 'Memoh', 'Memoh@Memoh', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 0, 3),
(6, 'Rehlum', 'rehlum@rehlum', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 0, 4);


CREATE TABLE `Empresas` (
  `idE` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `usersName` varchar(255) NOT NULL,
  `usersEmail` varchar(255) NOT NULL,
  `usersEmpresa` varchar(255) NOT NULL,
  `usersPwd` varchar(255) NOT NULL,
  `usersSaldo` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `Empresas` ADD `type` varchar(255) DEFAULT 'empresa';

INSERT INTO `Empresas` (`idE`, `usersName`, `usersEmail`, `usersEmpresa`, `usersPwd`, `usersSaldo`) VALUES
(3, 'Sol', 'sol@sol', 'Sistema Solar', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 1000),
(4, 'Lua', 'lua@lua', 'Órbita', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 1000);


