<?php
?>
        <div id="info" class="list">
            <div class="title">Informações</div>
            <div class="coluna-2">
                Nome</br>
                Email</br>
                Empresa</br>
                Saldo</br>
            </div>
            <div class="coluna-2">
                <?php echo($_SESSION['usersName']); ?></br>
                <?php echo($_SESSION['usersEmail']); ?></br>
                <?php echo($_SESSION['usersEmpresa']); ?></br>
                <?php echo($_SESSION['usersSaldo']); ?></br>
            </div>
        </div>


        <div class="list">
        <div class="title">Transferência</div>

            <form method="post" action="../../Source/Controllers/Users.php" id="trans">
            <?php flash('trans') ?>
            <div class="coluna-2">
                Saldo
            </div>
            <div class="coluna-2">
                <?php echo($_SESSION['usersSaldo']); ?>
            </div>
                <input type="hidden" name="type" value="trans">
                <input placeholder="Buscar" name="recepiente">
                <input placeholder="Valor" name="valor">
                <button type="submit" name="submit">Enviar</button>
            </form>
        </div>

        <div class="list">
        <div class="title">Empresa</div>
            <form method="post" action="../../Source/Controllers/Users.php" id="contrato">
                <?php flash('contrato') ?>
                <input type="hidden" name="type" value="trans">
                <input placeholder="Buscar" name="funcionario">
                <button type="submit" name="submit">Enviar</button>
            </form>
        </div>

        <div class="list">
        <div class="title">Serviços</div>
            <form method="get" id="servico">
                <?php flash('servico') ?>
                <input type="hidden" name="type" value="servicos">
                <input placeholder="Título" name="funcionario">
                <input placeholder="Descrição" name="valor">
                <button type="submit" name="submit" onclick="fetchData()">Enviar</button>
                <div id="servicosList">

                </div>
            </form>
        </div>




