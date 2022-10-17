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

	$request = "UPDATE basket SET quantity = quantity+1 WHERE product_id = '$product' AND login = '$login'";
	$result = $mysqli->query($request);

	header("Location: basket.php");

?>