<?php
    require_once 'includes/funktionen.inc.php';
    session_start();
	
	$stmt = $db->query('SELECT id,titel, jahr, land, Runtime,bild FROM film');
    $film = $stmt->fetchAll();
    unset($stmt);
	
	#echo '<script language="javascript">';
	#echo 'alert("Benutzername ist schon existieren !")';
	#echo '</script>';	
	
	if ($_POST AND isset($_POST['titel'])) {
      # var_dump($_POST); 
	  $stmt = $db->prepare('INSERT INTO film (titel,beschreibung, jahr, land, Runtime, bild)
           VALUES ( :titel, :beschreibung, :jahr, :land, :Runtime, :bild)');
        $stmt->execute($_POST);
		unset($stmt);
		$_POST['titel']="%".$_POST['titel']."%";
		unset($_POST['jahr']); 
		unset($_POST['land']);   
		unset($_POST['Runtime']);   
		unset($_POST['beschreibung']); 
		unset($_POST['bild']); 
		#var_dump($_POST); 
		$stmt = $db->prepare('SELECT id,titel, jahr, land, runtime FROM film
            WHERE titel like :titel');
        $stmt->execute($_POST);	
		$result = $stmt->fetchAll();		
    }
	 
    if ($_POST) {
	# var_dump($_POST); 
       # $stmt = $db->prepare('INSERT INTO film (titel,beschreibung, jahr, land, Runtime)
        #    VALUES ( :titel, :beschreibung, :jahr, :land, :Runtime)');
        #$stmt->execute($_POST);
     }   
    
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video Tec - Neuen Filme</title>
    <link href="css/stylesheet.css" type="text/css" rel="stylesheet" />
	
	<script>
	 function Checkname(value)
        { 
		document.write(value);
		<?php          
         $filmname[]="%".value."%";
		 var_dump($filmname); 
		 
		# $stmt = $db->prepare('SELECT id,titel, jahr, land, runtime FROM film
        # WHERE titel like :titel');
        #$stmt->execute($filmname);	
		#$result = $stmt->fetchAll();         
        ?> }
	</script>
</head>

<body>


    <div id="gesamt">

        <header id="kopf">
            <h1>Video Tec</h1>
        </header>

        <section id="inhalt">
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
         <h1>Schreiben Sie hier Film Daten:</h1>
		 
		 <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
		 
		 <input type="text" name="titel" id="titel" required="required" placeholder="Titel" /> 
		<textarea name="beschreibung" id="beschreibung" rows="5" cols="30" required="required" placeholder="Beschreibung" /></textarea>	  
		<input type="text" name="jahr" id="jahr" required="required" placeholder="Jahr" />
		<input type="text" name="land" id="land" required="required" placeholder="Land" />
		<input type="text" name="Runtime" id="Runtime" required="required" placeholder="Runtime" />
		<input type="text" name="bild" id="bild" placeholder="Bild Filename" />
		<input type="submit" value="Speicheren" class="button" /><br><br>
		</form>	
       <h1>Filme Liste</h1>
		
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
					<td><?php echo $s['Runtime'] ?></td>
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
					<td><?php echo $s['Runtime'] ?></td>
                   <td>  
					<a href="filme_bearbeiten.php?id=<?php echo $s['id'] ?>">
                            Bearbeiten
                        </a>
                    </td> 
                </tr>	
			<?php endforeach; ?>				
            <?php endif; ?>                       
            
        </table>
           		
        </section>
		
        <aside id="menu">        	
                <?php require 'includes/hauptmenu.tpl.php'; ?> 
		<br><br>
        <img width="180px" height="300px" style="margin:0px" src="css/menu.jpg" alt="">				
		</aside>
		
        <footer id="fuss">
		<?php if ($_POST) {echo "Vielen Dank.<br>";}?>
		<time datetime="<?php echo strftime('%Y-%m-%dT%H:%M:%S', date()); ?>">
                <?php echo strftime('%d.%m.%Y um %H:%M', time()); ?>
            </time>	
        </footer>
		
		

    </div>

</body>

</html>