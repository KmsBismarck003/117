<?php
session_start();
//include "../../conexionbd.php";
include "../header_facturacion.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
$id_usua=$usuario['id_usua'];
$id_at = $_GET['id_atencion'];
if (isset($_GET['id_datfin'])) {
  $id_datfin=$_GET['id_datfin'];
}else{

}




include "conexionbdf.php";



?>



<!DOCTYPE html>
<html>

<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
 <link rel="stylesheet" type="text/css" href="../../gestion_medica/hospitalizacion/css/select2.css">
 <script src="../../gestion_medica/hospitalizacion/js/select2.js"></script>
   <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

    <script src="jquery-3.1.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>



    <!--  Bootstrap  -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="../../js/jquery-3.3.1.min.js"></script>
    <script src="../../js/jquery-ui.js"></script>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/jquery.magnific-popup.min.js"></script>
    <script src="../../js/aos.js"></script>
    <script src="../../js/main.js"></script>


  <title>Facturación</title>
  <script type="text/javascript" src="jquery-1.12.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="jquery-ui.css">
  <script type="text/javascript" src="jquery-ui.js"></script>
</head>

<body>
  
  <div class="container">

<?php 
       include "../../conexionbd.php";
$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac, di.*  FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_at";

        $result_pac = $conexion->query($sql_pac);

        while ($row_pac = $result_pac->fetch_assoc()) {
          $pac_papell = $row_pac['papell'];
          $pac_sapell = $row_pac['sapell'];
          $pac_nom_pac = $row_pac['nom_pac'];
          $pac_dir = $row_pac['dir'];
          $pac_id_edo = $row_pac['id_edo'];
          $pac_id_mun = $row_pac['id_mun'];
          $pac_tel = $row_pac['tel'];
          $pac_fecnac = $row_pac['fecnac'];
          $pac_fecing = $row_pac['fecha'];
          $fec_egreso = $row_pac['fec_egreso'];
          $area = $row_pac['area'];
          $alta_med = $row_pac['alta_med'];
          $alta_adm = $row_pac['alta_adm'];
          $valida = $row_pac['valida'];
          $area = $row_pac['area'];
          $id_exp=$row_pac['Id_exp'];
          $correo = $row_pac['correo'];
          $cama_alta = $row_pac['cama_alta'];
          $dat_now = $row_pac['fec_egreso'];
        }
        include "conexionbdf.php";
?>
         <label class="control-label">Paciente: </label><strong> &nbsp; <?php echo $id_exp.' - '.$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac ?></strong>


<?php $paciente=$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac ?>

    <form action="" method="POST">
  <section class="content container-fluid">
<?php if(isset($_GET['error'])){
?>          
    <div class="alert alert-light alert-dismissible fade show btn-sm" role="alert">
            <font color="red">*<?php echo $_GET['error'];?></font>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <font color="red"> <span aria-hidden="true">&times;</span></font>
  </button>
            </div>
<?php }?>
<nav>
 
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
   
      <?php
      $iddat=$_GET['iddat'];
      $resultado341 = $conexion->query("SELECT * from comprobantes c,gen_factura g where c.id_dat_gen_f=$iddat and g.id_dat_gen_f=$iddat and c.id_atencion=$id_at") or die($conexion->error);
                while($f341 = mysqli_fetch_array($resultado341)){
      $valid=$f341['id_atencion'];
       $folion=$f341['folio'];
       $serien=$f341['serie'];
       $uuidn=$f341['uuid'];
       $fechan=$f341['fecha'];
       $rfc_emisorn=$f341['rfc_emisor'];
       $rfc_receptorn=$f341['rfc_receptor'];
       $monedan=$f341['moneda'];
       $totaln=$f341['total'];
       
       //
        $saldoant=$f341['saldoant'];
         $descuento=$f341['descuento'];
       
       
                }
      ?>
      <?php 
      if(isset($valid)){
       
      ?>
 <a class="nav-item nav-link">Nota de crédito</a>
<?php }else{
?>
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos generales</a>
    
    <?php } ?>
    
    
    
    
    
