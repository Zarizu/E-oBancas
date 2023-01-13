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
            if ($login['error'] == 'username') $output['message'] = $login;'Usuário não encontrado';
            if ($login['error'] == 'password') $output['message'] = $login;//'Senha incorreta';
            echo json_encode($output);
        }
    }

    public function update($data) {
        header('Content-Type: application/json;');
        if (!$data || !isset($data["id"])) {
            $output = [ "error" => "Must inform a product id" ];
        }
        else {
            $data["name"] =  isset($data["name"]) ? $data["name"] : null;
            $data["description"] =  isset($data["description"]) ? $data["description"] : null;
            $data["price"] =  isset($data["price"]) ? $data["price"] : null;
            $data["quantity"] =  isset($data["quantity"]) ? $data["quantity"] : null;
            
            $product = new \Source\Model\User($data["id"], $data["name"], $data["description"], $data["price"], $data["quantity"]);
            $resp = $product->update();

            if (!$resp) {
                echo json_encode([ "error" => "Not found" ]);
                return;
            }

            // $output["a"] = $a;
            $output["product"] = $product->getInfo();
        }

        echo json_encode($output);
    }

    public function logout() {
        session_start();
        unset($_SESSION["user"]);
    }

}