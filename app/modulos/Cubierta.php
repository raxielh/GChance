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
a.nombre AS agencias,
a.valor AS agencia_valor,
top.tope AS tope,
l.nombre AS loteria,
t.numero AS numero,
t.valor/(SELECT COUNT(*) FROM tiquetes_as_loterias WHERE tiquetes=t.id) AS valor,
t.fecha AS fecha
FROM
tiquetes t,
tiquetes_as_loterias tl,
loterias l,
agencias a,
tope top,
ganadores ga
WHERE
t.id=tl.tiquetes AND
tl.loterias=l.id AND
t.agencia=a.id AND
ga.numero=t.numero AND
ga.loteria=tl.loterias AND  
top.fecha='".$_GET['fecha']."'
ORDER BY a.nombre ASC
";
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
    <form action="index.php?modulo=Consolidado" method="get" >
    
    
    <table width="100%" border="0">
  <tr>
    <td width="20%"><input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control" size="20" required /><input type="hidden" name="modulo" value="Cubierta" class="form-control" size="20" /></td>
    <td width="80%"><input type="submit" value="Cambiar" class="btn btn-info" style="margin-top:0px" /></td>
  </tr>
</table>

    </form>      
    <hr />
    <form action="ficheroExcel2.php" method="post" target="_blank" id="FormularioExportacion">
    <p>Exportar a Excel  <img src="../img/export_to_excel.gif" class="botonExcel" /></p>
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
    </form>    
    <hr />
      <table width="100%" border="1" id="Exportar_a_Excel">
        <tr>
          <td align="center" bgcolor="#EEE"><strong>Nombre Agencia</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Agencia Valor</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Tope</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Loteria</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Numero</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Valor</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Fecha</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Cubierta</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Total Cubierta</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Total Tope</strong></td>
          <td align="center" bgcolor="#EEE"><strong>Total</strong></td>
        </tr>
        <?php do { ?>
          <tr>
            <td align="center"><?php echo $row_listado['agencias']; ?></td>
            <td align="center"><?php echo $av=$row_listado['agencia_valor']; ?></td>
            <td align="center"><?php $t=($row_listado['tope']);
									 echo number_format($t);
			
			?></td>
            <td align="center"><?php echo $row_listado['loteria']; ?></td>
            <td align="center"><?php echo $row_listado['numero']; ?></td>
            <td align="center"><?php $v=($row_listado['valor']); 
									 echo number_format($v);			
			?></td>
            <td align="center"><?php echo $row_listado['fecha']; ?></td>
            <td align="center"><?php
								
									  $cubierta = abs($v-$t);
									  echo number_format($cubierta);
								
								?></td>
            <td align="center"><?php
								
									$total_cubierta = (($cubierta/100)*$av)*1000;
									echo number_format($total_cubierta);
								
								?></td>
            <td align="center"><?php
								
									$total_tope = (($t/100)*$av)*1000;
									echo number_format($total_tope);								
								
								?></td>
            <td align="center"><?php
            					
									$total= $total_cubierta+$total_tope;
									echo number_format($total);
								
								?></td>
          </tr>
          <?php } while ($row_listado = mysql_fetch_assoc($listado)); ?>
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
