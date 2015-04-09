<?php
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; eval($asignacion); };
require_once("../db.php");
require_once("../variables.php");


$campos=array();
$campos=$_GET['campos'];


$modificos="";$sinfact="";
foreach ($campos as $camp => $value){if($camp !='sinfact'){
	$modificos .=" $camp = '$value',";

}else{$sinfact=$value;}
}
$modificos=substr($modificos,0,strlen($modificos)-1);

if (!$dbnivel->open()){die($dbnivel->error());};

$queryp= "update $tabla set $modificos where id=$id;"; 
$dbnivel->query($queryp);
echo $queryp;
if (!$dbnivel->close()){die($dbnivel->error());};

SyncModBD($queryp);


if($tabla=='articulos'){
    if (!$dbnivel->open()){die($dbnivel->error());};
if($sinfact){
    $queryp= "insert into sin_fact (cod) values ('$id');";
    $dbnivel->query($queryp);
}else{
    $queryp= "delete from sin_fact where cod='$id';";
    $dbnivel->query($queryp);
}
    if (!$dbnivel->close()){die($dbnivel->error());};
}




?>