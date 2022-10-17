<?php

	session_start();

	$login = $_SESSION['login'];
	$delete_product = $_GET['id'];

	$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
	$mysqli->set_charset("utf-8");
							
	if(!$mysqli) {
		printf("error", mysql_connect_error());
		unset($_POST);
	}

	$request = "DELETE from basket WHERE product_id = '$delete_product' AND login = '$login'";
	$result = $mysqli->query($request);

	header("Location: basket.php");

?>