<?php
require_once("../db.php");
require_once("../variables.php");






?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />



<title>test</title>


<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/js/functions.js"></script>

<script type="text/javascript" src="/js/modarticulos.js"></script>


<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />



</head>
<body onload="foc();">


<div style="clear: both;margin-bottom: 10px; "></div>	
<input type="hidden" id="1" value="" />
<table style="float: left;">
		<tbody>
		
		<tr>
			<td>Código</td>
			<td><input type="text" name="idmost" class="medio" id="cod" onchange="javascrit:cargaArticulo(this.value);" ></td> 
			
		</tr>
		
		<tr>
			<td>Proveedor:</td>
			<td><input type="text" name="color" class="largo" style="border:0px;background-color: #C8C8C8;    font-size: 10px;" id="2"></td>
		</tr>

		<tr>
			<td>Grupo:</td>
			<td><input type="text" name="color" class="medio" style="border:0px;background-color: #C8C8C8;    font-size: 10px;" id="3"></td>
		</tr>
		
		<tr>
			<td>Subgrupo:</td>
			<td><input type="text" name="color" class="medio" style="border:0px;background-color: #C8C8C8;    font-size: 10px;" id="4"></td>
		</tr>
		
		<tr>
			<td>Color:</td>
			<td><input type="text" name="color" class="medio" style="border:0px;background-color: #C8C8C8;    font-size: 10px;" id="5"></td>
		</tr>	
		
		
		<tr>
			<td>Detalles:</td>
			<td><input type="text" name="color" class="largo"  id="18"></td>
		</tr>	
		
		<tr>
			<td>Comentarios:</td>
			<td><input type="text" name="color" class="largo"  id="19"></td>
		</tr>	
		
		
		
		
		<tr height="53">
			<td>Dto.<input type="text" name="color" class="corto" id="6" onchange="calcosto('<?php echo "1." . $iva;?>');"> </td>
			<td>2º Dto.<input type="text" name="color" class="corto" id="7" style="margin-right: 35px;" onchange="calcosto('<?php echo "1." . $iva;?>');"> IVA <?php echo $iva;?> %</td>
		
		</tr>
		
		<tr>
			
			<td><input type="checkbox" id="8"> Congelado</td>
		
		</tr>
		
		<tr><td><div class="iconos save_on" style="margin-top:20px; float:left;" onclick="javascrit:modiArt();"></div></td></tr>
		
		
</tbody>
</table>

<table style="float: left; margin-left: 10px;">
		<tbody>
		
		<tr>
			<td>Ref. Prov</td>
			<td><input type="text" name="idmost" class="largo" style="width: 156px;" id="9" ></td>
		</tr>
		
		<tr>
			<td>Stock</td>
			<td><input type="text" name="idmost" class="corto" id="10" ></td>
		</tr>
		
		<tr>
			<td>Stock Min</td>
			<td><input type="text" name="idmost" class="corto" id="11" ></td>
		</tr>
		
		
		<tr>
			<td>Stock Ini</td>
			<td><input type="text" name="idmost" class="corto" id="20" ></td>
		</tr>
		
			<tr>
			<td>Repos.</td>
			<td><input type="text" name="idmost" class="corto" id="rep" style="border:0px;background-color: #C8C8C8;    font-size: 10px;" readonly ></td>
		</tr>
		
		<tr>
			<td>Temporada</td>
			<td><input type="text" name="idmost" class="corto" id="12" ></td>
		</tr>
		
		<tr>
			<td>P.Costo</td>
			<td><input type="text" name="idmost" class="corto" id="13"  onchange="calcosto('<?php echo "1." . $iva;?>');"></td>
		</tr>

	<tr>
			<td>P.Neto</td>
			<td><input type="text" name="idmost" class="corto" id="14" ></td>
		</tr>
			<tr>
			<td>P.Franq.</td>
			<td><input type="text" name="idmost" class="corto" id="15" ></td>
		</tr>
			<tr>
			<td>PVP</td>
			<td><input type="text" name="idmost" class="corto" id="16" ></td>
		</tr>

</tbody>
</table>


<div style="border: 1px solid #888888;
    height: 241px;
    left: 545px;
    position: absolute;
    top: 14px;
    width: 300px; background-color: #ffffff;">
    
<img src="" id="foto" style="max-width: 298px; max-height: 239px";>    
    
    </div>

<div style="clear: both;margin-bottom: 10px; "></div>




<div class="timer" id="timer"><img src="/iconos/loading1.gif"></div>


</body>
</html>

		