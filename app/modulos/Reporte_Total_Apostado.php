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
$query_listado = "SELECT a.*,acc.usuario AS usu,ag.`nombre` AS agencian  FROM tiquetes a,acceso acc,agencias ag WHERE a.usuario=acc.id AND a.`agencia`=ag.`id` 
AND a.`fecha`='".$_GET['fecha']."'
ORDER BY a.id DESC
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
    <form action="index.php?modulo=Reporte_Total_Apostado" method="get" >
    
    
    <table width="100%" border="0">
  <tr>
    <td width="20%"><input type="date" name="fecha" value="<?php echo date('Y-m-d'); ?>" class="form-control" size="20" required /><input type="hidden" name="modulo" value="Reporte_Total_Apostado" class="form-control" size="20" /></td>
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
        </tr>
        <?php 
		$suma=0;
		$sig=0;
		do { ?>
          <tr>
            <td align="center"><?php echo $row_listado['fecha']; ?></td>
            <td align="center"><?php 
					
					  
					    mysql_select_db($database_gchance, $gchance);
						@$query_loterias3 = "SELECT * FROM tiquetes_as_loterias tl,loterias l WHERE tl.loterias=l.id AND tl.tiquetes=".$row_listado['id'];
						@$loterias3 = mysql_query($query_loterias3, $gchance) or die(mysql_error());
						@$row_loterias3 = mysql_fetch_assoc($loterias3);
						 do {
						     echo @$row_loterias3['nombre'].', ';
						} while (@$row_loterias3 = mysql_fetch_assoc(@$loterias3));
					  
					  
					   ?></td>
             <td align="center"><?php echo $row_listado['numero']; ?></td>
              <td align="center"><?php  $x=$row_listado['valor']; 
			  echo number_format($x);
			  $suma=$suma+$x;
			  ?></td>
 
            
          </tr>
             <?php } while ($row_listado = mysql_fetch_assoc($listado)); ?>
          <tr>
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
