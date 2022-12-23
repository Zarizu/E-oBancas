<?php

namespace Source\Controller;

class Api {

    public function get($data) {
        header('Content-Type: application/json;');
        $user = new \Source\Model\User($data['id']);
        $user = $user->getById();

        if (!$user) {
            echo json_encode(["message" => "Not found"]);
            return;
        }

        echo json_encode($user->getInfo());
    }

    public function getAll() {
        header('Content-Type: application/json;');
        $users = \Source\Model\User::getAll();
        $data = [];

        if ($users) {
            foreach($users as $user) {
                $data[] = $user->getInfo();
            }
        }

        echo json_encode($data);
    }

    public function login($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["user"] || !$data["password"]) $output["message"] = "Preencha todos os campos";
        else {
            $user = new \Source\Model\User(NULL, NULL, $data["user"], $data["password"]);
            $login = $user->login();
    
            if ($login['logged']) {
                session_start();
                $_SESSION["user"] = $login['id'];
                $output = $login;
                echo json_encode($output);
                exit();
            }
    
            if ($login['error'] == 'username') $output['message'] = 'Usuário não encontrado';
            if ($login['error'] == 'password') $output['message'] = $login['teste'];//'Senha incorreta';
        }


        echo json_encode($output);
    }

    public function register($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["email"] || !$data["password"] || !$data["username"]) $output["message"] = "Preencha todos os campos";
        else {
            $user = new \Source\Model\User(NULL, $data["username"], $data["email"], $data["password"]);
            $register = $user->insert();
            if($register['result']) {
                $output["user"] = $user->getInfo();
                $output['message'] = 'Concluído';
                echo json_encode($output);
                exit();
            }

            if ($register['error'] == 'used') $output['message'] = 'Usuário já existe';
        }

        echo json_encode($output);
    }

    public function editInfo($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["username"] || !$data["email"]  || !$data["password"]) {
            $output["message"] = "Sem alterações";
            echo json_encode($output);
        } 
    
        
        $userName = new \Source\Model\User(NULL, NULL, $data["email"], NULL);
        $userEmail = new \Source\Model\User(NULL, $data["username"], NULL , NULL);
        $userPWd = new \Source\Model\User(NULL, NULL, NULL , $data["password"]);


        if($this->username != $data["username"]) $username = $userName->nameEdit($data["username"]);
        if($this->email != $data["email"]) $email = $userEmail->nameEdit($data["email"]);
        if($this->password != $data["password"]) $pwd = $userPWd->nameEdit($data["password"]);
            
    
        if ($username['result'] && $email['result'] && $pwd['result']) {
            $output['message'] = 'Informações atualizadas com sucesso';
            echo json_encode($output);
            exit();
        } else {
            $output['message'] = 'Coloque valores diferentes';
            echo json_encode($output);
        }
    }

    public function transfer($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["send"] || !$data["receive"]) $output["message"] = "Preencha todos os campos";
        else {
            $user = new \Source\Model\User();
            $transfer = $user->transfer($data["send"], $data["receive"]);
            $output["message"] = $transfer;
            echo json_encode($output);
        }
    }


    public function logout() {
        session_start();
        unset($_SESSION["user"]);
    }

}