<?php
namespace Application\App;

use Illuminate\Database\Capsule\Manager as DatabaseManager;

class Database {
    private $db;

    public function __construct() {
        $this->db = new DatabaseManager;
    }

    public function connect() {
        $this->db->addConnection(Config::get("database"));
        $this->db->setAsGlobal();
        $this->db->bootEloquent();
        return $this->db->connection();
    }
}