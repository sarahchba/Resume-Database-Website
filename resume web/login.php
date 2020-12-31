<?php
	require_once "pdo.php";
	session_start();
	if(isset($_POST["cancel"])){
		header("Location: index.php");
			return;
	}
	
	if (isset ($_POST["email"]) && isset($_POST["pass"])){
		//if not empty field
		if (strlen ($_POST["email"])>=1 && strlen($_POST["pass"])>=1){
			//hash and salt
			$salt = 'XyZzy12*_';
			$check = hash('md5', $salt.$_POST['pass']);
			$stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');
			$stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if ( $row !== false ) {
				$_SESSION['name'] = $row['name'];
				$_SESSION['user_id'] = $row['user_id'];
				header("Location: index.php");
				return;
			}
			else{
				$_SESSION["error"] = "Incorrect user name or password";
				error_log("Login fail ".$_POST['email']);
				header("Location: login.php");
				return;
				}
		}
	}
	
?>
<html><head>
	<title>Log In</title>
	<script src = "js/login.js"></script>
</head>
<body>
	<h1>Please Log In</h1>

	<?php
		if (isset ($_SESSION["error"]) ){
			echo ('<p style="color:red">'.$_SESSION["error"]."</p>");
			unset($_SESSION["error"]);
		}
	?>

	<form method="post">
		<p>User Name:  <input type="email" name="email" ></p>
		<p>Password:  <input type="password" name="pass" id="pw" ></p>
		<input type="submit" onclick="return Validate();" name="log in" value="Log In">
		<input type="submit" name="cancel" value="Cancel">
	</form>
</body>
</html>