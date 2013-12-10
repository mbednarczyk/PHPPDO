<!DOCTYPE HTML>
<html>
   <head>
		<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">
		<title>AB PHP</title>
		<link rel="stylesheet" type="text/css" href="test.css">   
		<?php include 'class1.php'; 
		$baza = new Demo('mysql');
		session_start();
		?>
   </head>
<body>


<div class="naglowek">
	<?php
if(isset($_SESSION['logowanie'])){
	echo '<div>
	<table class="login"><tr><td>
<form action="index.php" method="post" class="pure-form pure-form-stacked">
    <input type="hidden" name="password">
    <input type="hidden" name="wylogujtest" value=1>
    <input type="submit" value="Wyloguj" class="pure-button pure-button-primary"> 
</form></td></tr>
</table>
</div>';}?>
	<?php
if(!isset($_SESSION['logowanie'])){
echo '<div>
	<table class="login"><tr><td>
<form action="index.php" method="post" class="pure-form pure-form-stacked">
    <input type="text" name="login" placeholder="Login">
    <input type="password" name="password" placeholder="Haslo">
    <input type="hidden" name="zalogujtest" value=1>
    <input type="submit" value="Zaloguj" class="pure-button pure-button-primary"> 
</form></td></tr>
</table>
</div>';
}?>
</div>

<div class="pionowe">
	<br><br>
	<?php 
	echo '<br><table class="tabela">';
	echo '<tr>';
	echo '<td>';
	echo '<a class="a">Kategorie</a>';
	echo '</tr>';
	echo '</td>';
	echo '</table>';
	$baza->przykladowy_select();
	 ?>
<br>
<?php
if(isset($_SESSION['logowanie']))
{ //sprawdzamy czy jestesmy zalogowani
echo '<table border="0" class="tabela">
	<tr>
	<td>
	<a class="a">Funkcje</a>
	</tr>
	</td>
</table>




	<table border="0" class="tabela">
<tr>
<td>
<form action="index.php" method="POST">
<input type="hidden" name="dodaj" value=1>
<input type="submit" value="Dodaj" class="pure-button pure-button-primary">
</form>
</td>
</tr>

<tr>
<td>
<form action="index.php" method="POST">
<input type="hidden" name="usun" value=1>
<input type="submit" value="Usuń" class="pure-button pure-button-primary">
</form>
</td>
</tr>

<tr>
<td>
<form action="index.php" method="POST">
<input type="hidden" name="przenies" value=1>
<input type="submit" value="Przenieś" class="pure-button pure-button-primary">
</form>
</td>
</tr>

<tr>
<td>
<form action="index.php" method="POST">
<input type="hidden" name="zmien" value=1>
<input type="submit" value="Zmień nazwe" class="pure-button pure-button-primary">
</form>
</td>
</tr>
</table>';

}?>
</div>

<div class="poziome" >
	<div class="menzad">
	<?php
if(isset($_SESSION['logowanie'])){
echo '<ul id="menu">
	<li>
	<a href="#"><input type="submit" value="Menu zadań" class="pure-button pure-button-primary"></a>
	<ul>
		<form action="index.php" method="POST">
			<input type="hidden" name="Dodajzad">
		<li><input type="submit" value="Dodaj zadanie" class="pure-button pure-button-primary"></li>
	</form>


		<form action="index.php" method="POST">
			<input type="hidden" name="Edytujzad">
		<li><input type="submit" value="Edytuj zadanie" class="pure-button pure-button-primary"></li>
	</form>

		<form action="index.php" method="POST">
			<input type="hidden" name="Usunzad">
		<li><input type="submit" value="Usun zadanie" class="pure-button pure-button-primary"></li>
	</form>

	</ul>

</li>
</uL>';
}?></div>
</div>


<div class="tresc">
		<?php
		if(!array_key_exists('id_nadkat', $_POST)){
					$id_nadkat = 0;		
					}
					else{
		$id_nadkat =  $_POST['id_nadkat'];
		$baza->glowna($id_nadkat);
		echo '<br>';
	  $baza->pokaz($id_nadkat);
	  }
	  $baza->wyswDodaj();
	  $baza->wyswUsun();
	  $baza->wyswPrzenies();
	  $baza->wyswZmien();
	  $baza->wyswUsunzad();
	  $baza->wyswDodajzad();
	  $baza->wyswEdytujzad();
	  if(array_key_exists('dodajtest', $_POST)){
					if($_POST["wysDodaj"]==0){ 
	$baza->Dodaj();
	header('Refresh: 0; url=index.php');
					}
				else{ 
				$baza->Dodaj2();
				header('Refresh: 0; url=index.php');
				}		
					}
		if(array_key_exists('usuntest', $_POST)){
			$baza->Usun();
			header('Refresh: 0; url=index.php');
		}
		if(array_key_exists('przeniestest', $_POST)){
			$baza->Przenies();
			header('Refresh: 0; url=index.php');
		}
		if(array_key_exists('zmientest', $_POST)){
			$baza->Zmien();
			header('Refresh: 0; url=index.php');
		}
		if(array_key_exists('usunzadtest', $_POST)){
			$baza->Usunzad();
			header('Refresh: 0; url=index.php');
		}
		if(array_key_exists('dodajzadtest', $_POST)){
			$baza->Dodajzad();
			header('Refresh: 0; url=index.php');
		}
		if(array_key_exists('edytujzadtest', $_POST)){
			$baza->Edytujzad();
			header('Refresh: 0; url=index.php');
		}
		if(array_key_exists('wylogujtest', $_POST)){
			//session_start();
			session_unset();
			session_destroy();
			echo '<input type="submit" value="Wylogowano pomyślnie" class="zalogowano">';
			header('Refresh: 1; url=index.php');
		}
		if(array_key_exists('zalogujtest', $_POST)){
			//session_start();
			$baza->zaloguj();
			header('Refresh: 1; url=index.php');
		}

		?>
		
		
</div>


</body>
</html>