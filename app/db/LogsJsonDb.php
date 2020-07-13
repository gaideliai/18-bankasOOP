<?php
namespace App\DB;

use App\DB\DataBase;
use Ramsey\Uuid\Uuid;

class LogsJsonDB implements DataBase 
{
    private $logs;

    public function __construct() {
        if (!file_exists('./../db/logs.json')) {
            file_put_contents('./../db/logs.json', json_encode([]));
        }

        $this->logs = json_decode(file_get_contents('./../db/logs.json'), 1);
    }

    public function create(array $userData) : void {
        $uuid = (string) Uuid::uuid4();
        $this->logs[$uuid] = $userData;
        $this->save();
    }
 
    public function update(int $userId, array $userData) : void {

    }
 
    public function delete(int $userId) : void {

    }
 
    public function show(int $userId) : array {

    }
    
    public function showAll() : array {
        return $this->logs;
    }

    private function save() {
        file_put_contents('./../db/logs.json', json_encode($this->logs));
    }
}