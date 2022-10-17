<?php

	session_start();
	date_default_timezone_set('Europe/Moscow');
	$login = $_SESSION['login'];

	$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
	$mysqli->set_charset("utf-8");
			
	if(!$mysqli) {
		printf("error", mysql_connect_error());
		unset($_POST);
	}


	$login = $_SESSION['login'];
	$prod_id = $_GET['id'];
	$founded = 0;


	// достать все записи из корзины
	$result = $mysqli->query("SELECT product_id, login, quantity, time FROM basket WHERE login = '$login'");

	// если таблица не пустая
	if($result) {

		// просмотреть все записи в ней
		while($row = mysqli_fetch_array($result)) {
				
			// если уже нашли добавляемый товар в корзине -> обновить его количество
			if($row['product_id'] == $prod_id) {

				$quantity = $row['quantity'] + 1;
				$product_id = $row['product_id'];

				// обновляем количество
				$request = "UPDATE basket SET quantity = '$quantity' WHERE product_id = '$product_id' and login = '$login';";
				$q_result = $mysqli->query($request);

				// вернуться на страницу
				$founded = 1;
				header("Location: shop.php");
			}
		}
	}

	// иначе добавить товар в корзину покупателя в количестве одной штуки
	if(!$founded) {

		$date = date('Y-m-d H:i:s');

		// добавляем запись
		$add_new = "INSERT basket (product_id, login, quantity, time)
					VALUES ('$prod_id', '$login', '1', '$date')";
		$result = $mysqli->query($add_new);

		// вернуться на страницу
		header("Location: shop.php");
	}

?>