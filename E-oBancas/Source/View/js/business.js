class Business {
    #id = null;
    #name = null;
    #slogan = null;
    #worth = null;
    #founder = null;
    #color = null;

    constructor({
        id = null,
        name = null,
        slogan = null,
        worth = null,
        founder = null,
        color = null,
    }) {
        this.#id = id;

        if (name && name != '') this.#name = name;
        
        if (slogan && slogan != '') this.#slogan = slogan;
        
        if (worth && worth != '') this.#worth = worth;
        
        if (founder && founder != '') this.#founder = founder;
        
        if (color && color != '') this.#color = color;
    }

    static async getAll() {
        return request('business');
    }

    async get() {
        const body = {id: this.#id}
        const resp = await request(`business/${id}`);
        return resp;
    }

    async create() {
        const body = {name: this.#name}
        const resp = await request('create', { method: 'POST', body: body });
        if (resp.id) this.#id = resp.id;
        return resp;
    }

    async update() {
        const id = this.#id;
        const body = {};

        if (this.#name) body.name = this.#name;
        
        if (this.#slogan) body.slogan = this.#slogan;
        
        if (this.#worth) body.worth = this.#worth;
        
        if (this.#founder) body.founder = this.#founder;
        
        if (this.#color) body.color = this.#color;
        
        
        const resp = await request(`business/${id}`, { method: 'PUT', body: body });

        return resp;
    }

    getInfo() {
        return {
            id: this.#id,
            name: this.#name,
            slogan: this.#slogan,
            worth: this.#worth,
            founder: this.#founder,
            color: this.#color,
        }
    }
}

export { Business };