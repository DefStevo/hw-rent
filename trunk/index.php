<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trailer</title>
<link href="style/Layout.css" rel="stylesheet" type="text/css" />
<link href="style/Menu.css" rel="stylesheet" type="text/css" />
<!--[if lte IE 7]>
<style>
.content { margin-right: -1px; } /* Dieser negative Rand mit 1 Pixel hat in jeder Spalte in diesem Layout die gleiche korrigierende Auswirkung. */
ul.nav a { zoom: 1; }  /* Mit der zoom-Eigenschaft erhält IE den Auslöser hasLayout, der erforderlich ist, um den zusätzlichen Leerraum zwischen den Hyperlinks zu korrigieren. */
</style>
<![endif]-->
</head>

<body>
<?php
//Includes
include "script/globals.s.php";
include "script/db.s.php";
include "script/menu.s.php";
include "script/content.s.php";

?>

<div class="container">
  <div class="header">
    <a href="#"><img src="" alt="Hier Logo einfügen" name="Insert_logo" width="100%" height="100px" id="Insert_logo" style="background: #8090AB; display:block;" /></a> 
  </div><!-- end .header -->
  <div class="sidebar">
    <div id='cssmenu'>
      <?php
	    //Variablen
	    $site_menu = "";
		
		//Menü erstellen
	  	$site_menu = create_site_menu();
		
		//Menü anzeigen
		echo $site_menu;
	  ?>
    </div><!--end .cssMenu-->
  </div><!-- end .sidebar-->
  <div class="content">
    <p>
      <?php
		//Variablen
		$page = "";
		$list = "";
		$site_content = "";
		
		//Lese Übergaben PAGE
		if (isset($_GET["page"]))
		{
			$page = $_GET["page"];
		};
		
		//Lese Übergaben LIST
		if (isset($_GET["list"]))
		{
			$list = $_GET["list"];
		};
		
		//Inhalt lesen
		$site_content = create_site_content($page, $list);
		
		//Inhalt anzeigen
		echo $site_content;
	?>
    </p>
  </div><!-- end .content -->
</div><!-- end .container -->
</body>
</html>