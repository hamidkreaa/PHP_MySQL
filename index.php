<?php
    require_once 'includes/funktionen.inc.php';
    session_start();
	
	$_SESSION['Seit']='index';
    $stmt = $db->query('SELECT id,titel, jahr, land, runtime,bild FROM film');
    $film = $stmt->fetchAll();
    unset($stmt);

    
 // Loginmeldung auslesen sofern vorhanden
    if (isset($_SESSION['meldung'])) {
        // Meldung in einer Variablen ablegen (wird über dem Loginformular angezeigt)
        $meldung = $_SESSION['meldung'];
        // Meldung aus der Session löschen, da diese nur 1x angezeigt werden soll
        unset($_SESSION['meldung']);
    }
    // In Blogs werden Einträge in umgekehrter (reverse) Reihenfolge angezeigt
   // $eintraege = hole_eintraege(true);
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
        <h1>Liste aller Filme</h1>
        <table border="1">
            <tr>
                <th>Titel</th>
                <th>Jahr</th>
                <th>Land</th>
                <th>Runtime</th>
				<th>&nbsp;</th>
            </tr>

            <?php foreach ($film as $s): ?>
                <tr>
                    <td><?php echo $s['titel'] ?></td>
                    <td><?php echo $s['jahr'] ?></td>
                    <td><?php echo $s['land'] ?></td>
					<td><?php echo $s['runtime'] ?></td>
					<?php $filmebild[] = $s['bild'];?>  
									
                   <td>
				   
					<?php if (ist_eingeloggt() && $_SESSION['typ']=='A'): ?>
						<a href="filme_bearbeiten.php?id=<?php echo $s['id'] ?>">
                            Bearbeiten
					<?php else: ?>
                        <a href="zeige_film_formular.php?id=<?php echo $s['id'] ?>">
                            anzeigen
							<?php endif; ?>
							
				
                        </a>
                    </td> 
                </tr>
            <?php endforeach; ?>
        </table>
		<br>
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
		
		<?php if (ist_eingeloggt() and $_SESSION['typ']=='A'): ?>
				<?php foreach ($film as $s): ?>		
				<a href="filme_bearbeiten.php?id=<?php echo $s['id'] ?>">			
				<img width="180px" height="300px" src="material/<?php echo $s['bild'] ?>" alt="">  
				</a>
				<?php endforeach; ?> 
		<?php else: ?>
		<?php foreach ($film as $s): ?>		
				<a href="zeige_film_formular.php?id=<?php echo $s['id'] ?>">			
				<img width="180px" height="300px" src="material/<?php echo $s['bild'] ?>" alt="">  
				</a>
				<?php endforeach; ?> 
		<?php endif; ?>
        </section>

        <aside id="menu">
            <?php if (ist_eingeloggt()): ?>
                <?php require 'includes/hauptmenu.tpl.php'; ?>
            <?php else: ?>
                <?php require 'includes/loginformular.tpl.php'; ?>
            <?php endif; ?>
			<br><br>
			<img width="180px" height="300px" style="margin:0px" src="css/menu.jpg" alt="">
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