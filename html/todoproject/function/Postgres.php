<?php 
class DBConnectionHandler
{
    private static $serverName;

    private static $userName;

    private static $password;

    private static $db;

    private static $connection = null;

    public static function init()
    {
        static::$serverName =  $_ENV['DB_SERVER_NAME'] ?: 'localhost';
        static::$userName =  $_ENV['DB_USER_NAME'] ?: 'root';
        static::$password =  $_ENV['DB_PASSWORD'] ?: '';
        static::$db =  $_ENV['DB_NAME'] ?: 'todolist';
    }

    public static function setConnection()
    {
        static::init();

        $connectionStr = sprintf(
          "pgsql:host=%s;dbname=%s",
          static::$serverName,
          static::$db
        );

        try {
            $options = [
              PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
              PDO::ATTR_EMULATE_PREPARES => false
            ];
            static::$connection = new PDO($connectionStr, static::$userName, static::$password, $options);
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
