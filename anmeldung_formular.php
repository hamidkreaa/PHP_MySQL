<?php
    require_once 'includes/funktionen.inc.php';
    session_start();
	
    $stmt = $db->query('SELECT id, benutzername FROM benutzer');
    $benutzer = $stmt->fetchAll();
	 unset($stmt);
	 
	$benutzer_name=array();
	for($i=0;$i<count($benutzer);$i++)
	{
	$benutzer_name[$i]=$benutzer[$i]['benutzername'];
     }   
	#var_dump($benutzer_name);
	
    if ($_POST) {
	if (in_array($_POST['benutzername'],$benutzer_name))
    {		
		echo '<script language="javascript">';
		echo 'alert("Benutzername ist schon existieren !")';
		echo '</script>';	
	
    } else {
        $stmt = $db->prepare('INSERT INTO benutzer (anrede, vorname, nachname, passwort, benutzername)
            VALUES ( :anrede, :vorname, :nachname, :passwort, :benutzername)');
        $stmt->execute($_POST);
     }   
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video Tec - Neuen Kunde</title>
    <link href="css/stylesheet.css" type="text/css" rel="stylesheet" />
</head>

<body>


    <div id="gesamt">

        <header id="kopf">
            <h1>Video Tec</h1>
        </header>

        <section id="inhalt">
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
         <h1>Schreiben Sie hier Ihre Daten:</h1>
		 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		 <input class="radio" type="radio" name="anrede" value="Herr" checked>Herr
		 <input class="radio" type="radio" name="anrede" value="Frau">Frau
		 <input type="text" name="vorname" id="vorrname" required="required" placeholder="Vorname" />
		<input type="text" name="nachname" id="nachname" required="required" placeholder="Nchname" />	  
		<input type="text" name="benutzername" id="benutzername" required="required" placeholder="Benutzername" />
		<input type="password" name="passwort" id="passwort" required="required" placeholder="Passwort" />
		
		<input type="submit" value="Speicheren" class="button" /><br><br>
		</form>		  
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
		<?php if ($_POST) {echo "Vielen Dank.<br>Hallo " .$_POST['anrede'] . " " . $_POST['vorname'] . " " . $_POST['nachname'];}?>
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