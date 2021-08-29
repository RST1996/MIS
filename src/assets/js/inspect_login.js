setInterval(function(){
			 update();
			},50000);
function update()
{
	var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        	}
        };
        xhttp.open("POST", "../config/ajax/alive.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
}