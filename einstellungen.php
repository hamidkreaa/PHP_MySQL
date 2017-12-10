<?php
    require_once 'includes/funktionen.inc.php';
    session_start();
	// nur für Fragen für der Lehrer
        function Checkname($value){
		
          $filmname[]=$value;
		  var_dump($filmname);
		 #$stmt = $db->prepare('SELECT id,titel, jahr, land, runtime FROM film
         #WHERE titel like :titel');
        #$stmt->execute($filmname);	
		$result = $stmt->fetchAll(); 
			       
        }
   
	//Alle  Genre Zeigen
		$db->query('SET NAMES utf8');
		$stmt = $db->query('SELECT id, genre FROM genre ORDER BY id ASC');		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$genre=$stmt->fetchAll();
		unset($stmt);
		
	    //Alle  Actors Zeigen
    $stmt = $db->query('SELECT vorname,nachname FROM actors ORDER BY vorname');
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $actors = $stmt->fetchAll();
    unset($stmt);
	
    if ($_POST AND isset($_POST['genrespeicheren']) AND isset($_POST['genre']) AND !empty($_POST['genre'])) {
	 
        $stmt = $db->prepare('INSERT INTO genre (genre)
            VALUES ( :genre)');
		unset($_POST['vorname']);  
		unset($_POST['nachname']);   
		unset($_POST['actorsspeicheren']); 
		unset($_POST['genrespeicheren']); 
        $stmt->execute($_POST);
		redirect('einstellungen.php');
    }
	
	
	if ($_POST AND isset($_POST['actorsspeicheren']) AND isset($_POST['vorname']) AND isset($_POST['nachname'])  AND !empty($_POST['vorname']) AND !empty($_POST['nachname'])) {
	
	unset($_POST['genre']);
	unset($_POST['genrespeicheren']);
	unset($_POST['actorsspeicheren']); 
	#var_dump($_POST);  	
	  $stmt = $db->prepare('INSERT INTO actors (vorname , nachname)
          VALUES ( :vorname, :nachname)');
       $stmt->execute($_POST);
	   redirect('einstellungen.php');
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video Tec - Einstellungen</title>
    <link href="css/stylesheet.css" type="text/css" rel="stylesheet" />
</head>

<body>


    <div id="gesamt">

        <header id="kopf">
            <h1>Video Tec</h1>
        </header>
        <section id="inhalt">
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
		<h1>Film genre:</h1> 
			
        <table border="1">
            
            <tr>
             <th>Film genre</th>
                <td>
                    <ul>
                        <?php foreach ($genre as $t): ?>
                            <li>
                                 <?php echo ($t['genre']) ?>
                                
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>			 
        </table>
		
         <h1>Genre Addieren:</h1>
		 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">			 
		 Genre<input type="text" name="genre" id="genre" />
		<input type="submit" value="Speicheren" name="genrespeicheren" class="button" /><br><br>
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
		<h1>Schauspieler Addieren:</h1>
		Vorname<input type="text" name="vorname" id="vorrname"  placeholder="Vorname" onkeypress="Checkname(this.value)" />
		Nachname<input type="text" name="nachname" id="nachname" placeholder="Nchname" />
		<input type="submit" value="Speicheren" name="actorsspeicheren"class="button" /><br><br>		
		</form>	
		<table border="1">
			<tr>
                <th>Schauspieler</th>
                <td>
                    <ul>
                        <?php foreach ($actors as $t): ?>
                            <li>
                                 <?php echo ($t['vorname']) ?>
								 <?php echo '  ' ?>
								 <?php echo ($t['nachname']) ?>
                                
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
             </table>		
        </section>
		
        <aside id="menu">        			
                <?php require 'includes/hauptmenu.tpl.php'; ?> 
<br><br>
        <img width="180px" height="300px" style="margin:0px" src="css/menu.jpg" alt=""> 				
		</aside>
		
		
		
        <footer id="fuss">
		<?php if ($_POST) {echo "Vielen Dank"."<br>";}?>
		Hallo <?php echo $_SESSION['vorname']." ".$_SESSION['nachname']; ?>
		<time datetime="<?php echo strftime('%Y-%m-%dT%H:%M:%S', date()); ?>">
                <?php echo strftime('%d.%m.%Y um %H:%M', time()); ?>
            </time>	
            
        </footer>
		
		

    </div>

</body>

</html>