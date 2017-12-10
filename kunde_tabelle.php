<?php
    require_once 'includes/funktionen.inc.php';
    session_start();

    $stmt = $db->query('SELECT * FROM benutzer');
    $benutzer = $stmt->fetchAll();
    unset($stmt);
	$_SESSION['Seit']='tabelle';
    
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
        <h1>Liste aller Kunde</h1>
        <table border="1">
            <tr>
				<th>ID</th>
                <th>Vorname</th>
                <th>Nachname</th>
                <th>BenutzerName</th>
                <th>Passwort</th>
				<th>Typ</th>
				<th>&nbsp;</th>
            </tr>

            <?php foreach ($benutzer as $s): ?>
                <tr>
                    <td><?php echo $s['id'] ?></td>
                    <td><?php echo $s['vorname'] ?></td>
                    <td><?php echo $s['nachname'] ?></td>
					<td><?php echo $s['benutzername'] ?></td>
					<td><?php echo $s['passwort'] ?></td>
					<td><?php echo $s['typ'] ?></td>
                   <td>
                        <a href="user_bearbeiten.php?id=<?php echo $s['id'] ?>">
                            anzeigen
                        </a>
                    </td> 
                </tr>
            <?php endforeach; ?>
        </table>
           

        </section>

        <aside id="menu">  
                <?php require 'includes/hauptmenu.tpl.php'; ?>       
			<br><br>
        <img width="180px" height="300px" style="margin:0px" src="css/menu.jpg" alt="">
        </aside>

        <footer id="fuss">
		Hallo <?php if (ist_eingeloggt()): ?>
            <?php echo $_SESSION['vorname']; ?>
			<?php echo $_SESSION['nachname']; ?>
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