		
			<form action="calendarView.php?search=List" method="post" name="search">
			AktivitetsNamn<br>
			<input type="text" class="formButton" name="activityTitle">
			<br>
			<select class="selectBox" name="locationid">
			
			<option value="0">Alla</option>
			<?php 
$sql = "select locationid, locationname from locations order by sortorder asc, locationname";
$searchLocation = $conn->execute( $sql );
$searchLocations = $searchLocation;
foreach( $searchLocations as $searchLocation ) {
	print "<option value=\"".$searchLocation['locationid']."\">".$searchLocation['locationname']."</option>";

	//  $searchLocation->moveNext;
}
?>
			</select>
			<img src="images\1x1.gif" width="70" height="1">S&ouml;k
			<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
			</form>
			


