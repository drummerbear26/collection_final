<?php

require('../../dbfinal.php');
$title = "MySQL Megazord Database";
include("header.php");
$row_class = "odd";
// Make Connection
$conn = new mysqli($host, $db_user, $db_pw, $db_name);
// Check Connection
if($conn->connect_error){
	die("Can not establish connection" . $conn->connect_error);
}

// Insert new data
if($_SERVER["REQUEST_METHOD"] == "POST") {

	$show = $_POST["prshow"];
	$robot = $_POST["prmegazord"];
	$image = $_POST["primage"];
	$show_id = $_POST["prid"];

	$sql_insert = "INSERT INTO `series` (`show`, `robot`) VALUES ('$show', '$robot')";

	if ($conn->query($sql_insert) === TRUE){
		echo "New data created successfully";
	} else {
		echo "Error: " . $sql_insert . "<br />" . $conn->error;
	}
}

//Delete data
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_id"])){
	$delete_id = $_GET["delete_id"];
	$sql_delete = "DELETE FROM series WHERE id = '$delete_id'";
	if($conn->query($sql_delete) == TRUE) {
		echo "Record deleted";
	} else {
		echo "Error on deletion:" . $sql_delete . "<br />" . $conn->error;
	}
}

$sql = "SELECT series.id, series.show, series.robot, images.image FROM series
			LEFT OUTER JOIN images
			ON series.id = images.show_id";

$result = $conn->query($sql);

$sql_series = "SELECT * FROM series";
$result_series = $conn->query($sql_series);

?>
<br /><br />

<?php
echo "<table class='series'>\n";
echo "<tr class='table_header'>\n";
echo "\t<th>Series</th>\n";
echo "\t\t<th>Megazord</th>\n";
echo "\t\t<th>Image</th>\n";
echo "\t\t<th>Action</th>\n";
echo "</tr>\n";

if($result->num_rows > 0){
	while($row = $result->fetch_assoc()){
		if(isset($_GET["update_id"]) && $_GET["update_id"] == $row['id']){
			?>
			<tr class="table_row update">
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
					<input type="hidden" name="update_flag" value="<?php echo $row['id']; ?>">
					<td><input name="prshow" value="<?php echo $row["show"] ?>"></td>
					<td><input name="prmegazord" value="<?php echo $row["robot"] ?>"></td>
					<td><button type="sumbit">Update row</button></td>
				</form>
			</tr>
			<?php		
		}	else {
				echo "<tr class='table_row $row_class'>";
				echo "<td>" . $row["show"] . "</td>";
				echo "<td>" . $row["robot"] . "</td>";
				echo "<td><img src='images/" . $row["image"] . "'></td>";
				echo "<td>" . " <a href=". $_SERVER["PHP_SELF"] . "?delete_id=" . $row['id'] . "> Delete</a> |"
								. " <a href=". $_SERVER["PHP_SELF"] . "?update_id=" . $row['id'] . "> Update</a>" . "</td>";
				echo "</tr>";
				
				if($row_class == "odd"){
					$row_class = "even";
				} else if($row_class == "even"){
					$row_class = "odd";
				}				
		}		
	}
} else {
	echo "0 results; nope";
}
echo "</table>";

$conn->close();
?>
<div class="input_form">
	<br />
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		<label for="newShow"> Series: </label>
			<select name="prshow">
				<?php
					if($result_series->num_rows > 0){
						while($series_row = $result_series->fetch_assoc()){
							echo "<option value'".$series_row["id"]."'>".$series_row["show"]."</option>";
						}
					}
				?>
			</select>

		<label for="newRobot"> Megazord: </label>
			<input type="text" name="prmegazord" id="newRobot" /><br /><br />
		<button type="submit">Insert new Megazord</button>
		
	</form>
</div>
<?php
include("footer.php");
?>
