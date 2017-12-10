<nav>
    <ul>
        <li><a href="index.php">Hauptseite</a></li>
        <li><a href="erweiter_such_formular.php">Erweiter Such</a></li>   
		<li><a href="user_bearbeiten.php">Ihre Profil</a></li>	
		<?php if ($_SESSION['typ']=='A'): ?>
		<li><a href="einstellungen.php">Filme Einstellungen</a></li>
		<li><a href="filme_einfugen.php">Filme Einfugen</a></li>
		<li><a href="anmeldung_formular.php">Kunde Einfugen</a></li>
		<li><a href="kunde_tabelle.php">Kunde Tabelle</a></li> 
		<?php endif; ?>
        <li><a href="ausloggen.php">Ausloggen</a></li>
    </ul>
</nav>

<p>Eingeloggt als: <em><?php echo $_SESSION['eingeloggt']; ?></em></p>

            