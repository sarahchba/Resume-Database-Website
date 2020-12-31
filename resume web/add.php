<?php 
 require "pdo.php";
 require "function.php";
 require "bootstrap-jquery.php";
 session_start();

 if (!isset($_SESSION['name'])){
 	die("Name parameter missing");
 }
 if(isset($_POST["cancel"])){
 	header('Location: index.php');
	return;
 }
if (isset($_POST["save"])){
	if(strlen($_POST["firstname"])<1 || strlen($_POST["lastname"])<1 || strlen($_POST["email"])<1 || strlen($_POST["headline"])<1 || strlen($_POST["summary"])<1 ){
	$_SESSION["error"]="All fields are required";
	fromFormToSession();
	header('Location: add.php');
	return;
	}
	else if(validatePos() !== true){
		$_SESSION["error"]=validatePos();
		fromFormToSession();
		header('Location: add.php');
		return;
	}
	else{
	$stmt = $pdo->prepare('INSERT INTO profile (user_id, first_name, last_name, email, headline, summary) VALUES (:ui, :fn, :ln, :e, :h, :s)');
	$stmt->execute(array(
		':ui' => $_POST['user_id'],
		':fn' => $_POST['firstname'],
		':ln' => $_POST['lastname'],
		':e' => $_POST['email'],
		':h' => $_POST['headline'],
		':s' => $_POST['summary']
	));

	$profile_id = $pdo->lastInsertId();

	$stmt = $pdo->prepare('INSERT INTO position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :dec)');
	$rank=1;
	for($i=1;$i<=9;$i++){
		if ( ! isset($_POST['year'.$i]) ) continue;
		$stmt->execute(array(
	  ':pid' => $profile_id,
	  ':rank' => $rank,
	  ':year' => $_POST['year'.$i],
	  ':dec' => $_POST['desc'.$i])
	);

	$rank++;
	}
	

	$_SESSION["success"]="Successfully added";
	header('Location: index.php');
	return;
	}
}

 ?>
}
<html><head><title>Autos</title>

 </head>
<body><script src="js/functions.js"></script>
	<?php
	require_once "function.php";
	require "bootstrap-jquery.php";
	$count=0;
		 if (isset ($_SESSION["error"]) ){
			echo ('<p style="color:red">'.$_SESSION["error"]."</p>");
			unset($_SESSION["error"]);
			$firstname_var=$_SESSION['firstname'];
			$lastname_var=$_SESSION['lastname'];
			$email_var=$_SESSION['email'];
			$headline_var=$_SESSION['headline'];
			$summary_var=$_SESSION['summary'];
		}
		else{
			$firstname_var = "";
			$lastname_var = "";
			$email_var = "";
			$headline_var = "";
			$summary_var = "";
		}
	?>
	<form method="post">
		<p>First Name: <input type="text" name="firstname" value="<?= $firstname_var;?>"></p>
		<p>Last Name: <input type="text" name="lastname" value="<?= $lastname_var;?>"></p>
		<p>Email: <input type="email" name="email" value="<?= $email_var;?>"></p>
		<p>Headline: <input type="text" name="headline" value="<?= $headline_var;?>"></p>
		<p>Summary: <br><input type="text" name="summary" value="<?= $summary_var;?>" style="height:200px"></p>
		<input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">
		
		<p>Position: <input type="button" onclick="AddPosition()" name="email" id="add" value="+"  ></p>
		<div id="pos"></div>
		<input type="submit"  name="save" value="Save">
		<input type="submit" name="cancel" value="Cancel">
	</form>
</body>
</html>

