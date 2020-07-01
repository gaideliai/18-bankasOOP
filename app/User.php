<?php
namespace App;

// use App\DB\JsonDb;

class User {

    public static function createNew() 
    {
        return ['name' => $_POST['user'], 'pass' => md5($_POST['password'])];
    }
    

}