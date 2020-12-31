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



function AddPosition(){
	var total = $("#pos div").length;
	if( total<9){
		total++;
		 name1 = "position"+(total);
		 name2 = "year"+(total);
		 name3 = "desc"+(total);
		var newP  = document.createElement("p");
		var text1="Year: ";
		var text2="<input type='text' name="+name2+">";
		var text3="<input type='button' value='-' onclick='removePos(event);return false;'/>";
		var text4="<br><br><textarea name="+name3+" rows='8' cols='80'></textarea>";
		newP.innerHTML=text1+text2+text3+text4;
		var newDiv = document.createElement("div");
		newDiv.setAttribute("id", name1);
		newDiv.appendChild(newP);
		$("#pos").append(newDiv);
	}

}

function removePos(event){
	var pos = $(event.target);
	pos.parent().parent().remove();

}