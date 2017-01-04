
<?php
class DB {
	private static $dbName = 'db_pupuk' ;
	private static $dbHost = 'localhost' ;
	private static $dbUsername = 'root';
	private static $dbUserPassword = '';

	private static $cont  = null;

	public function __construct() {
		die('Init function is not allowed');
	}

	public static function connect()
	{
       // One connection through whole application
		if ( null == self::$cont )
		{

			$opt = array(
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
				PDO::ATTR_EMULATE_PREPARES => FALSE,
				);

			try
			{
				self::$cont =  new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword, $opt); 
			}
			catch(PDOException $e)
			{
				die($e->getMessage()); 
			}
		}
		return self::$cont;
	}

	public static function disconnect()
	{
		self::$cont = null;
	}
}
?>
