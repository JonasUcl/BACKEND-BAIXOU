<?php
class SQLConnection{

	private $Connection = null;
	public $Database = null;
	
	public function Open_Connection()
	{
		if(!isset($this->Database))
			die("Database isn't selected.");
		else
			$this->Connection = @mysql_connect(SERVER, USER, PASS) or die("<b>O banco de dados do site está <span style=\"color:red;\">offline</span>!<br/>Aguarde enquanto os administradores reiniciam o banco de dados!");
		return $this->Connection == true;
	}
	public function Close_Connection()
	{
		if(isset($this->Connection) && is_resource($this->Connection))
			mysql_close($this->Connection);
	}
	public function ExecuteQuery($Query)
	{
		if(!$this->Connection)
			throw new Exception(mysql_error() or mysql_errno());
		mysql_set_charset("UTF8",$this->Connection);
		$DB = mysql_select_db($this->Database, $this->Connection);
		if(!$DB)
			throw new Exception(mysql_error() or mysql_errno());
		$query = mysql_query($Query, $this->Connection);
		if(!$query)
			throw new Exception(mysql_error() or mysql_errno());
		else
			return $query;
	}
	public function Result($Query){
		$query = $this->ExecuteQuery($Query);
		$Result = mysql_result($query,0);
		return $Result;
    }
    public function JSON_ENCODE($Query){
		$SQL_Conn = new SQLConnection();
		$SQL_Conn->Database = DB;
		$SQL_Conn->Open_Connection();
		$Query = $SQL_Conn->ExecuteQuery($Query);
		$rows = array();
		while($row = mysql_fetch_object($Query))
		{
			foreach($row as $key => $col){
			   $col_array[$key] = $col;
			}
			$row_array[] =  $col_array;
	
		}
		return json_encode($row_array);
    }
}
?>