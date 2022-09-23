<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-oBancas</title>
    <link rel="stylesheet" href="./Assets/style.css" type="text/css">
    <script type="text/javascript" src="./Assets/script.js"></script>
</head>
<body>
    <nav>
        <ul>
            <a href="index.php"><li>E-oBancas</li></a>
            <?php if(!isset($_SESSION['usersName'])) : ?>
                <a href="./Source/Controllers/Users.php?q=signup"><li>Cadastro</li></a>
                <a href="./Source/Controllers/Users.php?q=login"><li>Entrar</li></a>
            <?php else: ?>
                <a href="./Source/Controllers/Users.php?q=logout"><li>Sair</li></a>
            <?php endif; ?>
        </ul>
    </nav>