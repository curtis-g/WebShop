<?php

session_start();

require_once('view.php');
$t = new View();

if (isset($_SESSION['name'])) {
	$t->logged_in = True;
	$t->user_name = $_SESSION['name'];
} else {
	$t->logged_in = False;
}
?>