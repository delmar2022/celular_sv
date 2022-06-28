<?php
/*Datos de conexion a la base de datos*/
define('DB_HOST', '127.0.0.1'); //DB_HOST:  generalmente suele ser "127.0.0.1"
define('DB_USER', 'root'); //Usuario de tu base de datos
define('DB_PASS', ''); //Contraseña del usuario de la base de datos
define('DB_NAME', 'bdcelular_sv'); //Nombre de la base de datos
class dbConexion
{
	/* Variables de conexion */
	var $dbhost = "localhost";
	var $username = "root";
	var $password = "";
	var $dbname = "bdcelular_sv";
	var $conn;
	//Funcion de conexion MySQL
	function getConexion()
	{
		$con = mysqli_connect($this->dbhost, $this->username, $this->password, $this->dbname) or die("Connection failed: " . mysqli_connect_error());

		/* Revisamos la conexion */
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		} else {
			$this->conn = $con;
		}
		return $this->conn;
	}
}
