<?php
mysql_connect($dbHost,$dbUser,$dbPassword) or die
  ("Keine DB- Verbindung moeglich");
  mysql_select_db($dbName) or die
  ("Die Datenbank existiert nicht");
?>