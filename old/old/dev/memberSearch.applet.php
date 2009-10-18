<?php
$content = '<form id="search" action = "members.php?mode=listMembers" method = "post" name = "search"> Anv&auml;ndarnamn <br/> 
	<input type = "text" class = "formButton" name = "username" id = "userName"/> 
	<img src = "images/1x1.gif"width = "50"height = "1" > 
	S&ouml;k 
	<input type = "image" src = "images/icons/arrows.gif" name = "search" id = "search" class = "proceed"/> 
	</form> 
	<a href = "members.php?mode=advSearch" class = "a2" > supers&ouml;ken&raquo; </a>';

print theme_box('Sök medlem:', $content);