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
    private static $guarded = ['slaptas-1', 'users', 'bank', 'add', 'deduct'];
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
                    if (strlen($_POST['name']) == 0) {
                        $_SESSION['note'] = '<span style="color:red;">Įveskite vartotojo vardą</span>';
                        self::redirect('users/create');
                    } elseif (strlen($_POST['name']) < 3) {
                        $_SESSION['note'] = '<span style="color:red;">Vartotojo vardą turi sudaryti bent trys simboliai</span>';
                        self::redirect('users/create');
                    } elseif (strlen($_POST['password']) == 0) {
                        $_SESSION['note'] = '<span style="color:red;">Įveskite slaptažodį</span>';
                        $_SESSION['name'] = $_POST['name'];
                        self::redirect('users/create');
                    } else {
                        $db->create($newUser);
                        $_SESSION['note'] = 'Valio, pridėtas '.$_POST['name'];
                        self::redirect('users/create');
                    }
                }

                if (file_exists(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php')) {
                    require(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php');
                }
            }
            if (self::$params[0] == 'bank') {

                if (self::$params[1] == 'addAccount') {
                    
                    if (strlen($_POST['name']) < 3) {
                        $_SESSION['note'] = '<span style="color:red;">Įveskite vardą</span>';
                        $_SESSION['surname'] = $_POST['surname'];
                        $_SESSION['id'] = $_POST['id'];
                        self::redirect('bank/create');
                    } elseif(strlen($_POST['surname']) < 3) {
                        $_SESSION['note'] = '<span style="color:red;">Įveskite vardą ir pavardę</span>'; 
                        $_SESSION['name'] = $_POST['name'];
                        $_SESSION['id'] = $_POST['id'];       
                        self::redirect('bank/create');
                    } elseif(!Account::verifyID($_POST['id'])) {
                        $_SESSION['note'] = '<span style="color:red;">Neteisingai įvestas asmens kodas</span>'; 
                        $_SESSION['name'] = $_POST['name'];
                        $_SESSION['surname'] = $_POST['surname'];       
                        self::redirect('bank/create');
                    }
                    $db = new DB;
                    $data = $db->showAll();
                    foreach ($data as $key => $account) {
                        if ($data[$key]['id'] == $_POST['id'] && $data[$key]['name'] != $_POST['name'] 
                            && $data[$key]['surname'] != $_POST['surname']) {
                            $_SESSION['note'] = '<span style="color:red;">Neteisingai įvestas asmens kodas!</span>';
                            $_SESSION['name'] = $_POST['name'];
                            $_SESSION['surname'] = $_POST['surname'];       
                            self::redirect('bank/create');
                        }
                    }
                    
                    $newAccount = Account::createNew();
                    $db->create($newAccount);
                    $_SESSION['note'] = 'Pridėta nauja kliento sąskaita';
                    self::redirect('bank/create');
                }

                if (self::$params[1] == 'delete') {
                    $db = new DB;
                    $user = $db->show($_POST['delete']);
                    if ($user['balance'] == 0) {
                        $db->delete($_POST['delete']);
                        $_SESSION['note'] = 'Ištrinta kliento sąskaita';
                    } else {
                        $_SESSION['note'] = '<span style="color:red;">Sąskaitos ištrinti nepavyko</span>';
                    }
                    
                    self::redirect('bank/list');
                }

                if (file_exists(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php')) {
                    require(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php');
                }
            }
            if (in_array(self::$params[0], self::$guarded)) {
                if (!Login::auth()){
                    self::redirect('login');
                }
            }            
        }
        if (count(self::$params) == 3) {
            if (self::$params[0] == 'bank') {

                if (self::$params[1] == 'add' || self::$params[1] == 'deduct') {                    
                    if (file_exists(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php')) {
                        require(self::VIEW_DIR.self::$params[0].'/'.self::$params[1].'.php');
                    } 
                }

                if (self::$params[1] == 'addFunds') {
                    $userID = self::$params[2];
                    Account::sum();
                    self::redirect('bank/add/'.$userID);
                }
                if (self::$params[1] == 'deductFunds') {
                    $userID = self::$params[2];
                    Account::substract();
                    self::redirect('bank/deduct/'.$userID);
                }
            }

            if (in_array(self::$params[0], self::$guarded)) {
                if (!Login::auth()){
                    self::redirect('login');
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
                    $_SESSION['note'] = '<span style="color:red;">Neteisingas prisijungimo vardas arba slaptažodis</span>';
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

    public static function redirect($param)
    {
        header('Location: '.self::URL.$param);
        die();
    }


}