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
  $insertSQL = sprintf("INSERT INTO ganadores (loteria, numero,fecha, usuario) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['loteria'], "text"),
                       GetSQLValueString($_POST['numero'], "text"),
					   GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($u, "int"));		   

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($insertSQL, $gchance) or die(mysql_error());
  header("Location:".$_SERVER['REQUEST_URI']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE ganadores SET loteria=%s, numero=%s, fecha=%s WHERE id=%s",
                       GetSQLValueString($_POST['loteria'], "text"),
                       GetSQLValueString($_POST['numero'], "text"),
					   GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($updateSQL, $gchance) or die(mysql_error());
  header("Location:".$_SERVER['REQUEST_URI']);
}

mysql_select_db($database_gchance, $gchance);
$query_listado = "SELECT a.*,acc.usuario usu,lo.nombre FROM ganadores a,acceso acc,loterias lo WHERE a.usuario=acc.id AND a.loteria=lo.id  ORDER BY a.id DESC";
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
$query_usu = sprintf("SELECT * FROM ganadores WHERE id = %s", GetSQLValueString($colname_usu, "int"));
$usu = mysql_query($query_usu, $gchance) or die(mysql_error());
$row_usu = mysql_fetch_assoc($usu);
$totalRows_usu = mysql_num_rows($usu);

mysql_select_db($database_gchance, $gchance);
$query_loterias = "SELECT * FROM loterias ORDER BY id DESC";
$loterias = mysql_query($query_loterias, $gchance) or die(mysql_error());
$row_loterias = mysql_fetch_assoc($loterias);
$totalRows_loterias = mysql_num_rows($loterias);
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
                    <td>Fecha</td>
                    <td>Loteria</td>
                    <td>Numero</td>
                    <td>Quien Creo?</td>
                  </tr>
                  </thead>
                  <tbody>
                  <?php do { ?>
                    <tr>
                      <td><a href="?modulo=<?php echo $_GET['modulo']; ?>&id=<?php echo $row_listado['id']; ?>" class="btn btn-success"><i class="fas fa-check"></i></a></td>
                      <td><?php echo $row_listado['fecha']; ?></td>
                      <td><?php echo $row_listado['nombre']; ?></td>
                      <td><?php echo $row_listado['numero']; ?></td>
                      <td><?php echo $row_listado['usu']; ?></td>
                    </tr>
                    <?php } while ($row_listado = mysql_fetch_assoc($listado)); ?>
                    </tbody>
                </table>      
          </div>
          <div class="col-md-3">
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center">
                  <tr valign="baseline">
                    <td align="right" valign="middle" nowrap="nowrap">Loteria:</td>
                    <td><table width="100%" border="0">
                      <tr>
                          <td><select name="loteria" id="loteria">
                            <?php
do {  
?>
                            <option value="<?php echo $row_loterias['id']?>"<?php if (!(strcmp($row_loterias['id'], $row_usu['loteria']))) {echo "selected=\"selected\"";} ?>><?php echo $row_loterias['nombre']?></option>
                            <?php
} while ($row_loterias = mysql_fetch_assoc($loterias));
  $rows = mysql_num_rows($loterias);
  if($rows > 0) {
      mysql_data_seek($loterias, 0);
	  $row_loterias = mysql_fetch_assoc($loterias);
  }
?>
                          </select></td>
                          <td><input type="text" id="t_1" value="" class="form-control" size="8"  placeholder="Filtro" /></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Numero:</td>
                    <td><input type="text" name="numero" required value="<?php echo htmlentities($row_usu['numero'], ENT_COMPAT, ''); ?>" size="32" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Fecha:</td>
                    <td><input type="date" name="fecha" class="form-control" required value="<?php echo htmlentities($row_usu['fecha'], ENT_COMPAT, ''); ?>" size="32" /></td>
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
              <td align="right" valign="middle" nowrap="nowrap">Loteria:</td>
              <td><table width="100%" border="0">
                <tr>
                    <td><select name="loteria" id="loteria2">
                      <?php
do {  
?>
                      <option value="<?php echo $row_loterias['id']?>"><?php echo $row_loterias['nombre']?></option>
                      <?php
} while ($row_loterias = mysql_fetch_assoc($loterias));
  $rows = mysql_num_rows($loterias);
  if($rows > 0) {
      mysql_data_seek($loterias, 0);
	  $row_loterias = mysql_fetch_assoc($loterias);
  }
?>
                    </select></td>
                    <td><input type="text" id="t_2" value="" class="form-control" size="8"  placeholder="Filtro" /></td>
                </tr>
              </table></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Fecha:</td>
              <td><input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d') ?>" size="32" required /></td>
            </tr>
             <tr valign="baseline">
              <td nowrap="nowrap" align="right">Numero:</td>
              <td><input type="text" name="numero" value="" class="form-control" size="32" required /></td>
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

<script>
//jQuery extension method:
jQuery.fn.filterByText = function(textbox) {
  return this.each(function() {
    var select = this;
    var options = [];
    $(select).find('option').each(function() {
      options.push({
        value: $(this).val(),
        text: $(this).text()
      });
    });
    $(select).data('options', options);

    $(textbox).bind('change keyup', function() {
      var options = $(select).empty().data('options');
      var search = $.trim($(this).val());
      var regex = new RegExp(search, "gi");

      $.each(options, function(i) {
        var option = options[i];
        if (option.text.match(regex) !== null) {
          $(select).append(
            $('<option>').text(option.text).val(option.value)
          );
        }
      });
    });
  });
};

// You could use it like this:

$(function() {
  $('#loteria').filterByText($('#t_1'));
    $('#loteria2').filterByText($('#t_2'));
});
</script>
<?php
@mysql_free_result($listado);

@mysql_free_result($roles);

@mysql_free_result($roles1);

@mysql_free_result($usu);

mysql_free_result($loterias);

@mysql_free_result($roles);
?>
