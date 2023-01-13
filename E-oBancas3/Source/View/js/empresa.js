class Empresa {
    #id = null;
    #name = null;
    #description = null;
    #worth = null;
    #quantity = null;
    #color = null;

    constructor(
        id = null,
        name = null,
        description = null,
        worth = null,
        quantity = null,
        color = null,
    ) {
        this.#id = id;

        if (name && name != '') this.#name = name;
        
        if (description && description != '') this.#description = description;
        
        if (worth && worth != '') this.#worth = worth;
        
        if (quantity && quantity != '') this.#quantity = quantity;
        
        if (color && color != '') this.#color = color;
    }

    static async getAll() {
        return request('empresa');
    }

    async get() {
        const body = {id: this.#id}
        const resp = await request('getBusiness', { method: 'POST', body: body });
        return resp;
    }

    async create() {
        const body = {
            name: this.#name,
            description: this.#description,
            worth: this.#worth,
            quantity: this.#quantity,
            color: this.#color,
        }
        const resp = await request('empresa', { method: 'POST', body: body });
        if (resp.id) {
            this.#id = resp.id;
        }

        return resp;
    }

    async update() {
        const id = this.#id;
        const body = {};

        if (this.#name) body.name = this.#name;
        
        if (this.#description) body.description = this.#description;
        
        if (this.#worth) body.worth = this.#worth;
        
        if (this.#quantity) body.quantity = this.#quantity;
        
        if (this.#color) body.color = this.#color;
        
        
        const resp = await request(`empresas/${id}`, { method: 'PUT', body: body });

        return resp;
    }

    getInfo() {
        return {
            id: this.#id,
            name: this.#name,
            description: this.#description,
            worth: this.#worth,
            quantity: this.#quantity,
            color: this.#color,
        }
    }
}

export { Empresa };