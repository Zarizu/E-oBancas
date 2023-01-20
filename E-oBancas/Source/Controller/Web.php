<?php

namespace Source\Controller;

class Web {
    public function __construct($path) {
        $this->view = new \Source\Core\View('/Source/View');
    }

    public function home() {
        // include __DIR__ . "/../View/index.html";
        $this->view->render('home', []);
    }

    public function register() {
        $this->view->render('register', []);
    }

    public function profile() {     
        session_start();
        if (isset($_SESSION["user"])) {
            $this->view->render('profile', []);
            return;
        }
        header("Location:home");        
    }

    public function bank() {
        $this->view->render('bank', []);
    }

    public function business() {
        $this->view->render('business', []);
    }
}