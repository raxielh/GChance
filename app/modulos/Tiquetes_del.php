<?php require_once('../../Connections/gchance.php'); ?>
<?php
if($r==2){}else{die("Sin permisos");}
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

$colname_Recordset1 = "-1";
if (isset($_GET['i'])) {
  $colname_Recordset1 = $_GET['i'];
}
mysql_select_db($database_gchance, $gchance);
$query_Recordset1 = sprintf("SELECT count(*) FROM tiquetes_as_loterias WHERE tiquetes = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $gchance) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);


if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  if($row_Recordset1['count(*)']>1){
	  $deleteSQL = sprintf("DELETE FROM tiquetes_as_loterias WHERE id=%s",
						   GetSQLValueString($_GET['id'], "int"));
	
	  mysql_select_db($database_gchance, $gchance);
	  $Result1 = mysql_query($deleteSQL, $gchance) or die(mysql_error());
	
	  $deleteGoTo = "../index.php?modulo=Tiquetes&id=".$_GET['i'];
	  header(sprintf("Location: %s", $deleteGoTo));
  }else{
	 echo '<script>alert("No puede borrar todas las loterias");</script>';
	 	  $deleteGoTo = "../index.php?modulo=Tiquetes&id=".$_GET['i'];
	  header(sprintf("Location: %s", $deleteGoTo));
	 }
}

mysql_free_result($Recordset1);
?>
