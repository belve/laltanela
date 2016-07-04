<?php
require_once("../db.php");
require_once("../variables.php");

require_once("../functions/gettiendas.php");

$cajt="";
foreach ($tiendas as $idt => $nomt) {
    $cajt.="<div class='cajt' id='idt_$idt' onclick='javascript:cajtie($idt);' ondblclick='tselALL();' style='background-color:#8DC29E;'>$nomt</div> <script>window.top.tsel[$idt]=1;</script> ";
}
$cajt.="<div style='clear:both;'></div>";

if (!$dbnivel->open()){die($dbnivel->error());};

$htmlProv="<option value=''></option>";
$queryp= "select id, nombre from proveedores ORDER BY nombre ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlProv .="<option value='$id'>$nombre</option>";	
}	



$htmlGrupo="<option value=''></option>";
$queryp= "select id, nombre from grupos ORDER BY id ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlGrupo .="<option value='$id'>$nombre</option>";	
}



$htmlCol="<option value=''></option>";
$queryp= "select id, nombre from colores ORDER BY nombre ASC;";	
$dbnivel->query($queryp);

while ($row = $dbnivel->fetchassoc()){
	$id=$row['id'];$nombre=$row['nombre'];
	$htmlCol .="<option value='$id'>$nombre</option>";	
}




if (!$dbnivel->close()){die($dbnivel->error());};

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script>



</script>

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/bd-basicos.js"></script>
<script type="text/javascript" src="/js/informes.js"></script>
<script src="/js/ffecha.js" type="text/javascript"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />

    <script>
        window.top.tsel	= new Array();
        window.top.tselALL	=1;
    </script>

</head>
<body>



<div style="position:relative; float:left; margin-left:0px">



<div style="position:absolute; top: 0px; left: 0px;  border: 1px solid #888888; padding: 5px;     width: 710px;">

<div style="float:left;margin-right: 10px;">
<div>Proveedor: <select style="margin-left:0px;" id="2" class="medio"><?php echo $htmlProv; ?></select></div>
<div>Grupo:     <select style="margin-left:22px;" id="3" onchange="cargasubgrupo(this.value);" class="medio">	<?php echo $htmlGrupo; ?></select></div>
<div>Subgrupo:  <select style="margin-left:2px;" id="4" class="medio"><option value=''></option></select></div>
</div>	

<div style="float:left;margin-right: 10px;">
<div>Color: <select style="margin-left:10px;" id="5" class="medio"><?php echo $htmlCol; ?></select></div>
<div>Código: <input  style="margin-left:0px;"class="medio" type="text" id="6" /></div>
<div>Precio: <input  style="margin-left:5px;"class="medio" type="text" id="7" /></div>
</div>	



<div style="float:left;margin-right: 10px;">
<div>Desde: <input  style="margin-left:0px;"class="medio" type="text" id="8" /></div>
<div>Hasta: <input  style="margin-left:4px;"class="medio" type="text" id="9" /></div>
<div>Temp: <input  style="margin-left:6px;"class="medio" type="text" id="10" /></div>
</div>	

<div style="float:left;margin-right: 10px;">
<div>Det: <input  style="margin-left:11px; width: 120px;"class="medio" type="text" id="11" /></div>
<div>Com: <input  style="margin-left:4px; width: 120px;"class="medio" type="text" id="12" /></div>
<div>Ref.P: <input  style="margin-left:0px; width: 120px;"class="medio" type="text" id="13" /></div>
</div>	




</div>

<div style="clear:both;"></div>






<div style="position: absolute;top: 115px;left: 0px;    width: 154px; border: 1px solid #888888; padding: 5px; ">

<div style="float: left; position: relative">
	
	<div style="">Desde: <input value="dd/mm/aaaa" type="text" class="medio" id="fini" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);"></div>
	<div style="">Hasta: <input class="contH medio" value="dd/mm/aaaa" type="text" id="ffin" onfocus="javascript:dlF(this.id);" onkeyup="javascript:tabF(this.id);" style="color:#333333;"></div>

</div>

</div>


<div class="cajastiendas" style="position: absolute; top:115px; left: 200px; margin:0px;">
   <?php echo $cajt; ?>
</div>


<div style="position: absolute; top:115px; left: 500px; margin:0px;">
	
	<div style="margin:0px; width: 151px;" class="boton" onclick="javascript:informe('ing_gast');" >Informe >> </div>


</div>



    <div style="float: left;  position: absolute; top: 150px; left: 545px;">

        <div id="reloj" class="relojCalc" style="visibility: hidden;"><img src="/iconos/loading1.gif"></div>
        <div id="status" style="font-size: 12px; text-decoration: blink; color: #888888;"></div>
    </div>




<iframe id="excel" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>
<iframe id="photos" src="" width="0" height="0" border="0" frameborder="0" marginheight="0" scrolling="no"></iframe>
</div>

</body>
</html>

