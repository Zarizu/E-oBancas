
<?php 
    include_once 'header2.php';
    include_once '../../Source/Boot/Helpers/session_helper.php';
?>

    <h1 class="header">Cadastro de Empresa</h1>

    <?php flash('register') ?>

    <form method="post" action="../../Source/Controllers/Users.php" class="index">
        <input type="hidden" name="type" value="register">
        <input type="text" name="usersName" 
        placeholder="Nome Completo">
        <input type="text" name="usersEmail" 
        placeholder="Endereço de Email">
        <input type="text" name="usersEmpresa" 
        placeholder="Nome da Empresa">
        <input type="password" name="usersPwd" 
        placeholder="Palavra-chave">
        <button type="submit" name="submit">Cadastrar-se</button>
    </form>
    <div class="form-sub-msg"><a href="./login">Já tem uma conta?</a></div>

    
<?php 
    include_once 'footer.php'
?>