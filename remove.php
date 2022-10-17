<?php

	session_start();

	$login = $_SESSION['login'];
	$product = $_GET['id'];

	$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
	$mysqli->set_charset("utf-8");
							
	if(!$mysqli) {
		printf("error", mysql_connect_error());
		unset($_POST);
	}

	$check_quantity = "SELECT quantity FROM basket WHERE product_id = '$product' AND login = '$login'";

	$result = $mysqli->query($check_quantity);

	$row = mysqli_fetch_array($result);
	$quantity = $row[0];

	if($quantity == 1) {

		$request = "DELETE FROM basket WHERE product_id = '$product' AND login = '$login'";
		$result = $mysqli->query($request);
		header("Location: basket.php");

	} else {

		$request = "UPDATE basket SET quantity = quantity-1 WHERE product_id = '$product' AND login = '$login'";
		$result = $mysqli->query($request);
		header("Location: basket.php");

	}

?>