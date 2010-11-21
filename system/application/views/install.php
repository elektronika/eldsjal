<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="/alt_style/style.css" type="text/css" media="screen" charset="utf-8">
	<title>Installera</title>
	
</head>

<body class="plain">
<h1>Installera Eldsjäl</h1>
<?php
echo form_open('/install/install')
.input('text', 'dsn', 'DSN')
.p('dbdriver://username:password@hostname/database')
.input('text', 'admin_email', 'Administratörens email')
.input('text', 'admin_username', 'Administratörens användarnamn')
.input('text', 'admin_first_name', 'Administratörens förnamn')
.input('text', 'admin_last_name', 'Administratörens efternamn')
.input('password', 'admin_password', 'Administratörens lösenord')
.submit()
.form_close();
?>

</body>
</html>
