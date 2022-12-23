import { request, alerta } from './utils.js';

const register = document.getElementById('register');
const login = document.getElementById('login');



register.addEventListener('click', async () => {
    const name = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    const data = await request(`register`, {
        method: 'POST',
        body: {
            username: name.value,
            email: email.value,
            password: password.value,
        },
    });
    const alert = new alerta(data);
    alert.activeAlert();
    console.log(data);
});


login.addEventListener('click', async () => {
    const user = document.getElementById('user');
    const password = document.getElementById('pwd');

    const data = await request(`login`, {
        method: 'POST',
        body: {
            user: user.value,
            password: password.value,
        },
    });
    const alert = new alerta(data);
    alert.activeAlert();
    console.log(data);

});

/*
document.getElementById('logout').addEventListener('click', () => {
    request('logout', { method: "DELETE" });
    window.location.reload();
});



const loginText = document.querySelector(".title-text .login");
const loginForm = document.querySelector("form.login");
const loginBtn = document.querySelector("label.login");
const signupBtn = document.querySelector("label.signup");
signupBtn.onclick = (()=>{
  loginForm.style.marginLeft = "-50%";
  loginText.style.marginLeft = "-50%";
});
loginBtn.onclick = (()=>{
  loginForm.style.marginLeft = "0%";
  loginText.style.marginLeft = "0%";
});*/
