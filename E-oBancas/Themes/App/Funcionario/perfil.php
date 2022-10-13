<?php     
    include_once 'header.php';
    include_once './Source/Boot/Helpers/Supports.php'
?>
        <div id="info" class="list">
            <div class="title">Informações</div>
            <div id="infoEdit">
                <div class="coluna-2">
                    Nome</br>
                    Email 
                </div>
                <div class="coluna-2">
                    <?php echo($_SESSION['usersName']); ?></br>
                    <?php echo($_SESSION['usersEmail']); ?></br>
                </div>
            </div>
            <button type="submit" id="editar">Editar</button>

        </div>

        <div class="list">
            <div class="title">Transferência</div> 
            <div class="coluna-2">Saldo</div>
            <div class="coluna-2"><?php echo($_SESSION['usersSaldo']) ?></div>
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
            <?php
                if($_SESSION['usersEmpresa'] == 0) {
                    echo '<p>Desempregado</p>';
                } else {
                    echo '<p>Empregado</p></br>'.$_SESSION['usersEmpresa'];
                }
            ?>
        </div>





