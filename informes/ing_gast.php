<?php
session_start();
set_time_limit(0);
ini_set("memory_limit", "-1");

require_once("basics.php");
require_once("../db.php");
require_once("../variables.php");
require_once("gimagF.php");

$pathimages="c:/D/fotos_altanela/";

$debug=0;

$foto=array();
$angle=array();
$grid=array();
$anchos=array();
$align=array();
$crang=array();
$Mrang=array();
$BTrang=array();

$options="";
$id_proveedor="";$id_grupo="";$id_subgrupo="";$id_color="";$codigo="";$pvp="";$desde="";$hasta="";$temporada="";$hago="";
$yalistados="";
$detalles="";
$comentarios="";
$limite=0;
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
$paginas=array();
$format=array();
$BOLDrang=array();
$foto=array();
$fini="";
$ffin="";$barrasIN="";

foreach($_GET as $nombre_campo => $valor){  $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";   eval($asignacion);};
$fdesde=$fini; $fhasta=$ffin;
$fini=substr($fini, 6,4) . "-" . substr($fini, 3,2) . "-" . substr($fini, 0,2);
$ffin=substr($ffin, 6,4) . "-" . substr($ffin, 3,2) . "-" . substr($ffin, 0,2);
$ttss=substr($ttss, 0,-1);

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


$tiendasin=explode(",",$ttss);$tiendasin=array_flip($tiendasin);


foreach ($tiendas as $idt => $nom) {if(array_key_exists($idt,$tiendasin)){
$vendidos[$idt]=array();
$stocks[$idt]=array();
$tiendas2[$idt]=$nom;
}}
$tiendas=$tiendas2;






require_once("../functions/listador.php");

$codigosIN="";
if($options){
$queryp= "select * from articulos where $options;";
}else{
$queryp= "select * from articulos where congelado=0;";
}	
		
        
$dbnivel->query($queryp);if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
$id_articulo=$row['id']; $cd=$row['codbarras']; $refprov=$row['refprov'];
$codigosIN .=$id_articulo . ",";
$barrasIN .=$cd . ",";


if(!array_key_exists($cd, $codigos)){
$codigos[$cd]="$cd / $refprov";
$g=substr($cd,0,1);$sg=substr($cd,1,1);$c=substr($cd,4);
$cord[$g][$sg][$c]=$cd;
$cods .=$cd . ","; 
$totcod[$cd]=1;
}




}
$codigosIN=substr($codigosIN, 0,-1);
$barrasIN=substr($barrasIN, 0,-1);
$codigosIN="AND id_articulo IN ($codigosIN)";




$queryp= "select
(select preciocosto from articulos where id=id_articulo) * sum(cantidad) as costo,
sum(cantidad) as cant,
id_tienda
from pedidos where
(fecha >= '$fini' AND fecha <= '$ffin') AND
(estado='T' OR estado='A' OR estado='F') AND
id_tienda IN ($ttss)
$codigosIN
group by id_tienda;";

$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};$enviados=array();
while ($row = $dbnivel->fetchassoc()){
	
$costo=$row['costo']; $idt=$row['id_tienda']; $cant=$row['cant'];
$grid[$idt]['costo']=$costo;
$grid[$idt]['cant']=$cant;
}


############ aqui debo sumar lo enviado en fijarstock
$queryp= "select
(select preciocosto from articulos where id=id_articulo) * sum(suma) as costo,
sum(suma) as cant,
id_tienda
from fij_stock where bd=2 AND (fecha >= '$fini' AND fecha <= '$ffin') AND
id_tienda IN ($ttss)
$codigosIN group by id_articulo, id_tienda;";

$dbnivel->query($queryp);

if($debug){echo "$queryp \n\n";};
while ($row = $dbnivel->fetchassoc()){
    $costo=$row['costo']; $idt=$row['id_tienda'];$cant=$row['cant'];

    if(array_key_exists($idt, $grid)){

        if(array_key_exists('costo', $grid[$idt])){
             $grid[$idt]['costo']=$grid[$idt]['costo']+$costo;
        }else{
             $grid[$idt]['costo']=$costo;
        }

        if(array_key_exists('cant', $grid[$idt])){
            $grid[$idt]['cant']=$grid[$idt]['cant']+$cant;
        }else{
            $grid[$idt]['cant']=$cant;
        }

    }else{
        $grid[$idt]['costo']=$costo;
        $grid[$idt]['cant']=$cant;
    }

}
########################################################







$codv=array();
$queryp= "select
id_tienda,
sum(cantidad) as cant,
sum(importe * cantidad) as imp
from ticket_det where (fecha >= '$fini' AND fecha <= '$ffin')
AND id_articulo IN ($barrasIN) AND
id_tienda IN ($ttss)
group by id_tienda;";
$dbnivel->query($queryp); if($debug){echo "$queryp \n\n";};

