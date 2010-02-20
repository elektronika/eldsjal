<h3>Hoppa In</h3>
<form id="login" action="/login.php" method="post">
	Användarnamn<br/>
	<input type="text" class="form-item-text" tabindex="1" name="username" value="<?php echo $username; ?>" id="username">
	Lösenord:<br/>
	<input type="password" class="form-item-text" tabindex="2" name="password" id="password">
	<input class="form-item-submit" type="submit" value="JA!" name="submit" id="submit">	
	
	<label for="cookie"><input type="checkbox" checked="checked" value="1" name="cookie">kom ihåg mig</label>
	<br/>
	<a href="register.php">Bli medlem &raquo;</a><br>
	<a href="retrievePassword.php">Tappat lösen? &raquo;</a>
</form>
