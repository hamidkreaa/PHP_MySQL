<?php
	require_once 'includes/funktionen.inc.php';
    session_start();
	
if ($_POST){
	}
	else{
	 if ($_SESSION['typ']=='A' and $_SESSION['Seit']=='tabelle' AND isset($_REQUEST['id']))
		 # admin zeigen
	 {
		$stmt = $db->prepare('SELECT * FROM benutzer WHERE id = ? LIMIT 1');
		$stmt->execute( array($_REQUEST['id']));
		$benutzer = $stmt->fetch();
		unset($stmt);		
	}else{ 
	# kunde zeigen
    $stmt = $db->prepare('SELECT * FROM benutzer WHERE benutzername = ? LIMIT 1');	
	$stmt->execute( array($_SESSION['eingeloggt']));
    $benutzer = $stmt->fetch();
    unset($stmt);
	}
	#var_dump($_SESSION);
	#var_dump($_REQUEST);
    $benutzer || render404();
}	
	# var_dump($_POST);
	if ($_POST AND isset($_POST['speicheren'])) {
		unset($_POST['speicheren']);
        $stmt = $db->prepare('UPDATE benutzer SET
                anrede=:anrede, vorname=:vorname,
                nachname=:nachname, passwort=:passwort
				, typ=:typ
            WHERE benutzername=:benutzername');
        $stmt->execute($_POST);
		$_SESSION['Seit']='user_bearbeiten';
		
		if ($_SESSION['typ']=='A'){
		redirect('kunde_tabelle.php');
		}else{
		redirect('index.php');}
    }
	else {
	#	var_dump($_POST);
	}
	if ($_POST AND isset($_POST['loschen'])) {
		unset($_POST['loschen']); 
		unset($_POST['anrede']);   		
		unset($_POST['vorname']);   
		unset($_POST['nachname']);   
		unset($_POST['passwort']);
		unset($_POST['typ']); 		
		#var_dump($_POST);		
	   $stmt = $db->prepare('delete from benutzer
            WHERE benutzername=:benutzername');
        $stmt->execute($_POST);
		$_SESSION['Seit']='user_bearbeiten';
		if ($_SESSION['typ']=='A'){
		redirect('kunde_tabelle.php');
		}else{
		redirect('ausloggen.php');}
    }
	else {
		#var_dump($_POST);
	}
?>
              
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video Tec - Neuen Kunde</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="css/stylesheet.css" type="text/css" rel="stylesheet" />
</head>
	<body>
    <div id="gesamt">

        <header id="kopf">
            <h1>Video Tec</h1>
        </header>
        <section id="inhalt">
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
		 <h1>Kunde "<?php echo $benutzer['benutzername'] ?>" bearbeiten</h1>		 
		 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">	
		<input class="radio" type="radio" name="anrede" value="Herr" <?php if ($benutzer['anrede']=='Herr'){echo 'checked';} ?>>Herr
		<input class="radio" type="radio" name="anrede" value="Frau"<?php if ($benutzer['anrede']=='Frau'){echo 'checked';} ?>>Frau	
		<input type="hidden" name="benutzername" value="<?php echo $benutzer['benutzername'] ?>" required="required"  />		
		<br>Vorname <input type="text" name="vorname" value="<?php echo $benutzer['vorname'] ?>" required="required"  />
		Namchname<input type="text" name="nachname" value="<?php echo $benutzer['nachname'] ?>" required="required" />	  
		Passwort<input type="text" name="passwort" value="<?php echo $benutzer['passwort'] ?>" required="required" />
		<?php if ($_SESSION['typ']=='A'): ?>
                Benutzer Typ<input type="text" name="typ" value="<?php echo $benutzer['typ'] ?>" required="required" /><br>
         <?php else: ?>
          <input type="hidden" name="typ" value="<?php echo $benutzer['typ'] ?>" required="required" /><br>
         <?php endif; ?>		
		<input type="submit" name="speicheren" value="Speicheren" class="button" />
		<input type="submit" name="loschen" value="Löschen" class="button" /><br><br>
		</form>		  
        </section>
        <aside id="menu">
		
            <?php require 'includes/hauptmenu.tpl.php'; ?>
			<br><br>
        <img width="180px" height="300px" style="margin:0px" src="css/menu1.jpg" alt="">
        </aside>
	
        <footer id="fuss">
		
		<?php echo "Hallo " . $_SESSION['vorname']." " .$_SESSION['nachname']. " ";?>
		<time datetime="<?php echo strftime('%Y-%m-%dT%H:%M:%S', date()); ?>">
                <?php echo strftime('%d.%m.%Y um %H:%M', time()); ?>
            </time>	
			
        </footer>
	
    </div>

</body>
	
</html>
