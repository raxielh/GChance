<?php require_once('../Connections/gchance.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO agencias (codigo, nombre, municipio,valor, usuario) VALUES (%s,%s, %s, %s, %s)",
                       GetSQLValueString($_POST['codigo'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['municipio'], "text"),
					   GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($u, "int"));		   

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($insertSQL, $gchance) or die(mysql_error());
  header("Location:".$_SERVER['REQUEST_URI']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE agencias SET codigo=%s, nombre=%s, municipio=%s, valor=%s WHERE id=%s",
                       GetSQLValueString($_POST['codigo'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['municipio'], "text"),
					   GetSQLValueString($_POST['valor'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($updateSQL, $gchance) or die(mysql_error());
  header("Location:".$_SERVER['REQUEST_URI']);
}

mysql_select_db($database_gchance, $gchance);
$query_listado = "SELECT a.*,acc.usuario usu FROM agencias a,acceso acc WHERE a.usuario=acc.id  ORDER BY a.id DESC";
$listado = mysql_query($query_listado, $gchance) or die(mysql_error());
$row_listado = mysql_fetch_assoc($listado);
$totalRows_listado = mysql_num_rows($listado);

mysql_select_db($database_gchance, $gchance);
$query_roles = "SELECT * FROM rol ORDER BY id ASC";
$roles = mysql_query($query_roles, $gchance) or die(mysql_error());
$row_roles = mysql_fetch_assoc($roles);
$totalRows_roles = mysql_num_rows($roles);

mysql_select_db($database_gchance, $gchance);
$query_roles1 = "SELECT * FROM rol";
$roles1 = mysql_query($query_roles1, $gchance) or die(mysql_error());
$row_roles1 = mysql_fetch_assoc($roles1);
$totalRows_roles1 = mysql_num_rows($roles1);

$colname_usu = "-1";
if (isset($_GET['id'])) {
  $colname_usu = $_GET['id'];
}
mysql_select_db($database_gchance, $gchance);
$query_usu = sprintf("SELECT * FROM agencias WHERE id = %s", GetSQLValueString($colname_usu, "int"));
$usu = mysql_query($query_usu, $gchance) or die(mysql_error());
$row_usu = mysql_fetch_assoc($usu);
$totalRows_usu = mysql_num_rows($usu);
?>
<ul class="nav nav-tabs">
	<li class="active"><a  href="#1" data-toggle="tab">Listado</a></li>
	<li><a href="#2" data-toggle="tab">Agregar</a></li>
</ul>
<div class="tab-content ">
	<div class="tab-pane active" id="1">
    	<div class="row">
          <div class="col-md-9">
            <?php if ($totalRows_listado > 0) { // Show if recordset not empty ?>
  <table width="100%" id="t">
    <thead>
      <tr>
        <td></td>
        <td>Codigo</td>
        <td>Nombre</td>
        <td>Municipio</td>
        <td>Valor</td>
        <td>Quien Creo?</td>
        </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td><a href="?modulo=<?php echo $_GET['modulo']; ?>&id=<?php echo $row_listado['id']; ?>" class="btn btn-success"><i class="fas fa-check"></i></a></td>
          <td><?php echo $row_listado['codigo']; ?></td>
          <td><?php echo $row_listado['nombre']; ?></td>
          <td><?php echo $row_listado['municipio']; ?></td>
          <td><?php echo $row_listado['valor']; ?></td>
          <td><?php echo $row_listado['usu']; ?></td>
        </tr>
        <?php } while ($row_listado = mysql_fetch_assoc($listado)); ?>
    </tbody>
  </table>
  <?php } // Show if recordset not empty ?>
          </div>
          <div class="col-md-3">
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Codigo:</td>
                    <td><input type="text" name="codigo" required value="<?php echo htmlentities($row_usu['codigo'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nombre:</td>
                    <td><input type="text" name="nombre" required value="<?php echo htmlentities($row_usu['nombre'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Municipio:</td>
                    <td><input type="text" name="municipio" value="<?php echo htmlentities($row_usu['municipio'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Valor:</td>
                    <td><input type="text" name="valor" value="<?php echo htmlentities($row_usu['valor'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td>
                    	<input type="submit" value="Guardar" class="btn btn-info" /> 
                        <a class="btn btn-danger" style="margin-top: 1em;margin-left:1em" onclick="borrar('<?php echo @$_GET['modulo']; ?>',<?php echo @$_GET['id']; ?>)" href="#">Eliminar</a></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_update" value="form2" />
                <input type="hidden" name="id" value="<?php echo $row_usu['id']; ?>" />
              </form>          
          </div>
        </div>
        
  </div>
	<div class="tab-pane" id="2">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Codigo:</td>
              <td><input type="text" name="codigo" value="" class="form-control" size="32" required /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Nombre:</td>
              <td><input type="text" name="nombre" value="" size="32" required /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Municipio:</td>
              <td><input type="text" name="municipio" value="" size="32" required /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Valor:</td>
              <td><input type="text" name="valor" value="" size="32" required /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Guardar" class="btn btn-info" /></td>
            </tr>
          </table>
          <input type="hidden" name="MM_insert" value="form1" />
      </form>
	</div>
	<div class="tab-pane" id="3">

    </div>
</div>
<?php
@mysql_free_result($listado);

@mysql_free_result($roles);

@mysql_free_result($roles1);

@mysql_free_result($usu);

@mysql_free_result($roles);
?>
