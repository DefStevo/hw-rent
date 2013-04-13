<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>hw-rent - Admin</title>
<link href="style/Layout.css" rel="stylesheet" type="text/css" />
<link href="style/Menu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
  <div class="header">  
  <p height="100px">
<?php
//Includes
include "script/globals.s.php";
include "script/login.s.php";
include "script/menu.s.php";
include "script/content.s.php";

//Logout
if (isset($_GET["action"]) and $_GET["action"] == "logout")
{
	redirect("login.php?action=logout");	
}

//Check Login
if (valid_login($user, $pass) and $_SESSION["user"] != "")
{
  //Login valid, Echo Username
  echo "<h1>Adminpage User: " . $_SESSION["user"] . "</h1>";
} else {
	//Redirect (Login)
	redirect("login.php");
}
?>
  </p>
  </div><!-- end .header -->
  <div class="sidebar">
    <div id='cssmenu'>
      <?php
	    //Varialben
		$admin_menu = "";
		
		//Menü erstellen
		$admin_menu = create_admin_menu();
		
		//Menü anzeigen
		echo $admin_menu;
	  ?>
    </div><!--end .cssMenu-->
  </div><!-- end .sidebar-->
  <div class="content">
  <p>
  <?php
	//Variablen
	$admin_content = "";
	
	{ //Region GET Variablen
	$content = "";
	$action = "";
	$id = "";
	$info = "";
	
	//Lese Übergaben CONTENT
	if (isset($_GET["content"]))
	{
		$content = $_GET["content"];
	};
	
	//Lese Übergaben ACTION
	if (isset($_GET["action"]))
	{
		$action = $_GET["action"];
	};
		
	//Lese Übergaben ID
	if (isset($_GET["id"]))
	{
		$id = $_GET["id"];
	};
	
	//Lese Übergabe Info
	if (isset($_GET["info"]))
	{
		$info = $_GET["info"];
	};
	
	} //END GET Variablen
		
	//Inhalt lesen
	$admin_content = create_admin_content($content, $action, $id, $info);
		
	//Inhalt anzeigen
	echo $admin_content;
	?>
  </p>
  </div><!-- end .content -->
</div><!-- end .container -->
</body>
</html>