/*const info = document.querySelec`orservicos[](`;');

info.addEventListener("click", info);
function info() {
    const perfil = document.getElementById("perfil");
    const info = document.getElementById("info");

    perfil.innerHTML = "display: none";
    info.style = "display: block";
}

//const servicoTitulo;
//const servicoDesc;   
fetch('../E-oBancas/Source/Controllers/Users.php', {
    method: 'POST',
    headers: {
        'Content-type': 'application/json'
    },
    body: JSON.stringify({
        titulo: '',
        titulo: ''
    })
}).then(res => {
    return res.json()
})
.then(data =>escrever(data))
.catch(error => console.log('ERRO'))


function escrever(servicos) {
    let servicos
    const list = document.getElementById('servicosList')
    
    list.innerHTML = `${servicos[]}`;

}
*/
//const showBtn = document.getElementById("show")
//showBtn.addEventListener("click", Empregados);

function empresa() {
    window.location.href = "./Source/Controllers/Empresas.php?q=showAll";

}

function editar() {
    const info = document.getElementById('info')
    info.innerHTML = `
    <div id="info">
        <div class="title">Informações</div>
        <form method="post" action="./Source/Controllers/Empresas.php">
            <input type="hidden" name="type" value="edit">
            <input type="text" name="editName" 
            placeholder="Nome Completo">
            <input type="text" name="editEmail" 
            placeholder="Endereço de Email">
            <input type="text" name="editEmpresa" 
            placeholder="Nome da Empresa">
            <input type="password" name="editPwd" 
            placeholder="Palavra-chave">
            <button type="submit" name="submit">Confirmar</button>
            <?php flash('edit') ?>
        </form>
    </div>`
}
    

/*
async function Empregados() {
    const res = await fetch("./Source/Controllers/Empresas.php?q=show", { method: 'GET'});
    const data = await res.json();
    console.log(data);

    data.forEach( i => {
        document.getElementById('funcionarios').insertAdjacentHTML("afterbegin", `
            <div id="funcionarios">
                Nome: ${i.usersName}
                Email: ${i.usersEmail}
                Saldo: ${i.usersSaldo}
            </div>
        `)
    });
}
/*
document.getElementById("editar").addEventListener("click", Editar);

function Editar() {
    document.getElementById("infoEdit").innerHTML = `
    <div class="coluna-2">
        Nome</br>
        Email 
    </div>
    <div class="coluna-2">
        <input type="text" name="usersName">
        <input type="text" name="usersEmail">
        <input type="password" name="usersPwd">
    </div>
    `;
}
*/


