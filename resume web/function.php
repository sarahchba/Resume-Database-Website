<?php
function unsetSessions(){
	for($i=1; $i<=9; $i++) {
	    if ( ! isset($_SESSION['year'.$i]) ){
	    	 continue;
	    }
	    if ( ! isset($_SESSION['desc'.$i]) ){
	    	 continue;
	    }
	    	unset($_SESSION['year'.$i]);
	    	unset($_SESSION['desc'.$i]);       	
}
}
function validatePos() {
	unsetSessions();
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['year'.$i]) ){
    	
    	 continue;
    }
    if ( ! isset($_POST['desc'.$i]) ){
    	 continue;
    }

    $year = $_POST['year'.$i];
    $desc = $_POST['desc'.$i];

    $_SESSION['year'.$i]=htmlentities($year);
    $_SESSION['desc'.$i]=htmlentities($desc);

    if ( strlen($year) == 0 || strlen($desc) == 0 ) {
      return "All fields are required";

    }

    else if ( ! is_numeric($year) ) {
      return "Position year must be numeric";
    }
  }
  unsetSessions();
  return true;
}

function fromFormToSession(){
	$_SESSION["firstname"]=htmlentities($_POST['firstname']);
	$_SESSION["lastname"]=htmlentities($_POST['lastname']);
	$_SESSION["email"]=htmlentities($_POST['email']);
	$_SESSION["headline"]=htmlentities($_POST['headline']);
	$_SESSION["summary"]=htmlentities($_POST['summary']);
}

function positions(){
	for($i=1; $i<=9; $i++) {
		if(!isset($_SESSION['year'.$i])) continue;
		if(!isset($_SESSION['desc'.$i])) continue;
		$name = 'year'.$i;
		$name2 = 'desc'.$i;
		$year = $_SESSION['year'.$i];
		$desc = $_SESSION['desc'.$i];
		echo ('<div><p> Year: <input type="text" name="'.$name.'" value="'.$year.'">');
		echo ("<input type='button' value='-' onclick='removePos(event);return false;'/></p>");
		echo ('<br><textarea name="'.$name2.'" value="'.$desc.'" rows="8" cols="80">'.$desc.'</textarea></div>');
	}
}

		