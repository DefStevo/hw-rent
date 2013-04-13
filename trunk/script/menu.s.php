<?php
include "script/globals.s.php";

function create_site_menu()
{
	//Variablen
	$query_menu = "SELECT sort, name, link, page, list, submenu FROM " . $GLOBALS["tbl_menu"] . " ORDER BY sort";
	
	$link_html = "";
	$menu_html = "";	
	
	//Beginn Menu
	$menu_html .= "<ul> \n";
	
	//Query Ausführen 
	//TODO: Fehlerbehandlung
	$result = db_query($query_menu);	
	
	//Schleife über Ergebnis
	while($row = $result->fetch_array())
	{
		$link_html = "";
		
		//Unterscheidung zwischen Menu und Untermenu
		if ($row["submenu"] == 0)
		{			
			//List vorhanden
			If ($row["list"] != NULL)
			{
				$link_html = "<a href='" . $row["link"] . "?list=" . $row["list"] . "'>";
			}
		
			//Page vorhanden
			If ($row["page"] != NULL)
			{
				$link_html = "<a href='" . $row["link"] . "?page=" . $row["page"] . "'>";
			}
				
			//Menueintrag erstellen
			$menu_html .= "        <li class='active '>" . $link_html . "<span>" . $row["name"] . "</span></a></li> \n";
	
		} else {
			//Menueintrag erstellen
			if ($row["page"] != NULL)
			{
				$link_html = "<a href='" . $row["link"] . "?page=" . $row["page"] . "'>";
			} else {
				$link_html = "<a href='#'>";
			}
			
			$menu_html .= "        <li class='has-sub '>" . $link_html . "<span>" . $row["name"] . "</span></a> \n";
			$menu_html .= "          <ul> \n";
			
			//Query für Untermenu erstellen
			$query_submenu = "SELECT desc_short, link, page FROM " . $GLOBALS["tbl_list"] . " WHERE name='" . $row["list"] . "' ORDER BY sort";
			
			$result_sub = db_query($query_submenu);
			
			//Schleife über Ergebnis
			while ($row_sub = $result_sub->fetch_array())
			{
				$menu_html .= "          <li class='active '><a href='" . $row_sub["link"] . "?page=". $row_sub["page"] . "'><span>" . $row_sub["desc_short"] . "</span></a></li> \n";
			}
			
			$menu_html .= "          </ul> \n";	
			$menu_html .= "        </li> \n";	
			
		}
	}
	
	// Ende Menu
	$menu_html .=  "      </ul> \n";
	
	return $menu_html;
}

function create_admin_menu()
{
	//Variablen
	$menu_html = "";
	
	$menu_html .= "<ul> \n";
	$menu_html .= "        <li class='active '><a href='admin.php?content=menu&action=list'><span>Men&Uuml; verwalten</span></a></li> \n";
    $menu_html .= "        <li class='active '><a href='admin.php?content=list&action=list'><span>Listen verwalten</span></a></li> \n";
    $menu_html .= "        <li class='active '><a href='admin.php?content=page&action=list'><span>Inhalte verwalten</span></a></li> \n";
	$menu_html .= "        <li class='active '><a href='admin.php?content=image&action=list'><span>Bilder verwalten</span></a></li> \n";
	$menu_html .= "      </ul> \n";
	$menu_html .= "      <p></p> \n";
	$menu_html .= "      <ul> \n";
	$menu_html .= "        <li class='active '><a href='admin.php?content=user&action=list'><span>Benutzer verwalten</span></a></li> \n";
	$menu_html .= "      </ul> \n";
	$menu_html .= "      <p></p> \n";
	$menu_html .= "      <ul> \n";
	$menu_html .= "        <li class='active '><a href='admin.php?action=logout'><span>Logout</span></a></li> \n";
    $menu_html .= "      </ul> \n";
	
	return $menu_html;
}
?>