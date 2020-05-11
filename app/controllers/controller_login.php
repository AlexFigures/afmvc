<?php
Class Controller_login extends Controller {

    private $login;

    function __construct()
    {
        $this->login = new Auth();
    }

    public function action_index()
    {
        if (isset($_POST["login"]) && isset($_POST["pass"])) {
            $username = trim(strip_tags($_POST["login"]));
            $pass = trim(strip_tags($_POST["pass"]));
            $this->login->authUser($username, $pass);
        }
    }

    public function action_logout(){
        $this->login->logOut();
    }

    public function action_reg(){
        if(isset($_POST["mode"])) {
            $mode = $_POST["mode"];

            if($mode == "checkEmail"){
                if(isset($_POST["remail"])){
                    $email = trim(strip_tags($_POST["remail"]));
                    header('Content-type: application/json');
                    echo json_encode(['checkEmail' => $this->login->checkEmail($email)]);
                }
            }

            if($mode == "checkLogin"){
                if(isset($_POST["rusername"])){
                    $username = trim(strip_tags($_POST["rusername"]));
                    header('Content-type: application/json');
                    echo json_encode(['checkLogin' => $this->login->checkLogin($username)]);
                }
            }
        }

        if(isset($_POST["rusername"]) && isset($_POST["password"]) && isset($_POST["remail"])){
            $username = trim(strip_tags($_POST["rusername"]));
            $pass = trim(strip_tags($_POST["password"]));
            $email = trim(strip_tags($_POST["remail"]));

            if($this->login->checkLogin($username) && $this->login->checkEmail($email)) {
                if ($this->login->register($username, $pass, $email)) {
                    $this->login->authUser($username, $pass);
                }
            }
        }

    }


}
