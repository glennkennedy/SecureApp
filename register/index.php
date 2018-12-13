<?php

session_start();
$parent = dirname($_SERVER['REQUEST_URI']);

if (!isset($_SESSION['usr'])) {
 header("Location: ../index.php");

}else {
  
  echo "hi";
  
}
?>

