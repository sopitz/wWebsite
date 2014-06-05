<?php 
require_once('../includes/config.php');
?>
$('#<?php echo $_GET['hideId']; ?>').hide();
setInterval(function() { location.href="<?php echo $SERVERPATH; ?>"; }, 3000);
