<?php

namespace App\Models;

use PDO;

class ConnectDB
{
    protected $db = null;
    const USER = "root";
    const PASS = "Q1w2e3r4";
    const HOST = "localhost";
    const DB = "test";
    
    public function __construct() {
        $user = self::USER;
        $pass = self::PASS;
        $host = self::HOST;
        $db = self::DB;
        
        $this->db = new PDO("mysql:dbname=$db;host=$host;charset=UTF8", $user, $pass);
    }
}