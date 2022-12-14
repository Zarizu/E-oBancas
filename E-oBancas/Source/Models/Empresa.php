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

        if($this->db->rowCount() > 0) {
            return $empresa;
        }else {
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
        $this->db->query("INSERT INTO empresas (usersName, usersEmail, usersEmpresa, usersPwd) 
        VALUES (:name, :email, :empresa, :password)");
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

    public function edit($data, $old) {
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

    public function hireUser($user, $empresa) {
        $row = $this->findUser($user, $user);

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

    public function getEmpregados($empresa) {
        $this->db->query('SELECT * FROM funcionarios WHERE usersEmpresa = :empresa');
        $this->db->bind(':empresa', $empresa);
        $empregados = $this->db->resultSet();

        if($this->db->rowCount() > 0){
            return $empregados;
        }else{
            return false;
        }
    }

    public function qntEmpregados($empresa) {
        $this->db->query('SELECT * FROM funcionarios WHERE usersEmpresa = :empresa');
        $this->db->bind(':empresa', $empresa);
        $this->db->execute();
        $qntEmpresa = $this->db->rowCount();
        if($qntEmpresa == 0) return 0;

        $this->db->query("UPDATE empresas SET usersEmpregados = :qntEmpresa WHERE idE = :empresa");
        $this->db->bind(':qntEmpresa', $qntEmpresa);
        $this->db->bind(':empresa', $empresa);
        if($this->db->execute()) {
            return $qntEmpresa;
        } else {
            return 0;
        }
    }



    public function showAll($empresaUser) {
        echo 'hdsfghbyihwsdfb';
        $row = $this->findUser($empresaUser, $empresaUser);

        if($row == false) return false;
        if($row->type != 'empresa') return false;

        $empresa = $row->idE;

        $this->db->query('SELECT * FROM funcionarios WHERE usersEmpresa = :empresa');
        $this->db->bind(':empresa', $empresa);
        //Check row
        $rows = $this->db->resultSet();
        if($rows) {
            return $rows;
            //$funcionarios = $this->db->resultSet();
            //echo json_encode($funcionarios);
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


        if($doneReceptor == true && $doneDoador == true) {
            return $contaNewSelf;
        } else{
            return false;
        }
    }
}
