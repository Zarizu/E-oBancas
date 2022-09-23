CREATE TABLE `funcionarios` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `usersName` varchar(255) NOT NULL,
  `usersEmail` varchar(255) NOT NULL,
  `usersPwd` varchar(255) NOT NULL,
  `usersSaldo` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `funcionarios` (`id`, `usersName`, `usersEmail`, `usersPwd`, `usersSaldo`) VALUES
(3, 'Homem', 'homem@homem', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 0),
(4, 'Mulher', 'mulher@mulher', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 0),
(5, 'Fabiane', 'Fabiane@Fabiane', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 0),
(6, 'Jota', 'Jota@Jota', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 0);


CREATE TABLE `admins` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `usersName` varchar(255) NOT NULL,
  `usersEmail` varchar(255) NOT NULL,
  `usersEmpresa` varchar(255) NOT NULL,
  `usersPwd` varchar(255) NOT NULL,
  `usersSaldo` int(255) NOT NULL,
  `Servicos` varchar(255) NOT NULL,
  `Funcionarios` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `admins` (`id`, `usersName`, `usersEmail`, `usersEmpresa`, `usersPwd`, `usersSaldo`, `Servicos`, `Funcionarios`) VALUES
(3, 'Sol', 'sol@sol', 'Sistema Solar', '$2y$10$YnQos8DheLahS.yX/PT0W.K4.2Lww3fFlf19PHiIq1flVpjEQEkau', 1000,"{'Titulo':'Conserto','Desc':'consertar coisas bem grandes'}",''),
(4, 'Lua', 'lua@lua', 'Órbita', '$2y$10$A6yoA6Zc3j9H6mWMjyvj8u2B1wEupTfh0tP6amMmTgmxAgT6LfIdu', 1000,'','');


