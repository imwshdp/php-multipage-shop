<?php

	session_start();
	$login = $_SESSION['login'];

	$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
	$mysqli->set_charset("utf-8");
							
	if(!$mysqli) {
		printf("error", mysql_connect_error());
		unset($_POST);
	}

	$request = "SELECT MAX(number)+1 from orders";
	$MAX_ORDER = $mysqli->query($request);

	// дать номер заказу
	$row = mysqli_fetch_array($MAX_ORDER);
	$order_num = $row[0];

	// обращение к таблице корзины
	$products_request = "SELECT product_id, login, quantity, time FROM basket WHERE login = '$login'";
	$basket_data = $mysqli->query($products_request);

	//если корзина НЕ пустая
	if($basket_data->num_rows != NULL) {

		date_default_timezone_set('Europe/Moscow');
		$date = date('Y-m-d H:i:s');

		// создать новый заказ
		$create_order_request = "INSERT orders (number, date, login)
								VALUES ('$order_num', '$date', '$login')";

		$add_order = $mysqli->query($create_order_request);

		// заполнить таблицу order_products
		// перебрав таблицу корзины
		while($part = mysqli_fetch_array($basket_data)) {

			$product_code = $part['product_id'];
			$product_quantity = $part['quantity'];

			$order_part_request = "INSERT order_products (number, code, quantity)
								VALUES ('$order_num', '$product_code', '$product_quantity')";

			$add_row = $mysqli->query($order_part_request);
		
		}

		// очистить корзину для пользователя
		$clear_basket = "DELETE FROM basket WHERE login = '$login'";
		$clearing = $mysqli->query($clear_basket);

		$_SESSION['order_confirmed'] = 1;

	// если корзина оказалась пустой
	} else {

		$_SESSION['order_confirmed'] = 0;

	}

?>

<!DOCTYPE html5>
<html>

	<head>
	
		<meta charset="utf-8">
		<title>ordering</title>

		<style>

			@import url(https://fonts.googleapis.com/css?family=Didact+Gothic|Comfortaa:400,700&subset=latin,cyrillic);

			body {
				display: flex;
				flex-direction: column;

				margin: 0;
				box-sizing: border-box;
				
				width: 100%;
				height: 100%;
				min-width: 500px;
				min-height: 600px;

				background: #FDEED9;

				font-family: 'Comfortaa', cursive;
				text-transform: uppercase;
				font-size: 15px;
				color: black;
			}

			main {
				display: flex;
				flex-direction: column;

				width: 100%;
				height: 20%;

				align-self: center;
				justify-content: center;
				align-content: center;
			}

			span {
				text-align: center;
			}

			div {
				display: flex;
				flex-direction: column;

				width: 15%;
				height: 10%;

				margin: 1%;
				padding: 1%;

				justify-content: center;
				align-self: center;

				background-color: #FED6BC;
				border: 1px solid black;

				font-size: 12px;
			}

			a {
				text-decoration: none;
				color: black;
				text-align: center;
			}

		</style>

	</head>

	<body>

		<main>

			<span>
			<?php
				if($_SESSION['order_confirmed'] == 1) {
					echo "Заказ успешно сформирован!";
				} else {
					echo "Не удалось сформировать заказ. Ваша корзина пуста.";
				}
			?>
			</span>

			<div>
				<a href = 'basket.php'>Вернуться</a>
			</div>

		</main>

	</body>

</html>