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

    public function getName() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getById() {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->query($query, [ "id" => $this->id ]);
        if($stmt->rowCount() == 0) return false;
        

        $user = $stmt->fetch();
        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;

        return $this;
    }

    public static function getAll() {
        $query = "SELECT * FROM users";
        $stmt = (new \Source\Core\Database())->query($query, []);
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
        $query = "INSERT INTO users(username, email, password) VALUES (:username, :email, :password)";
        $stmt = $this->db->query($query, [
            "email" => $this->email,
            "username" => $this->username,
            "password" => password_hash($this->password, PASSWORD_DEFAULT)
        ]);

        $this->id = $this->db->getLastId();
        return $this;
    }

    public function login() {
        $query = "SELECT * FROM users WHERE email = :email" ;
        $stmt = $this->db->query($query, ["email" => $this->email]);
        if($stmt->rowCount() == 0) return [
            "error" => 'username',
            "logged" => false
        ];


        $user = $stmt->fetch();
        if (password_verify($this->password, $user->password)) return [
            "error" => 'password',
            "logged" => false
        ];
        
        if (!password_verify($this->password, $user->password)) return [
            "id" => $user->id,
            "username" => $user->username,
            "logged" => true
        ];
    }

    public function infoEdit($post, $old) {
        $queryName = "UPDATE users SET username = :username WHERE usersName = :oldName";
        $queryEmail = "UPDATE users SET email = :email WHERE usersEmail = :oldEmail";
        $queryPwd = "UPDATE users SET password = :password WHERE usersPwd = :oldPwd";

        $this->db->query("UPDATE empresas SET usersName = :name WHERE usersName = :oldName");
        $this->db->bind(':name', $data['editName']);
        $this->db->bind(':oldName', $old['oldName']);
        $this->db->execute();

        $this->db->query("UPDATE empresas SET usersEmail = :email WHERE usersEmail = :oldEmail");
        $this->db->bind(':email', $data['editEmail']);
        $this->db->bind(':oldEmail', $old['oldEmail']);
        $this->db->execute();

        $this->db->query("UPDATE empresas SET usersEmpresa = :empresa WHERE usersEmpresa = :oldEmpresa");
        $this->db->bind(':empresa', $data['editEmpresa']);
        $this->db->bind(':oldEmpresa', $old['oldEmpresa']);
        $this->db->execute();

        $this->db->query("UPDATE empresas SET usersPwd = :password WHERE usersPwd = :oldPwd");
        $this->db->bind(':password', $data['editPwd']);
        $this->db->bind(':oldPwd', $old['oldPwd']);
        $this->db->execute();
        
        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

}

       /*
        $query = "SELECT * FROM users WHERE email = :email OR username = :username" ;
        $stmt = $this->db->query($query, [
            "email" => $this->email,
            "username" => $this->name 
        ]);*/