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
        if (!$data || !$data["email"] || !$data["password"]) $output["message"] = "Preencha todos os campos";
        else {
            $user = new \Source\Model\User(NULL, NULL, $data["email"], $data["password"]);
            $login = $user->login();
    
            if ($login['logged']) {
                session_start();
                $_SESSION["user"] = $login['username'];
                $output = $login;
                echo json_encode($output);
                exit();
            }
    
            if ($login['error'] == 'username') $output["message"] = "Usuário não encontrado";
            if ($login['error'] == 'password') $output["message"] = 'Senha incorreta';
        }


        echo json_encode($output);
    }

    public function register($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["email"] || !$data["password"] || !$data["username"]) $output["message"] = "Preencha todos os campos";
        else {
            $user = new \Source\Model\User(NULL, $data["username"], $data["email"], $data["password"]);
            $user->insert();

            $output["user"] = $user->getInfo();
        }

        echo json_encode($output);
    }

    public function logout() {
        session_start();
        unset($_SESSION["user"]);
    }

}