<?php if(isset($id_datfin)){ 
   echo' <a class="btn btn-success" href="facturas.php?id_atencion=' . $id_at . '&id_datfin=' . $id_datfin. '&id_usua=' . $id_usua . '" role="button">Mis facturas</a>';
}else{
  echo' <a class="btn btn-success" href="facturas.php?id_atencion='.$id_at.'" role="button">Mis facturas</a>';

}
?>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
<br>


  <!-- datos generales-->
<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">


<div class="container">
  <div class="row">
      
<?php 
$resultadof = $conexion->query("SELECT * from nota_credito") or die($conexion->error);
while($f3f = mysqli_fetch_array($resultadof)){

$id_nc=$f3f['id_nc']; }
                
  if($id_nc==null){
    ?>
<div class="col-sm-3">
    <strong>*Folio</strong>
    <input type="text" name="folio_nc"class="form-control" value="1" disabled>
    </div>
    
<div class="col-sm-2">
    <strong>*Serie</strong>
    <input type="text" name="serie_nc" class="form-control" value="NC" disabled>
    </div>
<?php }
else if($id_nc>0){
$resultado34 = $conexion->query("SELECT * from nota_credito") or die($conexion->error);

                while($f34 = mysqli_fetch_array($resultado34)){
$folio_nc=$f34['folio_nc'];
$folio_nc++;
                }
                 
            ?>
<div class="col-sm-3">
    <strong>*Folio</strong>
    <input type="text" name="folio_nc"class="form-control" value="<?php echo $folio_nc ?>" disabled>
    </div>
<div class="col-sm-2">
    <strong>*Serie</strong>
    <input type="text" name="serie_nc" class="form-control" value="NC" disabled>
    </div>
<?php
           }
               
    ?>
    </div>
    </div>
    
    
<p></p>
<div class="container">
  <div class="row">
         <div class="col-sm-5">
     <strong>*Tipo de relación</strong>
<select name="tipo_relacion_nc" class="form-control" data-live-search="true"style="width : 100%; heigth : 100%" required>
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_tiporelacion WHERE c_TipoRelacion=1 or c_TipoRelacion=7 order by Descripcion DESC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_TipoRelacion'] . "'>" . $row['c_TipoRelacion'] . " - ".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
     <div class="col-sm-3">
     <strong>*Método de pago</strong>
<select name="met_pago" class="form-control" data-live-search="true" id="opciones1" style="width : 100%; heigth : 100%" required>
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_metodopago WHERE c_MetodoPago='PUE' order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_MetodoPago'] . "'>" . $row['c_MetodoPago'] . " - ".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
      <div class="col-sm">
     <strong>*Forma de pago</strong>
<select name="forma_pago_nc" class="form-control" data-live-search="true"  style="width : 100%; heigth : 100%" required>
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_formapago where Descripcion='Efectivo' or Descripcion='Por definir' or Descripcion='Transferencia electrónica de fondos' or Descripcion='Tarjeta de crédito' or Descripcion='Tarjeta de débito' or Descripcion='Por definir' or Descripcion='Por definir' order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_FormaPago'] . "'>" . $row['c_FormaPago'] . " - ".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
   
</div>


<p></p>

  <div class="row">
      <div class="col-sm-5">
     <strong>*Uso del CFDI</strong>
<select name="uso_cfdi_nc" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_usocfdi WHERE c_UsoCFDI='G02' order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_UsoCFDI'] . "'>".$row['c_UsoCFDI']." - " .$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
        <div class="col-sm-3">
     <strong>*Tipo CFDI</strong>
<select name="tipo_cfdi_nc" class="form-control" data-live-search="true" style="width : 100%;heigth:100%;">
        
                <?php
         include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_tipodecomprobante where Descripcion='Egreso'";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_TipoDeComprobante'] . "'>".$row['c_TipoDeComprobante']."
- ".$row['Descripcion']."
                </option>"; 
                } ?>
            </select>
   
    </div>
    <div class="col-sm">
    <!-- <strong>*Fecha</strong>-->
<?php 
$fecha = date("Y:m:dTH:i:s"); ?>
<input type="hidden" name="fecha" class="form-control" value="<?php echo $fecha;?>">
    </div>
 
</div>

<!--<div class="container">
  <div class="row">
    <div class="col-sm">
<strong>Tiene información global</strong>
<input type="checkbox" name="inf_glob" id="check" value="Si" onchange="javascript:showContent()" />
</div>
</div>
</div>-->
<script type="text/javascript">
    function showContent() {
        element = document.getElementById("content");
        check = document.getElementById("check");
        if (check.checked) {
            element.style.display='block';
        }
        else {
            element.style.display='none';
        }
    }
