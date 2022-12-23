async function request(url, options = {}) {
    const baseURL = location.href.split('/').slice(0, -1).join('/');
  
    console.log();
    if (options.body) {
      options.body = new URLSearchParams(options.body).toString();
      options.headers = { 'Content-type': 'application/x-www-form-urlencoded' };
    }
  
    options.method = options.method || 'GET';
  
    const req = await fetch(`${baseURL}/${url}`, options);
    return await req.json();
  }
  
  class alerta {
    constructor(message) {
      this.mensagemAlerta = message;
      this.alertaAtivo = false;
      this.alertBox = document.createElement('div');
    }
  
    createAlert() {
      this.alertBox.classList.add('alert');
      document.body.appendChild(this.alertBox);
    }
  
    activeAlert() {
      this.createAlert();
      this.alertBox.innerHTML = this.mensagemAlerta;
      this.alertBox.style.display = 'flex';
      setTimeout(() => {
        this.alertBox.style.display = 'none';
      }, 6000);
    }
  }
  
  export { request, alerta };