<?php
require_once '../Core/Database.php';

class Empresa {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    //Find user by email or username
    public function findUser($email, $username) {
        $this->db->query('SELECT * FROM empresas WHERE usersName = :username OR usersEmail = :email');
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);
        $empresa = $this->db->single();

        if($this->db->rowCount() > 0){
            return $empresa;
        }else{
            $this->db->query('SELECT * FROM funcionarios WHERE usersName = :username OR usersEmail = :email');
            $this->db->bind(':username', $username);
            $this->db->bind(':email', $email);
            $funcionario = $this->db->single();


            //Check row
            if($this->db->rowCount() > 0){
                return $funcionario;
            }else{
                return false;
            }
        }
    }

    //Register User
    public function register($data) {
        $this->db->query("INSERT INTO empresas (usersName, usersEmail, usersEmpresa, usersPwd, usersSaldo) 
        VALUES (:name, :email, :empresa, :password, 0)");
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
        $row = $this->findUser($nameOrEmail, $nameOrEmail);

        if($row == false) return false;

        $hashedPassword = $row->usersPwd;
        if(password_verify($password, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }

    public function hireUser($nameOrEmail, $empresa) {
        $row = $this->findUser($nameOrEmail, $nameOrEmail);

        if($row == false) return false;
        $funcionario = $row->usersEmpresa;

        if($funcionario == $empresa) return false;

        if($funcionario == 0) {
            $this->db->query("UPDATE funcionarios SET usersEmpresa = :empresa WHERE usersName = :funcionario");
            $this->db->bind(':funcionario', $funcionario);
            $this->db->bind(':empresa', $empresa);
        } else {
            return false;
        }

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function fireUser($nameOrEmail, $empresa) {
        $row = $this->findUser($nameOrEmail, $nameOrEmail);

        if($row == false) return false;
        $funcionario = $row->usersEmpresa;


        if($funcionario == $empresa) {
            $this->db->query("UPDATE funcionarios SET usersEmpresa = 0 WHERE usersName = :funcionario");
            $this->db->bind(':funcionario', $funcionario);
        } else {
            return false;
        }

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function showAll($empresa) {
        $this->db->query('SELECT * FROM funcionarios WHERE usersEmpresa = :empresa');
        $this->db->bind(':empresa', $empresa);

        //Check row
        if($this->db->rowCount() > 0) {
            $funcionarios = $this->db->resultSet();
            echo json_encode($funcionarios);
        }else{
            return false;
        }
    }

    public function transfer($receptor, $doador, $valor) {
        $rowReceptor = $this->findUser($receptor, $receptor);
        $rowDoador = $this->findUser($doador, $doador);
        if($rowReceptor == false || $rowDoador == false) return false;

        $receptor = $rowReceptor->usersName;
        $conta = $rowReceptor->usersSaldo;
        $contaNew = $valor + $conta;
        if($rowReceptor->type == 'funcionario') { 
            $this->db->query("UPDATE funcionarios SET usersSaldo = :contaNew WHERE usersName = :receptor");
            $this->db->bind(':receptor', $receptor);
            $this->db->bind(':contaNew', $contaNew);
            $this->db->execute();
            $doneReceptor = true;
        }
        if($rowReceptor->type == 'empresa') {
            $this->db->query("UPDATE empresas SET usersSaldo = :contaNew WHERE usersName = :receptor");
            $this->db->bind(':receptor', $receptor);
            $this->db->bind(':contaNew', $contaNew);
            $this->db->execute();
            $doneReceptor = true;
        }

        $doador = $rowDoador->usersName;
        $contaSelf = $rowDoador->usersSaldo;
        $contaNewSelf = $contaSelf - $valor;
        if($rowDoador->type == 'funcionario') {
            $this->db->query("UPDATE funcionarios SET usersSaldo = :contaNewSelf WHERE usersName = :doador");
            $this->db->bind(':doador', $doador);
            $this->db->bind(':contaNewSelf', $contaNewSelf);
            $this->db->execute();
            $doneDoador = true;
        }
        if($rowDoador->type == 'empresa') {
            $this->db->query("UPDATE empresas SET usersSaldo = :contaNewSelf WHERE usersName = :doador");
            $this->db->bind(':doador', $doador);
            $this->db->bind(':contaNewSelf', $contaNewSelf);
            $this->db->execute();
            $doneDoador = true;
        }


        if($doneReceptor == true && $doneReceptor == true) {
            return true;
        } else{
            return false;
        }
    }
}
