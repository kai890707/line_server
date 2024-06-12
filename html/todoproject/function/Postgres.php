<?php 
class DBConnectionHandler
{
    private static $serverName;

    private static $port;

    private static $userName;

    private static $password;

    private static $db;

    private static $connection = null;

    public static function init()
    {
        static::$serverName =  $_ENV['DB_SERVER_NAME'] ?? 'dpg-cp3l3fol6cac73f7s0h0-a.oregon-postgres.render.com';
        static::$port =  $_ENV['DB_PORT']?? '5432';
        static::$userName =  $_ENV['DB_USER_NAME'] ?? 'linebot_root';
        static::$password =  $_ENV['DB_PASSWORD'] ?? 'Sdhnw2kSGhraKAfKV08rpxAyisORljCY';
        static::$db =  $_ENV['DB_NAME'] ?? 'todolist';
    }

    public static function setConnection()
    {
        static::init();

        $connectionStr = sprintf(
          "pgsql:host=%s;port=%s;dbname=%s;sslmode=require",
          static::$serverName,
          static::$port,
          static::$db,
          static::$userName,
          static::$password
        );

        try {
            $options = [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_EMULATE_PREPARES => false
            ];
            static::$connection = new PDO($connectionStr,static::$userName,static::$password,$options);
        } catch(PDOException $e) {
            throw $e;
        }
    }

    public static function getConnection()
    {
      if (is_null(static::$connection)) {
          static::setConnection();
      }
      return static::$connection;
    }
}
?>
