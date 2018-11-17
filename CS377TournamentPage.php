<html>
<?php

$dbserver='localhost';
$dbuser='root';
$dbpass=null;
$dbdatabase='tourneydb';

//creating the connection
$connection = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdatabase);

// If connection was not successful, handle the error
if($connection === false) {
	echo "connection error";
	echo mysqli_error($connection);
}

	$tourneyID = $_POST["tourID"];
	$result = mysqli_query($connection, "SELECT tournamentName, tournamentDes, tournamentLocation, tournamentDateTime FROM tournament WHERE tournamentID=$tourneyID");
	
if($result === false) {
    echo "No tournaments found.";
	echo mysqli_error($connection);
} else {
	$row = mysqli_fetch_assoc($result);
	echo "<head>";
	echo "<title>$row[tournamentName]</title>";
	if($tourneyID==1){
	?>
	<style> 
	body {
		background-image: url("Bops3_3.jpg");<!-- set up background -->
		color:red;
	}
	</style>
	<?php
	}
	if($tourneyID==2){
	?>
	<style> 
	body {
		background-image: url("Halo2.png");
		color:red;
	}
	</style>
	<?php
	}
	echo "</head>";
	echo "<body>";
	?>
	<p><a href="http://127.0.0.1/Group4ProjectStatusUpdate/Group4ProjectCode/Group4Project/CS377HomePage.php">Go Back To Home Page</a></p>
	<?php
	echo "<h1>$row[tournamentName]</h1><p> $row[tournamentDes]</p> <p>Location: $row[tournamentLocation]</p><p>Date: $row[tournamentDateTime]</p>";
	// print out result line by lines
	$resultA = mysqli_query($connection, "SELECT teamName FROM tournament_team WHERE tournamentID=$tourneyID");

	while ($rowA = mysqli_fetch_assoc($resultA)) {
		$team=$rowA['teamName'];
		echo "<h2>$team</h2>";
		$resultB = mysqli_query($connection, "SELECT memberName FROM team_member, member WHERE team_member.memberEmail=member.memberEmail AND teamName='$team'");
		while ($rowB = mysqli_fetch_assoc($resultB)) {
			echo ("    $rowB[memberName]<br>");
		}
	}
}//use teamname to get information from team member and print them out
?>
</html>