<?php 
	function headerFun($link){
			header("Location:$link");
		}
		session_start();
		if (empty($_SESSION['auth'])) {
			headerFun('login.php');
		}
		require('script/main.php');
		$login = $_SESSION['login'];

		if (isset($_GET['logout'])) {
        	session_destroy();
        	headerFun("index.php");
		}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Blog yozish</title>
</head>
<body>
	<header>
		<div class="container">
			
		</div>
	</header>
</body>
</html>