</script>

<p>

<hr>
<p>
  
<?php  
$servidor="localhost";
$nombreBd="u542863078_facturacion";
$usuario="u542863078_sima_fac";
$pass="Lh?0y=;/";
$conexion=new mysqli($servidor,$usuario,$pass,$nombreBd);
$conexion -> set_charset("utf8");
if($conexion-> connect_error){
die("No se pudo conectar");
}
  
  
  $result ="SELECT * FROM c_cliente";
  $array = array();
  if($result){
$result_diag=$conexion->query($result);
    while ($row =$result_diag-> fetch_assoc()) {
      $equipo =$row['razon_s'];
      array_push($array, $equipo); // equipos
    }
  }
?>

<div class="col-sm">
Datos del cliente
</div>
<div class="container">
  <div class="row">
    <div class="col-sm">
    <strong>Buscador de cliente</strong>
<input id="tag" type="text" class="form-control" placeholder="Escribe para comenzar a buscar">
    </div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm">
    <strong>*RFC</strong>
<input id="nombre" type="text" name="rfc" class="form-control">
    </div>
    <div class="col-sm">
     <strong>*Razón social</strong>
<input id="razon_s" type="text" name="razon_s" class="form-control">
    </div>
    <div class="col-sm">
    <strong>Calle</strong>
<input id="calle" type="text" name="calle" class="form-control">
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
   
    <div class="col-sm">
     <strong>No. Exterior</strong>
<input id="no_ext" type="text" name="no_ext" class="form-control">
    </div>
    <div class="col-sm">
     <strong>No. Interior</strong>
<input id="no_int" type="text" name="no_int" class="form-control">
    </div>
     <div class="col-sm">
       
  
    </div>
  </div>
</div>
   
<div class="container">
  <div class="row">
        <div class="col-sm-4">
          
           <strong>Estado</strong>
           <input id="id_estado" type="text" name="estado" class="form-control">
        
    </div>
        <div class="col-sm">
            
                <strong>Municipio</strong>
                 <input id="municipiosp" type="text" name="municipio" class="form-control">
           
        </div>

     <div class="col-sm-4">
     <strong>Código postal</strong>
<input id="cod_postal" type="text" name="cp_nc" class="form-control">

    </div>
    
    <div class="col-sm-11">
     <div id="select2lista"></div>
    </div>

 <div class="col-sm-8">
     <strong>Régimen fiscal</strong>
     <input id="reg_fiscal" type="text" name="reg_fiscal_nc" class="form-control">

    </div>
  
  </div>
</div>
<hr>

<div class="container">
  <div class="row">
    <div class="col-sm">
<strong><font color="steelblue">CFDI relacionado</font></strong>
</div>
</div>
<div class="container">
  <div class="row">
    
<?php   if(isset($valid)){ ?>
 <div class="col-sm-1">
     <strong>Folio</strong>
<input type="text" class="form-control" value="<?php echo $folion ?>" name="">
</div>
<div class="col-sm-1">
     <strong>Serie</strong>
<input type="text" class="form-control" value="<?php echo $serien ?>" name="">
</div>
<div class="col-sm-4">
     <strong>UUID</strong>
<input type="text" class="form-control" value="<?php echo $uuidn ?>" name="uuid_relacionado">
</div>
<div class="col-sm-2">
     <strong>RFC Emisor</strong>
<input type="text" class="form-control" value="<?php echo $rfc_emisorn ?>" name="rfc_emisor_nc">
</div>
<div class="col-sm-2">
     <strong>RFC Receptor</strong>
<input type="text" class="form-control" value="<?php echo $rfc_receptorn ?>" name="rfc_receptor_nc">
</div>
<div class="col-sm-2">
     <strong>Moneda</strong>
<input type="text" class="form-control" value="<?php echo $monedan ?>" name="">
</div>
<div class="col-sm-2"><br>
     <strong>Monto</strong>
<input type="text" class="form-control" value="<?php echo $saldoant+$descuento ?>" name="total_fac">
</div>

  <?php
//    descuento validacion si existe descuento en dat finacieros restarle a la factura en base e descuento autmatico
 include "../../conexionbd.php";
$resultadoas = $conexion->query("SELECT * from dat_financieros WHERE id_atencion=$id_at") or die($conexion->error);
              while ($rowas = $resultadoas->fetch_assoc()) {
                $banco=$rowas['banco'];
                $deposito=$rowas['deposito'];
              }
              
              if($banco=='DESCUENTO'){
              
              
    ?>


<div class="col-sm-2"><br>
     <strong>Descuento</strong>
<input type="text" class="form-control" name="descuento" value="<?php echo $deposito ?>">
</div>
<?php } ?>

<?php include "conexionbdf.php"; } ?>

