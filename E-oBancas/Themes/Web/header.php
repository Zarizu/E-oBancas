<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-oBancas</title>
    <link rel="stylesheet" href="./Assets/css/style.css" type="text/css">
    <script type="text/javascript" src="./Assets/script.js"></script>
</head>
<body>
    <nav>
        <ul>
            <a href="index.php"><li>E-oBancas</li></a>
            <?php if(!isset($_SESSION['usersName'])) : ?>
                <a href="./Themes/Web/Funcionario/signup.php"><li>Cadastro</li></a>
                <a href="./Themes/Web/Empresa/signup.php"><li>Cadastro E</li></a>
                <a href="./Themes/Web/Funcionario/login.php"><li>Entrar</li></a>
                <a href="./Themes/Web/Empresa/login.php"><li>Entrar E</li></a>
            <?php else: ?>
                <a href="./Source/Controllers/Funcionarios.php?q=logout"><li>Sair</li></a>
            <?php endif; ?>
        </ul>
    </nav>