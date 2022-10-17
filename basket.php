<?php

	session_start();

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

			.main {
				display: flex;
				justify-content: flex-end;
				align-self: center;
				margin-right: 1%;

				height: 90%;
				min-width: 25px;

				background: url(shop.png) 100% 100% no-repeat;;
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
				min-width: 450px;

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
				min-width: 330px;
				margin-top: 2%;

				text-transform: none;
				word-wrap: normal;
				border: 1px solid black;
				position: relative;
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

			.delete, .add, .remove {
				display: flex;
				position: absolute;

				left: 90%;
				top: 80%;

				width: 15%;
				height: 30%;
				min-width: 80px;

				justify-content: center;

				background-color: #FED6BC;
				border: 1px solid black;

				font-size: 12px;
				z-index: 1;
			}

			.add, .remove {
				width: 5%;
				height: 20%;
				min-width: 30px;

				top: 10%;
				left: 97%;
			}
			.remove {
				top: 40%;
			}

			.basket::-webkit-scrollbar {
 				display: none;
			}

			.basket {
  				-ms-overflow-style: none;
  				scrollbar-width: none;
			}

			@keyframes triggerY {
				0%, 100% {
					transform: translateY(0px);
				}
				
				50% {
					transform: translateY(5px);
				}
			}

			.delete:hover, .add:hover, .remove:hover{
				animation: triggerY 0.4s ease;
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
			<a href = "shop.php">
				<div class = "main"></div>
			</a>

		</div>

		<main>
				
			<div class = "basket">
				
				<?php

					$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
					$mysqli->set_charset("utf-8");
							
					if(!$mysqli) {
						printf("error", mysql_connect_error());
						unset($_POST);
					}

					$request = "SELECT * from basket";
					$result = $mysqli->query($request);

					// обращение к таблице товаров
					$products_request = "SELECT * from products";

					if($result) {

						// вывод содержимого корзины
						while($row = mysqli_fetch_array($result)) {

							// ищем товары пользователя
							if($row["login"] == $_SESSION["login"]) {

								// выборка товаров из таблицы на сервере
								$products_result = $mysqli->query($products_request);

								// выборка нужного имени товара по id
								while($products_row = mysqli_fetch_array($products_result)) {

									if($products_row['code'] == $row['product_id']) {
										$product_name = $products_row['name'];
										$product_id = $products_row['code'];
									}
								}

								$link = "<div class = 'delete'><a class='button' href = 'delete_from_basket.php?id=" . $product_id . "'>Удалить</a></div>";

								$add = "<div class = 'add'><a class='button' href = 'add.php?id=" . $product_id . "'>+</a></div>";

								$remove = "<div class = 'remove'><a class='button' href = 'remove.php?id=" . $product_id . "'>-</a></div>";

								echo "<div><span class = 'info'>Добавлен товар:</span><span>" . $product_name . " в количестве " . $row['quantity'] . " штук.</span><span class = 'info'>Дата добавления:</span><span>" . $row['time'] . "</span>" . $add . $remove . $link . "</div>";

							}

						}

					}

				?>

			</div>

			<div class = "order_menu">

				<div class = "order">
					<a href = 'confirm_order.php'>Оформить заказ</a>
				</div>
				<div class = "order">
					<a href = 'show_orders.php'>Мои заказы</a>
				</div>

			</div>

		</main>

		<script src = "clicks.js"></script>

	</body>

</html>