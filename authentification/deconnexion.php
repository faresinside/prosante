<?php
session_start();
session_unset ();
session_destroy();
header("refresh:1;url=connexion.php"); 
echo"<p style='color:red;'>déconnexion ...</p>";
exit();
?>
