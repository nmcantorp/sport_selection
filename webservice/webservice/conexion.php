<?php

/**
* Conexion a la base de datos
*/
class ClassConexion
{
	public $host 	= 'localhost';
	/*public $nomBD 	= 'sialen';
	public $user 	= 'root';
	public $pass	= '';*/

	/*public $nomBD 	= 'sialen5_appert';
	public $user 	= 'sialen5_appert';
	public $pass	= 'Appert12345';*/

	//public $host 	= 'localhost';
	public $nomBD 	= 'bc_deportes';
	public $user 	= 'root';
	public $pass	= '';
	
	public $conexion; public $total_consultas;

	public function MySQL(){ 
		if(!isset($this->conexion)){
			$this->conexion = (mysql_connect($this->host,$this->user,$this->pass)) or die(mysql_error());
			mysql_select_db($this->nomBD,$this->conexion) or die(mysql_error());
		}
	}

	public function consulta($consulta){
		$this->total_consultas++; 
		$resultado = mysql_query($consulta,$this->conexion);
		if(!$resultado){ 
			echo 'MySQL Error: ' . mysql_error();
			exit;
		}
		return $resultado;
	}

	public function fetch_array($consulta){
		return mysql_fetch_array($consulta);
	}

	public function num_rows($consulta){
		return mysql_num_rows($consulta);
	}

	public function getTotalConsultas(){
		return $this->total_consultas; 
	}

	public function insert_id(){
		return mysql_insert_id();
	}

	public function close_con(){
		return mysql_close();
	}
}

?>