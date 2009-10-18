<?php
  session_start( );
session_register( "userid_session" );
session_register( "userType_session" );
session_register( "userName_session" );
session_register( "userid_session" );
session_register( "boardMember_session" );
?>
<?php require_once( 'topInclude.php' );?>

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
	print "<div align=\"center\" class=\"message\">".$_GET['message']."</div>";
}
if( $_SESSION['userid'] == "" || $_SESSION['userid'] == 0 ) {
	header( "Location: "."userPresentation.php?userid=".$_GET['userid'] );
}

// [unsupported] session.timeout=30;

?>
	<tr>
		<td valign="top">	
		<div class="boxLeft">
		<?php require_once( 'toolbox.applet.php' );?>
		</div>	


		</td>
		<td height="190" valign="top">	
	<?php 

print $_GET['message'];
if( $_GET['mode'] == "save" ) {
	$sql = "insert into linkscategories (linkscategoryname, categorysortorder) values ('".cq( $_POST['categoryname'] )."', ".intval( $_POST['sortorder'] ).")";
	$pumpit = $conn->execute( $sql );
	$pumpit = null;
	header( "Location: "."linksAdmin.php?message=Kategorin registrerad!" );
}
elseif( $_GET['mode'] == "update" ) {
	if( $_SESSION['usertype'] < $application['linksadmin'] ) {
		header( "Location: "."links.php?message=Du har inte r&auml;ttigheter till det d&auml;r!" );
	}
	if( $_GET['id'] == "" ) {
		header( "Location: "."linksAdmin.php?message=Ingen s&aring;dan kategori i databasen" );
	}
	$sql = "update linkscategories set linkscategoryname = '".cq( $_POST['categoryname'] )."', categorysortorder = ".intval( $_POST['sortorder'] )." where linkscategoryid = ".intval( $_GET['id'] );

	//	response.Write(SQL)
	//	response.end

	$pumpit = $conn->execute( $sql );
	$pumpit = null;
	header( "Location: "."linksAdmin.php?message=Kategori #".$_GET['id']." uppdaterad" );
}
elseif( $_GET['mode'] == "edit" ) {
	if( $_GET['id'] == "" ) {
		header( "Location: "."linksAdmin.php?message=Ingen s&aring;dan kategori finns i databasen" );
	}
	if( $_SESSION['usertype'] < $application['linksadmin'] ) {
		header( "Location: "."links.php?message=Du har inte r&auml;ttigheter till det d&auml;r!" );
	}
	$sql = "select * from linkscategories where linkscategoryid = ".intval( $_GET['id'] );
	$result = $conn->execute( $sql );
	$sql = "select count(linkscategoryid) as linkscount from linkscategories";
	$linksCount = $conn->execute( $sql );
	if( $result ) {
		print "<form action=linksAdmin.php?mode=update&id=".$_GET['id']." method=post ID=Form1>";
		?>
			L&auml;nkkategorinamn:<br><input type="text" class="inputBorder" name="categoryName" ID="Text1" value="<?php     echo rq( $result['linkscategoryname'] );?>"><br>
			Sorteringsordning:<br><select class=selectBox  name="sortorder">
				<?php 
    $counter = 1;
		while( intval( $counter ) <= intval( $linksCount['linkscount'] ) ) {
			print "<option value=\"".$counter."\"";
			if( $result['categorysortorder'] == $counter ) {
				print " selected ";
			}
			print ">".$counter."</option><br>";
			$counter = $counter + 1;
		}
		?>	
			</select><br>
			Update <input type="image" src="images/icons/arrows.gif" value="Update">
			
			<?php 
    $result = null;
	}
	else {
		header( "Location: "."linksAdmin.php?message=Ingen s&aring;dan kategori i databasen" );
	}
}
elseif( $_GET['mode'] == "new" ) {
	$sql = "select count(linkscategoryid) as linkscount from linkscategories";
	$linksCount = $conn->execute( $sql );
	print "<form action=linksAdmin.php?mode=save method=post ID=Form1>";?>
			L&auml;nkkategorinamn:<br><input class="inputBorder" type="text" name="categoryName" ID="Text1"><br>
				Sorteringsordning:<br><select class="selectBox" name="sortorder" ID="Select1">
				<?php 
  $counter = 1;
	while( intval( $counter ) <= intval( $linksCount['linkscount'] ) ) {
		print "<option value=".$counter.">".$counter."</option>";
		$counter = $counter + 1;
	}
	print "<option value=".$counter." selected >".$counter."</option>";
	?>	
			</select><br>
			<input type="image" src="images/icons/arrows.gif" value="Save">
			</form>
		<?php
}
elseif( $_GET['mode'] == "deleteCategory" ) {
	if( $_SESSION['usertype'] < $application['linksadmin'] ) {
		header( "Location: "."linksAdmin.php?message=Du har inte r&auml;ttigheter att ta bort kategorier" );
	}
	if( $_GET['id'] == "" ) {
		header( "Location: "."linksAdmin.php?message=Inget ID angivet" );
	}
	$sql = "select count(linksid) as links from links where categoryid = ".intval( $_GET['id'] );
	$links = $conn->execute( $sql );
	$sql = "delete from links where categoryid = ".intval( $_GET['id'] );
	$conn->execute( $sql );
	$sql = "delete from linkscategories where linkscategoryid = ".intval( $_GET['id'] );
	$conn->execute( $sql );
	header( "Location: "."linksAdmin.php?message=Tog bort kategori id: ".$_GET['id']." med tillh&ouml;rande ".$links['links']." l&auml;nkar!" );
}
else {
	?>

		<table bgColor=#cccccc border="0" cellpadding="5" cellspacing="0">
		<tr>
		<td colspan="4">
			<a href="linksAdmin.php?mode=new" class="a2">Ny l&auml;nkkategori&raquo;</a>
		</td>
		</tr>
		<tr>
		<td>
		&nbsp;
		</td>
		<td>
		Kategorinamn
		</td>
		<td>
		Sorteringsordning
		</td>
		<td>
		L&auml;nkar
		</td>
		<td>
		&nbsp;
		</td>
		</tr>
		<?php 
  $sql = "select * from linkscategories order by categorysortorder asc";
	$result = $conn->execute( $sql );
	$results = $result;
	foreach( $results as $result ) {
		$sql = "select count(linksid) as links from links where categoryid = ".$result['linkscategoryid'];
		$links = $conn->execute( $sql );
		print "<tr><td class=ForumTopic1><img src=images/folder.gif></td><td><a href=linksAdmin.php?id=".$result['linkscategoryid']." class=a3>".rq( $result['linkscategoryname'] )."</a></td><td align=middle>".$result['categorysortorder']."</td><td>".$links['links']."</td><td>";
		if( $_SESSION['usertype'] >= $application['linksadmin'] ) {
			print "<a href=linksAdmin.php?mode=edit&id=".$result['linkscategoryid']." class=a3><img src=images/icons/edit.gif border=0 alt=\"Edit category\"></a>&nbsp;<a href=linksAdmin.php?mode=deleteCategory&id=".$result['linkscategoryid']." onClick=\"return confirmSubmit('Vill du verkligen ta bort kategorin med alla tillh&ouml;rande l&auml;nkar?')\"><img src=images/icons/trashcan.gif border=0 alt=\"Delete category\"></a>";
		}
		else {
			print "&nbsp;";
		}
		print "</td></tr>";

		//    $result->moveNext;
	}
	?>
		
		</table>
		
		<?php
}
?>
		</td>
	</tr>
	
	
	
<?php require_once( 'bottomInclude.php' );?>
