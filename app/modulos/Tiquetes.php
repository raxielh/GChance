<?php require_once('../Connections/gchance.php'); ?>
<?php
if($r==2||$r==1){}else{die("Sin permisos");}
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("INSERT INTO tiquetes_as_loterias (loterias, tiquetes) VALUES (%s, %s)",
                       GetSQLValueString($_POST['loterias'], "int"),
                       GetSQLValueString($_POST['tiquetes'], "int"));

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($insertSQL, $gchance) or die(mysql_error());
  		header("Location:".$_SERVER['REQUEST_URI']);
}

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
	if($_POST['loterias']==null){
		echo '<script>alert("Elija una loteria");</script>';
	}else{
		  $valor=str_replace(".", "",$_POST['valor']);
		  $insertSQL = sprintf("INSERT INTO tiquetes (agencia, numero, valor,fecha , usuario) VALUES (%s, %s, %s, %s, %s)",
							   GetSQLValueString($_POST['agencia'], "text"),
							   GetSQLValueString($_POST['numero'], "text"),
							   GetSQLValueString($valor, "text"),
							   GetSQLValueString($_POST['fecha'], "date"),
							   GetSQLValueString($u, "int"));		   
		
		  mysql_select_db($database_gchance, $gchance);
		  $Result = mysql_query($insertSQL, $gchance) or die(mysql_error());	
		  $id=mysql_insert_id();		
		foreach ($_POST['loterias'] as &$valor) {
				
				$insert = sprintf("INSERT INTO tiquetes_as_loterias (loterias, tiquetes) VALUES (%s, %s)",
							   GetSQLValueString($valor, "text"),
							   GetSQLValueString($id, "text"));
							   
			  mysql_select_db($database_gchance, $gchance);
			  $Result1 = mysql_query($insert, $gchance) or die(mysql_error());	
		}
		header("Location:".$_SERVER['REQUEST_URI']);
	}
	
	
  
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
	 $valor=str_replace(".", "",$_POST['valor']);
  $updateSQL = sprintf("UPDATE tiquetes SET agencia=%s, numero=%s, valor=%s, fecha=%s WHERE id=%s",
                       GetSQLValueString($_POST['agencia'], "text"),
                       GetSQLValueString($_POST['numero'], "text"),
                       GetSQLValueString($valor, "text"),
					   GetSQLValueString($_POST['fecha'], "date"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_gchance, $gchance);
  $Result1 = mysql_query($updateSQL, $gchance) or die(mysql_error());
  $_POST = array();
}

mysql_select_db($database_gchance, $gchance);
$query_listado = "SELECT a.*,acc.usuario AS usu,ag.`nombre` AS agencian  FROM tiquetes a,acceso acc,agencias ag WHERE a.usuario=acc.id AND a.`agencia`=ag.`id`  ORDER BY a.id DESC";
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
$query_usu = sprintf("SELECT * FROM tiquetes WHERE id = %s", GetSQLValueString($colname_usu, "int"));
$usu = mysql_query($query_usu, $gchance) or die(mysql_error());
$row_usu = mysql_fetch_assoc($usu);
$totalRows_usu = mysql_num_rows($usu);

mysql_select_db($database_gchance, $gchance);
$query_agencias = "SELECT * FROM agencias ORDER BY id DESC";
$agencias = mysql_query($query_agencias, $gchance) or die(mysql_error());
$row_agencias = mysql_fetch_assoc($agencias);
$totalRows_agencias = mysql_num_rows($agencias);

mysql_select_db($database_gchance, $gchance);
$query_loterias = "SELECT * FROM loterias ORDER BY id DESC";
$loterias = mysql_query($query_loterias, $gchance) or die(mysql_error());
$row_loterias = mysql_fetch_assoc($loterias);
$totalRows_loterias = mysql_num_rows($loterias);

mysql_select_db($database_gchance, $gchance);
$query_loterias = "SELECT * FROM loterias ORDER BY id DESC";
$loterias2 = mysql_query($query_loterias, $gchance) or die(mysql_error());
$row_loterias2 = mysql_fetch_assoc($loterias2);
$totalRows_loterias2 = mysql_num_rows($loterias2);
?>


