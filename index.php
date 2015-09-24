<?php

require('../../dbfinal.php');
$title = "MySQL Megazord Database";
include("header.php");

$conn = new mysqli($host, $db_user, $db_pw, $db_name);

if($conn->connect_error){
	die("Could not establish connection" . $conn->connect_error);
}
?>
<h3>Welcome to the Megazord Database</h3>

<p>
Power Rangers use zords, colossal assault vehicles, to fight evil space aliens. These zords can combine to form a robot, called a megazord. There are many different combinations that can be made from these zords. Search and browse the database to find which season each megazord was from or update the information. You can even add more megazords.
</p>
<?php
include("footer.php");
?>
