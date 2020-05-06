<?php
Class Controller_login extends Controller {

    private $login;

    public function action_index()
    {
        $this->login = new Auth();

        if (isset($_POST["login"]) && isset($_POST["pass"])) {

            $username = strip_tags($_POST["login"]);
            $pass = strip_tags($_POST["pass"]);
            $this->login->authUser($username, $pass);

        }
    }

    function action_logout(){
        $this->login = new Auth();
        $this->login->logOut();

        print_r($_COOKIE);
    }

}
