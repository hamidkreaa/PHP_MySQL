<pre>
<?php
    require_once 'includes/funktionen.inc.php';
    session_start();
	
	$stmt = $db->query('SELECT id, benutzername, passwort, vorname, nachname, typ FROM benutzer');
    $benutzer = $stmt->fetchAll();
    unset($stmt);
	#var_dump($benutzer);
	
    $benutzername = trim($_POST['benutzername']);
    // Prüfe, ob der Benutzer im Datenbank existiert und das Passwort übereinstimmt
	for($i=0;$i<count($benutzer);$i++)
	{
	if ($benutzer[$i]['benutzername']==$benutzername && $benutzer[$i]['passwort']==trim($_POST['passwort']))
    {
	 logge_ein($benutzername,$benutzer[$i]['typ'],$benutzer[$i]['vorname'],$benutzer[$i]['nachname']);
    } else {
      // Bei falschen Logindaten Meldung in der Session speichern
	 # var_dump($_POST);
	  
      $_SESSION['meldung'] = 'Falsche Logindaten.';
    }
    }
    /*
     * Leite zur index.php um. Der Besucher wird entweder das
     * Login-Formular sehen, wenn die Daten falsch waren, oder
     * das Hauptmenu, wenn der Login erfolgreich war.
     */
    redirect('index.php');
?>
</pre>