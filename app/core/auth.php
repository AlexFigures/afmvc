<?php
include_once(SITE_PATH . 'inc' . DS . 'db.php');
Class Auth {

    private $username;
    private $pass;

    static function isAuth() {
        if (isset($_SESSION["is_auth"]) && $_COOKIE['login']) {
            return $_SESSION["is_auth"];
        }
        else return false;
    }

    static function checkRights(){
        if (isset($_SESSION["rights"])){
            return $_SESSION["rights"];
        } else {
            return false;
        }
    }

    public function authUser($username,$pass){
        $this->username = $username;
        $this->pass = $pass;
        global $dbConnection;
        $stmt = $dbConnection->prepare('SELECT username, pass, rights from users where username=:username AND pass=:pass');
        $stmt->execute(array(
            ':username' => $username,
            ':pass' => md5(md5($pass))
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() == 1)
        {
            $_SESSION["is_auth"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["rights"] = $row['rights'];
            $token = bin2hex(random_bytes(16));
            setcookie('login', $token, time()+3600, '/');

            $stmt = $dbConnection->prepare("UPDATE users SET time=now(), uuid=:token WHERE username=:username AND pass=:pass");
            $stmt->execute(array(
                ':username' => $this->username,
                ':pass' => md5(md5($this->pass)),
                ':token' => $token
            ));

        } else {
            $_SESSION["is_auth"] = false;
        }
        header('Content-type: application/json');
        echo json_encode(['is_auth' => $_SESSION['is_auth']]);
    }

    public function register($username,$pass,$email){
        global $dbConnection;
        try{
            $stmt = $dbConnection->prepare('INSERT INTO users (username, pass, uuid, email) VALUES (:username, :pass, :uuid, :email)');
            $stmt->execute(array(
                ':username' => $username,
                ':pass' => md5(md5($pass)),
                ':uuid' => bin2hex(random_bytes(16)),
                ':email' => $email
            ));
        }catch(PDOException $e){
            echo 'Error : '.$e->getMessage();
            exit();
        }
        return true;
    }

    public function checkEmail($email){
        global $dbConnection;
        $stmt = $dbConnection->prepare('SELECT email from users where email=:email');
        $stmt->execute(array(
            ':email' => $email
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() == 1){
            return false;
        } else {
            return true;
        }
        header('Content-type: application/json');
    }

    public function checkLogin($username){
        global $dbConnection;
        $stmt = $dbConnection->prepare('SELECT username from users where username=:username');
        $stmt->execute(array(
            ':username' => $username
        ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() == 1){
            return false;
        } else {
            return true;
        }

    }

    public function logOut() {
        setcookie('login', '', time()-3600, '/');
        $_SESSION = [];
        session_destroy();
    }

}