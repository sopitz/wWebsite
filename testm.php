<?php
error_reporting(1);

echo "oiguig";


include_once 'includes/config.php';

$abfrage = mysql_query("SELECT `id`, `userID`, `usergroup`, `emailMd5`, `eMail`, `firstname`, `lastname`, `password`, `firstLog`, `status` FROM login left outer join guestlist on login.userID=guestlist.userID WHERE usergroup != 'global' ODER BY id DESC LIMIT 1");

$result = mysql_fetch_array($abfrage);
print_r($result);
?>