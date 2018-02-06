<?php require_once('../Connections/gchance.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_gchance, $gchance);
$query_listado = "
SELECT
a.nombre AS
agencias,
a.valor AS
agencia_valor,
top.tope AS tope,
l.nombre AS loteria,
t.numero AS numero,
t.valor/(SELECT COUNT(*) FROM tiquetes_as_loterias WHERE tiquetes=t.id) AS valor_, 
SUM(t.valor/(SELECT COUNT(*) FROM tiquetes_as_loterias WHERE tiquetes=t.id)) AS valor,
t.fecha AS fecha
FROM
tiquetes t,
ganadores g,
tiquetes_as_loterias tl,
loterias l,
agencias a,
tope top
WHERE
t.id=tl.tiquetes AND
t.numero=g.numero AND
g.loteria=tl.loterias AND
g.loteria=l.id AND
t.agencia=a.id AND
g.fecha='".$_GET['fecha']."' AND 
top.fecha='".$_GET['fecha']."'
GROUP BY loteria,numero
ORDER BY t.numero,l.nombre ASC
";
//echo $query_listado ;
$listado = mysql_query($query_listado, $gchance) or die(mysql_error());
$row_listado = mysql_fetch_assoc($listado);
$totalRows_listado = mysql_num_rows($listado);

if($r==2){}else{die("Sin permisos");}
?>
<ul class="nav nav-tabs">
	<li class="active"><a  href="#1" data-toggle="tab">Fecha</a></li>
</ul>
<script language="javascript">
$(document).ready(function() {
	$(".botonExcel").click(function(event) {
		$("#datos_a_enviar").val( $("<div>").append( $("#Exportar_a_Excel").eq(0).clone()).html());
		$("#FormularioExportacion").submit();
});
});
</script>
<style type="text/css">
.botonExcel{cursor:pointer;}
</style>
<div class="tab-content ">
	<div class="tab-pane active" id="1">
    <form action="index.php?modulo=Reporte_Tope" method="get" >
    
    
    <table width="100%" border="0">
  <tr>
    <td width="20%"><input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control" size="20" required /><input type="hidden" name="modulo" value="Reporte_Tope" class="form-control" size="20" /></td>
    <td width="80%"><input type="submit" value="Cambiar" class="btn btn-info" style="margin-top:0px" /></td>
  </tr>
</table>

    </form>      
    <hr />
    <form action="ficheroExcel.php" method="post" target="_blank" id="FormularioExportacion">
    <p>Exportar a Excel  <img src="../img/export_to_excel.gif" class="botonExcel" /></p>
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
    </form>    
    <hr />
      <table width="100%" border="1" id="Exportar_a_Excel">
        <tr>
          <td align="center" bgcolor="#EEE"><strong>Fecha</strong></td>
                    <td align="center" bgcolor="#EEE"><strong>Loteria</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Numero</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Valor</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Total Tope</strong></td>
        </tr>
        <?php 
		$suma=0;
		$sig=0;
		do { ?>
          <tr>
                     <td align="center"><?php echo $row_listado['fecha']; ?></td>
           <?php  $av=$row_listado['agencia_valor']; ?>
            <?php $t=($row_listado['tope']);
									  number_format($t);
			
			?>
            <td align="center"><?php echo $row_listado['loteria']; ?></td>
            <td align="center"><?php echo $n=$row_listado['numero']; ?></td>
            <td align="center"><?php $v=($row_listado['valor']); 
									 echo number_format($v);			
			?></td>
 
            <?php
									 $cn=strlen($n);
									if($n==0000||$n==1111||$n==2222||$n==3333||$n==4444||$n==5555||$n==6666||$n==7777||$n==8888||$n==9999 || $cn<4){
										$t=0;
									}
									
									
									if($t>=$v ){
										 $cubierta = 0;
									}else{
									  $cubierta = abs($v-$t);
									   number_format($cubierta);										
									
									}

								
								?>
           <?php

									$total_cubierta = (($cubierta/100)*$av)*1000;
									 number_format($total_cubierta);
								
								?>
            <td align="center"><?php
									if($t>=$v){
										//echo 0;
										$total_tope = (($v/100)*$av)*1000 ;
										echo number_format($total_tope);
										//$suma=$suma+$total_tope;
									}else{
										//echo 1;
									   $total_tope = (($t/100)*$av)*1000;
										echo number_format($total_tope);
										
										
									}	
									$suma=$suma+$total_tope;							
								
								?></td>
            <?php
            					
									$total= $total_cubierta+$total_tope;
									
									 number_format($total);
								
								?>
          </tr>
             <?php } while ($row_listado = mysql_fetch_assoc($listado)); ?>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center"><strong>Total</strong></td>
            <td align="center"><strong><?php echo number_format($suma); ?></strong></td>
          </tr>
       

      </table>
    </div>
	<div class="tab-pane" id="2">

  </div>
	<div class="tab-pane" id="3">

    </div>
</div>

<?php
mysql_free_result($listado);
?>
