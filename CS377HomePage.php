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

?>

<head>
<style>
body {
    background-image: url("Gradient1.png");<!-- import image here -->
}
</style>
<title>E-Sports</title>
</head>
<body>
<center>

<h1>Click to view more about the following!</h1>
<br> <br>
Tournaments:
<br>
<form action="CS377TournamentPage.php" method="post">
<?php
$result = mysqli_query($connection, "SELECT tournamentName, tournamentID FROM tournament");
if($result === false) { //error checking
    echo "No tournaments found.";
	echo mysqli_error($connection);
} else {
	
echo "<select name=tourID>";
	while ($row = mysqli_fetch_assoc($result)) {//get tournamentID from user and print out tournament names
		echo "<option value=\"$row[tournamentID]\">$row[tournamentName]</option>";
	}
}
?>
</select>
<input type="submit" value="Submit"> 
</form>

<br>
Teams:
<br>
<form action="CS377TeamPage.php" method="post">
<?php
$result = mysqli_query($connection, "SELECT teamName FROM team");
if($result === false) { //error checking
    echo "No teams found.";
	echo mysqli_error($connection);
} else {
	
echo "<select name=teamName>";//print out teamName
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<option value=\"$row[teamName]\">$row[teamName]</option>";
	}
}
?>
</select>
<input type="submit" value="Submit"> 
</form>

<br>
Players:
<br>
<form action="CS377PlayerPage.php" method="post">
  <!-- use post instead of get, posting more data -->
<?php
$result = mysqli_query($connection, "SELECT memberName FROM member");
if($result === false) { //error checking
    echo "No players found.";
	echo mysqli_error($connection);
} else {
	
echo "<select name=memberEmail>";
	while ($row = mysqli_fetch_assoc($result)) {//use memberEmail to print out the memberName
		echo "<option value=\"$row[memberEmail]\">$row[memberName]</option>";
	}
}
?>
</select>
<input type="submit" value="Submit"> 
</form>

</center>
</body>
</html>