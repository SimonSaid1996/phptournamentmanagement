<?php
require "dbprojectinfo.php";//"Needs" to be in seperate file because this line is used in multiple different files

$connection = mysqli_connect($dbserver,$dbuser,$dbpass,$dbdatabase);

// If connection was not successful, handle the error
if($connection === false) {
	echo "connection error";
	echo mysqli_error($connection);	
}

$addtype=$_GET['addtype'];//What was selected in the dropdown
$submitType=$_GET['submitType'];//Which submit button was pressed

if($submitType==="update"){//If update existing was pressed
	if($addtype==="tournament"){//Tournament was selected
		echo "What tournament do you want to update?";
		$result = mysqli_query($connection, "SELECT tournamentName, tournamentID FROM tournament");//Pretty much copied from the other one until </select>
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377TournamentData\" method=\"post\">";//Noting that I'm erring on the side of making a lot of smaller files this time
			echo "<select name=tID>";//Simon's best friend
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value=\"$row[tournamentID]\">$row[tournamentName]</option>";
			}
		echo "</select>";
		echo "<input type=\"submit\" value=\"Submit\"></form> ";
		echo "tournament/contest stuff";//To be deleted in non-skeleton
		}
	}
	if($addtype==="team"){
		echo "What team do you want to update?";
		$result = mysqli_query($connection, "SELECT teamName FROM team");//Entire if statement pretty much copied from above
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377TeamData\" method=\"post\">";
			echo "<select name=teamID>";
			while ($row = mysqli_fetch_assoc($result)) {
				$curTeam=$row["teamName"];//You cannot use $row["whatever"] and get the same result multiple times. If you need to, another variable is needed
				echo "<option value=\"$curTeam\">$curTeam</option>";
			}
		echo "</select>";
		echo "<input type=\"submit\" value=\"Submit\"></form> ";
		echo "team stuff";//To be deleted in non-skeleton
		}
	}
	if($addtype==="media"){
		echo "What form of exposure do you want to update?";//Try to think of something that sounds better, I can't
		$result = mysqli_query($connection, "SELECT companyName From media");//Entire if statement pretty much copied from above
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377MediaData\" method=\"post\">";
			echo "<select name=mediaID>";
			while ($row = mysqli_fetch_assoc($result)) {
				$curMedia=$row["companyName"];
				echo "<option value=\"$curMedia\">$curMedia</option>";
			}
		echo "</select>";
		echo "<input type=\"submit\" value=\"Submit\"></form> ";
		echo "media stuff";//To be deleted in non-skeleton
		}
	}
	if($addtype==="member"){
		echo "What player do you want to update?";
		$result = mysqli_query($connection, "SELECT memberName, memberEmail FROM member");//Entire if statement pretty much copied from above
		if($result === false) {
			echo "Generic Error Message.";
			echo mysqli_error($connection);
		} 
		else{
			echo "<form action=\"CS377MemberData\" method=\"post\">";
			echo "<select name=memberID>";
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<option value=\"$row[memberEmail]\">$row[memberName]</option>";
			}
		echo "</select>";
		echo "<input type=\"submit\" value=\"Submit\"></form> ";
		echo "member stuff";//To be deleted in non-skeleton
		}
	}
}
else{
	echo "New";//Make more interesting later
	if($addtype==="tournament"){echo "tournament";}//Full forms for each of these coming in non-skeleton version. 
	if($addtype==="team"){echo "team";}//They will all lead to a single InsertNew php file, where the querys will be written.
	if($addtype==="media"){echo "media";}//I don't think seperate files will be necessary for that one, as all of the required info should be obtained here
	if($addtype==="member"){echo "member";}//echos here are only for testing purposes
	echo "<input type='hidden' name='addtype' value=\"$addtype\">";//regardless, push this on to the next page to sort there as well.
}
echo "<form action=\"CS377InsertData.html\" method=\"get\">";//Back Button?
echo "<input type=\"submit\" value=\"Back\"></form>";
?>