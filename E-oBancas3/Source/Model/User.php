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
        $this->cash = $this->getCash($this->id);

        return $this;
    }

    public function getName() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCash($id) {
        $query = "SELECT cash FROM users WHERE id = :id";
        $stmt = $this->db->execute($query, ["id" => $id]);
        return $stmt;
    }
    public function getBusiness($id) {
        $query = "SELECT (business,boss) FROM users WHERE id = :id";
        $stmt = $this->db->execute($query, ["id" => $id]);
        if($stmt->rowCount() == 0) return false;
        
        $user = $stmt->fetch();
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
            $users[] = new User($user->id, $user->username, $user->email, NULL);
        }
        return $users;
    }

    public function getInfo() {
        return [
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email
        ];
    }

    public function checkUser($user) {
        $query = "SELECT * FROM users WHERE email = :user OR username = :user";
        $stmt = $this->db->execute($query, ["user" => $user]);
        if($stmt->rowCount() == 0) return ["result" => false];
        return [
            "id" => $this->id,
            "username" => $this->username,
            "email" => $this->email,
            "result" => true
        ];
    }

    public function register() {
        if($this->checkUser($this->email)['result'] || $this->checkUser($this->username)['result']) return [
            "error" => "used",
            "result" => false
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

/*
        $user = $stmt->fetch();
        if (password_verify($this->password, $user->password)) $resp =[
            "id" => $user->id,
            "logged" => true,
            "teste" => $user,
        ];
        else $resp =[
            "error" => 'password',
            "logged" => false,
            "senha" => password_hash($this->password, PASSWORD_DEFAULT),
            "senhaUser" => $user->password,
        ];

        return $resp;*/
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
            $sql = "UPDATE users SET $fieldName = :value WHERE id = :id";
            $stmt = $this->db->execute($sql, [
                "value" => $value,
                "id" => $this->id
            ]);
        }
        $this->getById();
        return $this;
    }
}
