<?php


require_once "Enviroment.php";

Enviroment::load(__DIR__);

class ConnectionPDO {

    public static $instance;

    public function __construct() {

    }

    public static function getInstance() {
        try{

            if (!isset(self::$instance)) {
                self::$instance = new PDO("mysql:host=". getenv('DB_HOST') .";dbname=". getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'), array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            }

            return self::$instance;

        }
        catch(PDOException $pe) {
            echo $pe->getMessage();
        }

    }
}