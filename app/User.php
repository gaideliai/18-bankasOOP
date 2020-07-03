<?php
namespace App;

// use App\DB\JsonDb;

class User {

    public static function createNew() 
    {
        return ['name' => $_POST['name'], 'pass' => md5($_POST['password'])];
    }
    

}