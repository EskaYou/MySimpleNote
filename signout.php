<?php
session_name("note_app_user_auth");
session_start();
unset($_SESSION["note_app_client"]);
session_destroy();
header("location: signin.php");


?>
