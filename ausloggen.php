<?php
    require_once 'includes/funktionen.inc.php';
    session_start();

    logge_aus();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Video Tec - Ausloggen</title>
    <link href="css/stylesheet.css" type="text/css" rel="stylesheet" />
</head>

<body>

    <div id="gesamt">

        <header id="kopf">
            <h1>Video Tec</h1>
        </header>

        <section id="inhalt">
		<img width="550px" height="30px" src="css/movie.jpg" alt=""> 
		<?php
				$dir = "material/";

// Sort in ascending order - this is default
			$a = scandir($dir);
			#print_r($a);
			for($i=2;$i<count($a);$i++){?>
			<a href="index.php">
				
				<img width="180px" height="300px" src="material/<?php echo $a[$i] ?>" alt="">  
				</a>
			<?php }?>
			
			
            

            <p>
                <a href="index.php" class="backlink">Zurück zur Hauptseite</a>
            </p>

        </section>

        <aside id="menu">
            <?php require 'includes/loginformular.tpl.php'; ?>
			<br><br>
			<img width="180px" height="300px" style="margin:0px" src="css/menu.jpg" alt="">
        </aside>

        <footer id="fuss">
		
                Sie wurden ausgeloggt
                
		<time datetime="<?php echo strftime('%Y-%m-%dT%H:%M:%S', date()); ?>">
                <?php echo strftime('%d.%m.%Y um %H:%M', time()); ?>
            </time>
			<br>
            Besuchen Sie uns bald wieder.
        </footer>

    </div>

</body>

</html>