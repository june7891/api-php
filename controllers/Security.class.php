<?php
class Security{
    public static function secureHTML($string){
        return htmlentities($string);
    }

    public static function verifAccessSession(){
        return (!empty($_SESSION['access']) && $_SESSION['access'] === 'loggedUser');
    }

    public static function createUserSession($user){
       
            $_SESSION['id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            $_SESSION['account_created_at'] = $user->account_created_at;
            $_SESSION['firstname'] = $user->firstname;

            header('Location: '.URL."homepage");
    }
}