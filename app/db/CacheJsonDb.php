<?php
namespace App\DB;

class CacheJsonDb
{

    private $cache;

    public function __construct() {

        if (!file_exists('./../db/cache.json')) {
            file_put_contents('./../db/cache.json', json_encode([]));
        }

        $this->cache = json_decode(file_get_contents('./../db/cache.json'), 1);
    }

    public function create(array $cacheData) : void {
        $this->cache[] = $cacheData;
        $this->save();
    }
 
    // public function update(string $userId, array $cacheData) : void {

    // }
 
    // public function delete(string $userId) : void {

    // }
 
    // public function show(string $userId) : array {

    // }
    
    public function showAll() : array {
        return $this->cache;
    }

    private function save() {
        file_put_contents('./../db/cache.json', json_encode($this->cache));
    }

}