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
        } elseif ($_POST['balance'] <= 0) {
            $_SESSION['note'] = '<span style="color:red;">Įveskite sumą - teigiamą skaičių</span>';
        }
         else {
            $_SESSION['note'] = '<span style="color:red;">Sąskaitoje nepakanka lėšų. Operacija neįvykdyta.</span>';
        }
    }

    public static function verifyID($number) {
        $id_string = (string)$number;
        # kodas trumpesnis nei 11 skaitmenu
        if (strlen($id_string) < 11) {
            return false;
        }
        # pirmas skaicius nuo 1 iki 6
        if ($id_string[0] < 1 || $id_string[0] > 6) {
            return false;
        }
        # menuo nuo 1 iki 12
        if (substr($id_string, 3, 2) > 12) {
            return false;
        }
        # diena nuo 1 iki 31
        if (substr($id_string, 5, 2) > 31) {
            return false;
        }
        if ($id_string[0] == 5 || $id_string[0] == 6) {
            # ar metai ne velesni uz einamuosius metus
            if (substr($id_string, 1, 2) > date('y')) {
                return false;
            }
            # ar menuo ne velesnis uz einamuju metu einamaji menesi
            if (substr($id_string, 1, 2) == date('y') && substr($id_string, 3, 2) > date('m')) {
                return false;
            }
            # ar diena ne velesne uz einamuju metu ir menesio einamaja diena
            if (substr($id_string, 1, 2) == date('y') && substr($id_string, 3, 2) == date('m')
                    && substr($id_string, 5, 2) > date('d')) {
                return false;
            }
        }
        # kontrolinio skaiciaus tikrinimas
        # suma: S = A*1 + B*2 + C*3 + D*4 + E*5 + F*6 + G*7 + H*8 + I*9 + J*1
        $sum = 0;    
        for ($i=0; $i < 10; $i++) { 
            if ($i == 9) {
                $sum += (int) $id_string[$i]*1;
            } 
            else {
                $sum += (int) $id_string[$i]*($i+1);
            }        
        }
        # kontolinis skaicius = suma / 11, jei liekana nelygi 10
        $remainder = $sum % 11;
        if($remainder != 10 && $id_string[10] != $remainder) {
            return false;
        }
        # jei liekana lygi 10:
        # S = A*3 + B*4 + C*5 + D*6 + E*7 + F*8 + G*9 + H*1 + I*2 + J*3
        if ($remainder == 10) {
            $sum = 0;    
            for ($i=0; $i < 10; $i++) { 
                if ($i >= 7) {
                    $sum += (int) $id_string[$i]*($i-6);
                }
                else {
                    $sum += (int) $id_string[$i]*($i+3);
                }            
            }
        }
        $remainder = $sum % 11;
        if ($remainder != 10 && $id_string[10] != $remainder) {
            return false;
        }
        # jei liekana vel lygi 10, kontrolinis skaicius = 0:
        if ($remainder == 10 && $id_string[10] != 0) {
            return false;
        }
        else {
            return true;
        }
    }


}