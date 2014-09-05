<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;




$frqcia="";
$options=""; $cong=0;
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";
$yalistados="";
$detalles="";
$comentarios="";
$ord=1;
$tab=1;
$arts=array();
$vals=array();
$fijos	=array();
$pvps= array();
$tiends=array();
$totcod=array();
$codVEND=array();
$codPOR=array();
$PC=array();
$VV=array();
$BE=array();$datos=array();
$paginas=array();$grid=array();$cord=array();$datos=array();
$fini="";
$ffin="";$mes="";
$format=array(); $BOLDrang=array(); $tipo=""; $temp="";$ccn=0;$total=0;$p=0;
$ttss="";$rot=0; $dev=0; 
foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$ttss=substr($ttss, 0,-1);$emps=array();
$frqcia=1;

$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);



$db='laltalena';
$dbn=new DB('192.168.1.11','edu','admin',$db);

$sum['pc']=0;
$sum['q']=0;
if (!$dbn->open()){die($dbn->error());};
$queryp="select id_articulo, 
sum(cantidad) as Qty, 
(sum(cantidad)*(SELECT preciocosto FROM articulos WHERE articulos.id=pedidos.id_articulo )) as Sqty 
from pedidos where fecha <= '$ffin' AND fecha >= '$fini'  AND estado NOT LIKE '-'  GROUP BY id_articulo;";
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){

$sum['pc']=$sum['pc']+ $row['Sqty'];	
$sum['q']=$sum['q']+ $row['Qty'];
	

}

if($sum['q']>0){
$res['pcm']=number_format(($sum['pc']/$sum['q']),2,',','.');
}else{
$res['pcm']="--";	
}


$queryp="select (select sum(importe) from tickets where fecha <= '$ffin' AND fecha >= '$fini') /
 (select sum(cantidad) from ticket_det where fecha <= '$ffin' AND fecha >= '$fini') as pvm;";
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){

$res['pvm']=number_format($row['pvm'],2,',','.');
	

}




$queryp="select (select sum(cantidad) from ticket_det where fecha <= '$ffin' AND fecha >= '$fini') / 
(select count(*) from tickets where fecha <= '$ffin' AND fecha >= '$fini') as upo;
";
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){

$res['upo']=number_format($row['upo'],3,',','.');
	

}




if (!$dbn->close()){die($dbn->error());};







if($risase){$db='laltalena_a';}else{$db='laltalena';};
$dbn=new DB('192.168.1.11','edu','admin',$db);

if (!$dbn->open()){die($dbn->error());};
$queryp="select count(*) as nt, sum(importe) as st, (sum(importe)/count(*)) as tm 
from tickets where fecha >= '$fini' AND fecha <= '$ffin' AND 
id_tienda IN ($ttss) AND importe >0; ";
$dbn->query($queryp);if($debug){echo "$queryp \n\n";};
echo $dbn->error();
while ($row = $dbn->fetchassoc()){
$res['tm']=number_format($row['tm'],2,',','.');
}




if (!$dbn->close()){die($dbn->error());};



echo json_encode($res);






?>

