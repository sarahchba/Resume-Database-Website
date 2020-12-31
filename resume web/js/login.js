function Validate() {
	console.log('Validating...');
	try {
		pw = document.getElementById('pw').value;
		console.log("Validating pw="+pw);
		if (pw == null || pw == "") {
			alert("Both fields must be filled out");
			return false;
		}
		return true;
	} catch(e) {
		return false;
	}
	return false;
}

function validatePos() {
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['year'.$i]) ) continue;
    if ( ! isset($_POST['desc'.$i]) ) continue;

    $year = $_POST['year'.$i];
    $desc = $_POST['desc'.$i];

    if ( strlen($year) == 0 || strlen($desc) == 0 ) {
      return "All fields are required";
    }

    if ( ! is_numeric($year) ) {
      return "Position year must be numeric";
    }
  }
  return true;
}