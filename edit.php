<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href="style/Layout.css" rel="stylesheet" type="text/css" />
<link href="style/Menu.css" rel="stylesheet" type="text/css" />
<script src="ckeditor/ckeditor.js"></script>

</head>

<body>
<?php
//Includes
include "script/globals.s.php";
include "script/edit.s.php";

?>

<form method="post">
        <p>
            <textarea name="editor1">&lt;p&gt;Initial value.&lt;/p&gt;</textarea>
            <script>
                CKEDITOR.replace( 'editor1' );
            </script>
        </p>
        <p>
            <input type="submit">
        </p>
    </form>

</body>
</html>