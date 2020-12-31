<?php 
 require "pdo.php";
 session_start();

 $stmt = $pdo->prepare("SELECT user_id FROM profile WHERE profile_id=:pi");
	$stmt->execute(array(
		':pi' => $_GET['profile_id']
	));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row['user_id'] !== $_SESSION['user_id']){
		$_SESSION["error"]="Can't delete this profile";
		header('Location: index.php');
		return;
	}

 if(isset($_POST["cancel"])){
 	header('Location: index.php');
	return;
 }
if (isset($_POST["delete"])){
	$stmt = $pdo->prepare('DELETE FROM profile WHERE profile_id=:pi');
	$stmt->execute(array(
		':pi' => $_GET['profile_id']
	));
	$_SESSION["success"]="Successfully deleted";
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

 ?>
<html><head><title>Autos</title></head>
<body>
	<h1>Delete User</h1>
	<p>Are you sure you want to delete the following row:<p>

	<?php
		echo ('<ul><li>');
		echo('First Name: '.$_SESSION['firstname']);
		echo ('</li><li>');
		echo('Last Name: '.$_SESSION['lastname']);
		echo ('</li><li>');
		echo('Headline: '.$_SESSION['headline']);
		echo ('</li><li>');
		echo('Email: '.$_SESSION['email']);
		echo ('</li></ul><br>');
	?>
	<form method="post">
		<input type="submit" name="delete" value="Delete">
		<input type="submit" name="cancel" value="Cancel">
	</form>
</body>
</html>

