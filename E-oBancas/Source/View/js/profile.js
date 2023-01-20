import { User } from './user.js';
import { Business } from './business.js';


async function main() {
    const button = document.getElementById('login');

    button.addEventListener('click', async () => {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        if(email == "" || password == "") {
            document.getElementById("message").innerHTML = "Preencha todos os campos";
            return;
        }
        const newUser = new User({email, password});
        const login = await newUser.login();
        console.log(login);
        if(login.message) { document.getElementById("message").innerHTML = login.message; }

        if (login.id) {
            document.getElementById("info").innerHTML = `
                <div class="header">INFO</div></br>
                <label id="username">${login.username}</label></br>
                <label id="email">${login.email}</label></br>
                <label id="cash">${login.cash}</label></br>
                <button id="update">Editar</button></br>
                <span id="message"></span>
            `;

            const button = document.getElementById('update');
            button.addEventListener('click', async () => {
                document.getElementById("info").innerHTML = `
                    <div class="header">Editar</div></br>
                    <input id="username" placeholder="${login.username}"></br>
                    <input id="email" placeholder="${login.email}"></br>
                    <input id="password" placeholder="Senha"></br>
                    <button id="update">Confirmar</button></br>
                    <span id="message"></span>
                `;
                const id = login.id;
                const username = document.getElementById('username').value;
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                const button = document.getElementById('update');

                button.addEventListener('click', async () => {
                    const message = document.getElementById('message');
                    const newUser = new User({id, username, email, password});
                    const update = await newUser.update();
                    document.getElementById("message").innerHTML = update.message;

                    console.log(update);
                })
            });
        }

        if(login.business == 0) {
            document.getElementById("empresa").innerHTML = `
                <div class="header">Empresa</div></br>
                <input id="name" placeholder="Nova Empresa"></br>
                <button id="business">+</button></br>
                <span>Desempregado</span>`;

            const button = document.getElementById('business');
            button.addEventListener('click', async () => {
                const message = document.getElementById('message');
                const name = document.getElementById('name').value;
                const newBusiness = new Business({name});
                const create = await newBusiness.create();
                document.getElementById("message").innerHTML = create.message;
                console.log(create);
            });
            return;
        }
        if(login.business > 0 && login.boss == 0) {
            document.getElementById("message").innerHTML = "Empregado";
            const business = login.business;
            const newUser = new User({business});
            const e = await newUser.getBusiness();
            document.getElementById("empresa").innerHTML = `
                <div class="header">${e.name}</div></br>
                <p">${e.slogan}</p></br>
                <label>Worth: ${e.worth}</label></br>
                <span>Criada por: ${e.founder}</span>
            `;
            return;
        }
        if(login.business > 0 && login.boss == 1) {
            document.getElementById("message").innerHTML = "Chefe";


            return;
        }

    });
}
main();

/*
document.getElementById("info").innerHTML = `
<div class="header">INFO</div></br>
<input id="username" placeholder="${login.username}"></br>
<input id="email" placeholder="${login.email}"></br>
<input id="password" placeholder="Senha;"></br>

<label id="cash">${login.cash}</label></br>
`;

*/