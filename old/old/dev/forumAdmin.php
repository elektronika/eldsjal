<?php
session_start( );






require_once( 'header.php' );?>

<script LANGUAGE="JavaScript">
function confirmSubmit(message)
{
var agree=confirm(message);
if (agree)
	return true ;
else
	return false ;
}
</script>
<?php 

if( $_GET['message'] != "" ) {
	print "<div class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 || $_SESSION['usertype'] < 2 ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}

// [unsupported] session.timeout=1000;

?>
	<tr>
		<td>
<?php require_once( 'toolbox.applet.php' );?>
		</td>
		<td height="190">	
<?php 

print $_GET['message'];
if( $_GET['mode'] == "save" ) {
	$sql = "insert into forumcategory (forumcategoryname, forumcategorysortorder, forumcategorydesc, forumcategorythreads, forumcategorylatestpost, forumsecuritylevel) values ('".cq( $_POST['categoryname'] )."', ".intval( $_POST['sortorder'] ).", '".cq( $_POST['categorydesc'] )."', 0, getdate(), ".intval( $_POST['security'] ).")";
	$pumpit = $conn->execute( $sql );
	$pumpit = null;
	header( "Location: "."forumAdmin.php?message=Category added to list" );
}
elseif( $_GET['mode'] == "update" ) {
	if( $_GET['id'] == "" ) {
		header( "Location: "."forumAdmin.php?message=No category specified" );
	}
	$sql = "update forumcategory set forumcategoryname = '".cq( $_POST['categoryname'] )."', forumcategorysortorder = ".intval( $_POST['sortorder'] ).", forumcategorydesc = '".cq( $_POST['categorydesc'] )."', forumsecuritylevel = ".intval( $_POST['security'] )." where forumcategoryid = ".intval( $_GET['id'] );

	//	response.Write(SQL)
	//	response.end

	$pumpit = $conn->execute( $sql );
	$pumpit = null;
	header( "Location: "."forumAdmin.php?message=Category #".$_GET['id']." updated" );
}
elseif( $_GET['mode'] == "edit" ) {
	if( $_GET['id'] == "" ) {
		header( "Location: "."forumAdmin.php?message=No such category exists in the database" );
	}
	$sql = "select * from forumcategory where forumcategoryid = ".intval( $_GET['id'] );
	$result = $conn->execute( $sql );
	$sql = "select count(forumcategoryid) as forumcount from forumcategory";
	$forumCount = $conn->execute( $sql );
	if( $result ) {
		print "<form action=forumAdmin.php?mode=update&id=".$_GET['id']." method=post ID=Form1>";
		?>
			<input type="text" class="forum" name="categoryName" id="Text1" value="<?php     echo rq( $result['forumcategoryname'] );?>"/>
			<select name="sortorder">
<?php 
  $counter = 1;
		while( intval( $counter ) <= intval( $forumCount['forumcount'] ) ) {
			print "<option value=\"".$counter."\"";
			if( $result['forumcategorysortorder'] == $counter ) {
				print " selected ";
			}
			print ">".$counter."</option><br/>";
			$counter = $counter + 1;
		}
		?>	
			</select>
			<textarea class="forum" name="categoryDesc" rows="10" cols="40"><?php     echo rqForm( $result['forumcategorydesc'] );?></textarea><br/>
			Login required: 
			 no: <input type="radio" name="security" value=0 <?php     if( $result['forumsecuritylevel'] == 0 ) {
			print " checked ";
		}?> id="Radio1"> yes: <input type="radio" name="security" <?php     if( $result['forumsecuritylevel'] == 1 ) {
			print " checked ";
		}?> value=1 id="Radio2"><br/>
			Update <input type="image" src="images/icons/arrows.gif" value="Update"/>
<?php 
  $result = null;
	}
	else {
		header( "Location: "."forumAdmin.php?message=No such category exists in the database" );
	}
}
elseif( $_GET['mode'] == "new" ) {
	$sql = "select count(forumcategoryid) as forumcount from forumcategory";
	$forumCount = $conn->execute( $sql );
	print "<form action=forumAdmin.php?mode=save method=post ID=Form1>";?>
			<input type="text" name="categoryName" id="Text1"/>
				<select name="sortorder" id="Select1">
<?php 
$counter = 1;
	while( intval( $counter ) <= intval( $forumCount['forumcount'] ) ) {
		print "<option value=".$counter.">".$counter."</option>";
		$counter = $counter + 1;
	}
	print "<option value=".$counter." selected >".$counter."</option>";
	?>	
			</select><br/>
			<textarea name="categoryDesc" rows="10" cols="40"></textarea><br/>
			Login required: 
			no: <input type="radio" name="security" value=0 checked id="Radio1"> yes: <input type="radio" name="security" value=1 id="Radio2"/><br/>
			<input type="image" src="images/icons/arrows.gif" value="Save"/>
			</form>
<?php
}
elseif( $_GET['mode'] == "recount" ) {
	$sql = "select topicid from forumtopics";
	$totalTopics = $conn->execute( $sql );
	$i = 0;
	$totalTopicss = $totalTopics;
	foreach( $totalTopicss as $totalTopics ) {
		$sql = "select messageid as number from forummessages where topicid = ".$totaltopics['topicid'];
		$totale = $conn->execute( $sql );
		$forumCount = 0;
		$totales = $totale;
		foreach( $totales as $totale ) {
			$forumCount = $forumCount + 1;

			//      $totale->moveNext;
		}
		$sql = "update forumtopics set totalentrys = ".intval( $forumcount ) - 1. " where topicid = ".$totaltopics['topicid'];
		$justDoIt = $conn->execute( $sql );
		$i = $i + 1;
		print "Set ".$forumCount." posts on topicid: ".$totalTopics['topicid']." <br/>";

		//    $totalTopics->moveNext;
	}
	print "Updated threadCount at threadlevel: ".$i." updates<br/>";
	$i = 0;
	$sql = "select forumcategoryid from forumcategory";
	$totalCategory = $conn->execute( $sql );
	$totalCategorys = $totalCategory;
	foreach( $totalCategorys as $totalCategory ) {
		$sql = "select count(topicid) as totale from forumtopics where forumcategoryid = ".intval( $totalcategory['forumcategoryid'] );
		$totalT = $conn->execute( $sql );
		$sql = "update forumcategory set forumcategorythreads = ".$totalt['totale']." where forumcategoryid = ".$totalcategory['forumcategoryid'];
		$conn->execute( $sql );
		$i = $i + 1;

		//    $totalCategory->moveNext;
	}
	print "Updated threadCount at categoryLevel: ".$i." updates<br/>";
}
elseif( $_GET['mode'] == "deleteCategory" ) {
	if( $_SESSION['usertype'] < $application['forumadmin'] ) {
		header( "Location: "."forumAdmin.php?message=You dont have sufficient rights to delete a category" );
	}
	$messageCounter = 0;
	$sql = "select forummessages.messageid from forummessages inner join forumtopics on forummessages.topicid = forumtopics.topicid where forumtopics.forumcategoryid = ".intval( $_GET['id'] );
	$list = $conn->execute( $sql );
	$lists = $list;
	foreach( $lists as $list ) {
		$sql = "delete from forummessages where messageid = ".$list['messageid'];
		$conn->execute( $sql );
		$messageCounter = $messageCounter + 1;

		//    $list->moveNext;
	}
	$sql = "delete from forumtopics where forumcategoryid = ".intval( $_GET['id'] );
	$conn->execute( $sql );
	$sql = "delete from forumcategory where forumcategoryid = ".intval( $_GET['id'] );
	$conn->execute( $sql );
	header( "Location: "."forumAdmin.php?message=Deleted category id: ".$_GET['id']." with corresponding ".$messageCounter." messages!" );
}
else {
	?>

		<table bgColor=#cccccc border="0" cellpadding="5" cellspacing="0">
		<tr>
		<td colspan="5">
			<a href="forumAdmin.php?mode=new" class="a2">New category &raquo;</a>
		</td>
		</tr>
		<tr>
		<td>
		&nbsp;
		</td>
		<td>
		Categoryname
		</td>
		<td>
		Threadcount
		</td>
		<td>
		Sortorder
		</td>
		<td>
		&nbsp;</td>
		</tr>
<?php 
$sql = "select forumcategoryid, forumcategorysortorder, forumcategoryname, forumcategorythreads from forumcategory order by forumcategorysortorder asc";
	$result = $conn->execute( $sql );
	$results = $result;
	foreach( $results as $result ) {
		print "<tr><td class=ForumTopic1><img src=images/folder.gif></td><td><a href=forumAdmin.php?id=".$result['forumcategoryid']." class=a3>".rq( $result['forumcategoryname'] )."</a></td><td><b>".$result['forumcategorythreads']."</b></td><td>".$result['forumcategorysortorder']."</td><td><a href=forumAdmin.php?mode=edit&id=".$result['forumcategoryid']." class=a3><img src=images/icons/edit.gif border=0 alt=\"Edit category\"></a>&nbsp;<a href=forumAdmin.php?mode=deleteCategory&id=".$result['forumcategoryid']." onClick=\"return confirmSubmit('Are you sure you want to permanently delete this category?')\"><img src=images/icons/trashcan.gif border=0 alt=\"Delete category\"></a></td></tr>";

		//    $result->moveNext;
	}
	?>
		<tr>
		<td colspan=4>
		<a href="forumAdmin.php?mode=recount">reindex threadCount</a>
		</td></tr>
		</table>
<?php
}
?>
		</td>
	</tr>
<?php require_once( 'footer.php' );?>
