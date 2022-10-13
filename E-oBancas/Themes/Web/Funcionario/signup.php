<?php 
    include_once 'header.php';
    include_once '../../../Source/Boot/Helpers/Supports.php';
?>

    <h1 class="header">Cadastro de Funcionário</h1>

    <?php flash('register') ?>

    <form method="post" action="../../../Source/Controllers/Funcionarios.php" class="index">
        <input type="hidden" name="type" value="register">
        <input type="text" name="usersName" 
        placeholder="Nome Completo">
        <input type="text" name="usersEmail" 
        placeholder="Endereço de Email">
        <input type="password" name="usersPwd" 
        placeholder="Palavra-chave">
        <button type="submit" name="submit">Cadastrar-se</button>
    </form>
    <div class="form-sub-msg"><a href="./login">Já tem uma conta?</a></div>

    
<?php 
    include_once '../footer.php'
?>