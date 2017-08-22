<?php

include_once('session.php');

if (isset($_POST['name'])){
	
    $_SESSION['name'] = $_POST['name'];
    $t->username = $_POST['name'];
    
	header("location:products.php");
} else {

	$t->render("login.phtml");
}
?>