<div class="col-sm"><br>
     <strong>*Objeto de Impuesto</strong>
<select name="obj_impuesto_nc" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
              <option value="">Seleccionar</option>
                <?php
         
                $sql_diag="SELECT * FROM c_objetoimp";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_ObjetoImp'] . "'>".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
</div>
</div>

<P>

<hr>

</p>

<input type="submit" name="notacredito" class="btn btn-primary" value="Guardar factura">

</form>
</div>

 <!--INSERT DE CREDITO  INSERT DE CREDITO  INSERT DE CREDITO INSERT DE CREDITO INSERT DE CREDITO INSERT DE CREDITO INSERT DE CREDITO INSERT DE CREDITO INSERT DE CREDITO  -->

 <?php 
if (isset($_POST['notacredito'])) {

$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_at = $_GET['id_atencion'];

$fecha_actual = date("Y-m-d H:i:s");

echo $fechasat = date("Y-m-d");
$horasat = date("H:i:s");

$fechasat;
list($anio, $mes, $dia) = explode("-",$fechasat);
$Fs=$anio.'-'.$mes.'-'.$dia;
$FechaCompleta=$Fs.'T'.$horasat;

//datos de nc
$serie_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["serie_nc"], ENT_QUOTES)));
$met_pago= mysqli_real_escape_string($conexion, (strip_tags($_POST["met_pago"], ENT_QUOTES)));
$forma_pago_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["forma_pago_nc"], ENT_QUOTES)));
$tipo_relacion_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo_relacion_nc"], ENT_QUOTES)));
$uso_cfdi_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["uso_cfdi_nc"], ENT_QUOTES)));
$tipo_cfdi_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo_cfdi_nc"], ENT_QUOTES)));


// datos de cliente
$razon_s= mysqli_real_escape_string($conexion, (strip_tags($_POST["razon_s"], ENT_QUOTES)));
$cp_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["cp_nc"], ENT_QUOTES)));
$reg_fiscal_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["reg_fiscal_nc"], ENT_QUOTES)));


//datos uuid relacionado
$uuid_relacionado= mysqli_real_escape_string($conexion, (strip_tags($_POST["uuid_relacionado"], ENT_QUOTES)));
$rfc_emisor_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["rfc_emisor_nc"], ENT_QUOTES)));
$rfc_receptor_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["rfc_receptor_nc"], ENT_QUOTES)));
$total_fac= mysqli_real_escape_string($conexion, (strip_tags($_POST["total_fac"], ENT_QUOTES)));


$total_fac= mysqli_real_escape_string($conexion, (strip_tags($_POST["total_fac"], ENT_QUOTES)));
$descuento= mysqli_real_escape_string($conexion, (strip_tags($_POST["descuento"], ENT_QUOTES)));

$obj_impuesto_nc= mysqli_real_escape_string($conexion, (strip_tags($_POST["obj_impuesto_nc"], ENT_QUOTES)));

$fecha= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));



