<html>
<head>
<title>Edit team Data</title>
</head>
<body>
<?php
require "dbprojectinfo.php";//"Needs" to be in seperate file because this line is used in multiple different files

$connection = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdatabase);

// If connection was not successful, handle the error
if($connection === false) {
	echo "connection error";
	echo mysqli_error($connection);	
}
else{
	if(isset($_POST['teamID'])){
		$team=$_POST['teamID'];
		
		$result = mysqli_query($connection, "SELECT memberName, member.memberEmail, role FROM member, team_member WHERE teamName='$team' AND member.memberEmail=team_member.memberEmail");
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377TeamData.php\" method=\"post\">";
			echo "<h1>team</h1>";//Add Statistics here
			echo "<table><input type='hidden' name='removeFromTeam' value='$team'";
			echo "<tr><td>Name</td><td>Role</td>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>$row[memberName]</td><td>$row[role]</td><td><button name=\"remove\" value=\"$row[memberEmail]\" type=\"submit\">Remove</button></td></tr>";
			}
			echo"</table><button name=\"addMember\" value=\"$team\" type=\"submit\">Add Player</button>";
			echo"<button name=\"deleteTeam\" value=\"$team\" type=\"submit\">deleteTeam</button></form>";//Statistics button
			?><br><form action="CS377InsertData.html" method="get">
			<input type="submit" value="Return to Start"></form><?php
		}
	}
	else if(isset($_POST['addedMember'])){
		$team=$_POST['addedMember'];
		$result = mysqli_query($connection, "SELECT memberName, member.memberEmail FROM member, team_member WHERE teamName!='$team' AND member.memberEmail=team_member.memberEmail");
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377TeamData.php\" method=\"post\">";
			echo "<select name='addedMember'>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value=\"$row[memberEmail]\">$row[memberName]</option>";
			}
			echo "</select><input type='hidden' name='addToTeam' value='$team'>";
			echo "Add member with role: <input type=\"text\" size=\"30\" name=\"memberRole\">";
			echo "<input type='submit' value='Add Player'></form>";
			?><br><form action="CS377InsertData.html" method="get">
			<input type="submit" value="Return to Start"></form><?php
		}
	}
	else if(isset($_POST['addMember'])){
		$query="INSERT INTO `team_member` (`teamName`, `memberEmail`, `role`) VALUES ('$_POST[addToTeam]', '$_POST[addedMember]', '$_POST[memberRole]')";
		$result = mysqli_query($connection,$query);
		if($result === false) {
			echo "insert failed";
			echo mysqli_error($connection);
		} 
		else {echo "New member added to the team.";}
		?>
		<form action="CS377TeamData.php" method="post">
		<input type='hidden' name='addMember' value="<?php echo "$_POST[addToTeam]";?>">
		<input type="submit" value="Add Another Member"></form><?php
	}
	else if(isset($_POST['remove'])){
		$success=mysqli_query($connection, "DELETE FROM team_member WHERE memberEmail='$_POST[remove]' AND teamName='$_POST[removeFromTeam]'");
		if ($success){echo "Member Removed";}
		else{echo "Member Not Removed";}
		echo "<br><form action='CS377TeamData.php' method='post'><input type='hidden' name='teamID' value='$_POST[removeFromTeam]'>";
		echo "<input type='submit' value='Back to Member List'></form>";
	}
	else if(isset($_POST['deleteTeam'])){
		$sucA=mysqli_query($connection,"DELETE FROM team WHERE '$_POST[deleteTeam]'=teamName");
		$sucB=mysqli_query($connection,"DELETE FROM tournament_team WHERE '$_POST[deleteTeam]'=teamName");//Reconfigure seeds?
		$sucC=mysqli_query($connection,"DELETE FROM team_member WHERE '$_POST[deleteTeam]'=teamName");
		$sucD=mysqli_query($connection,"DELETE FROM team_outstandingstatistic WHERE '$_POST[deleteTeam]'=teamName");
		if($sucA&&$sucB&&$sucC&&$sucD){echo "Delete successful.";}
		else{echo "Delete failed.";}
		?><br><form action="CS377InsertData.html" method="get">
		<input type="submit" value="Return to Start"></form><?php
	}
}
?>
</body>
</html>