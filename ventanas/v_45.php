<?php
require_once("../db.php");
require_once("../variables.php");

$mid='SANT050514173614';
$dbnivel2=new DB('192.168.1.11','edu','admin','laltalena_a');
if (!$dbnivel2->open()){die($dbnivel2->error());};
$queryp= "select id_ticket from tickets ORDER BY id DESC limit 1;"; 
$dbnivel2->query($queryp);
while ($row = $dbnivel2->fetchassoc()){$mid=$row['id_ticket'];};
if (!$dbnivel2->close()){die($dbnivel2->error());};



if (!$dbnivel->open()){die($dbnivel->error());};
$queryp= "select id, fecha from tickets where id_ticket='$mid';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$lid=$row['id']; $fechaINI=$row['fecha'];};
	
$queryp= "select count(id) as tot from tickets where id > $lid;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$tot=$row['tot'];};

$queryp= "select max(id) as midt from tickets;"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$midt=$row['midt'];};	

$queryp= "select fecha from tickets where id='$midt';"; 
$dbnivel->query($queryp);
while ($row = $dbnivel->fetchassoc()){$fechaFIN=$row['fecha'];};	


	
if (!$dbnivel->close()){die($dbnivel->error());};






$fechaINI=ffecha($fechaINI);
$fecha = date_create_from_format('d/m/Y', $fechaINI);
$fecha->add(new DateInterval('P1D'));
$fechaINI= $fecha->format('d/m/Y');

$fechaFIN=ffecha($fechaFIN);	

function ffecha($F){
$d=explode('-',$F);
return $d[2] . "/" . $d[1] . "/" . $d[0];	
	
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>test</title>

<script type="text/javascript" src="/jquery/jquery-1.9.0.min.js"></script>

<link rel='stylesheet' type='text/css' href='/css/framework_inside.css' />

<script>

    function doit0(){
    
    window.top.porc=document.getElementById('porc').value;
    document.getElementById('bt').innerHTML="0% Procesado.";	
    
   
    var id=document.getElementById('hminid').value;
    var idf=document.getElementById('hmaxid').value;
    var tot=document.getElementById('htot').value;
    doit1(id,idf,tot);
    }

	function doit1(id,idf,tot){
			
	url='/ajax/pRISASA.php?iid=' + id + '&fid=' +idf + '&porc=' + window.top.porc;
	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
		
		if((key==1)&&(val>0)){
		var func="doit2(" + val + "," + idf + "," + tot + ")";
				
		var por=100 - ((idf - val)*100)/tot; por=Math.round(por);
		document.getElementById('bt').innerHTML= por + "% Procesado";

		setTimeout(func, 1000);		
		}else{
		fin();	
		}
	
	
	});
	});		
		
		
	}
	
	function doit2(id,idf,tot){
	
	
	 	
	url='/ajax/pRISASA.php?iid=' + id + '&fid=' + idf + '&porc=' + window.top.porc;
	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
		
		if((key==1)&&(val>0)){
		var func="doit2(" + val + "," + idf + "," + tot + ")";
		
		var por=100 - ((idf - val)*100)/tot; por=Math.round(por);
		document.getElementById('bt').innerHTML= por + "% Procesado";
		
		setTimeout(func, 1000);		
		}else{
		fin();	
		}
	
	
	});
	});		
		
		
	}


function calc(){
$.ajaxSetup({'async': false});
document.getElementById('bcalc').className="anime boton";
      

    
	url='/ajax/calcP.php?ffin=' + document.getElementById('ffin').value;
	$.getJSON(url, function(data) {
	$.each(data, function(key, val) {
		
	if(key=='minid'){document.getElementById('hminid').value=val; }
	if(key=='tot'){document.getElementById('htot').value=val;}
	if(key=='maxid'){document.getElementById('hmaxid').value=val; }	
	
	});
	});	
	
document.getElementById('txt').innerHTML="Se procesarán del ticket " + document.getElementById('hminid').value + " al " + document.getElementById('hmaxid').value + ".";		
document.getElementById('bcalc').className="boton"; 
}

function fin(){
document.getElementById('bt').innerHTML="100% Procesado.";	

document.getElementById('txt').innerHTML="Periodo seleccionado procesado.";	

}	
	
</script>

<style>

@keyframes blinker {  
  0% { visibility: visible; }
  50% { visibility: hidden; }
  100% { visibility: visible; }
}
.anime {
  animation: blinker steps(1) 1s infinite;
}	
	
</style>


</head>
<body>	
<div style="cursor:auto;" id="todo">

<?php if($lid < $midt){ ?>

<div>
Del <?php echo $fechaINI;?> al <input type="text" id="ffin" value="<?php echo $fechaFIN;?>" style="width:100px;">
<div class="boton" style="width:50px;" id="bcalc";  onclick="calc();">Calcular</div>	
</div>	

<div id="txt">
Se procesarán del ticket <?php echo $lid; ?> al <?php echo $midt; ?>.
</div>

<input type="hidden" id="hminid" value="<?php echo $lid;?>"> 
<input type="hidden" id="hmaxid" value="<?php echo $midt;?>"> 
<input type="hidden" id="htot" value="<?php echo $tot;?>"> 


<div style="margin-top:10px;" id="bt">
<input type="text" id="porc" value="10" style="width: 30px; position: relative; float:left; " /> <div style="position: relative; float: left;">%</div> 	
<div class="boton" style="width:150px; position:relative; float:left; margin-top: 0; margin-left:10px;" id="bpro" onclick="doit0();">Procesar</div>
</div>
<?php }else{  ?>

No hay tickets pendientes de procesar.

<?php }  ?>

</div>
</body>
</html>