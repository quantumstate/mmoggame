<?php
session_start();
session_unset();
session_destroy();
$url = "index.php";
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
?>