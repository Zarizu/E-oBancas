import { User } from './user.js';

async function main() {
    const register = document.getElementById('register');
    const login = document.getElementById('login');

    register.addEventListener('click', async () => {
        const name = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const newUser = new User(name, email, password);
        const register = await newUser.register();
        console.log(register);
        document.getElementById("message-register").innerHTML = register.message;
    });

    login.addEventListener('click', async () => {
        const email = document.getElementById('user').value;
        const password = document.getElementById('pwd').value;
        console.log(email, password);
        const user = new User(email, password);
        const login = await user.login();
        console.log(login);
        document.getElementById("message-login").innerHTML = login.message;
        if(login.check)  window.location.href = "perfil";;

    });
}
main();

