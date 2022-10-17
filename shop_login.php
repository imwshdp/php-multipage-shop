<?php

if($_POST["login"] != "" and $_POST["password"] != "") {

	$mysqli = new mysqli("localhost", "root", "", "MyDatabase");
	$mysqli->set_charset("utf-8");
			
	if(!$mysqli) {
		printf("error", mysql_connect_error());
		unset($_POST);
	}

	$result = $mysqli->query("SELECT * from users");

	while($row = mysqli_fetch_array($result)) {

		if($row[0] == $_POST["login"] and $row[1] == $_POST["password"]) {
			
			session_start();
			$_SESSION["username"] = $row[2];
			$_SESSION["login"] = $row[0];
			//echo $username;

			unset($_POST);
			header("Location: shop.php");
		}

	}

	unset($_POST);

}

?>

<!DOCTYPE html5>
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
				font-size: 10px;
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
				width: 90%;
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
				align-self: center;
				align-items: center;

				border: thin solid black;
			}

			main > div {

				display: flex;
				flex-direction: column;

				width: 30%;
				height: 30%;
				min-height: 250px;
				min-width: 200px;
				margin-top: 50px;

				box-sizing: border-box;
				justify-content: center;
				align-items: center;

				border: thin solid black;

			}

			form {
				display: flex;
				flex-direction: column;
				margin-top: 0;

				width: 90%;
			}

			h2 { font-size: 12px; }

			h2 { font-size: 10px; }

			input  {
				border-radius: 5px;
				border: 2px solid gray;
				width: 100%;

				transition: border 1s ease-in 0s;
			}

			input:focus {
				border: 2px solid #FED6BC;
				transition: border 0.5s ease-in 0s;
			}

			input::placeholder {
				font-family: Bradley Hand, cursive;
				font-size: 12px;
			}

			a {
				text-decoration: none;
				color: black;
				align-self: center;
			}

			input::-webkit-input-placeholder { opacity: 1; transition: opacity 0.3s ease; }
			input:hover::-webkit-input-placeholder { opacity: 0; transition: opacity 0.3s ease; }
			input:focus::-webkit-input-placeholder { opacity: 0; }

		</style>

	</head>

	<body>

		<div class = "menu">

			<div class = "logo"></div>

			<div class = "greeting"></div>

		</div>

		<main>

			<div>

				<h1>Вход</h1>

				<form method = "post">

					<label><h2>Ваш логин:</h2></label>
					<input type = "text" name = "login">

					<label><h2>Ваш пароль:</h2></label>
					<input type="password" name = "password">
					<br><br>

					<input type = "submit" value = "Войти">
					<br><br>

					<a href="shop_reg.php">Регистрация</a>

				</form>

			</div>

		</main>

	</body>

</html>