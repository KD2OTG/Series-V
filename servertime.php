<?php

$time = gmdate("d-M-y G.i:s",time());
$time2 = gmdate("d-M-y G.i:s",$_SERVER['REQUEST_TIME']);


echo "Current server time using gmdate() with time(): " . $time . "<br>";
echo "Current server time using gmdate() with _SERVER['REQUEST_TIME']: " . $time2 . "<br>";



?>
