<?php
namespace App;

class Account {

    public static function createNew() 
    {
        return ['name' => $_POST['name'], 'surname' => $_POST['surname'], 'id' => $_POST['id'], 'account' => $_POST['account'], 'balance' => $_POST['balance']];
    }
    

}