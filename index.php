<?php

session_name("note_app_user_auth");
session_start();
if(isset($_SESSION["note_app_client"]) != "")
{
    header("location: dashboard.php");
}

?>

<!DOCTYPE html>
<html>
    <head>
	<title>LOLNote &#128514;</title>
	<link rel="stylesheet" href="Assets/css/Style.css">
    </head>
    <body>


	<div class="main-container">
	    <div class="main-inner">
		<div class="main-content">
		    <h1>LOLNote &#128514;</h1>
		    <a href="signup.php" class="ghost-button-primary">Daftar</a>
		    <a href="signin.php" class="ghost-button-primary">Masuk</a><br/><br/<br/>
		    <a href="tentang.php" class="ghost-button-primary">Tentang aplikasi</a>
		</div>
	    </div>
	</div>

	<div >

	
    </body>
</html>
