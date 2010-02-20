<h3>Hoppa In</h3>
<form id="login" action="login.php" method="post">
	Användarnamn<br/>
	<input type="text" tabindex="1" name="username" value="<?php echo $username; ?>" id="username">
	Lösenord:<br/>
	<input type="password" tabindex="2" name="password" id="password">
	<img src="images/icons/kort.gif"/>
	<input type="submit" value="LOGGA IN" name="submit" id="submit">
	</div>
	
	<div align="right" class="small">kom ihåg mig
	<input type="checkbox" checked="checked" value="1" name="cookie">
	<br/>
	<a href="register.php">Bli medlem &raquo;</a><br>
	<a href="retrievePassword.php">Tappat lösen? &raquo;</a>
	</div>
</form>
