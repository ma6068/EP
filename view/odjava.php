<?php
	session_start();
	$uloga = $_SESSION["uloga"];
	session_unset();
	session_destroy();
        header('Location: ' . './anonimenKatalog.php');
?>
