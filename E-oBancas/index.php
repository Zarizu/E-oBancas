<?php 
    
    include_once './Source/Boot/Helpers/Supports.php';

    if(isset($_SESSION['usersName'])) {
        switch($_SESSION['type']) {
            case 'Empresa':
                include_once './Themes/App/Empresa/perfil.php';
                break;
            case 'Funcionario':
                include_once './Themes/App/Funcionario/perfil.php';
                break;
        }
    } else {
        include_once './Themes/Web/header.php';
        echo '<h1 id="index-text">Bem vindo</h1></br>';
    }

    include_once './Themes/Web/footer.php'; 

