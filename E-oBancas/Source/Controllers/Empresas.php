<?php

    require_once '../Models/Empresa.php';
    require_once '../Boot/Helpers/Supports.php';

    class Empresas {

        private $ModeloEmpresa;
        
        public function __construct(){
            $this->ModeloEmpresa = new Empresa;
        }

        public function register() {
            //Init data
            $data = [
                'usersName' => $_POST['usersName'],
                'usersEmail' => $_POST['usersEmail'],
                'usersEmpresa' => $_POST['usersEmpresa'],
                'usersPwd' => $_POST['usersPwd'],
            ];
            $home = '../../Themes/Web/Empresa/home.php';
            $login = '../../Themes/Web/Empresa/login.php';

            //Validate inputs
            if(empty($data['usersName']) || empty($data['usersEmail']) || empty($data['usersEmpresa']) || empty($data['usersPwd'])){
                flash("register", "Preencha todos os campos");
                redirect($home);
            }
            /*
            if(!preg_match("/^[a-zA-Z0-9]*$/", $data['usersEmpresa'])){
                flash("register", "Invalid username");
                redirect($home);
            }

            if(!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)){
                flash("register", "Invalid email");
                redirect($home);
            }
            
            if(strlen($data['usersPwd']) < 6){
                flash("register", "Invalid password");
                redirect($home);
            } else if($data['usersPwd'] !== $data['pwdRepeat']){
                flash("register", "Passwords don't match");
                redirect($home);
            }*/
        
            //User with the same email or password already exists
            if($this->ModeloEmpresa->findUser($data['usersEmail'], $data['usersName'])){
                flash("register", "Nome ou Email já estão sendo usados");
                redirect($home);
            }

            //Passed all validation checks.
            //Now going to hash password
            
            $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

            //Register User
            if($this->ModeloEmpresa->register($data)){
                redirect($login);
            }else {
                die("Algo deu errado");
            }
        }

        public function edit() {
            //Init data
            $data = [
                'editName' => $_POST['editName'],
                'editEmail' => $_POST['editEmail'],
                'editEmpresa' => $_POST['editEmpresa'],
                'editPwd' => $_POST['editPwd']
            ];
            $old = [
                'oldName' => $_SESSION['usersName'],
                'oldEmail' => $_SESSION['usersEmail'],
                'oldEmpresa' => $_SESSION['usersEmpresa'],
                'oldPwd' => $_SESSION['usersPwd']
            ];
            $home = "../../index.php";
            $oldUser = $this->ModeloEmpresa->findUser($_SESSION['usersName'], $_SESSION['usersName']);

            if(empty($data['editName']) || empty($data['editEmail']) || empty($data['editEmpresa']) || empty($data['editPwd'])){
                flash("edit", "Preencha todos os campos");
            }
        
            if($this->ModeloEmpresa->findUser($data['editEmail'], $data['editName'])){
                flash("edit", "Nome ou Email já estão sendo usados");
            }

            $data['editPwd'] = password_hash($data['editPwd'], PASSWORD_DEFAULT);
            $oldPwd = $oldUser->usersPwd;
            if($oldPwd == $data['editPwd']) {
                flash("edit", "Use uma senha diferente");
            }


            if($this->ModeloEmpresa->edit($data, $old)) {
                $_SESSION['usersName'] = $data['editName'];
                $_SESSION['usersEmail'] = $data['editEmail'];
                $_SESSION['usersEmpresa'] = $data['editEmpresa'];
                $_SESSION['usersPwd'] = $data['editPwd'];
                redirect($home);
            }else {
                die("Algo deu errado");
            }
            
        }
        

        public function login() {
            //Init data
            $data=[
                'name/email' => $_POST['name/email'],
                'usersPwd' => $_POST['usersPwd']
            ];
            $login = '../../Themes/Web/Empresa/login.php';


            if(empty($data['name/email']) || empty($data['usersPwd'])){
                flash("login", "Preencha todos os campos");
                redirect($login);
                exit();
            }
            //Check for user/email
            if($this->ModeloEmpresa->findUser($data['name/email'], $data['name/email'])){
                //User Found
                $loggedInUser = $this->ModeloEmpresa->login($data['name/email'], $data['usersPwd']);
                if($loggedInUser) {
                    //Create session
                    $this->createUserSession($loggedInUser);
                } else {
                    flash("login", "Senha incorreta");
                    redirect($login);
                }
            }else{
                flash("login", "Usuário inexistente");
                redirect($login);
            }
        }

        public function createUserSession($user) {
            $_SESSION['Id'] = $user->IdE;
            $_SESSION['usersName'] = $user->usersName;
            $_SESSION['usersEmail'] = $user->usersEmail;
            $_SESSION['usersEmpresa'] = $user->usersEmpresa;
            $_SESSION['usersPwd'] = $user->usersPwd;
            $_SESSION['usersSaldo'] = $user->usersSaldo;
            $_SESSION['type'] = $user->type;
            $_SESSION['qntEmpregados'] = $this->ModeloEmpresa->qntEmpregados($user->IdE);
            redirect("../../index.php");
        }

        public function logout() {
            unset($_SESSION['Id']);
            unset($_SESSION['usersName']);
            unset($_SESSION['usersEmail']);
            unset($_SESSION['usersEmpresa']);
            unset($_SESSION['usersSaldo']);
            unset($_SESSION['type']);
            session_destroy();
            redirect("../../index.php");
        }

        public function fireUser() {
            $data=[
                'funcionario' => $_POST['funcionario'],
                'empresa' => $_SESSION['usersEmpresa']
            ];

            if($this->ModeloEmpresa->findUser($data['funcionario'], $data['funcionario'])){
                $this->ModeloEmpresa->fireUser($data['funcionario'], $data['empresa']);
            }
        }

        public function hireUser() {
            $data=[
                'funcionario' => $_POST['funcionario'],
                'empresa' => $_SESSION['usersEmpresa']
            ];

            if($this->ModeloEmpresa->findUser($data['funcionario'], $data['funcionario'])){
                $this->ModeloEmpresa->hireUser($data['funcionario'], $data['empresa']);
            }
        }

        public function showAll() {
            $empresaUser = $_SESSION['usersName'];
            $rows = $this->ModeloEmpresa->showAll($empresaUser);



        }

        public function transfer() {
            $data=[
                'receptor' => $_POST['receptor'],
                'doador' => $_SESSION['usersName'],
                'valor' => $_POST['valor']
            ];
            $home = "../../index.php";

            if(empty($data['receptor']) || empty($data['valor'])) {
                flash("transfer", "Preencha todos os campos");
                redirect($home);
                exit();
            }
            if($data['receptor'] == $data['doador']) {
                flash("transfer", "Você");
                redirect($home);
                exit();
            }
            if($this->ModeloEmpresa->findUser($data['receptor'], $data['receptor'])) {
                if($data['valor'] > $_SESSION['usersSaldo']) {
                    flash("transfer", "Dinheiro insuficiente");
                    redirect($home);
                    exit();
                }
                $transfer = $this->ModeloEmpresa->transfer($data['receptor'], $data['doador'], $data['valor']);
                $_SESSION['usersSaldo'] = $transfer;
                flash("transfer", "Transação concluída");
                redirect($home);
                exit();
            } else {
                flash("transfer", "Esse usuário não existe");
                redirect($home);
            }
        }
    }

    $init = new Empresas;
    $home = "../../index.php";

    //Ensure that user is sending a post request
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch($_POST['type']) {
            case 'register':
                $init->register();
                break;
            case 'login':
                $init->login();
                break;
            case 'edit':
                $init->edit();
                break;
            case 'fireUser':
                $init->fireUser();
                break;
            case 'fireUser':
                $init->fireUser();
                break;
            case 'transfer':
                $init->transfer();
                break;
            default:
        redirect($home);
        }
    } else {
        switch($_GET['q']) {
            case 'logout':
                $init->logout();
                break;
            case 'show':
                $init->showAll();
                break;
            default:
            redirect($home);
        }
    }

    