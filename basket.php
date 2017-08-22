<?php
include_once('session.php');

if ($t->logged_in == False){
    header("location:login.php");
}

if($_POST){

	if(isset($_POST['basketRemove'])){
		foreach ($_POST["basketSelect"] as $removeVal) {
			foreach ($_SESSION["basket"] as $basketVal) {
				if($removeVal == $basketVal){
					$_SESSION["basket"] = array_diff(
							$_SESSION["basket"], 
							array($removeVal));
				}
			}
		}
	
	} else if(isset($_POST['clearBasket'])){
	 	$_SESSION['basket'] = array();
 	
	} else if (isset($_POST['Checkout'])){
		
		$total_cost = 0.00;
		$basket_food = array();
		foreach ($basket_food as $value) {
			$total_cost += $value["price"];
		}
		$t->total_cost = $total_cost;
		$t->render('checkout.phtml');
		exit;
	} else if (isset($_POST["confirmCheckout"])){
		
		$t->render('basket.php');
		exit;
	}
}

$conn = pg_connect("host=db.dcs.aber.ac.uk port=5432
      dbname=teaching user=csguest password=r3p41r3d");

$res = pg_query($conn, "select * from food");

$food_array = array();
$basket_food = array();

if (!$conn){
	die("db connection unavailable");
} else {
	while ($rowarray = pg_fetch_array($res)){
		$food_array[] = $rowarray;
	}
	
	foreach($_SESSION['basket'] as $basket_num){
		foreach ($food_array as $value) {
			if ($value["ref"]==$basket_num){
				$basket_food[] = $value;
				break;
			}
		}
	}
}

$total_cost = 0.00;
foreach ($basket_food as $value) {
	$total_cost += $value["price"];
}

$t->total_cost = $total_cost;

$t->basket_food = $basket_food;

$t->render('basket.phtml');
?>