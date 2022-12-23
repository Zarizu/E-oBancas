# Projeto PW2 - Exemplo de rotas

Este projeto é serve de base para os alunos da disciplina de PW2 para trabalhar com rotas em um modelo MVC na linguagem PHP. É o mesmo exemplo visto em aula. 

## Requisitos

* Saber usar o básico do github.
* Possuir um servidor web rodando na máquina.
* PHP versão 7+.
* Servidor MySQL rodando na máquina.
* Possuir o [composer](https://getcomposer.org/) instalado.

## Instalando

Clone o repositório em sua máquina

```
git clone https://github.com/werlang/routes_sample.git
```

Instale as dependências usando o composer

```
composer update
```

Renomeie o arquivo `config.json.example` para `config.json`. Então preencha as informações no arquivo de acordo com as informações necessárias para conectar ao seu banco de dados.

```json
{
    "mysql": {
        "host": "localhost",
        "database": "aula_pw2",
        "user": "root",
        "password": "asdf1234"
    }
}
```

Crie a tabela users no seu banco de dados. Use o script `database.sql` nesta pasta.

```
mysql
USE aula_pw2;
SOURCE database.sql
```

Pronto!