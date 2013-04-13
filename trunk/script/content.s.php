<?php
include "script/globals.s.php";

function create_site_content($page="", $list="")
{
	//Variablen
	$content_html = "";
	
	//Standardpage setzen
	if (($list == "") and ($page == ""))
	{
		$page = "home";
	}	
	$query_page = "SELECT html FROM " . $GLOBALS["tbl_page"] . " WHERE name = '" . $page . "'";
	$query_list = "SELECT desc_short, desc_long, link, page, link_picture FROM " . $GLOBALS["tbl_list"] . " WHERE name = '" . $list . "' ORDER BY sort";
	
	//Page oder Link erstellen
	if ($list != "")
	{
		//Query ausführen
		$result = db_query($query_list);

		$content_html .= "<table boarder='0'> \n";
		
		//Schleife über Ergebnis
		while($row = $result->fetch_array())
		{
			$content_html .= "      <tr> \n";
			$content_html .= "        <td><a href='" . $row["link"] . "?page=" . $row["page"] . "'><span>" . $row["desc_short"] . "</span></a></td> \n";
			$content_html .= "        <td>" . $row["desc_long"] . "</td> \n";
			$content_html .= "        <td>" . $row["link_picture"] . "</td> \n";
			$content_html .= "      </tr> \n";
		}
		
		$content_html .= "    </table> \n";
	}
	if ($page != "")
	{
		//Query ausführen
		$result = db_query($query_page);
		
		//Schleife über Ergebnis
		while($row = $result->fetch_array())
		{
			$content_html = $row["html"];
		}
	}
	
	return $content_html;	
	
}

function create_admin_content($content="", $action="", $id="", $info="", $in_name="")
{
	//
	//CONTENT
	// menu
	// list
	// page
	// image
	// user
	//
	//ACTION
	// list = Anzeigen
	// edit = Bearbeiten
	// add = Neues Element
	// save = Speichern
	// delete = Löschen
	//
	//ID
	// id des Inhaltes (Menü/Liste/Seite/Bild/User)
	
	//Variablen
	$content_html = "";
	
	if ($content == "" and $action == "" and $id == "")
	{
		$content_html .= "<p></p> \n";
	} else {	
	
		switch($content)
		{
			//Menü
			case "menu":
				switch($action)
				{
					//Auflisten
					case "list":
						$content_html .= list_admin_menu($info);
					break;
					
					//Hinzufügen
					case "add":
						$content_html .= add_admin_menu();
					break;
					
					//Bearbeiten
					case "edit":
						$content_html .= edit_admin_menu($id);
					break;
					
					//Löschen
					case "delete":
						$content_html .= delete_admin_menu($id);
					break;
					
					//Speichern
					case "save":
						$content_html .= save_admin_menu($id);
					break;
					
					//Reihenfolge hoch
					case "up":
						$content_html .= up_admin_menu($id);
					break;
					
					//Reihenfolge runter					
					case "down":
						$content_html .= down_admin_menu($id);
					break;
				}
			break;
		}		
	}
	
	return $content_html;
}

