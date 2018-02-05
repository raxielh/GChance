<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
if (!isset($_SESSION)) {
  session_start();
}
$hostname_gchance = "localhost";
$database_gchance = "GChance";
$username_gchance = "root";
$password_gchance = "mysql";
$gchance = mysql_pconnect($hostname_gchance, $username_gchance, $password_gchance) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_set_charset('utf8', $gchance);
date_default_timezone_set('America/Bogota');

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

$colname_verificador = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_verificador = $_SESSION['MM_Username'];
}
mysql_select_db($database_gchance, $gchance);
$query_verificador = sprintf("SELECT * FROM acceso WHERE usuario = %s", GetSQLValueString($colname_verificador, "text"));
$verificador = mysql_query($query_verificador, $gchance) or die(mysql_error());
$row_verificador = mysql_fetch_assoc($verificador);
$totalRows_verificador = mysql_num_rows($verificador);

$r=($row_verificador['rol']);
$u=($row_verificador['id']);
 

mysql_free_result($verificador);
?>
