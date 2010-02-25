<?php
/*
function getMonth( $monthNr ) {
	$months = array('Januari', 'Februari', 'Mars', 'April', 'Maj', 'Juni', 'Juli', 'Augusti', 'September', 'Oktober', 'November', 'December');
	return $months[$monthNr - 1];
}

function getDays( $monthNr ) {
	return cal_days_in_month(CAL_GREGORIAN, $monthNr, date('Y'));
}

function getNext( $s ) {
	extract($GLOBALS);
	// s = sign (eg +,-)
	// am = aktuell m&aring;nad
	// ay = aktuellt &aring;r

	if( $s == "+" ) {
		if( $mm == 12 ) {
			$am = 1;
			$ay = $yyyy + 1;
		}
		else {
			$am = $mm + 1;
			$ay = $yyyy;
		}
	}
	else {
		if( $mm == 1 ) {
			$am = 12;
			$ay = $yyyy - 1;
		}
		else {
			$am = $mm - 1;
			$ay = $yyyy;
		}
	}
	if( strlen( $am ) <= 1 ) {
		$am = "0".$am;
	}
	$function_ret = $am."&yy=".$ay;
	return $function_ret;
}

// Plocka fram aktuellt datum

$datum = time( );
$aManad = date("m");
$aDag = date("d");
$aAr = date("Y");

// Vilken m&aring;nad skall visas?

if( isset( $_GET['mm'] ) && $_GET["mm"] != "" ) {
	$dd = $_GET["dd"];
	$mm = $_GET["mm"];
	$yyyy = $_GET["yy"];
}
else {
	$dd = date( "d", $datum );
	$mm = date( "m", $datum );
	$yyyy = date( "Y", $datum );
}

// Hur m&aring;nga rutor skall skippas f&ouml;rsta veckan?

$skip = date( "w", mktime( 0, 0, 0, $mm, 1, $yyyy ) ) - 1;

//$mm."/1-".$yyyy)+1-1;
//print $skip;

?>
      <table border="0" cellspacing="0" cellpadding="0" ID="Table1">
        <tr class="calendarHeader"> 
          <td> 
            <div class="calendarDayName">M&aring;</div>
          </td>
          <td> 
            <div class="calendarDayName">Ti</div>
          </td>
          <td> 
            <div class="calendarDayName">On</div>
          </td>
          <td> 
            <div class="calendarDayName">To</div>
          </td>
          <td> 
            <div class="calendarDayName">Fr</div>
          </td>
          <td> 
            <div class="calendarDayName">L&ouml;</div>
          </td>
          <td> 
            <div class="calendarDayName">S&ouml;</div>
          </td>
        </tr>
        <?php

$rs = $conn->execute( "SELECT DISTINCT(dd) FROM calendarevents WHERE mm = ".$mm." AND yyyy = ".$yyyy." AND private = 0 ORDER BY dd" );

//print_r($rs);

$rrs = array( );

if(is_array($rs) && ! is_array(current($rs)))
	$rs = array($rs);

if(is_array($rs))
	foreach( $rs as $r ) 
		$rrs[$r['dd']] = $r['dd'];
$rs = $rrs;
$dag = 1 - $skip;
$x = 0;
$skriv = false;
while( !( $x > ( getDays( $mm ) + $skip ) / 7 ) ) {
	print "<tr>";
	for( $y = 1; $y <= 7; $y = $y + 1 ) {
		$bgColor = "#ffffff";
		if( !( $rs == 0 ) ) {
			if( isset( $rs[$dag] ) ) {
				//Om det finns aktivitet p&aring; datumet

				$content = "";
				$bgColor = "#cccccc";

				//Markera d&aring; ramen

				$skriv = "true";

				//Skaffa hoverTexten

				$sql = "SELECT calendarevents.title, locations.locationname FROM calendarevents INNER JOIN locations ON calendarevents.locationid = locations.locationid WHERE calendarevents.private = 0 AND dd = ".$rs[$dag]." AND mm = ".$mm." AND yyyy = ".$yyyy." ORDER BY dd";
				$hovers = $conn->execute( $sql );
				if( ! is_array( current( $hovers ) ) ) 
					$hovers = array($hovers);
				foreach( $hovers as $hover ) {
					$content = $content."<b>".$hover['locationname']."</b>"."- ".$hover["title"]."<br><br>";
				}

			}
		}
		$today = 0;

		if( $aDag.$aManad.$aAr == $dag.$mm.$yyyy ) {
			$today = 1;
		}

		print "<td>";
		if( $dag > 0 && $dag < getDays( $mm ) + 1 ) {
			if( strlen( $dag ) <= 1 ) {
				$dag = "0".$dag;
			}
			if( $skriv == "true" ) {
				//Tidigare satt som dag med aktivitet, markera!

				if( isset( $_GET["dd"] ) && $_GET['dd'] == intval( $dag ) ) {
					print "<div class='calendarDateBoxFilledActive'>"."<a onMouseOver=\"return overlib('".$content."<br><br>');\" onMouseOut=\"return nd();\" href='calendarView.php?dd=".$dag."&mm=".$mm."&yy=".$yyyy."'  class='calendarMarkEvent'>";
				}
				elseif( $today != 1 ) {
					print "<div class='calendarDateBoxFilled'>"."<a onMouseOver=\"return overlib('".$content."<br><br>');\" onMouseOut=\"return nd();\" href='calendarView.php?dd=".$dag."&mm=".$mm."&yy=".$yyyy."'  class='calendarMarkEvent'>";
				}
				else {
					print "<div class='calendarDateBoxFilledToday'>"."<a onMouseOver=\"return overlib('".$content."<br><br>');\" onMouseOut=\"return nd();\" href='calendarView.php?dd=".$dag."&mm=".$mm."&yy=".$yyyy."' class='calendarMarkEventToday'>";
				}
				$today = 0;
				print $dag;

				$skriv = "false";
			}
			else {
				if( isset( $_GET["dd"] ) && intval( $_GET["dd"] ) == intval( $dag ) || intval( $dd ) == intval( $dag ) ) {
					print "<div class='calendarDateBoxActive'>"."<a href='calendarView.php?dd=".$dag."&mm=".$mm."&yy=".$yyyy."'  class='calendarDates'>";
				}
				elseif( $today != 1 ) {
					print "<div class='calendarDateBox'>"."<a href='calendarView.php?dd=".$dag."&mm=".$mm."&yy=".$yyyy."' class='calendarDates'>";
				}
				else {
					print "<div class='calendarDateBoxToday'>"."<a href='calendarView.php?dd=".$dag."&mm=".$mm."&yy=".$yyyy."' class='calendarDates'>";
				}
				$today = 0;
				print $dag;
			}
			print "</a></div></td>";
		}
		$dag = $dag + 1;
	}
	print "</tr>";
	$x = $x + 1;
}
?>
        <tr class="calendarBottom"> 
          <td class="calendarReduceMonth"> 
           <?php 
if( isset( $_GET['dd'] ) && $_GET["dd"] != "" ) {
	$dd = $_GET["dd"];
}
else {
	$dd = date( 'd' );
}
print "<a href=calendarView.php?mm=".getNext( "-" )."&dd=".$dd."><img src='left.gif' width='15' height='10' border='0'></a></td>";
?>
          
          <td colspan="5"> 
            <div class="calendarFooter">
              <?php print getMonth( $mm )." (".$yyyy.")";?>
            </div>
          </td>
          <td class="calendarIncreaseMonth"> 
           <?php 
print "<a href=calendarView.php?mm=".getNext( "+" )."&dd=".$dd."><img src='right.gif' width='15' height='10' border='0'></a>";
?>
          </td>
        </tr>
      </table>
*/ ?>
Poff botta!