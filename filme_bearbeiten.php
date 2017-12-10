<?php
    require_once 'includes/funktionen.inc.php';
    session_start();
    $_SESSION['Seit']='zeige_filme';

// 404-Seite anzeigen, wenn der Parameter id leer ist
    
	
if ($_POST){
	#var_dump($_POST); 
	#$genredaten = array(
	#'genre_id'=>$_POST['genre'][0],
	#'film_id'=>$_POST['id']);
	#var_dump($genredaten); 
	
	$stmt = $db->prepare('SELECT * FROM film WHERE id = ? LIMIT 1');
    $stmt->execute( array($_POST['id']) );
    $film = $stmt->fetch();
    unset($stmt);
   // var_dump($film);
   
    // 404-Seite anzeigen, wenn kein passendes Film gefunden wurde
    $film || render404();

    // Genre zum Film auslesen
    $stmt = $db->prepare('SELECT genre.id, genre FROM filmgenre 
	join genre on genre.id=filmgenre.genre_id 
	WHERE film_id = ?');
    $stmt->execute(array($_POST['id']));
    $genre = $stmt->fetchAll();
    unset($stmt);
	
      // Actors zum Film auslesen
    $stmt = $db->prepare('SELECT actors.id, vorname,nachname FROM filmactors
	join actors on actors.id=filmactors.actor_id 
	WHERE film_id = ?');
    $stmt->execute(array($_POST['id']));
    $actors = $stmt->fetchAll();
    unset($stmt);
	
	}
	else{
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
	
	}
	
	if ($_POST AND isset($_POST['genrespicheren'])) {
	#var_dump($_POST); 
	$genredaten = array(
	'genre_id'=>$_POST['genre'][0],
	'film_id'=>$film['id']);
	#var_dump($genredaten); 
	
	  $stmt = $db->prepare('INSERT INTO filmgenre (genre_id , film_id)
           VALUES ( :genre_id, :film_id)');
       $stmt->execute($genredaten);

    }
	if ($_POST AND isset($_POST['schauspieler'])) {
	#var_dump($_POST); 
	$schauspielerdaten = array(
	'actor_id'=>$_POST['actors'][0],
	'film_id'=>$film['id']);
	
	  $stmt = $db->prepare('INSERT INTO filmactors (actor_id , film_id)
           VALUES ( :actor_id, :film_id)');
       $stmt->execute($schauspielerdaten);

    }
   function fill_select()
{
	
try {
		$db = new PDO('mysql:host=localhost;dbname=video_tec', 'root', '', array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        ));

    $db->query('SET NAMES utf8');
		$stmt = $db->query('SELECT id, genre FROM genre ORDER BY id ASC');		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$daten=$stmt->fetchAll();

			echo '<label for="genre[]">Genre</label><br>';	
			echo "<select name = 'genre[]'>";
			for($i=0;$i<count($daten);$i++)
			{
				echo '<option value="'.$daten[$i]['id'].'">'.$daten[$i]['genre'].'</option>';	
			}
			echo '</select>';

    }	
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

} 
 function fill_schauspieler_select()
{
	
try {
		$db = new PDO('mysql:host=localhost;dbname=video_tec', 'root', '', array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true
        ));

    $db->query('SET NAMES utf8');
		$stmt = $db->query('SELECT id, vorname,nachname FROM actors ORDER BY id ASC');		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$daten1=$stmt->fetchAll();

			echo '<label for="actors[]">Actors</label><br>';	
			echo "<select name = 'actors[]'>";
			for($i=0;$i<count($daten1);$i++)
			{
				echo '<option value="'.$daten1[$i]['id'].'">'.$daten1[$i]['vorname']. " ". $daten1[$i]['nachname'].'</option>';	
			}
			echo '</select>';

    }	
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }

} 
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video Tec - Film Bearbeiten</title>
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
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
		<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"> 
		<input type="hidden" name="id" value="<?php echo $film['id'] ?>" /> 
		 Titel<input type="text" name="titel" value="<?php echo $film['titel'] ?>" required/> 
		Beschreibung<textarea name="beschreibung" rows="3" cols="30" required="required"><?php echo $film['beschreibung'] ?>" </textarea>	 		
		Jahr<input type="text" name="jahr" value="<?php echo $film['jahr'] ?>" required />
		Land<input type="text" name="land" value="<?php echo $film['land'] ?>" />
		Runtime<input type="text" name="Runtime" value="<?php echo $film['Runtime'] ?>" />
		Bild<input type="text" name="bild" value="<?php echo $film['bild'] ?>" />
		<input type="submit" value="Speicheren" name="speicheren" class="button" /><br><br>
<!-- filme Genre Spicheren-->
		 <?php fill_select(); ?>
		<input type="submit" value="Genre Spicheren" name="genrespicheren" class="button" /><br><br>
<!-- filme Schauspieler Spicheren-->
		Schauspieler <?php fill_schauspieler_select(); ?>
		<input type="submit" value="Schauspieler Spicheren" name="schauspieler" class="button" /><br><br>		
		</form>	
		

        </section>
<!-- Menu  anzeigen-->		
		<aside id="menu">   
                <?php require 'includes/hauptmenu.tpl.php'; ?>				
	<!-- filme Bild anzeigen-->
	<br><br>
        <img width="180px" height="300px" style="margin:0px" src="material/<?php echo $film['bild'] ?>" alt="">  
        </aside>
 
 <!-- Footer  anzeigen-->		       
       
          <footer id="fuss">
		Hallo 
         <?php echo $_SESSION['vorname']." ".$_SESSION['nachname']." "; ?>	
		<time datetime="<?php echo strftime('%Y-%m-%dT%H:%M:%S', date()); ?>">
                <?php echo strftime('%d.%m.%Y um %H:%M', time()); ?>
            </time>
			<br>
            Sie sind Willkommen
        </footer>
            
    </div>

</body>

</html>