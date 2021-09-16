<?php
require_once("Manager.php");

class UsersManager extends Manager{

    //Recup les infos des membres
    public function logIn () {
        $jeanf = 'jeanf';
        $db = $this->dbConnect();
        $user = $db->prepare('SELECT id, username, password, email FROM admin_user WHERE username = :jeanf');
        $user->bindValue(':jeanf', $jeanf, PDO::PARAM_STR);
        $user->execute();
        
        return $user;
    }
    
    public function change_pwd ($password) {
        $db = $this->dbConnect();
        $requ = $db -> prepare ('UPDATE admin_user SET password = :password WHERE username = "jeanf" ');
        $newpwd = $requ->execute(array('password' => $password));
        return $newpwd;
    }
    
    public function pwd_forgotten ($password) {
        $db = $this->dbConnect();
        $requ = $db -> prepare ('UPDATE admin_user SET password = :password WHERE username = "jeanf" ');
        $new_forgotten_pwd = $requ->execute(array('password' => $password));
        return $new_forgotten_pwd;
    }
}


