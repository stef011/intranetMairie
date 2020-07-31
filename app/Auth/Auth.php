<?php 

namespace App\Auth;

use Model\Administrateur;

class Auth 
{
    // public $login;

    /**
     * Returns the current user
     * 
     * @return Administrateur|null
     */
    static function user()
    {
        if(isset($_SESSION['user']))
        {
            return $_SESSION['user'];
        }else{
            return null;
        }
    }

    static function authenticate($credentials)
    {
        $login = $credentials['login'];
        $password = hash("md5", 'PWDKEY' . htmlspecialchars($credentials['password']));

        // var_dump($login .' '. $password);

        $user = Administrateur::filter(['LOGIN_ADMIN' => $login, 'PWD_CRYPT'=> $password]);
        if (empty($user)) {
            header('Location: '. $_SERVER['HTTP_REFERER']);
            exit();
            return false;
        } else{
            $_SESSION['user'] = $user[0];
            return true;
        }
        // die(var_dump($admin));
        // die(var_dump($_SERVER));
    }

    static function logout()
    {
        $_SESSION['user'] = null;
        header('Location: '. $_SERVER['HTTP_REFERER']);
    }
}
