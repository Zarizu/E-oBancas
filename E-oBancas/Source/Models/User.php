<?php
require_once '../Core/Database.php';

class User {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    //Find user by email or username
    public function findUserByEmailOrUsername($email, $username) {
        $this->db->query('SELECT * FROM admins WHERE usersName = :username OR usersEmail = :email');
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        //Check row
        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    //Register User
    public function register($data) {
        $this->db->query("INSERT INTO admins (usersName, usersEmail, usersEmpresa, usersPwd, usersSaldo, servicos, funcionarios) 
        VALUES (:name, :email, :empresa, :password, 0, '','')");
        //Bind values
        $this->db->bind(':name', $data['usersName']);
        $this->db->bind(':email', $data['usersEmail']);
        $this->db->bind(':empresa', $data['usersEmpresa']);
        $this->db->bind(':password', $data['usersPwd']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //Login user
    public function login($nameOrEmail, $password) {
        $row = $this->findUserByEmailOrUsername($nameOrEmail, $nameOrEmail);

        if($row == false) return false;

        $hashedPassword = $row->usersPwd;
        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }

    public function trans($recepiente, $valor) {
        $row = $this->findUserByEmailOrUsername($recepiente, $recepiente);
        if($row == false) return false;
        if($row){
            return $row;
        }

        $selfName = $_SESSION['usersName'];
        $selfSaldo = $_SESSION['usersSaldo'] - $valor;
        $envio = $row->usersSaldo + $valor;

        if($envio > $_SESSION['usersSaldo']) {
            return false;
        }

        $this->db->query('UPDATE admins SET usersSaldo = :envio WHERE usersName = :recepiente;
        UPDATE admins SET usersSaldo = :selfSaldo WHERE usersName = :selfName;');
        $this->db->bind(':recepiente', $recepiente);
        $this->db->bind(':envio', $envio);
        $this->db->bind(':selfName', $selfName);
        $this->db->bind(':selfSaldo', $selfSaldo);


        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function contrato($funcionario) {
        $row = $this->findUserByEmailOrUsername($funcionario, $funcionario);
        if($row == false) return false;
        if($row){
            return $row;
        }

        $data = [
            'Nome' => $row->usersName,
            'Email' => $row->usersEmail,
            'Saldo' => $row->usersSaldo,
        ];
        $newData = json_decode($row->funcionarios);
        $newData[] = $data;
        
        $this->db->query("INSERT INTO admins (funcionarios)
        VALUES :newData");
        //Bind values
        $this->db->bind(':newData', json_encode($newData));

        //Execute
        if($this->db->execute()) {
            return $newData;
        }else{
            return false;
        }
    }

    public function servico($titulo, $desc) {

        $data = [
            'Titulo' => $titulo,
            'Desc' => $desc
        ];
        $newData = json_decode($_SESSION['servicos']);
        $newData[] = $data;
        
        $this->db->query("INSERT INTO admins (servicos)
        VALUES :newData");
        //Bind values
        $this->db->bind(':newData', json_encode($newData));

        //Execute
        if($this->db->execute()) {
            return $newData;
        }else{
            return false;
        }
    }
    
}
