import { User } from './user.js';
import { Empresa } from './empresa.js';


async function main() {
    const button = document.getElementById('teste');

    button.addEventListener('click', async () => {
        const email = document.getElementById('user').value;
        const newUser = new User(email);
        const login = await newUser.login();
        console.log(login);
        document.getElementById("info").innerHTML = JSON.stringify(login);


        if(login.business == 0) {
            document.getElementById("empresa").innerHTML = `
                <div class="header">Empresa</div></br>
                <input id="business" placeholder="Nova Empresa"></br>
                <button id="business">+</button>`;
            document.getElementById("message-teste").innerHTML = "Desempregado";

        }
        if(login.business > 0 && login.boss == 0) {
            document.getElementById("message-teste").innerHTML = "Empregado";
            const newEmpresa = new Empresa(login.id);
            const empresa = await newEmpresa.get();

        }
        if(login.business > 0 && login.boss == 1) document.getElementById("message-teste").innerHTML = "Chefe";

    });
}
main();

