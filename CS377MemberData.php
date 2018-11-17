<html>
<head>
<title>Edit Member Data</title>
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
else{     //team=selectedEmail  teamID=inputEmail    check yours and correct mine part into yours
	if(isset($_POST['inputEmail'])){
		$selectedEmail=$_POST['inputEmail'];
		
		$result = mysqli_query($connection, "SELECT memberName, memberEmail, memberPhoneNum, dateOfBirth,winLossRatio FROM member WHERE memberEmail='$selectedEmail'");
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377MemberData.php\" method=\"post\">";
			echo "<h1>selectedEmail</h1>";//Add Statistics here
			echo "<table><input type='hidden' name='removeFromTeam' value='$selectedEmail'";
			echo "<tr><td>memberinfo</td><td>Role</td>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr><td>$row[memberName]</td><td>$row[memberEmail]</td><td>$row[memberPhoneNum]</td>
				<td>$row[dateOfBirth]</td><td>$row[winLossRatio]</td>
				<td><button name=\"remove\" value=\"$row[memberEmail]\" type=\"submit\">Remove</button></td></tr>";
			}
			echo"</table><button name=\"addMember\" value=\"$selectedEmail\" type=\"submit\">Add Player</button>";
			echo"<button name=\"deleteTeam\" value=\"$selectedEmail\" type=\"submit\">deleteTeam</button></form>";//Statistics button
			?><br><form action="CS377InsertData.html" method="get">
			<input type="submit" value="Return to Start"></form><?php
		}
	}
	
	
	// i have no idea why this section of code exists.
	else if(isset($_POST['addTOEmail'])){
		$selectedEmail=$_POST['addToEmail'];
		$result = mysqli_query($connection, "SELECT memberName, memberEmail, memberPhoneNum, dateOfBirth,winLossRatio FROM member WHERE memberEmail!='$selectedEmail'");
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377TeamData.php\" method=\"post\">";// i think that we need to change CS377TeamData.php into other php files but i am not sure
			echo "<select memberEmail='addedEmail'>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value=\"$row[memberEmail]\">$row[memberName]</option>";
			}
			echo "</select><input type='hidden' name='addToEmail' value='$selectedEmail'>";
			echo "Add member name: <input type=\"text\" size=\"30\" name=\"memberName\">";
			echo "Add member phone: <input type=\"text\" size=\"30\" name=\"memberPhoneNum\">";
			echo "Add member birthdate: <input type=\"text\" size=\"30\" name=\"dateOfBirth\">";// we need to change it into the correct form
			echo "Add member winning record: <input type=\"text\" size=\"30\" name=\"winLossRatio\">";
			echo "<input type='submit' value='Add Player'></form>";
			?><br><form action="CS377InsertData.html" method="get">
			<input type="submit" value="Return to Start"></form><?php
		}
	}
	else if(isset($_POST['addedEmail'])){//addedEmail is the momberPhoneNum, i tried to match Matthew's code but failed so bad, we also need to add dateOfBirth,winLossRatio
		$query="INSERT INTO `member` (`memberName`, `memberEmail`, `memberPhoneNum`,'dateOfBirth','winLossRatio') VALUES ('$_POST[memberName]', '$_POST[addToEmail]', 
		'$_POST[memberPhoneNum]','$_POST[dateOfBirth]','$_POST[winLossRatio]')";
		$result = mysqli_query($connection,$query);
		if($result === false) {
			echo "insert failed";
			echo mysqli_error($connection);
		} 
		else {echo "New memberinfo added.";}
		?>
		<form action="CS377TeamData.php" method="post">      
		<input type='hidden' name='addMember' value="<?php echo "$_POST[addToTeam]";?>">  <!-- again, i am not sure which files i should change into here -->
		<input type="submit" value="Add Another Member"></form><?php
	}
	else if(isset($_POST['remove'])){
		$success=mysqli_query($connection, "DELETE FROM member WHERE memberEmail='$_POST[remove]'");// not sure if this is right, supposed to be right
		if ($success){echo "Member Removed";}
		else{echo "Member Not Removed";}
		echo "<br><form action='CS377TeamData.php' method='post'><input type='hidden' name='inputEmail' value='$_POST[removeFromTeam]'>";// i know this part is wrong, but can't change any because i don't have enough information
		echo "<input type='submit' value='Back to Member List'></form>";
	}
	else if(isset($_POST['deleteMember'])){
		$sucA=mysqli_query($connection,"DELETE FROM member '$_POST[deleteMember]'=memberEmail");
		$sucB=mysqli_query($connection,"DELETE FROM member WHERE '$_POST[deleteMember]'=memberEmail");//Reconfigure seeds?
		$sucC=mysqli_query($connection,"DELETE FROM team_member WHERE '$_POST[deleteMember]'=memberEmail");
		$sucD=mysqli_query($connection,"DELETE FROM team_outstandingstatistic WHERE '$_POST[deleteMember]'=memberEmail");
		if($sucA&&$sucB&&$sucC&&$sucD){echo "Delete successful.";}// something might be wrong here , make sure to check and test
		else{echo "Delete failed.";}
		?><br><form action="CS377InsertData.html" method="get"><!-- again, i am not sure which files i should change into here -->
		<input type="submit" value="Return to Start"></form><?php
	}
}
?>
</body>
</html>