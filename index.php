<?php 

require_once("config.php");

$teofilo = new Usuario();

$teofilo->loadById(1);

echo $teofilo;

 ?>