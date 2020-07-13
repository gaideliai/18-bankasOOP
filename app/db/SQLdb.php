<?php
namespace App\DB;

use App\DB\DataBase; 
use PDO;

class SQLdb implements DataBase 
{
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $db   = 'bankas';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

    }

    public function create(array $userData) : void {
        $sql = "INSERT INTO bankas (firstname, lastname, id, account, balance)
        VALUES (:name, :surname, :id, :account, :balance)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($userData);

    }
 
    public function update(int $userId, array $userData) : void {
        $sql = "UPDATE bankas SET firstname=?, lastname=?, id=?, account=?, balance=? WHERE clientID = $userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$userData['firstname'], $userData['lastname'], $userData['id'], $userData['account'], $userData['balance']]);
    }
 
    public function delete(int $userId) : void {
        $sql = "DELETE FROM bankas WHERE clientID = :id";
        $stmt = $this->pdo->prepare($sql);        
        $stmt->execute(['id' => $userId]);        
    }
 
    public function show(int $userId) : array {
        $sql = "SELECT * FROM bankas WHERE clientID = $userId";
        $stmt = $this->pdo->query($sql);
        $row = $stmt->fetch();
        return $row;
    }
    
    public function showAll() : array {
        $sql = "SELECT * FROM bankas";
        $stmt = $this->pdo->query($sql);
        $data = $stmt->fetchAll();
        return $this->sortData($data);
    }

    private function sortData($data) {
        usort($data, [$this, 'sortByKey']);
        return $data;
    }

    public function sortByKey($a, $b) {
        $aa = $a['lastname'];
        $bb = $b['lastname'];
        return strcasecmp($aa, $bb);
    }
    
}