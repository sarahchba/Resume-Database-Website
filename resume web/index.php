<html>
<head><title>Index</title></head>
<body>
	<h1>Welcome to Resume Database</h1>
	<?php 
	 require_once "pdo.php";
	 session_start();

	if(isset($_SESSION['name'])){

		echo('<a href="logout.php" >Logout</a><br><br>');
	}
	else{
		echo('<a href="login.php" >Please Login In</a><br><br>');
	}

	if(isset($_SESSION["success"])){
		echo($_SESSION["success"]);
		unset($_SESSION["success"]);
	}
	if(isset($_SESSION["error"])){
		echo($_SESSION["error"]);
		unset($_SESSION["error"]);
	}
	//check if the table is empty
			$stmt = $pdo->prepare("SELECT name, headline, profile_id FROM profile JOIN users WHERE profile.user_id=users.user_id");
			$stmt->execute();
	//display table	
			echo ('<table border="1">'."\n");
				echo ('<tr><td><b>Name</b></td><td><b>Headline</b></td><td><b>Action</b></td></tr>');
			while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				echo ('<tr><td>');
				echo ('<a href="view.php?profile_id='.htmlentities($row['profile_id']).'">'.htmlentities($row['name']).'</a>');
				echo ('</td><td>');
				echo (htmlentities($row['headline']));
					//when logged in
				  if (isset ($_SESSION["name"]) ){
						echo('</td><td>');
			    		echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> ');
		    			echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
		    		}
				echo ('</td></tr>');
			}
			echo ('</table>');
			if (isset ($_SESSION["name"]) ){
				//unset($_SESSION["success"]);
				echo('<a href="add.php">Add new entry</a>');
			}
					
	?>
</body>
</html>

