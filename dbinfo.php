<?php
include ('../dbinfo.php');
$database="mmog";


$sqllink=mysql_connect(localhost,$dbusername,$dbpassword);
@mysql_select_db($database);

?>