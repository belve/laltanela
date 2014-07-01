
<?php
require_once("../db.php");
require_once("../variables.php");

function ffecha($F){
$d=explode('/',$F);
return $d[2] . "-" . $d[1] . "-" . $d[0];	
	
}


foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};


$ffin=ffecha($ffin);




$mid='SANT050514173614';
$dbnivel2=new DB('192.168.1.11','edu','admin','laltalena_a');
if (!$dbnivel2->open()){die($dbnivel2->error());};
$queryp= "select id_ticket from tickets ORDER BY id DESC limit 1;"; 
$dbnivel2->query($queryp);
while ($row = $dbnivel2->fetchassoc()){$mid=$row['id_ticket'];};
if (!$dbnivel2->close()){die($dbnivel2->error());};



if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id from tickets where id_ticket='$mid';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$lid=$row['id'];};
	
$queryp= "select count(id) as tot from tickets where id > $lid AND fecha <= '$ffin';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$tot=$row['tot'];};

$queryp= "select max(id) as midt from tickets where fecha <= '$ffin';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$midt=$row['midt'];};	




	
if (!$dbnivel->close()){die($dbnivel->error());};






$res['minid']=$lid;
$res['tot']=$tot;
$res['maxid']=$midt;

echo json_encode($res);
?>