while ($row = $dbnivel->fetchassoc()){
    $idt=$row['id_tienda']; $imp=$row['imp']; $cant=$row['cant'];
    $grid[$idt]['vend']=$imp;
    $grid[$idt]['vcant']=$cant;
}


if (!$dbnivel->close()){die($dbnivel->error());};



$fila=2;

$BOLDrang['A2:H2']=1;
$grilla[$fila]['B']='Costo (sin IVA)';
$grilla[$fila]['C']='IVA';
$grilla[$fila]['D']='Cantidad';
$grilla[$fila]['E']='Ventas (sin IVA)';
$grilla[$fila]['F']='IVA';
$grilla[$fila]['G']='Cantidad';
$grilla[$fila]['H']='Bº';



$totales=array();
foreach ($grid as $idt => $fields) {$fila++;

    if(array_key_exists($idt,$tiendasN)){$tie=$tiendasN[$idt];}else{$tie='--';}
    $grilla[$fila]['A']=$tie; $BOLDrang['A'.$fila]=1;

    if(!array_key_exists('costo',$fields)){$fields['costo']=0;};
    if(!array_key_exists('cant',$fields)){$fields['cant']=0;};
    if(!array_key_exists('vend',$fields)){$fields['vend']=0;};
    if(!array_key_exists('vcant',$fields)){$fields['vcant']=0;};

    $c1=$fields['costo']; $c2=round(($c1*$iva/100),2); $c3=$fields['cant']; $c4=$fields['vend']; $c5=round(($c4 - ($c4/(1+($iva/100)))),2); $c4=$c4-$c5;  $c6=$fields['vcant'];  $c7=($c4 +$c5) - ($c1 + $c2);

    $grilla[$fila]['B']=$c1;
    $grilla[$fila]['C']=$c2;
    $grilla[$fila]['D']=$c3;
    $grilla[$fila]['E']=$c4;
    $grilla[$fila]['F']=$c5;
    $grilla[$fila]['G']=$c6;
    $grilla[$fila]['H']=$c7;


    $BOLDrang['B'. $fila .':H'. $fila]=0;

    foreach ($fields as $field => $val){
    if(!array_key_exists($field,$totales)){$totales[$field]=0;}
    $totales[$field]=$totales[$field]+$val;
    }


}
$fila++;

if(!array_key_exists('costo',$totales)){$totales['costo']=0;};
if(!array_key_exists('cant',$totales)){$totales['cant']=0;};
if(!array_key_exists('vend',$totales)){$totales['vend']=0;};
if(!array_key_exists('vcant',$totales)){$totales['vcant']=0;};

$c1=$totales['costo']; $c2=round(($c1*$iva/100),2); $c3=$totales['cant']; $c4=$totales['vend']; $c5=round(($c4 - ($c4/(1+($iva/100)))),2);  $c4=$c4-$c5;  $c6=$totales['vcant']; $c7=($c4 +$c5) - ($c1 + $c2);

$grilla[$fila]['A']='Totales';
$grilla[$fila]['B']=$c1;
$grilla[$fila]['C']=$c2;
$grilla[$fila]['D']=$c3;
$grilla[$fila]['E']=$c4;
$grilla[$fila]['F']=$c5;
$grilla[$fila]['G']=$c6;
$grilla[$fila]['H']=$c7;

$BOLDrang['A'. $fila .':H'. $fila]=1;

$gridD=array();
 /*
$crang['A' . ($fila+1) . ':' . $colu[$col-1] . ($fila+1)]='CCCCCC';
$crang['A' . ($fila+2) . ':' . $colu[$col-1] . ($fila+2)]='FFFF66';
$crang['A' . ($fila+3) . ':' . $colu[$col-1] . ($fila+3)]='CCFF99';
$align['C' . ($fila) . ':' . $colu[$col-1] . ($fila)]='C';


$BTrang['A1:S1']=1;
$BTrang['A2:O2']=1;
$BTrang['B3:O3']=1;

*/

$anchos['A']=30;
$anchos['B']=20;
$anchos['C']=20;
$anchos['D']=20;
$anchos['E']=20;
$anchos['F']=20;
$anchos['G']=20;
$anchos['H']=20;

$cdg=array();


$_SESSION['foto']=$foto;
$_SESSION['angle']=$angle;
$_SESSION['cgd'] = $cdg; 
$_SESSION['grid'] = $grilla;
$_SESSION['anchos'] = $anchos;
$_SESSION['align'] = $align;
$_SESSION['crang']=$crang;
$_SESSION['Mrang']=$Mrang;
$_SESSION['BTrang']=$BTrang;
$_SESSION['paginas']=$paginas;
$_SESSION['format']=$format;
$_SESSION['nomfil']="Ingresos - Gastos";
$_SESSION['BOLDrang']=$BOLDrang;

$res['ng']=7*count($grilla);

echo json_encode($res);


?>