<ul class="nav nav-tabs">
	<li class="active"><a  href="#1" data-toggle="tab">Listado</a></li>
	<li ><a href="#2" data-toggle="tab">Agregar</a></li>
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
        <td>Agencia</td>
        <td>Numero</td>
        <td>Valor</td>
        <td>Loterias</td>
        <td>Fecha</td>
        <td>Quien Creo?</td>
        </tr>
    </thead>
    <tbody>
      <?php do { ?>
        <tr>
          <td><a href="?modulo=<?php echo $_GET['modulo']; ?>&id=<?php echo $row_listado['id']; ?>" class="btn btn-success"><i class="fas fa-check"></i></a></td>
          <td><?php echo $row_listado['agencian']; ?></td>
          <td><?php echo $row_listado['numero']; ?></td>
          <td><?php echo number_format($row_listado['valor']); ?></td>
          <td><?php 
					
					  
					    mysql_select_db($database_gchance, $gchance);
						$query_loterias3 = "SELECT * FROM tiquetes_as_loterias tl,loterias l WHERE tl.loterias=l.id AND tl.tiquetes=".$row_listado['id'];
						$loterias3 = mysql_query($query_loterias3, $gchance) or die(mysql_error());
						$row_loterias3 = mysql_fetch_assoc($loterias3);
						 do {
						echo $row_loterias3['nombre'].', ';
						} while ($row_loterias3 = mysql_fetch_assoc($loterias3));
					  
					  
					   ?></td>
          <td><?php echo $row_listado['fecha']; ?></td>
          <td><?php echo $row_listado['usu']; ?></td>
        </tr>
        <?php } while ($row_listado = mysql_fetch_assoc($listado)); ?>
    </tbody>
  </table>
  <?php } // Show if recordset not empty ?>
          </div>
          <div class="col-md-3">
          <?php if($r==2){ ?>
              <form action="<?php echo $editFormAction; ?>" method="post" name="form2" id="form2">
                <table align="center">
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Agencia:</td>
                    <td><select id="agencia2" name="agencia" required="required">
                      <?php
do {  
?>
                      <option value="<?php echo $row_agencias['id']?>"<?php if (!(strcmp($row_agencias['id'], $row_usu['agencia']))) {echo "selected=\"selected\"";} ?>><?php echo $row_agencias['nombre']?></option>
                      <?php
} while ($row_agencias = mysql_fetch_assoc($agencias));
  $rows = mysql_num_rows($agencias);
  if($rows > 0) {
      mysql_data_seek($agencias, 0);
	  $row_agencias = mysql_fetch_assoc($agencias);
  }
?>
                    </select></td>
                    <td><input type="text" id="t_agencia2" value="" class="form-control" size="8"  placeholder="Filtro" /></td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Numero:</td>
                    <td><input type="text" name="numero" required value="<?php echo htmlentities($row_usu['numero']); ?>" size="32" /></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">Valor:</td>
                    <td><input type="text" name="valor" value="<?php echo htmlentities($row_usu['valor']); ?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" size="32" /></td>
                    <td>&nbsp;</td>
                  </tr>
                    <td nowrap="nowrap" align="right">Fecha:</td>
                    <td><input type="date" class="form-control" name="fecha" value="<?php echo htmlentities($row_usu['fecha']); ?>" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" size="32" /></td>
                    <td>&nbsp;</td>
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right">&nbsp;</td>
                    <td>
                    	<input type="submit" value="Guardar" class="btn btn-info" /> 
                        <a class="btn btn-danger" style="margin-top: 1em;margin-left:1em" onclick="borrar('<?php echo @$_GET['modulo']; ?>',<?php echo @$_GET['id']; ?>)" href="#">Eliminar</a></td>
                    <td>&nbsp;</td>
                  </tr>
                <input type="hidden" name="MM_update" value="form2" />
                <input type="hidden" name="id" value="<?php echo $row_usu['id']; ?>" />
              </form>  
                  <tr valign="baseline">
                    <td nowrap="nowrap" align="right"><strong>Loterias</strong>:</td>
                    <td colspan="2"><hr /><form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
                      <table width="100%" align="center">
                        <tr valign="baseline">
                          <td width="94%"><select name="loterias">
                            <?php 
do {  
?>
                            <option value="<?php echo $row_loterias['id']?>" ><?php echo $row_loterias['nombre']?></option>
                            <?php
} while ($row_loterias = mysql_fetch_assoc($loterias));
?>
                          </select></td>
                          <td width="6%"><input type="submit" value="Agregar" class="btn btn-info" style="margin-top:0px" /></td>
                        </tr>
                        <tr valign="baseline">
                          <td><input type="hidden" name="tiquetes" value="<?php echo @$_GET['id']; ?>" size="32" /></td>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                      <input type="hidden" name="MM_insert" value="form3" />
                    </form>
<hr />
                    <?php 	
					if(@$_GET['id']){
					?>
                    
                    <?php
                    	mysql_select_db($database_gchance, $gchance);
						@$query_loterias4="SELECT  tl.id AS ide,l.id,l.nombre FROM tiquetes_as_loterias tl,loterias l WHERE tl.loterias=l.id AND tl.tiquetes=".$_GET['id'];
						$loterias4 = mysql_query($query_loterias4, $gchance) or die(mysql_error());
						$row_loterias4 = mysql_fetch_assoc($loterias4);
					?>
                    
                    <?php do{ ?>
                    	
                        <a href="#" onclick="borrar2('<?php echo @$_GET['modulo']; ?>',<?php echo $row_loterias4['ide']; ?>,<?php echo @$_GET['id']; ?>)"><i class="fas fa-trash-alt"></i></a>
						<?php echo $row_loterias4['nombre']; ?><br />
                    
                    
                    <?php } while ($row_loterias4 = mysql_fetch_assoc($loterias4)); ?>
                    
                    <?php
					}
					?>                  
                    <hr />
                    </td>
                  </tr>
                </table>
      
              <?php } ?>  
          </div>
        </div>
        
  </div>
	<div class="tab-pane" id="2">
      <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
          <table align="center">
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Agencia:</td>
              <td>
              <select id="agencia" name="agencia" required>
                <?php
