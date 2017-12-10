<?php
    require_once 'includes/funktionen.inc.php';
    session_start();

    $stmt = $db->query('SELECT id,titel, jahr, land, runtime FROM film');
    $film = $stmt->fetchAll();
    unset($stmt);
	
	# suche bei Film Name
	if ($_POST AND isset($_POST['suchfilmeName'])) {
      # var_dump($_POST); 
		$_POST['filmeName']="%".$_POST['filmeName']."%";
		unset($_POST['genre']); 
		unset($_POST['vorname']);   
		unset($_POST['nachname']);   
		unset($_POST['suchfilmeName']); 
		#var_dump($_POST); 
		$stmt = $db->prepare('SELECT id,titel, jahr, land, runtime FROM film
            WHERE titel like :filmeName');
        $stmt->execute($_POST);	
		$result = $stmt->fetchAll();		
    }
	
	
	# suche bei alle Filme Datei 
    if ($_POST AND isset($_POST['suchgenre'])) {
      # var_dump($_POST); 
		$_POST['genre']="%".$_POST['genre']."%";
		$_POST['filmeName']="%".$_POST['filmeName']."%"; 
		$_POST['vorname']="%".$_POST['vorname']."%";
		$_POST['nachname']="%".$_POST['nachname']."%";
		unset($_POST['suchgenre']); 
		#var_dump($_POST); 
		$stmt = $db->prepare('SELECT film.id, titel, jahr, land, runtime  FROM 
			film join filmgenre on film.id=filmgenre.film_id 
			join genre on genre.id=filmgenre.genre_id 
			join filmactors on film.id=filmactors.film_id 
			join actors on filmactors.actor_id=actors.id 
			where genre like :genre and titel like :filmeName
			And vorname like :vorname And nachname like :nachname');
        $stmt->execute($_POST);	
		$result = $stmt->fetchAll();		
    }
	
	# suche bei Film Actors Vorname
	if ($_POST AND isset($_POST['suchvorname'])) {
      # var_dump($_POST); 
	  $_POST['vorname']="%".$_POST['vorname']."%";
		unset($_POST['filmeName']); 
		unset($_POST['genre']);   
		unset($_POST['nachname']);   
		unset($_POST['suchvorname']); 
		#var_dump($_POST); 
		$stmt = $db->prepare('select film.id, titel, jahr, land, runtime FROM film
		join filmactors on film.id=filmactors.film_id 
		join actors on actors.id=filmactors.actor_id
			where vorname like :vorname');
        $stmt->execute($_POST);	
		$result = $stmt->fetchAll();		
    }
	# suche bei Film Actors Nachname
	if ($_POST AND isset($_POST['suchnachname'])) {
      # var_dump($_POST); 
	  $_POST['nachname']="%".$_POST['nachname']."%";
		unset($_POST['filmeName']); 
		unset($_POST['genre']);   
		unset($_POST['vorname']);   
		unset($_POST['suchnachname']); 
		#var_dump($_POST); 
		$stmt = $db->prepare('select film.id, titel, jahr, land, runtime FROM film
		join filmactors on film.id=filmactors.film_id 
		join actors on actors.id=filmactors.actor_id
			where nachname like :nachname');
        $stmt->execute($_POST);	
		$result = $stmt->fetchAll();		
    }
	
 // Loginmeldung auslesen sofern vorhanden
    if (isset($_SESSION['meldung'])) {
        // Meldung in einer Variablen ablegen (wird über dem Loginformular angezeigt)
        $meldung = $_SESSION['meldung'];
        // Meldung aus der Session löschen, da diese nur 1x angezeigt werden soll
        unset($_SESSION['meldung']);
    }
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video - Tec</title>
    <link href="css/stylesheet.css" type="text/css" rel="stylesheet" />
</head>

<body>

    <div id="gesamt">

        <header id="kopf">
            <h1>Video Tec</h1>
        </header>

        <section id="inhalt">
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
		<h1>Geben Sie ein Suchwort ein:</h1>
		 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		 <input type="text" name="vorname" id="vorrname" placeholder="SchauSpielerVorname" />
		 <input type="submit" value="Suchen" name="suchvorname" class="button" /><br><br>
		<input type="text" name="nachname" id="nachname"  placeholder="SchauSpielerNchname" />	
		<input type="submit" value="Suchen" name="suchnachname" class="button" /><br><br>		
		<input type="text" name="filmeName" id="filmeName"  placeholder="FilmeName" />
		<input type="submit" value="Suchen" name="suchfilmeName" class="button" /><br><br>
		<input type="text" name="genre" id="genre"  placeholder="Genre" />		
		<input type="submit" value="Alle Suchen" name="suchgenre" class="button" /><br><br>
		</form>		  
        <h1>Such resultat</h1>
		
        <table border="1">
            <tr>
                <th>Titel</th>
                <th>Jahr</th>
                <th>Land</th>
                <th>Runtime</th>
				<th>&nbsp;</th>
            </tr>
			<?php if ($_POST): ?>	
	<!-- anzeigen Suche ergiebnes-->
			<?php foreach ($result as $s): ?>
                <tr>
                    <td><?php echo $s['titel'] ?></td>
                    <td><?php echo $s['jahr'] ?></td>
                    <td><?php echo $s['land'] ?></td>
					<td><?php echo $s['runtime'] ?></td>
                   <td>  
					<a href="zeige_film_formular.php?id=<?php echo $s['id'] ?>">
                            anzeigen
                        </a>
                    </td> 
                </tr>	
			<?php endforeach; ?>
			
			<?php else: ?>
                
            <?php foreach ($film as $s): ?>
                <tr>
                    <td><?php echo $s['titel'] ?></td>
                    <td><?php echo $s['jahr'] ?></td>
                    <td><?php echo $s['land'] ?></td>
					<td><?php echo $s['runtime'] ?></td>
                   <td>  
					<a href="zeige_film_formular.php?id=<?php echo $s['id'] ?>">
                            anzeigen
                        </a>
                    </td> 
                </tr>	
			<?php endforeach; ?>				
            <?php endif; ?>
                        
            
        </table>
           

        </section>

        <aside id="menu">
            <?php if (ist_eingeloggt()): ?>
                <?php require 'includes/hauptmenu.tpl.php'; ?>
            <?php else: ?>
                <?php require 'includes/loginformular.tpl.php'; ?>
            <?php endif; ?>
			<br><br>
        <img width="180px" height="300px" style="margin:0px" src="css/menu2.jpg" alt="">
        </aside>

        <footer id="fuss">
		Hallo <?php if (ist_eingeloggt()): ?>
            <?php echo $_SESSION['vorname']." ".$_SESSION['nachname']; ?>
			<?php else: ?>
                Kunde
            <?php endif; ?>
            Huete
		<time datetime="<?php echo strftime('%Y-%m-%dT%H:%M:%S', date()); ?>">
                <?php echo strftime('%d.%m.%Y um %H:%M', time()); ?>
            </time>
			<br>
            Sie sind Willkommen
        </footer>

    </div>

</body>

</html>