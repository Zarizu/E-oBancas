<?php

namespace Source\Model;

class User {
    private $id;
    private $username;
    private $email;
    private $password;

    public function __construct(
        ?int $id = NULL,
        ?string $username = NULL, 
        ?string $email = NULL,
        ?string $password = NULL
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

        return $this;
    }

    public function getName() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCash($user) {
        $query = "SELECT cash FROM users WHERE email = :user OR username = :user";
        $stmt = $this->db->execute($query, ["user" => $user]);
        return $stmt;
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

    public function insert() {
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
        return ["user" => $this, "result" => true];
    }

    public function login() {
        $query = "SELECT * FROM users WHERE email = :email OR username = :username";
        $stmt = $this->db->execute($query, ["email" => $this->email, "username" => $this->username]);
        if($stmt->rowCount() == 0) return [
            "error" => 'username',
            "logged" => false
        ];


        $user = $stmt->fetch();
        if (!password_verify($this->password, $user->password)) return [
            "error" => 'password',
            "logged" => false,
            "teste" => $user
        ];
        
        if (password_verify($this->password, $user->password)) return [
            "id" => $user->id,
            "username" => $user->username,
            "logged" => true,
        ];
    }

    public function nameEdit($username) {
        $query = "UPDATE users SET username = :username WHERE username = :old";
        $stmt = $this->db->execute($query, ["username" => $this->username, "old" => $username]);
        return ["username" => $username, "result" => true];
    }

    public function emailEdit($email) {
        $query = "UPDATE users SET email = :email WHERE email = :old";
        $stmt = $this->db->execute($query, ["email" => $this->email, "old" => $email]);
        return ["email" => $email, "result" => true];

    }

    public function pwdEdit($password) {
        $hash =password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET password = :password WHERE password = :old";
        $stmt = $this->db->execute($query, ["password" => $this->password, "old" => $hash]);
        return ["username" => $hash, "result" => true];

    }

    public function transfer($sent, $receive) {
        $receive = $this->checkUser($receive);
        $self = $this->getCash($this->email);

        if(!$receive['result']) return "Usuário não existe";
        if($sent > $self) return "Dinheiro insuficiente";

        
        $cash = $receive['cash'] + $sent;
        $query = "UPDATE users SET cash = :cash WHERE email = :user OR username = :user";
        $stmt = $this->db->execute($query, ["cash" => $cash, "user" => $receive]);

        $cashSelf = $self - $sent;
        $querySelf = "UPDATE users SET cash = :cash WHERE email = :user OR username = :user";
        $stmt = $this->db->execute($querySelf, ["cash" => $cashSelf, "user" => $this->email]);
        return "Transação concluída";
    }
}
