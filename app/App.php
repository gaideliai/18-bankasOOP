<?php
namespace App;

use App\Login;
use App\User;
use App\Account;
use App\DB\LogsJsonDb as LogsDB;
use App\DB\JsonDb as DB;

class App
{
    const DIR = '/uzdaviniai/bankasOOP/public/';
    const VIEW_DIR = './../view/';
    const URL = 'http://localhost/uzdaviniai/bankasOOP/public/';
    
    private static $params = [];
    private static $guarded = ['slaptas-1', 'slaptas-2'];
    // private static $userID = '';


    public static function start()
    {
        session_start();
        $param = str_replace(self::DIR, '', $_SERVER['REQUEST_URI']);
        self::$params = explode('/', $param);
        

        if (count(self::$params) == 2) {
            if (self::$params[0] == 'users') {

                if (self::$params[1] == 'addUser') {
                    $newUser = User::createNew();
                    $db = new LogsDB;        //new LogsJsonDb;
                    // if ()
                    $db->create($newUser);
                    $_SESSION['note'] = 'Valio, pridėtas '.$_POST['user'];
                    self::redirect('users/create');
                }

                if (file_exists(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php')) {
                    require(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php');
                }
            }
            if (self::$params[0] == 'bank') {

                if (self::$params[1] == 'addAccount') {
                    $newAccount = Account::createNew();
                    $db = new DB;
                    $db->create($newAccount);
                    $_SESSION['note'] = 'Pridėta nauja kliento sąskaita';
                    self::redirect('bank/create');
                }

                if (self::$params[1] == 'delete') {
                    $db = new DB;        
                    $db->delete($_POST['delete']);
                    $_SESSION['note'] = 'Ištrinta kliento sąskaita';
                    self::redirect('bank/list');
                }

                if (file_exists(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php')) {
                    require(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php');
                }
            }            
        }
        if (count(self::$params) == 3) {
            if (self::$params[0] == 'bank') {

                if (self::$params[1] == 'add') {
                    if (file_exists(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php')) {
                        require(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php');
                    } 
                }

                if (self::$params[1] == 'addFunds') {
                    $userID = self::$params[2];
                    Account::sum();
                    self::redirect('bank/add/'.$userID);
                }
            }

                           
        }
        
        if (count(self::$params) == 1) {
            if (self::$params[0] == 'doLogin') {

                $login = new Login;
    
                if ($login->result()) {
                    self::redirect('slaptas-1');
                }
                else {
                    self::redirect('login');
                }
            }
    
            if (in_array(self::$params[0], self::$guarded)) {
                if (!Login::auth()){
                    self::redirect('login');
                }
            }

            if (self::$params[0] == 'logout') {
                session_destroy();
                self::redirect('login');
            }

            if (file_exists(self::VIEW_DIR.self::$params[0].'.php')) {
                require(self::VIEW_DIR.self::$params[0].'.php');
            }
        }
      

    }

    public static function getUriParams()
    {
        return self::$params;
    }

    // public static function getUserID()
    // {
    //     return self::$userID;
    // }

    public static function redirect($param)
    {
        header('Location: '.self::URL.$param);
        die();
    }


}