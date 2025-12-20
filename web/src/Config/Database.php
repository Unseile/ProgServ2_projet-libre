<?php

//Implémentation de la base de données
namespace Config;

require_once __DIR__ . '/autoloader.php';

use PDO, Exception;
use Utils\Language;

const DATABASE_CONFIGURATION_FILE = __DIR__ . '/database.ini';

class Database
{
    private PDO $pdo;
    private Language $language;


    public function __construct()
    {
        $this->language = new Language();
        $lang = $this->language->getCookieLanguage();
        $translations = $this->language->getContent($lang, 'common_errors');
        
        $config = parse_ini_file(DATABASE_CONFIGURATION_FILE, true);
        if (!$config) {
            throw new Exception($translations['reading_db_config'] . " " . DATABASE_CONFIGURATION_FILE);
        }
        $host = $config['host'];
        $port = $config['port'];
        $database = $config['database'];
        $username = $config['username'];
        $password = $config['password'];
        $this->pdo = new PDO("mysql:host=$host;port=$port;charset=utf8mb4", $username, $password);

        /*$sql = "CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();*/

        $sql = "USE `$database`;";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
    }

    public function getPDO(): PDO
    {
        return $this->pdo;
    }
}
