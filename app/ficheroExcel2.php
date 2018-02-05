<?php
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: filename=Reporte_chance_Cubierta_Generado_".date('Y-m-d H:i:s').".xls");
header("Pragma: no-cache");
header("Expires: 0");

if (isset($_POST['datos_a_enviar']) && $_POST['datos_a_enviar'] != '') echo $_POST['datos_a_enviar'];
?>