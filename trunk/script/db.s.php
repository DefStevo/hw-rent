<?php
include "script/globals.s.php";

$mysqli = new MySQLi();

//DB Verbindung herstellen
db_connect($GLOBALS["db_server"],$GLOBALS["db_user"],$GLOBALS["db_pass"],$GLOBALS["db_database"]);

function sql_escape($string)
{
	global $mysqli;
	
	$sql_escape = "";
	
	$sql_escape = $mysqli->real_escape_string($string);	
	
	return $sql_escape;
}
function db_connect($host, $user, $pass, $db)
{
	global $mysqli;
    $mysqli = new mysqli($host, $user, $pass, $db);
    
    if ($mysqli->connect_error) 
    {
        //echo "DB Verbindung Fehler: " . mysqli_connect_error();
		return false;
    } else {
		//echo "DB Verbindung OK";
    	return true;
    }
}

function db_get_error()
{
	global $mysqli;
	return $mysqli->error;
}

function db_affacted_rows()
{
	global $mysqli;
	return $mysqli->affected_rows;
}

function db_query($query)
{
	global $mysqli;	
	$result = $mysqli->query($query);
	return $result;
}

function db_disconnect()
{
	global $mysqli;
	$mysqli->close();
}
?>