do {  
?>
                <option value="<?php echo $row_agencias['id']?>"><?php echo $row_agencias['nombre']?></option>
                <?php
} while ($row_agencias = mysql_fetch_assoc($agencias));
  $rows = mysql_num_rows($agencias);
  if($rows > 0) {
      mysql_data_seek($agencias, 0);
	  $row_agencias = mysql_fetch_assoc($agencias);
  }
?>
              </select>
              </td>
              <td><input type="text" id="t_agencia" value="" class="form-control" size="8"  placeholder="Filtro" /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Numero:</td>
              <td><input type="number" name="numero" size="32" required /></td>
              <td>&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Valor:</td>
              <td><input type="text" name="valor" size="32" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))" required /></td>
              <td>&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">Fecha:</td>
              <td><input type="date" name="fecha" class="form-control" value="<?php echo date('Y-m-d') ?>" size="32" required /></td>
              <td>&nbsp;</td>
            </tr>
            <tr valign="baseline">
              <td align="center" valign="top" nowrap="nowrap"><strong>Loterias</strong>:</td>
              <td colspan="2" valign="baseline"><?php do { ?>
              <input name="loterias[]" type="checkbox" value="<?php echo $row_loterias2['id']; ?>" /><?php echo $row_loterias2['nombre']; ?><br />
              <?php } while ($row_loterias2 = mysql_fetch_assoc($loterias2)); ?><hr /></td>
            </tr>
            <tr valign="baseline">
              <td nowrap="nowrap" align="right">&nbsp;</td>
              <td><input type="submit" value="Guardar" class="btn btn-info" /></td>
              <td>&nbsp;</td>
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
  $('#agencia').filterByText($('#t_agencia'));
  $('#agencia2').filterByText($('#t_agencia2'));
});
</script>
<?php
@mysql_free_result($listado);

@mysql_free_result($roles);

@mysql_free_result($roles1);

@mysql_free_result($usu);

@mysql_free_result($agencias);

@mysql_free_result($loterias);
@mysql_free_result($loterias2);
@mysql_free_result($loterias3);
@mysql_free_result($loterias4);
@mysql_free_result($roles);
?>
