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


async function fetchData() {
    const response = await fetch('../E-oBancas/Source/Controllers/Users.php?q=servicos');
    const data = await response.json();

    data.forEach(obj => {
        Object.entries(obj).forEach(([key, value]) => {
            console.log(`${key} ${value}`);
        });
        console.log('-------------------');
    });
}