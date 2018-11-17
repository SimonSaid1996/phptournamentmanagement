<?php

$dbserver='localhost';
$dbuser='root';
$dbpass=null;
$dbdatabase='tournamentdb';

//creating the connection
$connection = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdatabase);

// If connection was not successful, handle the error
if($connection === false) {
	echo "connection error";
	echo mysqli_error($connection);
}

if(isset($_POST["tID"])){
	$tourneyID = $_POST["tID"];
	$result = mysqli_query($connection, "SELECT tournamentName, tournamentDes, tournamentLocation, tournamentDateTime FROM tournament WHERE tournamentID=$tourneyID");
	
if($result === false) {
    echo "No tournaments found.";
	echo mysqli_error($connection);
} else {
	$row = mysqli_fetch_assoc($result);
	echo "<head>";
	echo "<title>$row[tournamentName]</title>";
	echo "</head>";
	echo "<body>";
	
	echo "<h1>$row[tournamentName]</h1><p> $row[tournamentDes]</p> <p>Location: $row[tournamentLocation]</p><p>Date: $row[tournamentDateTime]</p>";
	
	$resultA = mysqli_query($connection, "SELECT teamName FROM tournament_team WHERE tournamentID=$tourneyID");

	while ($rowA = mysqli_fetch_assoc($resultA)) {
		$team=$rowA['teamName'];
		echo "<h2>$team</h2>";
		$resultB = mysqli_query($connection, "SELECT memberName FROM team_member, member WHERE team_member.memberEmail=member.memberEmail AND teamName='$team'");
		while ($rowB = mysqli_fetch_assoc($resultB)) {
			echo ("    $rowB[memberName]<br>");
		}
	}
}
}
else{
?>

<head>
<title>Tournament Select</title>
</head>
<body>

Click to view more about the following!
<br> <br>
Tournaments:
<br>
<form action="CS377ProjectB.php" method="post">
<?php
$result = mysqli_query($connection, "SELECT tournamentName, tournamentID FROM tournament");
if($result === false) {
    echo "No tournaments found.";
	echo mysqli_error($connection);
} else {
	
echo "<select name=tID>";
while ($row = mysqli_fetch_assoc($result)) {
	echo "<option value=\"$row[tournamentID]\">$row[tournamentName]</option>";
}
?>
</select>
<input type="submit" value="Submit"> 
</form>

<br>
Teams:
<br>



</body>
<?php
}


}
?>