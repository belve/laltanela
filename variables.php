<?php

$iva=21;


######## risasa
$delT=10;     #### elimina uno de cada
$tnoRISASA[999]=1;	###### tiendas que no procesa
##################################


$equiEST['P']="ACTIVO";
$equiEST['F']="FINALIZADO";
$equiEST['A']="EN ALMACÉN";
$equiEST['T']="ENVIADO A TIENDAS";
$equiEST['E']="ENVIADO A TIENDAS";

$tab_sync['articulos']=1;
$tab_sync['empleados']=1;
$tab_sync['colores']=1;
$tab_sync['grupos']=1;
$tab_sync['subgrupos']=1;
$tab_sync['proveedores']=1;
$tab_sync['tiendas']=1;


global $dbnivel; global $tiendas;
$dbnivel=new DB('192.168.1.11','edu','admin','laltalena');

$pathimages="c:/D/fotos_altanela/";
$urlimages="/photos/";

require_once("../functions/gettiendas.php");
require_once("../functions/sync.php");
?>