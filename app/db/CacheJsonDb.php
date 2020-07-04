<?php
namespace App\DB;

use App\API;

class CacheJsonDb
{

    private $cache;

    public function __construct() {

        if (!file_exists('./../db/cache.json')) {
            file_put_contents('./../db/cache.json', json_encode([]));
        }

        $this->cache = json_decode(file_get_contents('./../db/cache.json'), 1);
    }

    public function create() {
        $rate = API::getRate();
        $this->cache[] = ['rate'=>$rate, 'time'=>time()];
        $this->save();
    }
 
    public function update() {
        foreach ($this->cache as $key => $value) {  
            if (($this->cache[$key]['time'] + 360) < time()) {
                $this->delete($key);
                $this->create();
            }
        } 
    }
 
    public function delete($index) {
        unset($this->cache[$index]);
        $this->save();
    }
 
    // public function show(string $userId) : array {

    // }
    
    public function showAll() : array {
        return $this->cache;
    }

    private function save() {
        file_put_contents('./../db/cache.json', json_encode($this->cache));
    }

}