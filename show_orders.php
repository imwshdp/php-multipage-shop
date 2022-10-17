<?php

	session_start();
	$login = $_SESSION['login'];

	$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
	$mysqli->set_charset("utf-8");
							
	if(!$mysqli) {
		printf("error", mysql_connect_error());
		unset($_POST);
	}

?>

<!DOCTYPE html>
<html>

	<head>
	
		<meta charset="utf-8">
		<title>shop</title>

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

			.menu {
				display: flex;
				flex-direction: row;

				width: 100%;
				height: 5%;

				margin: 0;
				box-sizing: border-box;
				border: thin solid black;
				background-color: #FED6BC;
			}

			.logo {
				display: flex;

				width: 10%;
				height: 100%;

				background: url(logo.png) 100% 100% no-repeat;;
				background-position: center;
				background-size: contain;
			}

			.greeting {
				display: flex;
				justify-content: flex-end;
				margin-left: auto;
				margin-right: 1%;

				width: auto;
			}

			.user {
				display: flex;
				justify-content: flex-end;
				align-self: center;
				margin-right: 2%;

				height: 90%;
				min-width: 25px;

				background: url(user.png) 100% 100% no-repeat;;
				background-position: center;
				background-size: contain;
			}

			form {
				display: inline-flex;
				flex-direction: row;

				margin: inherit;
			}

			input[type = "radio"] {
				align-self: center;
				margin: 0 0 0 15px;
			}

			label {
				margin: 0 10px;
				align-self: center;
				font-size: 12px;
			}

			input[type = "submit"] {
				background-color: #FFFADD;
				margin: 0;
				border-radius: 5px;

				align-self: center;
				cursor: pointer;

				font-family: 'Comfortaa', cursive;
				font-size: 12px;
				transition: box-shadow 1s ease 0s;
			}

			main {
				display: flex;
				flex-direction: column;

				width: 100%;
				height: 95%;

				box-sizing: border-box;
				justify-content: center;
				align-items: center;

				border: thin solid black;
			}

			span, p, a {
				align-self: center;
				text-align: center;
				margin: 3%;
			}

			a {
				text-decoration: inherit;
				color: black;
				font-weight: bolder;
				margin-right: 0;
			}

			.menu > a {
				margin: 0;
				padding: 0;
				margin-right: 1%;
			}

			.greeting > span {
				word-wrap: normal;
				font-size: 10px;
				margin: 0;
			}

			.basket {
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;

				width: 80%;
				height: 85%;

				align-content: flex-start;
				justify-content: space-evenly;

				border: thick double black;
				overflow: auto;
			}

			.basket > div {
				display: flex;
				background-color: #FFFADD;
				flex-direction: column;
				flex-wrap: wrap;
				
				width: 70%;
				margin-top: 2%;

				text-transform: none;
				word-wrap: normal;
				border: 1px solid black;
			}

			.basket div span {
				display: flex;
				align-self: flex-start;
				margin-top: 0;
				margin: 1%;
			}

			.basket div .info {
				font-weight: bold;
			}

			.order_menu {

				display: flex;
				flex-direction: row;
				align-self: flex-end;

				width: 100%;
				justify-content: center;
			}

			.order {
				display: flex;

				width: 15%;
				margin: 1%;
				padding: 1%;

				justify-content: center;
				align-self: center;

				background-color: #FED6BC;
				border: 1px solid black;
				font-size: 12px;
			}

			.order > a {
				margin-left: 0;
			}

			.basket::-webkit-scrollbar {
 				display: none;
			}

			.basket {
  				-ms-overflow-style: none;
  				scrollbar-width: none;
			}

		</style>

	</head>

	<body>

		<div class = "menu">

			<div class = "logo"></div>

			<div class = "greeting">
				<span>
					<?php
						if(isset($_SESSION["username"])) {
							echo "С возвращением, " . "<b>" . $_SESSION["username"] . "</b>!";
						} else {
							echo '<a href = "shop_login.php">Войти</a>';
						}
					?>
				</span>
			</div>

			<div class = "user"></div>

		</div>

		<main>
				
			<div class = "basket">
				
				<?php

					$orders_request = "SELECT number, date, login FROM orders WHERE login = '$login'";
					$oders_row = $mysqli->query($orders_request);

					// если есть что-то
					if($oders_row->num_rows != 0) {

						// проход по всем заказам
						while($order = mysqli_fetch_array($oders_row)) {

							$ORDER_NUMBER = $order['number'];

							$order_info = "<span class = 'info'>Номер заказа: " . $ORDER_NUMBER . "</span>";
							echo "<div>$order_info";

							// получить детали заказа
							$OrderProducts_request = "SELECT number, code, quantity FROM order_products WHERE number = '$ORDER_NUMBER'";
							
							$OrderProducts_row = $mysqli->query($OrderProducts_request);

							// проход по всем товарам заказа
							while($orderProduct = mysqli_fetch_array($OrderProducts_row)) {

								$PRODUCT_CODE = $orderProduct['code'];

								// получить название товара
								$products_request = "SELECT code, name FROM products WHERE code = '$PRODUCT_CODE '";
							
								$products_row = $mysqli->query($products_request);

								while($products = mysqli_fetch_array($products_row)) {

									// получили название товара
									if($products['code'] == $PRODUCT_CODE) {
										$PRODUCT_NAME = $products['name'];
									}

								}

								// заполняем детали товара в заказе
								$order_details = "<span class> &#8226; " . $PRODUCT_NAME . ": " . $orderProduct['quantity'] . " шт.</span>";

								echo "$order_details";
							}

							$ORDER_DATE = $order['date'];
							$order_date = "<span class = 'info'>Дата заказа:</span><span>" . $ORDER_DATE . "</span>";
							echo "$order_date</div>";
						}
						
					} else {
						
						echo "<br>Нет сформированных заказов.";

					}

				?>

			</div>

			<div class = "order_menu">

				<div class = "order">
					<a href = 'basket.php'>Вернуться</a>
				</div>

			</div>

		</main>

	</body>

</html>