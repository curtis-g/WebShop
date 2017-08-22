<?php
include_once('session.php');

if ($t->logged_in == False){
    header("location:login.php");
}

if (isset($_POST["select"])){
  $food_selected = $_POST['select'];
  var_dump($_POST["select"]);
  
  if(!empty($food_selected)) {
    if (empty($_SESSION["basket"])){
      $_SESSION["basket"] = array();
    }
    foreach ($food_selected as $val) {
      $_SESSION["basket"][] = $val;
    }
  }
}
$conn = pg_connect("host=db.dcs.aber.ac.uk port=5432
      dbname=teaching user=csguest password=r3p41r3d");

$res = pg_query($conn, "select * from food");

$food_array = array();

if (!$conn){
  die("A database connection is unavailable");
} else {
  
  while ($arrayrow = pg_fetch_array($res)){
      if (isset($_SESSION['basket'])) {
          $in_basket = False;
         
          foreach ($_SESSION['basket'] as $case_basket) {
              if ($arrayrow['ref'] == $case_basket){
                $in_basket = True;
              }
          }
          if (!$in_basket){
            $food_array[] = $arrayrow;
          }
      } else { 
          $food_array[] = $arrayrow;
      }
  }
}

$t->food = $food_array;

$t->render('products.phtml');
?>