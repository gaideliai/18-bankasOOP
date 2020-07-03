<?php
namespace App;

use App\DB\JsonDb as DB;
use App\App;

class Account {

    public static function createNew() 
    {
        return ['surname' => $_POST['surname'], 'name' => $_POST['name'], 'id' => $_POST['id'], 'account' => $_POST['account'], 'balance' => $_POST['balance']];
    }
    
    public static function generateAccountNumber(array $userData) 
    {
        $IBAN = 'LT';
        foreach (range(1, 2) as $value) {
            $IBAN .= rand(0, 9);
        }
            $IBAN .= '70770';
        foreach (range(1, 11) as $value) {
            $IBAN .= rand(0, 9);
        }
        foreach ($userData as $key => $account) {
            if ($userData[$key]['account'] == $IBAN) {
                generateAccountNumber($userData);
            } 
            else {
                return $IBAN;
            }
        }
        return $IBAN;
    }

    public static function formatIban(string $IBAN) {
        $string = substr($IBAN, 0, 4);
        for ($i=4; $i < strlen($IBAN); $i=$i+4) { 
            $string .= ' ';
            $string .= substr($IBAN, $i, 4);
        }
        return $string;
    }

    public static function formatCurrency(float $balance) {
        $balance = number_format($balance, 2, ',', ' ');
        return $balance;
    }

    public static function sum() {
        $DB = new DB;
        $userData = $DB->show(App::getUriParams()[2]);
        if ($_POST['balance'] > 0) {
            $userData['balance'] += $_POST['balance'];    
            $DB->update(App::getUriParams()[2], $userData);
            $_SESSION['note'] = 'Lėšos įskaitytos į sąskaitą';
        } else {
            $_SESSION['note'] = '<span style="color:red;">Įveskite sumą - teigiamą skaičių</span>';
        }
    }

    public static function substract() {
        $DB = new DB;
        $userData = $DB->show(App::getUriParams()[2]);
        if ($_POST['balance'] <= $userData['balance'] && $_POST['balance'] > 0) {
            $userData['balance'] -= $_POST['balance'];    
            $DB->update(App::getUriParams()[2], $userData);
            $_SESSION['note'] = 'Lėšos nurašytos iš sąskaitos';
        } elseif ($_POST['balance'] < 0) {
            $_SESSION['note'] = '<span style="color:red;">Įveskite sumą - teigiamą skaičių</span>';
        }
         else {
            $_SESSION['note'] = '<span style="color:red;">Sąskaitoje nepakanka lėšų. Operacija neįvykdyta.</span>';
        }
    }


}