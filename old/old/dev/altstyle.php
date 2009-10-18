<?php
session_start();
if(!isset($_SESSION['userid']) || empty($_SESSION['userid']) ) {
	header('Location: main.php?message=Tyvärr, endast för inloggade användare!');
	exit();
} else {
	if(!isset($_SESSION['alt_style']) || $_SESSION['alt_style'] == 0) {
		$_SESSION['alt_style'] = 1;
		header('Location: main.php?message=Ålrajt, nu är det nya stilen som gäller!');
	} else {
		$_SESSION['alt_style'] = 0;
		header('Location: main.php?message=Sisådär, då var det tillbaks till det vanliga!');
	}
}