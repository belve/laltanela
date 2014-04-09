<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");

$debug=0;



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
$BE=array();
$paginas=array();$grid=array();
$fini="";
$ffin="";
$format=array(); $BOLDrang=array();

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};




$peds="";$cods="";$codigos=array();$vendidos=array();$cord=array();

if (!$dbnivel->open()){die($dbnivel->error());};
$nprov="";
if($id_proveedor){
$queryp= "select nomcorto from proveedores where id=$id_proveedor;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nprov=$row['nomcorto'];};
}


$ngrupo="";
if($id_grupo){
$queryp= "select nombre from grupos where id=$id_grupo;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ngrupo=$row['nombre'];};
}
$nsgrupo="";
if($id_subgrupo){
$queryp= "select nombre from subgrupos where id=$id_subgrupo;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$nsgrupo=$row['nombre'];};
}

$ncolor="";
if($id_color){
$queryp= "select nombre from colores where id=$id_color;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$ncolor=$row['nombre'];};
}



foreach ($tiendas as $idt => $nom) {
$vendidos[$idt]=array();
$stocks[$idt]=array();	
}





if($cong){$conge=" AND congelado=0";}else{$conge="";}

require_once("../functions/listador.php");

$codigosIN="";$codigosIN2="";
if($options){
$queryp= "select id, codbarras, refprov, stock, stockini, temporada, congelado, pvp, precioneto from articulos where $options$conge;";

}else{
$queryp= "select id, codbarras, refprov, stock, stockini, temporada, congelado, pvp, precioneto from articulos where congelado=0;";	
}

$equicon[0]='NO';
$equicon[1]='SI';

$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$cd=$row['codbarras'];
$cd2=$row['id'];

$datos[$cd]['refprov']=$row['refprov'];
$datos[$cd]['stock']=$row['stock'];
$datos[$cd]['stockini']=$row['stockini'];
$datos[$cd]['temporada']=$row['temporada'];
$datos[$cd]['congelado']=$equicon[$row['congelado']];
$datos[$cd]['pvp']=$row['pvp'];
$datos[$cd]['precioneto']=$row['precioneto'];


$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;



}


$queryp= "select (select nombre from grupos where id=id_grupo) as G, nombre as SG, id_grupo, clave from subgrupos;";	
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$grupos[$row['id_grupo']]=$row['G'];	
$subgrupos[$row['id_grupo'] . $row['clave']]=$row['SG'];	
}


if (!$dbnivel->close()){die($dbnivel->error());};


$cols[1]['A']='A';
$cols[1]['B']='B';

$cols[2]['A']='D';
$cols[2]['B']='E';

$cols[3]['A']='G';
$cols[3]['B']='H';

$cols[4]['A']='J';
$cols[4]['B']='K';


$act=1;$actO='A';


if($act==1){
$cdg=array();
if(count($cord)>0){
if($actO=='A'){ksort($cord);}else{krsort($cord);} 
foreach ($cord as $gu => $subs) {
	if($actO=='A'){ksort($subs);}else{krsort($subs);} foreach ($subs as $sb => $ccs)	{
		if($actO=='A'){ksort($ccs);}else{krsort($ccs);} foreach ($ccs as $cd => $codbar) {
$cdg[$codbar]=1;
}}}}}


$angle=array();
$gridD=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();

$fila=0;$cuenf=0; $first=1; $lg=""; $lsg=""; $c=1; $count=0; $lastfil=$fila;

if(count($cdg)>0){
foreach ($cdg as $cd => $point) {
//if($cuenf >= 8){$cuenf=0;$paginas[$fila+4]=1;}	



if($count > 49){
$lg=""; $lsg=""; $first=1;	$count=0;
if ($c < 4){$c++; $fila=$lastfil;}else{ $c=1; $paginas[$fila]=1; $lastfil=$fila;};
}


$fila++; $count++;

$A=$cols[$c]['A'];
$B=$cols[$c]['B'];


if ($first) {
$grid[$fila][$A]="CODIGO";
$grid[$fila][$B]="STOCK."; 


$align		[$A . $fila . ':' . $B . $fila]='C';
$BOLDrang	[$A . $fila . ':' . $B . $fila]=1;
$BTrang		[$A . $fila . ':' . $B . $fila]=1;
$fila++;$count++; $first=0;

}



$g=substr($cd,0,1);
$sg=substr($cd,0,2);



if(!array_key_exists($sg, $subgrupos)){$subgrupos[$sg]="GENERICO";};

$sng=$grupos[$g] . " / " . $subgrupos[$sg];

if($sg!=$lsg){
	 $fila++; $count++; $lsg=$sg; 
	 $grid[$fila][$A]=$sng; 
	 $align		[$A . $fila . ':' . $B . $fila]='C';
	 $BOLDrang	[$A . $fila . ':' . $B . $fila]=1;
	 $Mrang		[$A . $fila . ':' . $B . $fila]=1;
	 $fila++; $count++;
}


$align[$A . $fila]='C';
$align[$B . $fila]='C';

$grid[$fila][$A]=$cd;
$grid[$fila][$B]=$datos[$cd]['stock']; 

$BTrang		[$A . $fila . ':' . $B . $fila]=1;
$BOLDrang	[$A . $fila . ':' . $B . $fila]=2;



}}

$anchos['A']=18;
$anchos['B']=13;
$anchos['C']=2;
$anchos['D']=18;
$anchos['E']=13;
$anchos['F']=2;
$anchos['G']=18;
$anchos['H']=13;
$anchos['I']=2;
$anchos['J']=18;
$anchos['K']=13;

$_SESSION['angle']=$angle;
$_SESSION['BOLDrang']=$BOLDrang;
$_SESSION['cgd'] = $cdg; 
$_SESSION['grid'] = $grid; 
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['format']=$format;
$_SESSION['paginas']=$paginas;
$_SESSION['nomfil']="Inventario-" . date('Y') . date('m') . date('d');

$res['ng']=count($grid)+count($anchos)+count($align)+count($crang)+count($Mrang)+count($BTrang)+count($paginas)+count($format);
echo json_encode($res);
?>