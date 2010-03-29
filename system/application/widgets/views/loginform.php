<h3>Hoppa In</h3>
<form id="login" action="/login" method="post">
	<?php echo input('text' ,'username', 'Användarnamn', $username); ?>
	<?php echo input('password' ,'password', 'Lösenord'); ?>
	<input class="form-item-submit" type="submit" value="JA!" name="submit" id="submit">	
	
	<label for="cookie"><input type="checkbox" checked="checked" value="1" name="cookie">kom ihåg mig</label>
	<br/>
	<a href="/register">Bli medlem &raquo;</a><br>
	<a href="/lostpassword">Tappat lösen? &raquo;</a>
</form>
