<?php
namespace App;

use App\DB\LogsJsonDB as LogsDB;

class Login
{
    
    private $loginResult = false;

    public function __construct()
    {
        // $logs = json_decode(file_get_contents('./../db/logs.json'), 1);
        $logsDB = new LogsDB;
        $logs = $logsDB->showAll();
        if (!empty($_POST)) {
            foreach ($logs as $user) {
                if ($user['name'] === $_POST['user'] &&
                $user['pass'] === md5($_POST['password'])) {
                    $_SESSION['login'] = 1;
                    $this->loginResult = true;
                }
            }
        }
    }

    public function result()
    {
        return $this->loginResult;
    }

    public static function auth()
    {
        return (isset($_SESSION['login']) && $_SESSION['login'] == 1);
    }

}