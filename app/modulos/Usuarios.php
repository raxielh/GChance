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
  $insertSQL = sprintf("INSERT INTO acceso (nombre, usuario, pass, telefono, rol) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString(sha1($_POST['pass']), "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['rol'], "int"));

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($insertSQL, $gchance) or die(mysql_error());
  header("Location:".$_SERVER['REQUEST_URI']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE acceso SET nombre=%s, usuario=%s, telefono=%s, rol=%s WHERE id=%s",
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['usuario'], "text"),
                       GetSQLValueString($_POST['telefono'], "text"),
                       GetSQLValueString($_POST['rol'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($updateSQL, $gchance) or die(mysql_error());
  header("Location:".$_SERVER['REQUEST_URI']);
}

mysql_select_db($database_gchance, $gchance);
$query_listado = "SELECT acceso.*,rol.nombre AS rol_n FROM acceso,rol WHERE acceso.rol=rol.id ORDER BY acceso.id DESC";
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
$query_usu = sprintf("SELECT * FROM acceso WHERE id = %s", GetSQLValueString($colname_usu, "int"));
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
        	<table width="100%" id="t">
                <thead>
                  <tr>
                    <td></td>
                    <td>Nombre</td>
                    <td>Usuario</td>
                    <td>Pass</td>
                    <td>Telefono</td>
                    <td>Rol</td>
                  </tr>
                  </thead>
                  <tbody>
                  <?php do { ?>
                    <tr>
                      <td><a href="?modulo=<?php echo $_GET['modulo']; ?>&id=<?php echo $row_listado['id']; ?>" class="btn btn-success"><i class="fas fa-check"></i></a></td>
                      <td><?php echo $row_listado['nombre']; ?></td>
                      <td><?php echo $row_listado['usuario']; ?></td>
                      <td><?php echo $row_listado['pass']; ?></td>
                      <td><?php echo $row_listado['telefono']; ?></td>
                      <td><?php echo $row_listado['rol_n']; ?></td>
                    </tr>
                    <?php } while ($row_listado = mysql_fetch_assoc($listado)); ?>
                    </tbody>
                </table>      
          </div>
          <div class="col-md-3">
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Nombre:</td>
                    <td><input type="text" name="nombre" required value="<?php echo htmlentities($row_usu['nombre'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Usuario:</td>
                    <td><input type="text" name="usuario" required value="<?php echo htmlentities($row_usu['usuario'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Telefono:</td>
                    <td><input type="number" name="telefono" value="<?php echo htmlentities($row_usu['telefono'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Rol:</td>
                    <td><select name="rol" required>
                        <?php 
                do {  
                var_dump($roles1);
                ?>
                        <option  value="<?php echo $row_roles1['id']?>" <?php if (!(strcmp($row_roles1['id'], htmlentities($row_usu['rol'], ENT_COMPAT, '')))) {echo "SELECTED";} ?>><?php echo $row_roles1['nombre']?></option>
                        <?php
                } while ($row_roles1 = mysql_fetch_assoc($roles1));
                ?>
                      </select>
                    </td>
                  </tr>
                  <tr> </tr>
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
              <td nowrap="nowrap" align="right">Nombre:</td>
              <td><input type="text" name="nombre" value="" class="form-control" size="32" required /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Usuario:</td>
              <td><input type="text" name="usuario" value="" size="32" required /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Pass:</td>
              <td><input type="text" name="pass" value="" size="32" required /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Telefono:</td>
              <td><input type="number" name="telefono" value="" size="32" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Rol:</td>
              <td><select name="rol" required>
                <?php 
        do {  
        ?>
                <option value="<?php echo $row_roles['id']?>"><?php echo $row_roles['nombre']?></option>
                <?php
        } while ($row_roles = mysql_fetch_assoc($roles));
        ?>
              </select></td>
            </tr>
            <tr> </tr>
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
