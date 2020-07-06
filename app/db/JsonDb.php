<?php
namespace App\DB;

use App\DB\DataBase;
use Ramsey\Uuid\Uuid;

class JsonDB implements DataBase 
{
    private $data;

    public function __construct() {
        if (!file_exists('./../db/data.json')) {
            file_put_contents('./../db/data.json', json_encode([]));
        }

        $this->data = json_decode(file_get_contents('./../db/data.json'), 1);
    }

    public function create(array $userData) : void {
        $uuid = (string) Uuid::uuid4();
        $this->data[$uuid] = $userData;
        $this->save();
    }
 
    public function update(string $userId, array $userData) : void {
        foreach ($this->data as $key => $value) {
            if ($userId == $key) {
                $this->data[$key] = $userData;
            }
        }
        $this->save();
    }
 
    public function delete(string $userId) : void {
            unset($this->data[$userId]);
            $this->save();
    }
 
    public function show(string $userId) : array {
        foreach ($this->data as $key => $value) {
            if ($key == $userId) {
                return $value;
            }
        }
    }
    
    public function showAll() : array {
        asort($this->data);
        return $this->data;
    }

    private function save() {
        file_put_contents('./../db/data.json', json_encode($this->data));
    }

    
}