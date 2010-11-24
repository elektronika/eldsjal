<h3>Eldsjälsstatus</h3>
<p>
<?php
$sql = "select * from statistics order by statisticsid desc limit 1";	
$statistics = $this->db->query( $sql )->result_array();
$statistics = current($statistics);
$start_date = mktime( 0, 0, 0, 5, 1, 2003 );
$diff = time( ) - $start_date;
$age = round( $diff / ( 3600 * 24 ) );
print "Medlemmar: ".$statistics['memberCount']."<br>Sovande: ".$statistics['sleepers']."<br>Medel&aring;lder: ".$statistics['averageAge']."<br>26 & &ouml;ver: ".$statistics['above']."<br>Under 26: ".$statistics['below']."<br>Funnits i ".$age." dagar "."<br>Unika bes&ouml;k: ".$statistics['uniqueHits']."<br>Forumtr&aring;dar: ".$statistics['forumTopics']."<br>Foruminl&auml;gg: ".$statistics['forumMessages']."<br>Total inlogg: ".$statistics['loginCount']."<br>Tankar: ".$statistics['diarys']."<br>Aktiviteter: ".$statistics['events']."<br>G&auml;stboksinl&auml;gg: ".$statistics['guestbooks']."<br>Bilder: ".$statistics['images']."<br>";
?></p>