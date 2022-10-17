<?php

	session_start();

	// если на странице не авторизированный пользователь -> получить его login из cookie
	if($_SESSION["login"]) {

		//echo "MY SESSION LOGIN IS " . $_SESSION["login"];

	} else {

		$id_basket = $_COOKIE["id_basket"];
		
		if(!isset($id_basket)) {
			// если куки не найден -> создать его
			$uniq_ID = uniqid("ID");
			setcookie("id_basket", $uniq_ID, time()+60*60*24*14);
		} else {
			// если куки существует -> обновить время
			setcookie("id_basket", $id_basket, time()+60*60*24*14);
		}

		$_SESSION["login"] = $_COOKIE["id_basket"];
		//echo "MY COOKIE LOGIN IS " . $_SESSION["login"];

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
				flex-direction: row;
				align-self: center;

				width: 5%;
				height: 100%;
				min-width: 50px;
				margin-left: 2.5%;

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

			.basket {
				display: flex;
				justify-content: flex-end;
				align-self: center;
				margin-right: 1%;

				height: 90%;
				min-width: 25px;

				background: url(basket.png) 100% 100% no-repeat;;
				background-position: center;
				background-size: contain;
			}

			form {
				display: inline-flex;
				flex-direction: row;

				margin: inherit;
				margin-left: 2.5%;
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

			div img {
				height: 200px;
				width: 200px;

				border: 1px solid black;
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

			.products_container {
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;
				/*display: block;*/

				width: 80%;
				height: 90%;

				margin: 0;
				align-content: flex-start;
				justify-content: space-evenly;

				border: thick double black;
				overflow: auto;
			}

			.product {
				/*display: inline-flex;*/
				display: flex;
				flex-direction: column;
				background-color: #FFFADD;

				width: 230px;
				height: 320px;

				margin: 30px;
				padding: 10px;
				box-sizing: border-box;

				transition: box-shadow 1s ease 0s;
				border: 2px solid black;

				position: relative;
			}

			.product:hover, input[type = "submit"]:hover {
				transition: box-shadow 1s ease 0s;
				box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
			}

			.product:hover .add_product {
				transition: box-shadow 1s ease 0s;
				box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
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

			.add_product {
				display: flex;
				position: absolute;

				height: 15%;
				width: 50%;
				min-width: 50px;
				min-height: 50px;

				margin-left: 60%;
				margin-top: 120%;

				justify-content: center;

				background-color: #FED6BC;
				border: 1px solid black;

				font-size: 12px;
				transition: box-shadow 1s ease 0s;
				z-index: 2;

			}

			@keyframes triggerY {
				0%, 100% {
					transform: translateY(0px);
				}
				
				50% {
					transform: translateY(5px);
				}
			}

			.add_product:hover {
				animation: triggerY 0.4s ease;
				transition: box-shadow 1s ease 0s;
			}

			.products_container::-webkit-scrollbar {
 				display: none;
			}

			.products_container {
  				-ms-overflow-style: none;
  				scrollbar-width: none;
			}

		</style>

	</head>

	<body>

		<div class = "menu">

			<div class = "logo"></div>

			<form method = "post">

				<input type = "submit" value = "Выбор категории">

				<input type="radio" id="all" name="catalog" value="">
				<label for="all">Каталог</label>

				<input type="radio" id="shoes" name="category" value="shoes">
				<label for="shoes">Обувь</label>
				
				<input type="radio" id="pants" name="category" value="pants">
				<label for="pants">Штаны</label>

			</form>

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
			<a href = "basket.php">
				<div class = "basket"></div>
			</a>

		</div>

		<main>

			<div class = "products_container">

				<?php

					$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
					$mysqli->set_charset("utf-8");
							
					if(!$mysqli) {
						printf("error", mysql_connect_error());
						unset($_POST);
					}

					$result = $mysqli->query("SELECT * from products");

					while($product = mysqli_fetch_array($result)) {
						
						if($product['category'] == $_POST["category"]) {

							$link = "<div class = 'add_product'><a class='button' href = 'add_product.php?id=" . $product["code"] . "'>В корзину</a></div>";

							echo "<div class = 'product'><p><img src='products/" . $product['photo'] . "'></p>" . "<span><b>" . $product['name'] . "</b></span><span>" . $product['price'] . " ₽</span>" . $link . "</div>";
						}

						// если категория не выбрана - вывести всё
						if($_POST["category"] == "") {
							$link = "<div class = 'add_product'><a class='button' href = 'add_product.php?id=" . $product["code"] . "'>В корзину</a></div>";

							echo "<div class = 'product'><p><img src='products/" . $product['photo'] . "'></p>" . "<span><b>" . $product['name'] . "</b></span><span>" . $product['price'] . " ₽</span>" . $link . "</div>";
						}

					}

				?>

			</div>

		</main>

	</body>

</html>