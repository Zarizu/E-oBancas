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


document.getElementById("show").addEventListener("click", Empregados);
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
*/


function editar() {
    const info = document.getElementById('info')
    info.innerHTML = `
    <div id="info">
        <div class="title">Informações</div>
        <form method="post" action="./Source/Controllers/Funcionarios.php">
            <input type="hidden" name="type" value="edit">
            <input type="text" name="editName" 
            placeholder="Nome Completo">
            <input type="text" name="editEmail" 
            placeholder="Endereço de Email">
            <input type="password" name="editPwd" 
            placeholder="Palavra-chave">
            <button type="submit" name="submit">Confirmar</button>
            <?php flash('edit') ?>
        </form>
    </div>`
}