{ //Region Menü
function list_admin_menu($info = "")
{
	//Variablen
	$content_html = "";
	$query_list_menu = "Select id, sort, name, link, page, list, submenu from " . $GLOBALS["tbl_menu"] . " order by sort";
	$result = "";
	$row_num = 0;
	$num_rows = 0;
	
	//DB Abfrage
	$result = db_query($query_list_menu);
	
	//Anzahl Zeilen ermitteln
	$num_rows = $result->num_rows;
	
	//Fehlerausgabe
	If ($info != "")
	{
		$content_html .= "  <p><b>" . $info . "</b></p>\n";
	}
	
	//Header
	$content_html .= "  <table boarder='1'> \n";
	$content_html .= "      <tr> \n";
	$content_html .= "        <th><span>id</span></th>\n";
	$content_html .= "        <th><span>sort</span></th>\n";
	$content_html .= "        <th><span>name</span></th>\n";
	$content_html .= "        <th><span>link</span></th>\n";
	$content_html .= "        <th><span>page</span></th>\n";
	$content_html .= "        <th><span>list</span></th>\n";
	$content_html .= "        <th><span>submenu</span></th>\n";
	$content_html .= "        <th><span> </span></th>\n";
	$content_html .= "        <th><span> </span></th>\n";
	$content_html .= "        <th><span> </span></th>\n";
	$content_html .= "        <th><span> </span></th>\n";
	$content_html .= "        <th><span> </span></th>\n";
	$content_html .= "      </tr> \n";

	//Schleife über Ergebnis
	while($row = $result->fetch_array())
	{
		//Zeilenzähler erhöhen
		$row_num += 1;
				
		$content_html .= "      <tr> \n";
		$content_html .= "        <td><span>" . $row["id"] . "</span></td>\n";
		$content_html .= "        <td><span>" . $row["sort"] . "</span></td>\n";
		$content_html .= "        <td><span>" . $row["name"] . "</span></td>\n";
		$content_html .= "        <td><span>" . $row["link"] . "</span></td>\n";
		$content_html .= "        <td><span>" . $row["page"] . "</span></td>\n";
		$content_html .= "        <td><span>" . $row["list"] . "</span></td>\n";
		$content_html .= "        <td><span>" . $row["submenu"] . "</span></td>\n";
		$content_html .= "        <td><span></span></td>\n";
		$content_html .= "        <td><a href='admin.php?content=menu&action=edit&id=" . $row["id"] . "'><img src='images/edit.png' alt='edit'></a></td>\n";
		$content_html .= "        <td><a href='admin.php?content=menu&action=delete&id=" . $row["id"] . "'><img src='images/delete.png' alt='edit'></a></td>\n";
		
		//Button Up wird in 1. Zeile nicht angezeigt
		if ($row_num == 1)
		{
			$content_html .= "        <td><span> </span></td>\n";
		} else {
			$content_html .= "        <td><a href='admin.php?content=menu&action=up&id=" . $row["id"] . "'><img src='images/up.png' alt='up'></a></td>\n";
		}
		
		//Button Down wird in letzter Zeile nicht angezeigt
		if ($row_num == $num_rows)
		{
			$content_html .= "        <td><span> </span></td>\n";
		} else {
			$content_html .= "        <td><a href='admin.php?content=menu&action=down&id=" . $row["id"] . "'><img src='images/down.png' alt='down'></a></td>\n";
		}
				
		$content_html .= "      </tr>\n";
	}
		
	$content_html .= "    </table>\n";
	
	//Buttons zum hinzufügen
	$content_html .= "    <p></p>\n";
	$content_html .= "    <a href='admin.php?content=menu&action=add&id=0'><img src='images/add.png' alt='add'></a>\n";
	
	return $content_html;

}

function add_admin_menu()
{
	//Variablen
	$content_html = "";
	$result = "";
	$query_list = "Select name from " . $GLOBALS["tbl_list"] . " group by name";
	$query_page = "Select name from " . $GLOBALS["tbl_page"];
	
	$content_html .= "<h1>Neuen Menüeintrag anlegen</h1>\n";
	
	$content_html .= "  <form action='admin.php?content=menu&action=save&id=0' method='POST'>\n";
	
	$content_html .= "    <p>Name: <input type='text' name='in_name' value='' /></p>\n";
	$content_html .= "    <p>Link: <input type='text' name='in_link' value='index.php' /></p>\n";
	$content_html .= "    <p>Liste: <select name='in_list'>\n";
	$content_html .= "      <option value='null'></option>\n";
	
	//Listen ermitteln
	//DB Abfrage
	$result = db_query($query_list);
	
	//Schleife über Ergebnis
	while($row = $result->fetch_array())
	{
		$content_html .= "      <option value='". $row["name"] . "'>" . $row["name"] . "</option>\n";
	}
	
	$content_html .= "    </select>\n";
	
	$content_html .= "    <p>Seite: <select name='in_page'>\n";	
	$content_html .= "      <option value='null'></option>\n";
	
	//Seiten ermitteln
	//DB Abfrage
	$result = db_query($query_page);
	
	//Schleife über Ergebnis
	while($row = $result->fetch_array())
	{
		$content_html .= "      <option value='". $row["name"] . "'>" . $row["name"] . "</option>\n";
	}
	
	$content_html .= "    </select>\n";
	
	$content_html .= "    <p><input type='checkbox' name='in_submenu' value='1' />Untermenü</p>\n";
	
	
	$content_html .= "    <p><input type='submit' value='Speichern' /></p>\n";
	
	$content_html .= "  </form>\n";
	
	return $content_html;
}

function edit_admin_menu()
{
	//Variablen
	$content_html = "";
	$content_html .= "<h1>Menu EDIT</h1>";
	
	return $content_html;
}

function save_admin_menu($id)
{
	//Variablen
	$content_html = "";
	$in_sort = "";
	$in_name = "";
	$in_link = "";
	$in_list = "";
	$in_page = "";
	$in_submenu = "0";
	
	$result = "";
	$query_select = "";
	$query_insert = "";
	$query_update = "";
	
	//POST Variablen auslesen
	If (isset($_POST["in_sort"]))
	{
		$in_sort = $_POST["in_sort"];
	}
	
	If (isset($_POST["in_name"]))
	{
		$in_name = $_POST["in_name"];
	}
	
	If (isset($_POST["in_link"]))
	{
		$in_link = $_POST["in_link"];
	}
	
	If (isset($_POST["in_page"]) and $_POST["in_page"] != "null")
	{
		$in_page = $_POST["in_page"];
	}
	
	//Liste kann nur verwendet werden wenn Page nicht angegeben
	If (isset($_POST["in_list"]) and $_POST["in_list"] != "null" and $in_page == "")
	{
		$in_list = $_POST["in_list"];
	}
	
	//Submenu kann nur bei Liste verwendet werden
	If (isset($_POST["in_submenu"]) and $in_list != "")
	{
		$in_submenu = $_POST["in_submenu"];
	}
	
	If ($id == 0)
	{
		//Insert
		$query_select = "Select max(id) + 1 as next_id, max(sort) + 1 as next_sort from " . $GLOBALS["tbl_menu"];
		
		//DB Abfrage
		$result = db_query($query_select);
		
		//Schleife über Ergebnis
		while($row = $result->fetch_array())
		{
			$in_id = $row["next_id"];
			$in_sort = $row["next_sort"];
		}
		
		//Insert zusammenstellen
		$query_insert = "INSERT INTO " . $GLOBALS["tbl_menu"] . " (id, sort, name, link, list, page, submenu) \n";
		$query_insert .= "VALUES (" . $in_id . ", " . $in_sort . ", '" . $in_name . "', '" . $in_link . "', '" . $in_list . "', '" . $in_page . "', '" . $in_submenu . "')";
		
		//Insert durchführen
		db_query($query_insert);
		
		//redirect
		if (db_affacted_rows() == 0)
		{
			redirect("admin.php?content=menu&action=list&info=" . db_get_error());
		} else {
			redirect("admin.php?content=menu&action=list");
		}
		
	} else {
		//Update
	}
	
}

function delete_admin_menu($id)
{
	//Variablen
	$info = "";
	$result = "";
	$query_delete = "Delete from " . $GLOBALS["tbl_menu"] . " where id = " . $id;
	$query_select = "Select id from " . $GLOBALS["tbl_menu"] . " order by sort";
	$query_update = "";
	$id_update;
	$sort_update = 0;
	
	//Datensatz löschen
	$result = db_query($query_delete);
	
	echo $query_delete . "\n";
		
	if (db_affacted_rows() == 0)
	{
		$info = "Fehler: Datensatz (ID " . $id . ") konnte nicht gelöscht werden";
	} else {
		//Neu ordnen
		
		//Daten selektieren
		$result = db_query($query_select);
		
		//Schleife über Ergebnis
		while($row = $result->fetch_array())
		{
			$id_update = $row["id"];
			$sort_update += 1;
						
			$query_update = "Update " . $GLOBALS["tbl_menu"] . " set sort = " . $sort_update . " where id = " . $id_update;
			
			db_query($query_update);
		}
			
	}
	
	//Seite neu laden
	if ($info == "")
	{
		redirect("admin.php?content=menu&action=list");
	} else {
		redirect("admin.php?content=menu&action=list&info=" . $info);
	}
}

function up_admin_menu($id)
{
	//Variablen
	$sort = 0;
	$sort2 = 0;
	$query_get_sort = "Select sort from " . $GLOBALS["tbl_menu"] . " where id = " . sql_escape($id);
	$result = "";
	$result_upd = "";
	$num_rows = 0;
	
	$info = "";
	
	//DB Abfrage
	$result = db_query($query_get_sort);
	
	//Anzahl Zeilen ermitteln
	$num_rows = $result->num_rows;
	
	If ($num_rows == 0)
	{
		//Eintrag nicht gefunden
		$info = "Fehler: Eintrag " . $id . " nicht vorhanden";
		break;
	} else {
	
		//Schleife über Ergebnis
		while($row = $result->fetch_array())
		{
			$sort = $row["sort"];
			$sort2 = $row["sort"] - 1;

			//Update auf Datensatz mit kleinern Sort durchführen
			$result_upd = db_query("Update " . $GLOBALS["tbl_menu"] . " set sort = " . $sort . " where sort = " . $sort2);
						
			If (db_affacted_rows() == 0)
			{
				$info = "Fehler: Update nicht erfolgreich, Kein Eintrag mit Sortierung " . $sort2 . " vorhanden";
				break;
			}
			
			//Update auf Datensatz durchführen
			$result_upd = db_query("Update " . $GLOBALS["tbl_menu"] . " set sort = sort - 1 where id = " . $id);
			
			If (db_affacted_rows() == 0)
			{
				$info = "Fehler: Update nicht erfolgreich, Kein Eintrag mit Sortierung " . $row["sort"] . " vorhanden";
				break;
			}
			
		}
	}
	
	//Seite neu laden
	if ($info == "")
	{
		redirect("admin.php?content=menu&action=list");
	} else {
		redirect("admin.php?content=menu&action=list&info=" . $info);
	}
	
}

function down_admin_menu($id)
{
	//Variablen
	$sort = 0;
	$sort2 = 0;
	$query_get_sort = "Select sort from " . $GLOBALS["tbl_menu"] . " where id = " . sql_escape($id);
	$result = "";
	$result_upd = "";
	$num_rows = 0;
	
	$info = "";
	
	//DB Abfrage
	$result = db_query($query_get_sort);
	
	//Anzahl Zeilen ermitteln
	$num_rows = $result->num_rows;
	
	If ($num_rows == 0)
	{
		//Eintrag nicht gefunden
		$info = "Fehler: Eintrag " . $id . " nicht vorhanden";
		break;
	} else {
	
		//Schleife über Ergebnis
		while($row = $result->fetch_array())
		{
			$sort = $row["sort"];
			$sort2 = $row["sort"] + 1;

			//Update auf Datensatz mit kleinern Sort durchführen
			$result_upd = db_query("Update " . $GLOBALS["tbl_menu"] . " set sort = " . $sort . " where sort = " . $sort2);
						
			If (db_affacted_rows() == 0)
			{
				$info = "Fehler: Update nicht erfolgreich, Kein Eintrag mit Sortierung " . $sort2 . " vorhanden";
				break;
			}
			
			//Update auf Datensatz durchführen
			$result_upd = db_query("Update " . $GLOBALS["tbl_menu"] . " set sort = sort + 1 where id = " . $id);
			
			If (db_affacted_rows() == 0)
			{
				$info = "Fehler: Update nicht erfolgreich, Kein Eintrag mit Sortierung " . $row["sort"] . " vorhanden";
				break;
			}
			
		}
	}
	
	//Seite neu laden
	if ($info == "")
	{
		redirect("admin.php?content=menu&action=list");
	} else {
		redirect("admin.php?content=menu&action=list&info=" . $info);
	}
	
}



} //END MENU
?>
