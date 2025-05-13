<?php
session_start();
include "../../conexionbd.php";

$id=$_REQUEST['id'];
$id2=$_REQUEST['id2'];

$fecha_mat= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_mat"], ENT_QUOTES)));
$hora_mat= mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_mat"], ENT_QUOTES))); 
$medicam_mat = mysqli_real_escape_string($conexion, (strip_tags($_POST["medicam_mat"], ENT_QUOTES))); 
$dosis_mat = mysqli_real_escape_string($conexion, (strip_tags($_POST["dosis_mat"], ENT_QUOTES)));
$unimed = mysqli_real_escape_string($conexion, (strip_tags($_POST["unimed"], ENT_QUOTES))); 
$via_mat = mysqli_real_escape_string($conexion, (strip_tags($_POST["via_mat"], ENT_QUOTES)));
$otro = mysqli_real_escape_string($conexion, (strip_tags($_POST["otro"], ENT_QUOTES)));
$cantidad = mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));

$sql_stock = "SELECT * FROM material_ceye where material_id=$medicam_mat";
            //echo $sql_stock;
        $result_stock = $conexion->query($sql_stock);
        while ($row_stock = $result_stock->fetch_assoc()) {
             $material_id = $row_stock['material_id'];
            $mat_nom = $row_stock['material_nombre'].', '.$row_stock['material_contenido'];
            /*if ($tr==1) $precio = $row_stock['material_precio'];
            if ($tr==2) $precio = $row_stock['material_precio2'];
            if ($tr==3) $precio = $row_stock['material_precio3'];*/
        }

$sql2 = "UPDATE medica_enf SET fecha_mat ='$fecha_mat', hora_mat ='$hora_mat',medicam_mat ='$mat_nom',dosis_mat='$dosis_mat',unimed='$unimed',via_mat='$via_mat',otro='$otro',cantidad='$cantidad',material_id='$material_id' WHERE id_med_reg=$id";
  //$sql2 = "UPDATE medica_enf SET medicam_mat = '$mat_nom' WHERE id_med_reg=$id";
  
  echo mysqli_query($conexion,$sql2);
  
  
 $sql2c = "UPDATE medicamentos_ceye SET dosis = '$dosis_mat', material_id = '$material_id',mat_nom = '$mat_nom',via='$via_mat',frecuencia='$otro',cantidad='$cantidad',unimed='$unimed' WHERE id_medceye=$id2";
 
  echo mysqli_query($conexion,$sql2c);
  
  
  
  ?>