import { request } from './utils.js';

class User {
    #id = null;
    #username = null;
    #email = null;
    #password = null;
    #cash = null;
    #business = null;
    #boss = null;


    constructor({
        id = null,
        username = null,
        email = null,
        password = null,
        cash = null,
        business = null,
        boss = null,
    }){
        this.#id = id;
        if (username && username != '') this.#username = username;
        if (email && email != '') this.#email = email;
        if (password && password != '') this.#password = password;
        if (cash && cash != '') this.#cash = cash;
        if (business && business != '') this.#business = business;
        if (boss && boss != '') this.#boss = boss;
    }

    static async getAll() {
        return request('Users');
    }

    async get() {
        const id = this.#id;
        const resp = await request(`users/${id}`);
        return resp;
    }

    async getBusiness() {
        const business = this.#business;
        const resp = await request(`empresa/${business}`);
        return resp;
    }

    async register() {
        const body = {
            username: this.#username,
            email: this.#email,
            password: this.#password,
        }
        const resp = await request('register', { method: 'POST', body: body });
        if (resp.id) this.#id = resp.id;
        return resp;
    }

    async login() {
        const body = {
            email: this.#email,
            password: this.#password,
        }
        const resp = await request('login', { method: 'POST', body: body });
        if (resp.id) this.#id = resp.id;
        return resp;
    }

    async update() {
        const id = this.#id;
        const body = {};

        if (this.#username) 
        body.username = this.#username;
        if (this.#email) 
        body.email = this.#email;
        if (this.#password) 
        body.password = this.#password;
        
        const resp = await request(`update/${id}`, { method: 'PUT', body: body });
        return resp;
    }

    getInfo() {
        return {
            id: this.#id,
            username: this.#username,
            email: this.#email,
            password: this.#password
        }
    }
}

export { User };