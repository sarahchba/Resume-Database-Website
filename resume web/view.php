<?php 
 require "pdo.php";
 require "function.php";
 session_start();

 if(isset($_POST["done"])){
 	header('Location: index.php');
	return;
 }

	$stmt = $pdo->prepare("SELECT first_name, last_name, email, headline, summary FROM profile WHERE profile_id=:pi");
	$stmt->execute(array(
		':pi' => $_GET['profile_id']
	));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$_SESSION["firstname"]=htmlentities($row['first_name']);
	$_SESSION["lastname"]=htmlentities($row['last_name']);
	$_SESSION["email"]=htmlentities($row['email']);
	$_SESSION["headline"]=htmlentities($row['headline']);
	$_SESSION["summary"]=htmlentities($row['summary']);

	$stmt = $pdo->prepare("SELECT year, description FROM position WHERE profile_id=:pi ORDER BY rank");
	$stmt->execute(array(
		':pi' => $_GET['profile_id']
	));
	unsetSessions();
	$rank = 1;
	while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		$_SESSION["year".$rank]=htmlentities($row['year']);
		$_SESSION["desc".$rank]=htmlentities($row['description']);
		$rank++;
	}

 ?>
<html><head><title>Autos</title></head>
<body>
	
	
	<?php
		echo('<h1>Profile for: '.$_SESSION['name'].'</h1>');
		echo ('<ul><li>');
		echo('First Name: '.$_SESSION['firstname']);
		echo ('</li><li>');
		echo('Last Name: '.$_SESSION['lastname']);
		echo ('</li><li>');
		echo('Headline: '.$_SESSION['headline']);
		echo ('</li><li>');
		echo('Email: '.$_SESSION['email']);
		echo ('</li><li>');
		echo('Summary: '.$_SESSION['summary']);
		echo('</li><li>Positions: <ul>');
		for($i=1;$i<=9;$i++){
			if ( ! isset($_SESSION['year'.$i]) ) continue;
			echo('<li>'.$_SESSION["year".$i]);
			echo(' : '.$_SESSION["desc".$i].'</li>');
		}
		echo ('</li></ul></ul><br>');
	?>
	<form method="post">
		<input type="submit" name="done" value="Done">
	</form>
</body>
</html>

