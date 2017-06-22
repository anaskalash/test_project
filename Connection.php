<?php 

/**
  * @author anas kalash
  * @desc connect to database
  **/

include ("Config.php");
/**
* @author Anas Kalash
* @desc Connection class to  prepare the BD link
**/
class Connection {
	
	public $host;
    public $user;
    public $password;
    public $databaseName;
	
	/**
	* Constructor
	*/
	public	function __construct()
	{	
		$this->host 		= Config::HOST_NAME ;
		$this->user			= Config::USERNAME;
		$this->password 	= Config::PASSWORD;
		$this->databaseName = Config::DATABASE_NAME;

	}
	/**
	* The method that make the connection to the database
	*/
	public function connect()
	{
		$con = new mysqli($this->host, $this->user, $this->password, $this->databaseName);
		if(!$con){
			echo "Connect to the database failed";
		}

		session_start();
		return $con;
	}
}