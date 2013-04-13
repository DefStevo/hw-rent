<?php
//Includes 
include "script/globals.s.php";
include "script/db.s.php";

//Variablen deklarieren
$user = "";
$pass = "";

//Session starten
session_start();

//DB Verbindung herstellen
db_connect($db_server,$db_user,$db_pass,$db_database);

//POST Parameter übernehmen
if (isset($_POST["user"]))
{
	//Real_Escape_String gegen SQL-Injection
	$user = $mysqli->real_escape_string($_POST["user"]);	
}

if (isset($_POST["pass"]))
{
	//Real_Escape_String gegen SQL-Injection
	$pass = $mysqli->real_escape_string($_POST["pass"]);	
}

function valid_login($user, $pass)
{
	//Variable setzen		
	$valid = False;
		
	$query_user = "SELECT name FROM " . $GLOBALS["tbl_user"] . " WHERE name='" . $user . "' AND password='" . $pass . "' AND status != 1";
    
	If ($user != "")
	{
		//Session User Zurücksetzen
		$_SESSION["user"] = "";
		
		//Query Ausführen 
		//TODO: Fehlerbehandlung
		$result = db_query($query_user);

		//Schleife über Ergebnis
		while($row = $result->fetch_array())
		{
			//Session Variable zuweisen
	  		$_SESSION["user"] = $row["name"];
		}
	}
	
	//Wenn Session User gesetzt ist
	If (isset($_SESSION["user"]) and ($_SESSION["user"] != ''))
	{
		$valid = True;
	}

	return $valid;
}

function logout()
{
	$_SESSION["user"] = "";	
}

function redirect($page)
{
	$url = "";
	
	//URL ermittlen
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$url = "https://";
	} else {
		$url = "http://";
	}
	$url .= $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	
	$url = substr($url, 0, strrpos ($url, "/", 0) + 1) . $page;
	
	header("Location: " . $url);
}
?>