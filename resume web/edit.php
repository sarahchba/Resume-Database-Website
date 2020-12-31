<?php 
 require "pdo.php";
 require "function.php";
 require "bootstrap-jquery.php";
 session_start();

	$stmt = $pdo->prepare("SELECT user_id FROM profile WHERE profile_id=:pi");
	$stmt->execute(array(
		':pi' => $_GET['profile_id']
	));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row['user_id'] != $_SESSION['user_id']){
		$_SESSION["error"]="Can't edit this profile";
		header('Location: index.php');
		return;
	}

 if(isset($_POST["cancel"])){
 	header('Location: index.php');
	return;
 }
if (isset($_POST["firstname"])){
	if(strlen($_POST["firstname"])<1 || strlen($_POST["lastname"])<1 || strlen($_POST["email"])<1 || strlen($_POST["headline"])<1 || strlen($_POST["summary"])<1){
	$_SESSION["error"]="All fields are required";
	fromFormToSession();
	header('Location: edit.php?profile_id='.$_GET['profile_id']);
	return;
	}
	else{
	$stmt = $pdo->prepare('UPDATE profile SET  first_name=:fn, last_name=:ln, email=:e, headline=:h, summary=:s WHERE profile_id=:pi');
	$stmt->execute(array(
		':pi' => $_GET['profile_id'],
		':fn' => $_POST['firstname'],
		':ln' => $_POST['lastname'],
		':e' => $_POST['email'],
		':h' => $_POST['headline'],
		':s' => $_POST['summary']
	));

	//$profile_id = $pdo->lastInsertId();
	$stmt = $pdo->prepare('DELETE FROM position WHERE profile_id=:pi');
	$stmt->execute(array(
	  ':pi' => $_GET['profile_id']
	));
	$stmt = $pdo->prepare('INSERT INTO position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :dec)');
	$rank=1;
	for($i=1;$i<=9;$i++){
		if ( ! isset($_POST['year'.$i]) ) continue;
		$stmt->execute(array(
	  ':pid' => $_GET['profile_id'],
	  ':rank' => $rank,
	  ':year' => $_POST['year'.$i],
	  ':dec' => $_POST['desc'.$i])
	);

	$rank++;
	}
	
	$_SESSION["success"]="Successfully edited";
	header('Location: index.php');
	return;
	}
}
else if(!isset($_SESSION['error'])){
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
	
	
}
 ?>
<html><head><title>Autos</title></head>
<body>
	<?php

		 if (isset ($_SESSION["error"]) ){
			echo ('<p style="color:red">'.$_SESSION["error"]."</p>");
			unset($_SESSION["error"]);
		}

		$firstname_var = "";
		$lastname_var = "";
		$email_var = "";
		$headline_var = "";
		$summary_var = "";
		if(isset($_SESSION['firstname'])){ 
			$firstname_var=$_SESSION['firstname'];
		}
		if(isset($_SESSION['lastname'])){ 
			$lastname_var=$_SESSION['lastname'];
		}
		if(isset($_SESSION['email'])){ 
			$email_var=$_SESSION['email'];
		}
		if(isset($_SESSION['headline'])){ 
			$headline_var=$_SESSION['headline'];
		}
		if(isset($_SESSION['summary'])){ 
			$summary_var=$_SESSION['summary'];
		}
	?>
	<form method="post">
		<p>First Name: <input type="text" name="firstname" value="<?= $firstname_var;?>"></p>
		<p>Last Name: <input type="text" name="lastname" value="<?= $lastname_var;?>"></p>
		<p>Email: <input type="email" name="email" value="<?= $email_var;?>"></p>
		<p>Headline: <input type="text" name="headline" value="<?= $headline_var;?>"></p>
		<p>Summary: <br><input type="text" name="summary" value="<?= $summary_var;?>" style="height:200px"></p>
		<p>Position: <input type="button" onclick="AddPosition()" name="email" id="add" value="+"  ></p>
		<div id='pos'><?= positions()?></div>
		<input type="submit" name="save" value="Save">
		<input type="submit" name="cancel" value="Cancel">
	</form>
</body>
</html>

