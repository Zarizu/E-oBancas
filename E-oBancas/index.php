<?php 
    include_once './Themes/Web/header.php';
    include_once './Source/Boot/Helpers/session_helper.php';
?>
    <?php if(isset($_SESSION['usersName'])){
        include_once './Themes/App/perfil.php';
    }else{
        echo '<h1 id="index-text">Bem vindo</h1></br>';
    } 
    ?>
<?php 
    include_once './Themes/Web/footer.php'
?>