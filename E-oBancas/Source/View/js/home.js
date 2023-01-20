import { User } from './user.js';

async function main() {
    const register = document.getElementById('register');
    const login = document.getElementById('login');

    register.addEventListener('click', async () => {
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        if(username == "" || email == "" || password == "") {
            document.getElementById("message-register").innerHTML = "Preencha todos os campos";
            return;
        }
        const newUser = new User({username, email, password});
        const register = await newUser.register();
        console.log(register);
        document.getElementById("message-register").innerHTML = register.message;
    });

    login.addEventListener('click', async () => {
        const email = document.getElementById('user').value;
        const password = document.getElementById('pwd').value;
        if(email == "" || password == "") {
            document.getElementById("message-login").innerHTML = "Preencha todos os campos";
            return;
        }
        const user = new User({email, password});
        const login = await user.login();
        console.log(login);
        if (login.message) {
            document.getElementById("message-login").innerHTML = login.message;
            return;
        }
        if(login.check) window.location.href = "perfil";

    });
}
main();

