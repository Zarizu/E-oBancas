<?php

namespace Source\Model;

class User {
    private $id;
    private $username;
    private $email;
    private $password;
    private $business;
    private $boss;
    private $cash;
    private $db;


    public function __construct(
        int $id = NULL,
        string $username = NULL, 
        string $email = NULL,
        string $password = NULL
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;

        $this->db = new \Source\Core\Database();
    }

    public function getById() {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->execute($query, [ "id" => $this->id ]);
        if($stmt->rowCount() == 0) return false;
        

        $user = $stmt->fetch();
        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->cash = $user->cash;
        $this->business = $user->business;
        $this->boss = $user->boss;

        return $this;
    }

    public static function getAll() {
        $query = "SELECT * FROM users";
        $stmt = (new \Source\Core\Database())->execute($query, []);
        if($stmt->rowCount() == 0) return false; 

        $users = [];
        while($user = $stmt->fetch()) {
            $users[] = new User(
                $user->id,
                $user->username, 
                $user->email, 
                NULL,
                $user->business,
                $user->boss,
                $user->cash,
            );
        }
        return $users;
    }

    public function getBusiness() {
        $query = "SELECT * FROM business WHERE id = :business";
        $stmt = $this->db->execute($query, ["id" => $this->business]);
        if($stmt->rowCount() == 0) return false;
        
        $user = $stmt->fetch();
        
        return [
            "id" => $user->id,
            "name" => $user->name,
            "slogan" => $user->slogan,
            "worth" => $user->worth,
            "founder" => $user->founder,
            "color" => $user->color,
        ];
    }

    public function getInfo() {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email,
        ];
    }

    public function register() {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->execute($query, ["email" => $this->email]);
        if(!$stmt->rowCount() == 0) return [
            "result" => false,
            "error" => "used",
        ];

        $query = "INSERT INTO users(username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->execute($query, [
            "email" => $this->email,
            "username" => $this->username,
            "password" => password_hash($this->password, PASSWORD_DEFAULT)
        ]);

        $this->id = $this->db->getLastId();
        return ["user" => $stmt->fetch(), "result" => true];
    }

    public function login() {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->execute($query, ["email" => $this->email]);
        $user = $stmt->fetch();
        if($stmt->rowCount() == 0) return [
            "error" => 'username',
            "logged" => false,
            "teste" => $this->email,
        ];
        else return [
            "id" => $user->id,
            "logged" => true,
            "info" => $user,
        ];

        $user = $stmt->fetch();
        if (password_verify($this->password, $user->password)) return[
            "id" => $user->id,
            "logged" => true,
            "teste" => $user,
            "senha" => $this->password,
        ];
        else return[
            "error" => 'password',
            "logged" => false,
            "senha" => $this->password,
            "senhaUser" => $user->password,
        ];
    }

    public function update() {
        $fields = [];

        if (isset($this->username)) {
            $fields[] = [
                "name" => "username",
                "value" => $this->username
            ];
        }
        if (isset($this->email)) {
            $fields[] = [
                "name" => "email",
                "value" => $this->email
            ];
        }
        if (isset($this->password)) {
            $fields[] = [
                "name" => "password",
                "value" => $this->password
            ];
        }

        foreach($fields as $field) {
            $fieldName = $field["name"];
            $value = $field["value"];
            $query = "UPDATE users SET $fieldName = :value WHERE id = :id";
            $stmt = $this->db->execute($query, [
                "value" => $value,
                "id" => $this->id
            ]);
            if($stmt->rowCount() == 0) return["result" => false];
        }
        
        $this->getById();
        return["result" => $this];
    }
}
