<?php

    require_once '../Models/User.php';
    require_once '../Boot/Helpers/session_helper.php';

    class Users {

        private $userModel;
        
        public function __construct(){
            $this->userModel = new User;
        }

        public function register() {
            //Init data
            $data = [
                'usersName' => $_POST['usersName'],
                'usersEmail' => $_POST['usersEmail'],
                'usersEmpresa' => $_POST['usersEmpresa'],
                'usersPwd' => $_POST['usersPwd'],
            ];

            //Validate inputs
            if(empty($data['usersName']) || empty($data['usersEmail']) || empty($data['usersEmpresa']) || 
            empty($data['usersPwd'])){
                flash("register", "Preencha todos os campos");
                redirect("../../Themes/Web/signup.php");
            }
            /*
            if(!preg_match("/^[a-zA-Z0-9]*$/", $data['usersEmpresa'])){
                flash("register", "Invalid username");
                redirect("../../Themes/Web/signup.php");
            }

            if(!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)){
                flash("register", "Invalid email");
                redirect("../../Themes/Web/signup.php");
            }
            
            if(strlen($data['usersPwd']) < 6){
                flash("register", "Invalid password");
                redirect("../../Themes/Web/signup.php");
            } else if($data['usersPwd'] !== $data['pwdRepeat']){
                flash("register", "Passwords don't match");
                redirect("../../Themes/Web/signup.php");
            }*/
        
            //User with the same email or password already exists
            if($this->userModel->findUserByEmailOrUsername($data['usersEmail'], $data['usersName'])){
                flash("register", "Nome ou Email já estão sendo usados");
                redirect("../../Themes/Web/signup.php");
            }

            //Passed all validation checks.
            //Now going to hash password
            
            $data['usersPwd'] = password_hash($data['usersPwd'], PASSWORD_DEFAULT);

            //Register User
            if($this->userModel->register($data)){
                redirect("../../Themes/Web/login.php");
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

            if(empty($data['name/email']) || empty($data['usersPwd'])){
                flash("login", "Preencha todos os dados");
                header("location: ../../Themes/Web/login.php");
                exit();
            }
            //Check for user/email
            if($this->userModel->findUserByEmailOrUsername($data['name/email'], $data['name/email'])){
                //User Found
                $loggedInUser = $this->userModel->login($data['name/email'], $data['usersPwd']);
                if($loggedInUser) {
                    //Create session
                    $this->createUserSession($loggedInUser);
                }else{
                    flash("login", "Senha incorreta");
                    redirect("../../Themes/Web/login.php");
                }
            }else{
                flash("login", "Usuário inexistente");
                redirect("../../Themes/Web/login.php");
            }
        }

        public function createUserSession($user) {
            $saldo = 'R$'.$user->usersSaldo;

            $_SESSION['usersId'] = $user->usersId;
            $_SESSION['usersName'] = $user->usersName;
            $_SESSION['usersEmail'] = $user->usersEmail;
            $_SESSION['usersEmpresa'] = $user->usersEmpresa;
            $_SESSION['usersPwd'] = $user->usersPwd;
            $_SESSION['usersSaldo'] = $saldo;

            $_SESSION['servicos'] = $user->Servicos;
            $_SESSION['funcionarios'] = $user->Funcionarios;
            //$_SESSION['servicos'] = $user->$servicos;
        // $_SESSION['funcionarios'] = $user->$funcionarios;

            redirect("../../index.php");
        }

        public function logout() {
            unset($_SESSION['usersId']);
            unset($_SESSION['usersName']);
            unset($_SESSION['usersEmail']);
            unset($_SESSION['usersEmpresa']);
            unset($_SESSION['usersPwd']);
            unset($_SESSION['usersSaldo']);
            unset($_SESSION['servicos']);
            unset($_SESSION['funcionarios']);
            session_destroy();
            redirect("../../index.php");
        }

        public function trans() {
            $data = [
                'recepiente' => $_POST['recepiente'],
                'valor' => $_POST['valor']
            ];

            if(!empty($data['recepiente']) || !empty($data['valor'])) {
                if($this->userModel->trans($data['recepiente'],$data['valor']) == false) {
                    flash('trans', 'Dinheiro insuficiente');

                }
                ;
            } else {
                flash('trans', 'Preencha todos os campos');
                unset($_POST['funcionario']);
                unset($_POST['valor']);
            }
        }

        public function contrato() {
            $this->userModel = new User;
        }
        
        public function servicos() {
            $data = [
                'titulo' => $_GET['titulo'],
                'desc' => $_GET['desc']
            ];

            if(!empty($data['titulo']) || !empty($data['desc'])) {
                $this->userModel->servico($data['titulo'], $data['desc']);
            } else {
                flash('servicos', 'Preencha todos os campos');
                unset($_GET['funcionario']);
                unset($_GET['desc']);
            }
        }
        
        public function goSignup() {
            redirect("../../Themes/Web/signup.php");
        }

        public function goLogin() {
            redirect("../../Themes/Web/login.php");
        }
    }

    $init = new Users;

    //Ensure that user is sending a post request
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch($_POST['type']) {
            case 'register':
                $init->register();
                break;
            case 'login':
                $init->login();
                break;
            case 'trans':
                $init->trans();
                break;
            case 'contrato':
                $init->contrato();
                break;
            case 'servicos':
                $init->servicos();
                break;
            default:
            redirect("../../index.php");
        }
    } else {
        switch($_GET['q']) {
            case 'logout':
                $init->logout();
                break;
            case 'logout':
                $init->servicos();
                break;
            case 'signup':
                $init->goSignup();
                break;
            case 'login':
                $init->goLogin();
                break;
            default:
            redirect("../../index.php");
        }
    }

    