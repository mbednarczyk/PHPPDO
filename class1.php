<?php
  class Demo
  {
    private $pdo = null;

		//konstruktor nawi¹zuje po³¹czenie z baz¹ danych
		public function __construct($szbd)
		{
      if ($szbd=='mysql') {
		    require("config_mysql.php"); 
			  try {
					$this->pdo = new PDO("mysql:host=$host;dbname=$dbname;port=$port",$login,$haslo, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					//echo 'Po³¹czenie z MySQL zosta³o nawi¹zane!<br>';   
			  	/*$this->pdo = new PDO('mysql:host='.$host.';dbname='.$database.
                                ';port='.$port, $username, $password,
                                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );*/
				} 
				catch(PDOException $e) {
          echo 'Po³¹czenie z MySQL nie mog³o zostaæ utworzone: '.$e->getMessage();
          exit(1);
        }
		  }
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 		
		} // __construct();

    public function przykladowy_select()
    { 
			try{
        $stmt = $this->pdo -> query('SELECT id_kat, nazwa FROM kat WHERE id_nadkat is NULL;');
		echo '<table border="0" class="tabela">';
        foreach($stmt as $row)
        {
        	echo '<tr>';
			echo '<td>';
		//$tmp = $this->pdo -> query("SELECT nazwa FROM kat WHERE id_nadkat='.$row['id_kat'].'";);
		echo '<form action="index.php" method="POST">';
          //echo '<a href="index.php">'.$row['nazwa'].' </a><br />';
		  //echo '<a>'.$row['nazwa'].'</a>';
		  echo '<input type="hidden" name="id_nadkat" value="'.$row['id_kat'].'" />';
		  echo '<input type="submit" value="'.$row['nazwa'].'" class="pure-button pure-button-primary">';
		  echo '</form>';
		  echo '</tr>';
			echo '</td>';
        }
        echo '</table>';
        $stmt -> closeCursor(); // zamkniecie zbioru wynikow 
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
	  
	  
		}//przykladowy_select
		

		public function glowna($id_nadkat){
			try{
				if(!array_key_exists('id_nadkat', $_POST)){
					$id_nadkat = 0;		
					echo "hehehe";
					}
					else {
						echo "Zadania i podkategorie kategorii: ";
						$nn = $this->pdo -> query('SELECT nazwa FROM kat WHERE id_kat = '.$id_nadkat.';');
						foreach($nn as $row){
							echo '<a>'.$row['nazwa'].'</a>';
						}
					}
					$nn -> closeCursor();
			}
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		}
		
		public function pokaz($id_nadkat)
		{
		try{
		if(!array_key_exists('id_nadkat', $_POST)){
					$id_nadkat = 0;		
					echo "hehehe";
					}
					else {

echo '<table display><th><a class="a">Zadania:</a></th><tr><td>';
echo '<table border="1" class="pure-table">
<thead>
<tr>
<th>Nazwa zadania</th>
<th>Trudnosc</th>
</tr>
</thead>
<tbody>';
$stmt3 = $this->pdo->query('SELECT DISTINCT z.nazwa, z.plik_pdf, z.trudnosc, k.id_kat FROM zad z, kat k INNER JOIN kat WHERE z.id_kat=k.id_kat AND k.id_kat = '.$id_nadkat.';');

foreach($stmt3 as $row){
	
echo '<tr>';
echo '<td><a href="zadania/'.$row['plik_pdf'].'">'.$row['nazwa'].'</a></td>';
echo '<td>';
for($i=0; $i<$row['trudnosc']; $i++){ 
echo '<img src="ocena.jpg">';
}
echo '</td>';
echo '</tr>';
}
$stmt3 -> closeCursor();

echo '</tbody></table></td></tr></table>';

echo '<br>';

		$stmt = $this->pdo -> query('SELECT id_kat, nazwa, id_nadkat FROM kat WHERE id_nadkat = '.$id_nadkat.';');
		echo '<table border="0" class="tabela">';
		echo "<th><a class='a'>Podkategorie:</th>"; echo '<br>';
		foreach($stmt as $row)
        {
		echo '<tr>';
			echo '<td>';
		//$tmp = $this->pdo -> query("SELECT nazwa FROM kat WHERE id_nadkat='.$row['id_kat'].'";);
		echo '<form action="index.php" method="POST">';
		 // echo '<a>'.$row['nazwa'].'</a>';
		  echo '<input type="hidden" name="id_nadkat" value="'.$row['id_kat'].'" />';
		  echo '<input type="submit" value="'.$row['nazwa'].'" class="pure-button pure-button-primary">';
		  //echo '<input type="image" src="icon.jpg">';
		  echo '</form>';
		  echo '</tr>';
			echo '</td>';
        }
        echo '</table>';
        $stmt -> closeCursor(); // zamkniecie zbioru wynikow 
		
      } 
	  }
	  
	  
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		}
		
		public function wyswDodaj(){
		try{
		if (array_key_exists('dodaj', $_POST)) {
		$stmt = $this->pdo -> query('SELECT id_kat, nazwa FROM kat;');
			echo '<script>function showHide()        
{            
    if(document.getElementById("podkategoria").checked)
 
        {                
        document.getElementById("nazwanad").style.visibility = "visible"; 
document.getElementById("tekst").style.visibility = "visible";		
        }            
    else            
        {                
        document.getElementById("nazwanad").style.visibility = "hidden";
		document.getElementById("tekst").style.visibility = "hidden";
        }        
}</script>';
			echo '<form action="index.php" method="POST" class="pure-form pure-form-stacked">';
			
			//echo 'ID kategorii: <input type="text" name="id" id="zy" placeholder="ID"><br>';
			echo 'Nazwa kategorii: <input type="text" name="nazwa" placeholder="Nazwa kategorii"><br>'; echo '<label for="podkategoria" class="pure-checkbox">';
			echo 'Będę podkategorią? (zaznaczenie = TAK): <input type="checkbox" id="podkategoria" onclick="showHide();"></label><br>';
			echo '<a name="tekst" id="tekst" style="visibility:hidden;">Podepnij mnie do kategorii:</a>';
			echo '<select id="nazwanad" style="visibility:hidden;" name="wysDodaj">';
			echo '<option value=NULL></option>';
			foreach($stmt as $row){
			 echo '<option value="'.$row['id_kat'].'">'.$row['nazwa'].'</option>';
			}
			 $stmt -> closeCursor();
			echo '</select>';
			echo '<br>';
			echo '<input type="hidden" name="dodajtest" value=1><input type="submit" value="Dodaj" class="pure-button pure-button-primary">';
			echo '</form>';
}
}
catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		
		}
		
		public function Dodaj() {
		try{
			//wersja odporna na sqlinjection
		$stmt = $this->pdo->prepare('INSERT INTO kat (nazwa, id_nadkat) VALUES(:nazwa, NULL)');
		$a=$_POST['nazwa'];
		$stmt -> bindValue(':nazwa', $a, PDO::PARAM_STR);
		$done = $stmt -> execute();

		//Wersja nr1 nie odporna na sqlinjection
		/*$this->pdo -> exec('INSERT INTO kat (nazwa, id_nadkat) VALUES(
				\''.$_POST['nazwa'].'\', NULL)');*/
		
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
	  }
		
		public function Dodaj2(){
		try{
			$stmt = $this->pdo->prepare('INSERT INTO kat (nazwa, id_nadkat) VALUES(:nazwa, :idnadkat)');
			$a=$_POST['nazwa'];
			$b=$_POST['wysDodaj'];
			$stmt -> bindValue(':nazwa', $a, PDO::PARAM_STR);
			$stmt -> bindValue(':idnadkat', $b, PDO::PARAM_INT);
			$done = $stmt -> execute();

		/*Wersja nr1 nie odporna na sqlinjection
		$this->pdo -> exec('INSERT INTO kat (nazwa, id_nadkat) VALUES(
				\''.$_POST['nazwa'].'\', \''.$_POST['wysDodaj'].'\')');*/
		
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		
		
		}
		
		
		public function wyswUsun(){
		try{
		if (array_key_exists('usun', $_POST)) {
		$stmt = $this->pdo -> query('SELECT id_kat, nazwa FROM kat;');
		echo "Wybierz kategorię do usunięcia:";
		echo '<form action="index.php" method="POST" class="pure-form pure-form-stacked">';
		echo '<select name="wysUsun">';
		foreach($stmt as $row)
        {
		  echo '<option value="'.$row['id_kat'].'">'.$row['nazwa'].'</option>';
        }
        $stmt -> closeCursor(); // zamkniecie zbioru wynikow 
		  echo '</select>';
		 echo '<input type="hidden" name="usuntest" value=1><input type="submit" value="Usuń" class="pure-button pure-button-primary">';
		  echo '</form>';
		}
		}
		catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		}
		
		
		public function Usun(){
		try{
		$this->pdo -> exec('DELETE FROM kat WHERE id_kat = '.$_POST['wysUsun'].'');
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		
		}
		
		public function wyswPrzenies(){
		try{
		if (array_key_exists('przenies', $_POST)) {
		echo '<a>Wybierz kategorie do przeniesienia: </a>';
		$stmt = $this->pdo -> query('SELECT id_kat, nazwa FROM kat;');
		$stmt2 = $this->pdo -> query('SELECT id_kat, nazwa FROM kat;');
		echo '<form action="index.php" method="POST" class="pure-form pure-form-stacked">';
		echo '<select name="wysPrzenies">';
		
		foreach($stmt as $row)
        {
		  echo '<option value="'.$row['id_kat'].'">'.$row['nazwa'].'</option>';
        }
        $stmt -> closeCursor(); // zamkniecie zbioru wynikow 
		  echo '</select>';
			echo '<br>';
			echo '<a>Podepnij mnie pod kategorie: </a>';
			echo '<br>';
		echo '<select name="wysPrzenies2">';
		
		foreach($stmt2 as $row)
        {
		  echo '<option value="'.$row['id_kat'].'">'.$row['nazwa'].'</option>';
        }
        $stmt -> closeCursor(); // zamkniecie zbioru wynikow 
		  echo '</select>';
		  echo '<br>';
		 echo '<input type="hidden" name="przeniestest" value=1><input type="submit" value="Przenieś" class="pure-button pure-button-primary">';
		  echo '</form>';
		}
		}
		catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		
		}
		
		public function Przenies(){
		try{
		$this->pdo -> exec('UPDATE kat SET id_nadkat='.$_POST['wysPrzenies2'].' WHERE id_kat = '.$_POST['wysPrzenies'].'');
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		}
		
		
		public function wyswZmien(){
		try{
		if (array_key_exists('zmien', $_POST)) {
		$stmt = $this->pdo -> query('SELECT id_kat, nazwa FROM kat;');
		echo '<form action="index.php" method="POST" class="pure-form pure-form-stacked">';
		echo '<a>Wybierz kategorie, ktorej chcesz zmienic nazwe:</a><br>';
		echo '<select name="wysZmien">';
		foreach($stmt as $row)
        {
		  echo '<option value="'.$row['id_kat'].'">'.$row['nazwa'].'</option>';
        }
        $stmt -> closeCursor(); // zamkniecie zbioru wynikow 
		  echo '</select>';
		  echo '<br>';
		  echo 'Nowa nazwa kategorii: <input type="text" name="id" placeholder="Nowa nazwa kategorii"><br>';
		 echo '<input type="hidden" name="zmientest" value=1><input type="submit" value="Zmień nazwę" class="pure-button pure-button-primary">';
		  echo '</form>';
		}
		}
		catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
		
		}
		
		public function Zmien(){
		try{
			//dodano odpornosc na SQLinjection
			$stmt = $this->pdo->prepare('UPDATE kat SET nazwa=:nazwa WHERE id_kat =:idkat ');
			$a=$_POST['id'];
			$b=$_POST['wysZmien'];
			$stmt -> bindValue(':nazwa', $a, PDO::PARAM_STR);
			$stmt -> bindValue(':idkat', $b, PDO::PARAM_INT);

			$done = $stmt -> execute();

		//Pierwsza opcja - nieodporna na SQLijcetion	
		//$this->pdo -> exec('UPDATE kat SET nazwa="'.$_POST['id'].'" WHERE id_kat = '.$_POST['wysZmien'].'');
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }
	  }


	  public function wyswUsunzad(){
	  	try{
		if (array_key_exists('Usunzad', $_POST)) {
		$stmt = $this->pdo -> query('SELECT id_zad, nazwa FROM zad;');
		echo '<table border="1" class="pure-table">
<thead>
<tr>
<th>Wybierz zadanie do usuniecia</th>
</tr>
</thead>
<tbody><tr><td>';

		echo '<form action="index.php" method="POST" class="pure-form pure-form-stacked">';
		echo '<select name="wysUsunzad">';
		foreach($stmt as $row)
        {
		  echo '<option value="'.$row['id_zad'].'">'.$row['nazwa'].'</option>';
        }
        $stmt -> closeCursor(); // zamkniecie zbioru wynikow 
		  echo '</select><tr><td>';
		 echo '<input type="hidden" name="usunzadtest" value=1><input type="submit" value="Usuń" class="pure-button pure-button-primary">';
		  echo '</form></td></tr>';
		  echo '</tbody></table>';
		}
		}
		catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }

	  }

	  public function Usunzad(){
	try{
		$this->pdo -> exec('DELETE FROM zad WHERE id_zad = '.$_POST['wysUsunzad'].'');
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }

	  }

	  public function wyswDodajzad(){
	  	try{
	  		if (array_key_exists('Dodajzad', $_POST)) {
	  			$stmt = $this->pdo -> query('SELECT id_kat, nazwa FROM kat;');
	  			echo '<table border="1" class="pure-table">
<thead>
<tr>
<th>Wybierz zadanie do usuniecia</th>
</tr>
</thead>
<tbody>';
	  			
	  			echo '<form enctype="multipart/form-data" action="index.php" method="POST" class="pure-form pure-form-stacked">';
				//echo '<tr><td>ID zadania:<input type="text" name="idzad" placeholder="ID zadania"></td></tr>';
				echo '<tr><td>Zdanie nalezy do przedmiotu: <select name="wysDodajzad">';
				foreach($stmt as $row)
        {
		  echo '<option value="'.$row['id_kat'].'">'.$row['nazwa'].'</option>';
        }
        		$stmt -> closeCursor();
				echo '</select></td></tr>';
				echo '<tr><td>Nazwa zadania:<input type="text" name="nazwazad" placeholder="Nazwa zadania"></td></tr>';
				echo '<tr><td>Trudnosc:<select name="ile_gwiazd">
  					<option value="1">1</option>
  					<option value="2">2</option>
 				 	<option value="3">3</option>
  					<option value="4">4</option>
  					<option value="5">5</option>
					</select></td></tr>';
					echo '<input type="hidden" name="MAX_FILE_SIZE" value="300000000" />
							<tr><td><input type="file" name="plik" /></tr></td>';
							echo '<tr><td><input type="hidden" name="dodajzadtest" value=1><input type="submit" value="Dodaj" class="pure-button pure-button-primary"></td></tr>';
				echo '</form></tbody></table>';
	  		}
	  	}
	  	catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }

	  }

	  public function Dodajzad(){
	  	$plik_nazwa = $_FILES['plik']['name'];
	  		$this->pdo -> exec('INSERT INTO zad (id_kat, nazwa, plik_pdf, trudnosc) VALUES( 
				\''.$_POST['wysDodajzad'].'\',
				\''.$_POST['nazwazad'].'\',
				\''.$_FILES['plik']['name'].'\',
				\''.$_POST['ile_gwiazd'].'\')');
	  		if(is_uploaded_file($_FILES['plik']['tmp_name'])) { 
     move_uploaded_file($_FILES['plik']['tmp_name'], "zadania/$plik_nazwa"); }
	  }


	  public function wyswEdytujzad(){
	  	try{
	  		if (array_key_exists('Edytujzad', $_POST)) {
	  			$stmt = $this->pdo -> query('SELECT id_zad, nazwa FROM zad;');
	  			echo '<table border="1" class="pure-table">
				<thead>
				<tr>
			<th>Wybierz zadanie do usuniecia</th>
			<th>Wybierz trudnosc</th>
			</tr>
			</thead>
			<tbody><tr>';
			echo '<form action="index.php" method="POST" class="pure-form pure-form-stacked"><td><select name="wysEdytujzad">';
			foreach($stmt as $row)
        {
		  echo '<option value="'.$row['id_zad'].'">'.$row['nazwa'].'</option>';
        }
        		$stmt -> closeCursor();
        		echo '</select></td>';
        		echo '<td>Trudnosc:<select name="ile_gwiazd">
  					<option value="1">1</option>
  					<option value="2">2</option>
 				 	<option value="3">3</option>
  					<option value="4">4</option>
  					<option value="5">5</option>
					</select></td>';
					echo '</tr><tr><td><input type="hidden" name="edytujzadtest" value=1><input type="submit" name="button_edytuj" value="Edytuj" class="pure-button pure-button-primary"></td><td></td></tr>';
			echo '</form></tbody></table>';

	  }
	}
	  catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }


  }




  	public function Edytujzad(){
  		try{
		$this->pdo -> exec('UPDATE zad SET trudnosc="'.$_POST['ile_gwiazd'].'" WHERE id_zad = '.$_POST['wysEdytujzad'].'');
      } 
			catch(PDOException $e) {
        echo 'Mamy problem: '.$e->getMessage();
      }


  	}

  	public function zaloguj(){
 $log=$_POST['login'];
$has=$_POST['password'];
$ile=0;
//WERSJA ODPORNA NA SQLIJNCETION
$log=htmlentities($log, ENT_QUOTES, "UTF-8");
$has=htmlentities($has, ENT_QUOTES, "UTF-8");
$zapytanie=sprintf("SELECT id_user FROM user 
 WHERE login='%s' AND haslo='%s'",
 mysql_real_escape_string($log),
 mysql_real_escape_string($has));
$stmt = $this->pdo -> query($zapytanie);
foreach($stmt as $row){
	$ile=count($row['id_user']);

}
if($ile>0)
		{echo '<input type="submit" value="Zalogowano pomyślnie" class="zalogowano">';
	$_SESSION['logowanie'] = $log;}
	else{echo "Nie zalogowano";}



/*WERSJA NIEODPORNA NA SQLINJECTION
$stmt = $this->pdo -> query('SELECT id_user FROM user WHERE login="'.$_POST['login'].'" AND haslo = "'.$_POST['password'].'"');
foreach($stmt as $row){
	$ile=count($row['id_user']);

}
if($ile>0)
		{echo '<input type="submit" value="Zalogowano pomyślnie" class="zalogowano">';
	$_SESSION['logowanie'] = $log;}
	else{echo "Nie zalogowano";}*/


  }

		
  } 

	
?>