//insert a nota credito
$resultadof = $conexion->query("SELECT * from nota_credito") or die($conexion->error);

                while($f3f = mysqli_fetch_array($resultadof)){

$id_nc=$f3f['id_nc'];
                }
                
  if($id_nc==null){
      
$conce="84111506 Descuento de ". $descuento . " del CFDI " . $folion . " " . $serien . " " . $uuidn;
$subtotal=$descuento/1.16; 
$iva=$subtotal*.16;
$total=$subtotal+$iva;

$insertfac=mysqli_query($conexion,'INSERT INTO nota_credito(id_atencion,id_usua,fecha,rfc_emisor_nc,rfc_receptor_nc,uuid_relacionado,folio_nc,serie_nc,tipo_relacion_nc,met_pago,forma_pago_nc,uso_cfdi_nc,tipo_cfdi_nc,cp_nc,reg_fiscal_nc,total_fac,descuento,cantidad,clave_nc,un_med_nc,concepto_nc,iva_descuento,subtotal_descuento,obj_impuesto_nc,codigo_sat_nc,razon_s,paciente,id_dat_gen_f) values ('.$id_at.','.$id_usua.',"'.$fecha_actual.'","'.$rfc_emisor_nc.'","'.$rfc_receptor_nc.'","'.$uuid_relacionado.'",1,"NC","'.$tipo_relacion_nc.'","'.$met_pago.'","'.$forma_pago_nc.'","'.$uso_cfdi_nc.'","'.$tipo_cfdi_nc.'","'.$cp_nc.'","'.$reg_fiscal_nc.'","'.$total_fac.'","'.$descuento.'",1,"ACT","SER","'.$conce.'","'.$iva.'","'.$subtotal.'","'.$obj_impuesto_nc.'",84111506,"'.$razon_s.'","'.$paciente.'","'.$iddat.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
    
}
else if($id_nc>0){
$resultado34 = $conexion->query("SELECT * from nota_credito") or die($conexion->error);

                while($f34 = mysqli_fetch_array($resultado34)){
$folio_nc=$f34['folio_nc'];
$folio_nc++;
                }
                 
$conce="84111506 Descuento de " . $descuento . " del CFDI " . $folion . " " . $serien . " " . $uuidn;
$subtotal=$descuento/1.16; 
$iva=$subtotal*.16;
$total=$subtotal+$iva;

$insertfac=mysqli_query($conexion,'INSERT INTO nota_credito(id_atencion,id_usua,fecha,rfc_emisor_nc,rfc_receptor_nc,uuid_relacionado,folio_nc,serie_nc,tipo_relacion_nc,met_pago,forma_pago_nc,uso_cfdi_nc,tipo_cfdi_nc,cp_nc,reg_fiscal_nc,total_fac,descuento,cantidad,clave_nc,un_med_nc,concepto_nc,iva_descuento,subtotal_descuento,obj_impuesto_nc,codigo_sat_nc,razon_s,paciente,id_dat_gen_f) values ('.$id_at.','.$id_usua.',"'.$fecha_actual.'","'.$rfc_emisor_nc.'","'.$rfc_receptor_nc.'","'.$uuid_relacionado.'","'.$folio_nc.'","NC","'.$tipo_relacion_nc.'","'.$met_pago.'","'.$forma_pago_nc.'","'.$uso_cfdi_nc.'","'.$tipo_cfdi_nc.'","'.$cp_nc.'","'.$reg_fiscal_nc.'","'.$total_fac.'","'.$descuento.'",1,"ACT","SER","'.$conce.'","'.$iva.'","'.$subtotal.'","'.$obj_impuesto_nc.'",84111506,"'.$razon_s.'","'.$paciente.'","'.$iddat.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
           }
$id_generado = mysqli_insert_id($conexion);

//factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml factura xml

$fecha_actual = date("Y-m-d H:i:s");


$resultado = $conexion->query("SELECT * from nota_credito WHERE id_nc=$id_generado ORDER BY id_nc DESC") or die($conexion->error);
              while ($row = $resultado->fetch_assoc()) {
                 $id_nc=$row['id_nc']; 
                 $totalDES=$row['descuento'];
                 $subtotal_descuento=$row['subtotal_descuento'];
                 $met_pago=$row['met_pago'];
                 $tipo_cfdi_nc=$row['tipo_cfdi_nc'];
                 $forma_pago_nc=$row['forma_pago_nc'];
                 $folio_nc=$row['folio_nc'];
                 $forma_pago_nc=$row['forma_pago_nc'];
                 $concepto_nc=$row['concepto_nc'];
                 
                 $tipo_relacion_nc=$row['tipo_relacion_nc'];
                 $uuid_relacionado=$row['uuid_relacionado'];
                 
                 $rfc_receptor_nc=$row['rfc_receptor_nc'];
                 $cp_nc=$row['cp_nc'];
                 $reg_fiscal_nc=$row['reg_fiscal_nc'];
                 $uso_cfdi_nc=$row['uso_cfdi_nc'];
                 

//PARA PRUEBAS                 
//INDISTRIA ILUMINADORA DE ALMACENES
//IIA040805DZ4


$xml ='<?xml version="1.0" encoding="utf-8"?>
<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Moneda="MXN" TipoCambio="1" Total="'.$english_format_number = number_format($totalDES, 2, '.', '').'" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" Exportacion="01" MetodoPago="'.$met_pago.'" TipoDeComprobante="'.$tipo_cfdi_nc.'" SubTotal="'.$english_format_number = number_format($totalDES, 2, '.', '').'" FormaPago="'.$forma_pago_nc.'" LugarExpedicion="52140" Fecha="'.$FechaCompleta.'" Folio="'.$folio_nc.'" Serie="NC" Version="4.0" xmlns:cfdi="http://www.sat.gob.mx/cfd/4">

   <cfdi:CfdiRelacionados TipoRelacion="'.$tipo_relacion_nc.'">
        <cfdi:CfdiRelacionado UUID="'.$uuid_relacionado.'" />
    </cfdi:CfdiRelacionados>

<cfdi:Emisor Rfc="CMS1501012H9" Nombre="CLINICA MEDICA SI" RegimenFiscal="601"/>
  <cfdi:Receptor Rfc="'.$rfc_receptor_nc.'" Nombre="'.$razon_s.'" DomicilioFiscalReceptor="'.$cp_nc.'" RegimenFiscalReceptor="'.$reg_fiscal_nc.'" UsoCFDI="'.$uso_cfdi_nc.'"/>
  <cfdi:Conceptos>';

$xml .= '<cfdi:Concepto ClaveProdServ="84111506" Cantidad="1" ClaveUnidad="ACT" Unidad="SER" Descripcion="'.$concepto_nc.'" ValorUnitario="'.$english_format_number = number_format($totalDES, 6, '.', '').'" Importe="'.$english_format_number = number_format($totalDES, 6, '.', '').'" ObjetoImp="01"></cfdi:Concepto>';

  $xml .= '</cfdi:Conceptos>
</cfdi:Comprobante>';


$nnombre= "datos_nc.xml";
$arch=fopen($nnombre, "w");
fwrite($arch, $xml);
fclose($arch);
  //xml
//termino de creacion de xml


//TIMBRADO

$ws="https://v2.timbracfdi33.mx:1449/Timbrado.asmx?wsdl";
//$ws = "https://pruebas.timbracfdi33.mx/Timbrado.asmx?wsdl";/*<- Esta ruta es para el servicio de pruebas, para pasar a productivo cambiar por https://v2.timbracfdi33.mx:1449/Timbrado.asmx*/
$response = '';
$workspace="../cuenta_paciente/";
//$workspace="F:\DemoPHPTimbraCFDI\ArchivosservicioIntegracionTimbrado//";/*<- Configurar la ruta en donde se encuentra nuestro kit de integración para localizar correctamente el archivo V40_Ingreso.xml*/
/* Ruta del comprobante a timbrar*/
$rutaArchivo = $workspace.'datos_nc.xml';
//$rutaArchivo = $workspace.'V40_Ingreso.xml';
/* El servicio recibe el comprobante (xml) codificado en Base64, el rfc del emisor deberá configurarlo según su necesidad*/ 
$base64Comprobante = file_get_contents($rutaArchivo);
$base64Comprobante = base64_encode($base64Comprobante);
try
{
$params = array();

$params['usuarioIntegrador'] = 'DHSdSjriIjdZV96Kc1Jztg==';
//integrador productivo msi DHSdSjriIjdZV96Kc1Jztg==


/*Nombre del usuario integrador asignado, para efecto de pruebas utilizaremos 'mvpNUXmQfK8=' <- Este usuario es para el servicio de pruebas, para pasar a productivo cambiar por el que le asignarán posteriormente*/
//$params['usuarioIntegrador'] = 'Fwlh2XZwEbz7VQ+hIeo2wQ==';
//$params['usuarioIntegrador'] = 'mvpNUXmQfK8=';


/* Comprobante en base 64*/
$params['xmlComprobanteBase64'] = $base64Comprobante;
/*Id del comprobante, deberá ser un identificador único, para efecto del ejemplo se utilizará un numero aleatorio*/
$params['idComprobante'] = rand(5, 999999);

$context = stream_context_create(array(
    'ssl' => array(
        // set some SSL/TLS specific options
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ),
  'http' => array(
            'user_agent' => 'PHPSoapClient'
            )
 ) );
$options =array();
$options['stream_context'] = $context;
$options['cache_wsdl']= WSDL_CACHE_MEMORY;
$options['trace']= true;

libxml_disable_entity_loader(false);
echo "SoapClient";

$client = new SoapClient($ws,$options);
echo "__soapCall";
$response = $client->__soapCall('TimbraCFDI', array('parameters' => $params));

}
catch (SoapFault $fault)
{
  echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
}
/*Obtenemos resultado del response*/
echo "resultado";
//echo $response;
$tipoExcepcion = $response->TimbraCFDIResult->anyType[0];
$numeroExcepcion = $response->TimbraCFDIResult->anyType[1];
$descripcionResultado = $response->TimbraCFDIResult->anyType[2];
$xmlTimbrado = $response->TimbraCFDIResult->anyType[3];
$codigoQr = $response->TimbraCFDIResult->anyType[4];
$cadenaOriginal = $response->TimbraCFDIResult->anyType[5];
$errorInterno = $response->TimbraCFDIResult->anyType[6];
$mensajeInterno = $response->TimbraCFDIResult->anyType[7];
$detalleError = $response->TimbraCFDIResult->anyType[8];

if($xmlTimbrado != '')
{
  echo "xmlTimbrado";
/*El comprobante fue timbrado correctamente*/

/*Guardamos comprobante timbrado*/
file_put_contents($workspace.'comprobanteTimbrado_nc.xml', $xmlTimbrado);

/*Guardamos codigo qr*/
file_put_contents($workspace.'codigoQr_nc.jpg', $codigoQr);

/*Guardamos cadena original del complemento de certificacion del SAT*/
file_put_contents($workspace.'cadenaOriginal_nc.txt', $cadenaOriginal);

print_r("Timbrado exitoso");

$fecha_c = date("Y-m-d H:i:s");

//insert a comprobantes
$file_factura = "comprobanteTimbrado_nc.xml";

$xml_content = file_get_contents($file_factura);

$xml_content = str_replace("<tfd:", "<cfdi:", $xml_content);
$xml_content = str_replace("<cfdi:", "<", $xml_content);
$xml_content = str_replace("</cfdi:", "</", $xml_content);

$xml_content = str_replace("<nomina12:", "<", $xml_content);
$xml_content = str_replace("</nomina12:", "</", $xml_content);
$xml_content = str_replace("<nomina11:", "<", $xml_content);
$xml_content = str_replace("</nomina11:", "</", $xml_content);

$xml_content = str_replace("<pago10:", "<", $xml_content);
$xml_content = str_replace("</pago10:", "</", $xml_content);

$xml_content = str_replace("@attributes", "attributes", $xml_content);


$xml_content = simplexml_load_string(utf8_encode($xml_content));

$xml_content = (array) $xml_content;

// xml data
$xml_data["version"]       = $xml_content["@attributes"]["Version"];
$xml_data["fecha"]       = $xml_content["@attributes"]["Fecha"];
$xml_data["total"]       = $xml_content["@attributes"]["Total"];
$xml_data["subtotal"]       = $xml_content["@attributes"]["SubTotal"] ;
$xml_data["moneda"]       = $xml_content["@attributes"]["Moneda"] ;
$xml_data["sello"]       = $xml_content["@attributes"]["Sello"];

$xml_data["nocertificado"]       = $xml_content["@attributes"]["NoCertificado"];

$xml_content["Emisor"] = (array) $xml_content["Emisor"];
$xml_content["Receptor"] = (array) $xml_content["Receptor"];
$xml_content["Complemento"] = (array) $xml_content["Complemento"];
$xml_content["Complemento"]["TimbreFiscalDigital"] = (array) $xml_content["Complemento"]["TimbreFiscalDigital"];


$xml_data["rfc_emisor"]  = $xml_content["Emisor"]["@attributes"]["Rfc"];
$xml_data["rfc_receptor"]  = $xml_content["Receptor"]["@attributes"]["Rfc"];
$xml_data["uuid"]       = $xml_content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["UUID"];

$xml_data["sellosat"]       = $xml_content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["SelloSAT"];
$xml_data["cfd"]       = $xml_content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["SelloCFD"];


$xml_data["impuestos"]=$xml_content["Impuestos"]["TotalImpuestosTrasladados"];

//print_r ($xml_data);
//echo $xml_data["cfd"];
$montopag= mysqli_real_escape_string($conexion, (strip_tags($_POST["montopag"], ENT_QUOTES)));
// insert data
$saldoant=$xml_data["total"]-$montopag;

$insertconc=mysqli_query($conexion,'INSERT INTO comprobante_nc(id_atencion,id_usua,fecha,cadena_or,sello_sat,sello_cfd,no_certificado,uuid_nc,id_nc,id_dat_gen_f) values ('.$id_at.','.$id_usua.',"'.$xml_data["fecha"].'","'.$cadenaOriginal.'","'.$xml_data["sellosat"] .'","'.$xml_data["cfd"].'","'.$xml_data["nocertificado"].'","'.$xml_data["uuid"].'","'.$id_nc.'","'.$iddat.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$stm = $conexion->prepare($insertconc);
$stm->execute($xml_data); 
print_r("Registro agregado"); exit;

//termino de insert a comprobantes


?>
<h2>Insert XML Data to MySql Table Output</h2>
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
    //descarcar xml
    //$fa=$_GET['ffiscal'];
$nombre_fichero = 'comprobanteTimbrado.xml';
$fichero_texto = fopen($nombre_fichero, "r");
$contenido_fichero = fread($fichero_texto, filesize($nombre_fichero));

header('Content-Type: text/xml');
header("Content-Disposition:attachment ; filename='".$xml_data["uuid"]."'.xml");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
} else {
    $message = "No records inserted";
}


}
else
{
  echo "else";
  echo "[".$tipoExcepcion."  ".$numeroExcepcion." ".$descripcionResultado."  ei=".$errorInterno." mi=".$mensajeInterno."]" ;
}



}



echo '<script type="text/javascript">window.location.href ="nota_credito.php?id_atencion='.$id_at.'&iddat='.$iddat.'" ;</script>';
  }





 ?>


  </div>


  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>
<!-- FastClick -->
<script type="text/javascript">
    $(document).ready(function () {
      var items = <?= json_encode($array) ?>

      $("#tag").autocomplete({
        source: items,
        select: function (event, item) {
          var params = {
            equipo: item.item.value
          };
          $.get("getEquipo.php", params, function (response) {
            var json = JSON.parse(response);
            if (json.status == 200){
              $('#nombre').val(json.rfc);
              $("#razon_s").val(json.razon_s);
              $("#calle").val(json.calle);
$("#no_ext").val(json.no_ext);
$("#no_int").val(json.no_int);
$("#id_estado").val(json.estado);
$("#municipiosp").val(json.municipio);
$("#cod_postal").val(json.cod_postal);
$("#asentamiento").val(json.asentamiento);
$("#reg_fiscal").val(json.reg_fiscal);
    $("#nom_c").val(json.nom_c);          

            }else{

            }
          }); // ajax
        }
      });
    });
  </script>
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>
<script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>

  <script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador1').select2();
    });
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
    $(document).ready(function () {
        $('#cod_postal').select2();
    });
</script>
<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('../../municipios.php?id_estado=' + event.target.value)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Error en la respuesta');
                }//en if
                return res.json();
            })
            .then(datos => {
                let html = '<option value=""> Seleccionar municipio</option>';
                if (datos.data.length > 0) {
                    for (let i = 0; i < datos.data.length; i++) {
                        html += `<option value="${datos.data[i].id}">${datos.data[i].nombre}</option>`;
                    }//end for
                }//end if
                document.querySelector('#municipios').innerHTML = html;
            })
            .catch(error => {
                console.error('Ocurrió un error ' + error);
            });
    });
</script>
 

 <script type="text/javascript">
  $(document).ready(function(){
    $('#cod_postal').val(1);
    recargarLista();

    $('#cod_postal').change(function(){
      recargarLista();
    });
  })
</script>
<script type="text/javascript">
  function recargarLista(){
    $.ajax({
      type:"POST",
      url:"datos.php",
      data:"asenta=" + $('#cod_postal').val(),
      success:function(r){
        $('#select2lista').html(r);
      }
    });
  }
</script>

</body>
</html>