<?php
require_once '../Core/Database.php';

class Funcionario {

    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    //Find user by email or username
    public function findUser($email, $username) {
        $this->db->query('SELECT * FROM empresas WHERE usersName = :username OR usersEmail = :email');
        $this->db->bind(':username', $username);
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            $this->db->query('SELECT * FROM funcionarios WHERE usersName = :username OR usersEmail = :email');
            $this->db->bind(':username', $username);
            $this->db->bind(':email', $email);
            $row2 = $this->db->single();


            //Check row
            if($this->db->rowCount() > 0){
                return $row2;
            }else{
                return false;
            }
        }
    }

    //Register User
    public function register($data) {
        $this->db->query("INSERT INTO funcionarios (usersName, usersEmail, usersPwd, usersSaldo, usersEmpresa) 
        VALUES (:name, :email, :password, 0, 0)");
        //Bind values
        $this->db->bind(':name', $data['usersName']);
        $this->db->bind(':email', $data['usersEmail']);
        $this->db->bind(':password', $data['usersPwd']);

        //Execute
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function edit($data, $old) {

        $this->db->query("UPDATE empresas SET usersName = :name WHERE usersName = :oldName");
        $this->db->bind(':name', $data['editName']);
        $this->db->bind(':oldName', $old['oldName']);
        $this->db->execute();

        $this->db->query("UPDATE empresas SET usersEmail = :email WHERE usersEmail = :oldEmail");
        $this->db->bind(':email', $data['editEmail']);
        $this->db->bind(':oldEmail', $old['oldEmail']);
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
