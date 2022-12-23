// const templateVars = {};
// document.querySelectorAll('.template-vars').forEach(e => {
//     templateVars[e.id] = e.value;
//     e.remove();
// });


// document.querySelector('#name').innerHTML = templateVars.name;
// document.querySelector('#email').innerHTML = templateVars.email;

import { request, alerta } from './utils.js';

const edit = document.getElementById('edit');
const send = document.getElementById('send');



edit.addEventListener('click', async () => {
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


send.addEventListener('click', async () => {
    const user = document.getElementById('receive');
    const password = document.getElementById('send');

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

const btn = document.querySelector('.btnTeste');
btn.addEventListener('click', () => {
  const alert = new alerta('status');
  alert.activeAlert();
});

document.getElementById('logout').addEventListener('click', () => {
    request('logout', { method: "DELETE" });
    window.location.reload();
});