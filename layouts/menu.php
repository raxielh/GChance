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
$query_tope = "SELECT * FROM tope WHERE fecha ='".date('Y-m-d')."'";
$tope = mysql_query($query_tope, $gchance) or die(mysql_error());
$row_tope = mysql_fetch_assoc($tope);
$totalRows_tope = mysql_num_rows($tope);

?>
<div class="col-md-12">
  <?php if ($totalRows_tope > 0) { // Show if recordset not empty ?>
  <h2>El Tope para hoy (<?php echo $row_tope['fecha']; ?>) es de <?php echo number_format($row_tope['tope']); ?></h2>
  <?php } // Show if recordset not empty ?>
  <?php if ($totalRows_tope == 0) { // Show if recordset not empty ?>
  <h2>El Tope para hoy no ha sido asignado</h2>
  <?php } // Show if recordset not empty ?>

<hr />
</div>
<div class="col-md-9">
<?php if($r==2){ ?>
<a class="btn btn-app" href="?modulo=Usuarios"><i class="fas fa-users grande"></i><br> Usuarios</a>


<a class="btn btn-app" href="?modulo=Agencias"><i class="fas fa-folder grande"></i><br> Agencias</a>

<a class="btn btn-app" href="?modulo=Loterias"><i class="fas fa-gift grande"></i><br> Loterias</a>
<?php } ?>

<a class="btn btn-app" href="?modulo=Tiquetes"><i class="fas fa-id-badge grande"></i><br> Tiquetes</a>

<?php if($r==2){ ?>
<a class="btn btn-app" href="?modulo=Tope"><i class="fas fa-stop-circle grande"></i><br> Tope</a>

<a class="btn btn-app" href="?modulo=Ganadores"><i class="fas fa-star grande"></i><br> Resultado Loteria</a>

<a class="btn btn-app" href="?modulo=Consolidado&fecha=<?php echo date('Y-m-d'); ?>"><i class="fab fa-audible grande"></i><br> Consolidado Ganadores</a>

<a class="btn btn-app" href="?modulo=Consolidado_a_Pagar&fecha=<?php echo date('Y-m-d'); ?>"><i class="fas fa-book grande"></i><br>  Consolidado a Pagar</a>
<hr />
<a class="btn btn-app" href="?modulo=Reporte_Cubierta&fecha=<?php echo date('Y-m-d'); ?>"><i class="fas fa-book grande"></i><br>  Reporte Cubierta</a>

<a class="btn btn-app" href="?modulo=Reporte_Tope&fecha=<?php echo date('Y-m-d'); ?>"><i class="fas fa-book grande"></i><br>  Reporte Tope</a>

<a class="btn btn-app" href="?modulo=Reporte_Total_Apostado&fecha=<?php echo date('Y-m-d'); ?>"><i class="fas fa-book grande"></i><br>  Reporte Total Apostado</a>


<?php } ?>
</div>
<div class="col-md-3">
resultado loteria fecha
</div>
<?php
mysql_free_result($tope);
?>
