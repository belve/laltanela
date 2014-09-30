<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
require_once("../db.php");
require_once("../variables.php");


$TSEL=substr($tiend,0,-1);
if(strlen($TSEL)==0){$TSEL=0;}


if (!$dbnivel->open()){die($dbnivel->error());};


$borros=array();

$valores['opt']="<option value='0'>Todos</option>";

$queryp= "select id, nombre, apellido1, apellido2 from empleados where trabajando='S' AND id_tienda IN (SELECT id_tienda FROM tiendas where id in ($TSEL) );";
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){
$id=$row['id']; $nom=$row['nombre'] . " " . $row['apellido1'] . " " . $row['apellido2'];
	
$valores['opt'].="<option value='$id'>$nom</option>";
	 
}



if (!$dbnivel->close()){die($dbnivel->error());};



echo json_encode($valores);