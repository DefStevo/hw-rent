<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>hw-rent - Login</title>
<link href="style/Layout.css" rel="stylesheet" type="text/css" />
<link href="style/Menu.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?php
//Includes
include "script/globals.s.php";
include "script/login.s.php";

if (isset($_GET["action"]) and $_GET["action"] == "logout")
{
	logout();
	redirect("index.php");
}

if (valid_login($user, $pass) and $_SESSION["user"] != "")
{
	//Redirect
	echo "User: " . $_SESSION["user"];
	redirect("admin.php");
} 
?>
<div class="container">
  <table boarder="0" align="center">
    <tr>
      <td>
        <br />
          <?php
		  if (isset($_GET["action"]) and $_GET["action"] == "login")
		  {
			  echo "<font align='center' color='#FF0000'><strong>Benutzername oder Kennwort falsch</strong></font><br /> \n";
		  } else {
			  echo "<br />";
		  }
		  ?>
        <br />   
      </td>
    </tr>
  </table>
  <form method="post" action="login.php?action=login">
    <table boarder="0" align="center">
      <tr>
        <td>Benutzer:</td>
        <td><input type="text" name="user" size="20"/></td>
      </tr>
      <tr>
        <td>Kennwort:</td>
        <td><Input type="passowrd" name="pass" size="20"/></td>
      </tr>
    </table>
    <table boarder="0" align="center">
      <tr>
        <td><input type="submit" class="button" value="Login" size="20"/> </td>
      </tr>
    </table>
  </form>
  <br />
  <br />
  <br />
</div><!-- end .container -->
</body>
</html>