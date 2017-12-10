<?php
    require_once 'includes/funktionen.inc.php';
    session_start();
    $_SESSION['Seit']='zeige_filme';

// 404-Seite anzeigen, wenn der Parameter id leer ist
    empty($_REQUEST['id']) && render404();
	// var_dump($_REQUEST);
	


    $stmt = $db->prepare('SELECT * FROM film WHERE id = ? LIMIT 1');
    $stmt->execute( array($_REQUEST['id']) );
    $film = $stmt->fetch();
    unset($stmt);
   // var_dump($film);
   
    // 404-Seite anzeigen, wenn kein passendes Film gefunden wurde
    $film || render404();

    // Genre zum Film auslesen
    $stmt = $db->prepare('SELECT genre.id, genre FROM filmgenre 
	join genre on genre.id=filmgenre.genre_id 
	WHERE film_id = ?');
    $stmt->execute(array($film['id']));
    $genre = $stmt->fetchAll();
    unset($stmt);
	
      // Actors zum Film auslesen
    $stmt = $db->prepare('SELECT actors.id, vorname,nachname FROM filmactors
	join actors on actors.id=filmactors.actor_id 
	WHERE film_id = ?');
    $stmt->execute(array($film['id']));
    $actors = $stmt->fetchAll();
    unset($stmt);
    
 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video Tec - Film Zeigen</title>
    <link href="css/stylesheet.css" type="text/css" rel="stylesheet" />
</head>

<body>
    
    <div id="gesamt">
    
        <header id="kopf">
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
            <h1>Video Tec</h1>
        </header>
        
        <section id="inhalt">
            <img width="550px" height="30px" src="css/movie.jpg" alt=""> 
			<h1>Film Name: "<?php echo $film['titel'] ?>"</h1>

        <table border="1">
            <tr>
                <th>Titel</th>
                <td><?php echo $film['titel'] ?></td>
            </tr>
            <tr>
                <th> Beschreibung </th>
                <td><?php echo $film['beschreibung'] ?></td>
            </tr>
            <tr>
                <th>Jahr</th>
                <td><?php echo $film['jahr'] ?></td>
            </tr>
            <tr>
                <th>Land</th>
                <td><?php echo $film['land'] ?></td>
            </tr>
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
            <tr>
                <th>Genre</th>
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
			 <tr>
                <th>Runtime</th>
                <td><?php echo $film['Runtime'] ?></td>
            </tr>
        </table>

        </section>
<!-- Menu  anzeigen-->		
		<aside id="menu">
            <?php if (ist_eingeloggt()): ?>
                <?php require 'includes/hauptmenu.tpl.php'; ?>
            <?php else: ?>
                <?php require 'includes/loginformular.tpl.php'; ?>
            <?php endif; ?>
			<br><br>
	<!-- filme Bild anzeigen-->
			<img width="180px" height="300px" style="margin:0px" src="material/<?php echo $film['bild'] ?>" alt="">  
        </aside>
 
 <!-- Footer  anzeigen-->		       
       
          <footer id="fuss">
		Hallo <?php if (ist_eingeloggt()): ?>
            <?php echo $_SESSION['vorname']." " .$_SESSION['nachname']. " "; ?>
			<?php else: ?>
                Kunde
            <?php endif; ?>
		<time datetime="<?php echo strftime('%Y-%m-%dT%H:%M:%S', date()); ?>">
                <?php echo strftime('%d.%m.%Y um %H:%M', time()); ?>
            </time>
			<br>
            Sie sind Willkommen
        </footer>
            
    </div>

</body>

</html>