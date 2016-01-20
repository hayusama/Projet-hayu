<?php
class Database
{

	const DB_HOST = "HOST";
	const DB_DATABASE = "DATABASE";
	const DB_USERNAME = "USERNAME";
	const DB_PASSWORD = "PASS";
	const DB_PORT = "PORT";
	private static $instance = null;
 
   public static function getInstance() {
 
        if (!self::$instance) {
			try{
				self::$instance = new PDO("mysql:host=".self::DB_HOST.";port=".self::DB_PORT.";dbname=".self::DB_DATABASE, self::DB_USERNAME, self::DB_PASSWORD);
				self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance->exec("SET NAMES 'UTF8'");
			}
			catch (PDOException $e) {
				echo 'Erreur : '.$e->getMessage().'<br />';
				echo 'N.: '.$e->getCode().'<br/><br/>';
				echo 'Erreur lors de la connexion à la bdd.';
			}
        }
        return self::$instance;
    }
 
  public static function __callStatic ($method, $args) {
    if (!is_callable(self::getInstance(), $method))
      throw new BadMethodCallException("No such method $method for DB");
 
    return call_user_func_array(array(self::getInstance(), $method), $args);
  }
}
?>