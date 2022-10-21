<?php     
    include_once 'header.php';
    include_once './Source/Boot/Helpers/Supports.php'

?>
<div id="info" class="list">
    <div class="title">Informações</div>
    <div class="coluna-2">
        Nome</br>
        Email</br>
        Empresa
    </div>
    <div class="coluna-2">
        <?php echo($_SESSION['usersName']); ?></br>
        <?php echo($_SESSION['usersEmail']); ?></br>
        <?php echo($_SESSION['usersEmpresa']); ?>
    </div>
    <button id="edit" onclick="editar()">Editar</button>
    <?php flash('edit') ?>
</div>

<div class="list">
    <div class="title">Transferência</div> 
    <div class="coluna-2">Saldo</div>
    <div class="coluna-2">R$ <?php echo($_SESSION['usersSaldo']) ?></div>
    <form method="post" action="./Source/Controllers/Empresas.php" id="transfer">
        <input type="hidden" name="type" value="transfer">
        <input placeholder="Buscar" name="receptor">
        <input placeholder="Valor" name="valor" type="number">
        <button type="submit" name="submit">Enviar</button>
        <?php flash('transfer') ?>
    </form>
</div>

<div class="list">
    <div class="title">Empresa</div>
        <?php echo( $_SESSION['qntEmpregados']); ?>
        <input placeholder="Buscar" name="funcionario">
        <button id="show" onclick="empresa()">Funcionários</button>
        <div id="funcionarios"></div>
</div>




