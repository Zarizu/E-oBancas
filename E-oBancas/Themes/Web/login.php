
<?php 
    include_once 'header2.php';
    include_once '../../Source/Boot/Helpers/session_helper.php';
?>
    <h1 class="header">Entrar como Empresa</h1>

    <?php flash('login') ?>

    <form method="post" action="../../Source/Controllers/Users.php" id="login">
        <input type="hidden" name="type" value="login">
        <input type="text" name="name/email"  
        placeholder="Nome ou Endereço de Email">
        <input type="password" name="usersPwd" 
        placeholder="Palavra-chave">
        <button type="submit" name="submit">Entrar</button>
    </form>

    <div class="form-sub-msg"><a href="./signup">Não tem uma conta?</a></div>
    
<?php 
    include_once 'footer.php'
?>