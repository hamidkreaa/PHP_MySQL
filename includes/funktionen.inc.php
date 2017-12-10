<?php

    /**
     * Zeigt eine 404-Fehlerseite an und bricht die Abarbeitung des aktuellen
     * Skripts ab. 
     */
    function render404() {
        header("HTTP/1.0 404 Not Found");
        echo "Seite nicht gefunden!";
        exit();
    }

    /**
     * Formatiert einen MySQL-DATE-String in ein deutsches Datum um
     *
     * @param string $$db_date Der DATE-String
     * @return string Das deutsche, formatierte Datum
     */
    function datum($db_date) {
        return strftime('%d.%m.%Y', strtotime($db_date));
    }

    /**
     * Leitet den Browser auf eine neue URL weiter und beendet die
     * Skriptausführung.
     *
     * @param string $url Die URL, auf die weitergeleitet wird.
     
    function redirect($url) {
        header("Location: $url");
        exit;
    }
*/
    $db = new PDO('mysql:host=localhost;dbname=video_tec', 'root', '', array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        ));

    $db->query('SET NAMES utf8');
	
	
	
?>
<?php
   
    function redirect($datei)
    {
        header('Location: ' . $datei);
        exit;
    }
    
    function ist_eingeloggt()
    {
        if (isset($_SESSION['eingeloggt'])) {
            return true;
        } else {
            return false;
        }
    }
    
    function logge_ein($benutzername,$typ,$vorname,$nachname)
    {
        $_SESSION['eingeloggt'] = $benutzername;
		$_SESSION['typ'] = $typ;
		$_SESSION['nachname'] = $nachname;
		$_SESSION['vorname'] = $vorname;
    }
    
    function logge_aus()
    {
        unset($_SESSION['eingeloggt']);
    }
?>