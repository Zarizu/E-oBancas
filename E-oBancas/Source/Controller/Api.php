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

    public function getUserBusiness($data) {
        header('Content-Type: application/json;');
        $user = new \Source\Model\User(NULL, NULL, NULL, NULL, $data['business']);
        $output = $user->getBusiness();

        echo json_encode($output);
    }

    public function register($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["username"] ||!$data["email"] || !$data["password"]) $output["message"] = "Preencha todos os campos";
        else {
            $user = new \Source\Model\User(NULL, $data["username"], $data["email"], $data["password"]);
            $register = $user->register();
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

    public function login($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["email"] || !$data["password"]) $output["message"] = "Preencha todos os campos";
        else {
            $user = new \Source\Model\User(NULL, NULL, $data["email"], $data["password"]);
            $login = $user->login();
    
            if ($login['logged']) {
                session_start();
                $_SESSION["user"] = $login['id'];
                $output = $login['info'];
                echo json_encode($output);
                exit();
                
            }
            $output = [];
            if ($login['error'] == 'username') $output['message'] = 'Usuário não encontrado';
            if ($login['error'] == 'password') $output['message'] = 'Senha incorreta';
            echo json_encode($output);
        }
    }

    public function update($data) {
        header('Content-Type: application/json;');
        if (!$data || !isset($data["id"])) $output["message"] = "Como tu fez isso";
        else {
            $data["username"] =  isset($data["username"]) ? $data["username"] : null;
            $data["email"] =  isset($data["email"]) ? $data["email"] : null;
            $data["password"] =  isset($data["password"]) ? $data["password"] : null;
            
            $newUser = new \Source\Model\User($data["id"], $data["username"], $data["email"], $data["password"]);
            $resp = $newUser->update();

            if ($resp) {
                echo json_encode([ "message" => "Não funcionou" ]);
                return;
            }

            // $output["a"] = $a;
            $output["newUser"] = $newUser->getInfo();
        }
        echo json_encode($output);
    }

    public function logout() {
        session_start();
        unset($_SESSION["user"]);
    }


    ////////// Businss ///////////////////

    public function getBusiness($data) {
        header('Content-Type: application/json;');
        $business = new \Source\Model\Business($data['id']);
        $business = $business->getById();

        if (!$business) {
            echo json_encode(["message" => "Not found"]);
            return;
        }

        echo json_encode($business->getInfo());
    }

    public function getAllBusiness() {
        header('Content-Type: application/json;');
        $business = \Source\Model\Business::getAll();
        $data = [];

        if ($business) {
            foreach($business as $bs) $data[] = $bs->getInfo();
        }
        
        //echo json_encode($data);

        $response = [
            "code" => 200,
            "type" => "success",
            "message" => "OK",
            "empresas" => $data,
        ];
        echo json_encode($response,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function create($data) {
        header('Content-Type: application/json;');
        if (!$data || !$data["name"]) $output["message"] = "Preencha todos os campos";
        else {
            $business = new \Source\Model\Business(NULL, $data["name"]);
            $create = $business->create();
            if($create['result']) {
                $output["business"] = $business->getInfo();
                $output['message'] = 'Concluído';
                echo json_encode($output);
                exit();
            }
            if ($create['error'] == 'used') $output['message'] = 'Usuário já existe';
        }
        echo json_encode($output);
    }

}