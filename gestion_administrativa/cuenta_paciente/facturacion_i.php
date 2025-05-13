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

$deposito=$_GET['deposito'];
$id_datfin=$_GET['id_datfin'];
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
<?php $nopac=$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac ?>
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
      
      $resultado341 = $conexion->query("SELECT * from comprobantes where id_finan=$id_datfin") or die($conexion->error);
                while($f341 = mysqli_fetch_array($resultado341)){
      $valid=$f341['id_atencion'];
      $facestatus=$f341['total'];
       $finanid=$f341['id_finan'];
        $estatuss=$f341['estatus'];
                }
      ?>
  
    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Datos generales</a>
    

    
    
    
    
    
<?php if(isset($id_datfin)){ 
   echo' <a class="btn btn-success" href="facturas.php?id_atencion=' . $id_at . '&id_datfin=' . $id_datfin. '&id_usua=' . $id_usua . '&nopac='.$nopac.'" role="button">Mis facturas</a>';
}else{
  echo' <a class="btn btn-success" href="facturas.php?id_atencion='.$id_at.'&nopac='.$nopac.'" role="button">Mis facturas</a>';

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
    <div class="col-sm">
    <strong>*Serie</strong>
<input type="text" name="serie" value="A" class="form-control" disabled>
    </div>
    <div class="col-sm">
     <strong>*Método de pago</strong>
<select name="metodo_pago" class="form-control" data-live-search="true" id="opciones1" style="width : 100%; heigth : 100%" required>
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_metodopago order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_MetodoPago'] . "'>".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
    <div class="col-sm">
     <strong>*Moneda</strong>
<select name="moneda" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
             
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_moneda where Descripcion='Peso mexicano' order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){

                echo "<option value='" . $row['c_Moneda'] . "'>".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
      
    <?php 
    $resultadof = $conexion->query("SELECT * from gen_factura") or die($conexion->error);

                while($f3f = mysqli_fetch_array($resultadof)){

$id_dat_gen_ff=$f3f['id_dat_gen_f'];
                }
                
  if($id_dat_gen_ff==null){
  
    ?>
<div class="col-sm">
    <strong>*Folio</strong>
    <input type="text" name="folio"class="form-control" value="1" disabled>
    </div>

<?php }
else if($id_dat_gen_ff>0){
$resultado34 = $conexion->query("SELECT * from gen_factura") or die($conexion->error);

                while($f34 = mysqli_fetch_array($resultado34)){
$folio=$f34['folio'];
                }
                 $folio++;
            ?>
<div class="col-sm">
    <strong>*Folio</strong>
    <input type="text" name="folio"class="form-control" value="<?php echo $folio ?>" disabled>
    </div>

<?php
           }
               
    ?>
    
      
      
      
    
    
    <div class="col-sm">
     <strong>*Forma de pago</strong>
<select name="forma_pago" class="form-control" data-live-search="true" style="width : 100%; heigth : 100%" required>
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_formapago where Descripcion='Efectivo' or Descripcion='Por definir' or Descripcion='Transferencia electrónica de fondos' or Descripcion='Tarjeta de crédito' or Descripcion='Tarjeta de débito' or Descripcion='Por definir' or Descripcion='Por definir' or Descripcion='Cheque nominativo' order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_FormaPago'] . "'>" . $row['c_FormaPago'] . " - ".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>

<script>
    let opciones1 = document.getElementById("opciones1")
    let opciones2 = document.getElementById("opciones2")
    
    opciones1.addEventListener("change", () => {
      let texto = opciones1.options[opciones1.selectedIndex].text
      if (texto ==="Seleccionar") {
        opciones2[0].select = true
      opciones2[0].disabled = false
       opciones2[1].disabled = true
       opciones2[3].disabled = true
        opciones2[4].disabled = true
        opciones2[5].disabled = true
        opciones2[2].disabled = true
        
     opciones2.selectedIndex = 0;
      }
      else if (texto === "Pago en parcialidades o diferido") {
      opciones2[0].disabled = true
       opciones2[1].disabled = true
       opciones2[3].disabled = true
        opciones2[4].disabled = true
        opciones2[5].disabled = true
        opciones2[2].disabled = false
          opciones2.selectedIndex = 2;
      } else  if (texto === "Pago en una sola exhibición"){
       opciones2[2].disabled = true
       opciones2[0].disabled = false
       opciones2[1].disabled = false
       opciones2[3].disabled = false
        opciones2[4].disabled = false
        opciones2[5].disabled = false
        opciones2.selectedIndex = 0;
      }
    })
</script>

    <div class="col-sm">
     <strong>*Uso del CFDI</strong>
<select name="uso_cfdi" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_usocfdi where Descripcion='Pagos' order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_UsoCFDI'] . "'>".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    
    <div class="col-sm-4">
     <strong>*Tipo CFDI</strong>
<select name="tip_cfdi" class="form-control" data-live-search="true" style="width : 100%;heigth:100%;">
        
                <?php
         include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_tipodecomprobante where Descripcion='Ingreso' || Descripcion='Pago'";
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
 <div id="content" style="display: none;">
<div class="container">
  <div class="row">
    <div class="col-sm">
    <strong>Periodicidad</strong>
<select name="periodicidad" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_periodicidad order by Descripcion ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['Descripcion'] . "'>".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
    <div class="col-sm">
     <strong>Meses</strong>
<select name="meses" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
              <option value="">Seleccionar</option>
                <?php
         //include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_meses order by c_Meses ASC";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['Descripcion'] . "'>".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
    <div class="col-sm">
     <strong>Año</strong>
<select name="anio" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
              <option value="2022   ">2022</option>
            </select>
    </div>
  </div>
</div>
</div>
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
<input id="cod_postal" type="text" name="cod_postal" class="form-control">

    </div>
    
    <div class="col-sm-11">
     <div id="select2lista"></div>
    </div>

 <div class="col-sm-8">
     <strong>Régimen fiscal</strong>
     <input id="reg_fiscal" type="text" name="reg_fiscal" class="form-control">

    </div>
    <div class="col-sm">
   
     <input hidden id="nom_c" type="text" name="nom_c" class="form-control">

    </div>
  </div>
</div>
<hr>

<div class="container">
  <div class="row">
    <div class="col-sm-6">
<strong><font color="steelblue">Conceptos</font></strong>
</div>
</div>
</div>
<div class="container">
  <div class="row">
        <div class="col-sm-6">
<strong>Tipo de concepto</strong>
<select class="form-control pago" id="boton3" name="tipconcep">
  <option value="">Seleccionar tipo de concepto </option>
 <!-- <option value="Desglose">Desglose </option>-->
<option value="Global" checked>Global </option>
 <!-- <option value="Complemento">Complemento </option>-->
</select>
</div>
</div>
</div>
<P>
<script type="text/javascript">
$(document).ready(function(){
        $(".pago").click(function(evento){
          
            var valor = $(this).val();
          
            if(valor == 'Desglose'){
                $("#div1").css("display", "block");
                $("#div2").css("display", "none");
                $("#div3").css("display", "none");
            }else if(valor == 'Global'){
                $("#div1").css("display", "none");
                $("#div2").css("display", "block");
                $("#div3").css("display", "none");
            }else if(valor == 'Complemento'){
                $("#div1").css("display", "none");
                $("#div2").css("display", "none");
                $("#div3").css("display", "block");
            }else if(valor == ''){
                $("#div1").css("display", "none");
                $("#div2").css("display", "none");
                $("#div3").css("display", "none");
            }
    });
});

</script>


<div class="collapse" id="div2" style="display:;"> <!--GLOBAL GLOBAL GLOBAL GLOBAL GLOBAL GLOBAL GLOBAL-->
<div class="card card-body">
  <table class="table table-bordered" id="mytable">
                <thead class="thead bg-light">
              
                    <!--<th scope="col">Clave prod/serv</th>
                      <th scope="col">Clave unidad</th> 
                       <th scope="col">Cantidad</th> 
                    <th scope="col">Precio</th>
                    <th scope="col">Descuento</th>
                    <th scope="col">Importe</th>-->
                  
                    <th scope="col"></th>
                </tr>
                </thead>

                <tbody>
<?php
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_at = $_GET['id_atencion'];

//include "../../conexionbd.php";
//$resultado4 = $conexion->query("SELECT * FROM dat_financieros where id_atencion = $id_at and id_datfin=$id_datfin") or die($conexion->error);
              //while ($row4 = $resultado4->fetch_assoc()) { ?>
<tr> 
<td class="fondo"><strong><font size="4">ANTICIPO DEL BIEN O SERVICIO<?php //echo $row['descripcion'];?></font></strong>
<!--<br><strong>Clave unidad:</strong> <?php echo $cunidad='ACT';?></td>-->

<!--<td class="fondo"><br><strong>Cantidad:</strong> <?php echo $CANT=1;?><br><strong>Precio:</strong> $<?php echo $row['precio'];?></td>-->
                         
<!--<td class="fondo"><br><strong>Descuento:</strong> $<?php echo $row['descuento'];?>-->

<?php
$desc=$row['descripcion'];
$impor=$row['cantidad']*$row['precio'];

if ($row['descuento']==null) {
  $import=$impor;
}else{
$descuento=$row['descuento'];
  $import=$impor-$descuento;
}
?>

<?php $deposito=$_GET['deposito']; 

number_format($subglo=$deposito/1.16, 2);
number_format($subglo=$deposito/1.16, 2);
number_format($IIIVA=$subglo*.16, 2);?>


<br><strong>Total de pago:</strong> $<?php echo number_format($IIIVA+$subglo, 2);?>


     <br><strong>Subtotal:</strong> $<?php echo number_format($subglo=$deposito/1.16, 2)?><br>
    <strong>Importe: </strong>$<?php echo number_format($subglo=$deposito/1.16, 2) ?> 
     <br>
   <strong> IVA: </strong><?php echo number_format($IIIVA=$subglo*.16, 2);?><br></td>



<td class="fondo">
<br>
  
  <a href="elim_conc.php?id_co=<?php echo $row['id_conce'];?>&id_atencion=<?php echo $row['id_atencion'];?>"><br><button type="button" class="btn btn-danger"><i class="fa fa-trash" style="font-size:17px" aria-hidden="true"></i> </button></a>

 </td>
</tbody>
              
            </table>



<p>

 <div class="container">
  <div class="row">

    <div class="col-sm">
     <strong>*Objeto de Impuesto</strong>
<select name="impuestoo" class="form-control" data-live-search="true" style="width : 100%; heigth : 100%">
              <option value="">Seleccionar</option>
                <?php
         include "../conexionbdf.php";
                $sql_diag="SELECT * FROM c_objetoimp";
                $result_diag=$conexion->query($sql_diag);
                while($row=$result_diag->fetch_assoc()){
                echo "<option value='" . $row['c_ObjetoImp'] . "'>".$row['Descripcion']."</option>"; 
                } ?>
            </select>
    </div>
    
</div>
</div>
<p>

<!-- global-->
<?php 
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_at = $_GET['id_atencion'];
$resultado = $conexion->query("SELECT * from gen_concepto WHERE id_atencion=$id_at ORDER BY id_conce DESC") or die($conexion->error);
              while ($row = $resultado->fetch_assoc()) {             
    ?>
<?php
$impor=$row['cantidad']*$row['precio'];

if ($row['descuento']==null) {
  $import=$impor;

}else{
$descuento=$row['descuento'];
  $import=$impor-$descuento;
}
?>
    <!--<div class="container">
  <div class="row">
    <div class="col-sm">
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
<strong>Subtotal $<?php echo $impor ?></strong>
<br>
<strong>Descuento $<?php echo $descuento?></strong>
<br>
<strong>Retenciones $0.00</strong><br>
<strong>Traslados $0.00</strong>
<br>
<strong><h2>Total $<?php echo $import?></h2></strong>
    </div>
  </div>
</div>-->
<?php
                }
                 
                ?>

<p>
<div class="row">
    <div class="col-sm">
    </div>
     
    <div class="col-sm">
<input type="submit" name="factglobal" class="btn btn-primary" value="Guardar factura">
     
    </div>
</div>


</div>
</div>
<hr>

</p>

</form>
</div>


<!-- datos generales fin-->


 
 <!--INSERT DE GLOBAL GLOBAL GLOBAL CNCEPTO GLOBAL GLOBAL CONCEPTO GLOBAL-->

 <?php 
if (isset($_POST['factglobal'])) {

$obj_impuestoo= mysqli_real_escape_string($conexion, (strip_tags($_POST["impuestoo"], ENT_QUOTES)));

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

$serie= mysqli_real_escape_string($conexion, (strip_tags($_POST["serie"], ENT_QUOTES)));
$forma_pago= mysqli_real_escape_string($conexion, (strip_tags($_POST["forma_pago"], ENT_QUOTES)));
$moneda= mysqli_real_escape_string($conexion, (strip_tags($_POST["moneda"], ENT_QUOTES)));
//$folio= mysqli_real_escape_string($conexion, (strip_tags($_POST["folio"], ENT_QUOTES)));
$metodo_pago= mysqli_real_escape_string($conexion, (strip_tags($_POST["metodo_pago"], ENT_QUOTES)));
$uso_cfdi= mysqli_real_escape_string($conexion, (strip_tags($_POST["uso_cfdi"], ENT_QUOTES)));
$exportacion= mysqli_real_escape_string($conexion, (strip_tags($_POST["exportacion"], ENT_QUOTES)));
$tip_cfdi= mysqli_real_escape_string($conexion, (strip_tags($_POST["tip_cfdi"], ENT_QUOTES)));

$fecha= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));


if (isset($_POST['inf_glob'])) {
 $inf_glob=mysqli_real_escape_string($conexion, (strip_tags($_POST["inf_glob"], ENT_QUOTES)));
}else{
  $inf_glob="No";
}

$periodicidad= mysqli_real_escape_string($conexion, (strip_tags($_POST["periodicidad"], ENT_QUOTES)));
$meses= mysqli_real_escape_string($conexion, (strip_tags($_POST["meses"], ENT_QUOTES)));
$anio= mysqli_real_escape_string($conexion, (strip_tags($_POST["anio"], ENT_QUOTES)));
$rfc= mysqli_real_escape_string($conexion, (strip_tags($_POST["rfc"], ENT_QUOTES)));
$razon_s= mysqli_real_escape_string($conexion, (strip_tags($_POST["razon_s"], ENT_QUOTES)));
$calle= mysqli_real_escape_string($conexion, (strip_tags($_POST["calle"], ENT_QUOTES)));
$no_ext= mysqli_real_escape_string($conexion, (strip_tags($_POST["no_ext"], ENT_QUOTES)));
$no_int= mysqli_real_escape_string($conexion, (strip_tags($_POST["no_int"], ENT_QUOTES)));

$estado= mysqli_real_escape_string($conexion, (strip_tags($_POST["estado"], ENT_QUOTES)));
$municipio= mysqli_real_escape_string($conexion, (strip_tags($_POST["municipio"], ENT_QUOTES)));

$cod_postal= mysqli_real_escape_string($conexion, (strip_tags($_POST["cod_postal"], ENT_QUOTES)));
$asenta= mysqli_real_escape_string($conexion, (strip_tags($_POST["asenta"], ENT_QUOTES)));
$reg_fiscal= mysqli_real_escape_string($conexion, (strip_tags($_POST["reg_fiscal"], ENT_QUOTES)));
$nom_c= mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_c"], ENT_QUOTES)));


$resultadof = $conexion->query("SELECT * from gen_factura") or die($conexion->error);

                while($f3f = mysqli_fetch_array($resultadof)){

$id_dat_gen_ff=$f3f['id_dat_gen_f'];
                }
                
  if($id_dat_gen_ff==null){
$insertfac=mysqli_query($conexion,'INSERT INTO gen_factura(id_atencion,id_usua,serie,forma_pago,moneda,folio,metodo_pago,uso_cfdi,tip_cfdi,exportacion,fecha,inf_glob,periodicidad,meses,anio,rfc,razon_s,calle,no_ext,no_int,estado,municipio,cod_postal,asenta,reg_fiscal,nom_c) values ('.$id_at.','.$id_usua.',"A","'.$forma_pago.'","'.$moneda.'",1,"'.$metodo_pago.'","'.$uso_cfdi.'","'.$tip_cfdi.'","'.$exportacion.'","'.$fecha_actual.'","'.$inf_glob.'","'.$periodicidad.'","'.$meses.'","'.$anio.'","'.$rfc.'","'.$razon_s.'","'.$calle.'","'.$no_ext.'","'.$no_int.'","'.$estado.'","'.$municipio.'","'.$cod_postal.'","'.$asenta.'","'.$reg_fiscal.'","'.$nom_c.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
    
}
else if($id_dat_gen_ff>0){
$resultado34 = $conexion->query("SELECT * from gen_factura") or die($conexion->error);

                while($f34 = mysqli_fetch_array($resultado34)){
$folio=$f34['folio'];
   $folio++;
                }
              
            
$insertfac=mysqli_query($conexion,'INSERT INTO gen_factura(id_atencion,id_usua,serie,forma_pago,moneda,folio,metodo_pago,uso_cfdi,tip_cfdi,exportacion,fecha,inf_glob,periodicidad,meses,anio,rfc,razon_s,calle,no_ext,no_int,estado,municipio,cod_postal,asenta,reg_fiscal,nom_c) values ('.$id_at.','.$id_usua.',"A","'.$forma_pago.'","'.$moneda.'","'.$folio.'","'.$metodo_pago.'","'.$uso_cfdi.'","'.$tip_cfdi.'","'.$exportacion.'","'.$fecha_actual.'","'.$inf_glob.'","'.$periodicidad.'","'.$meses.'","'.$anio.'","'.$rfc.'","'.$razon_s.'","'.$calle.'","'.$no_ext.'","'.$no_int.'","'.$estado.'","'.$municipio.'","'.$cod_postal.'","'.$asenta.'","'.$reg_fiscal.'","'.$nom_c.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
           }



//insert a nueva conceptos

$fecha_actual = date("Y-m-d H:i:s");

$cantidad= mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));
//$descripcion= mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
//$coaseguro= mysqli_real_escape_string($conexion, (strip_tags($_POST["coaseguro"], ENT_QUOTES)));
$deducible= mysqli_real_escape_string($conexion, (strip_tags($_POST["deducible"], ENT_QUOTES)));
$traslado= mysqli_real_escape_string($conexion, (strip_tags($_POST["traslado"], ENT_QUOTES)));
$iva= mysqli_real_escape_string($conexion, (strip_tags($_POST["iva"], ENT_QUOTES)));
$precio= mysqli_real_escape_string($conexion, (strip_tags($_POST["precio"], ENT_QUOTES)));
//$clave_unidad= mysqli_real_escape_string($conexion, (strip_tags($_POST["clave_unidad"], ENT_QUOTES)));


$otros= mysqli_real_escape_string($conexion, (strip_tags($_POST["otros"], ENT_QUOTES)));

$codescdedl= mysqli_real_escape_string($conexion, (strip_tags($_POST["codescdedl"], ENT_QUOTES)));
$dasegl= mysqli_real_escape_string($conexion, (strip_tags($_POST["dasegl"], ENT_QUOTES)));



if($codescdedl!=null or $dasegl!=null){ // caso cuando hay descuentos inicio cuando hay descuentos
    $dasegl=floor(($dasegl/100)*100)/100;
    
    
     


    $resultado = $conexion->query("SELECT * from gen_concepto WHERE id_atencion=$id_at ORDER BY id_conce DESC limit 1") or die($conexion->error);
              while ($row = $resultado->fetch_assoc()) { 

$resultadoimporte = $conexion->query("SELECT *,sum(importe) as base from gen_concepto WHERE id_atencion=$id_at group by id_atencion") or die($conexion->error);
while ($rowim = $resultadoimporte->fetch_assoc()) {
//$tprecio=$rowim["base"];
//parte de arriba inicio



//nuevo 
$english_format_number = number_format($dasegg=floor(($deposito)*($dasegl)*100)/100, 2, '.', ''); //subtototal * aseguradora
$english_format_number = number_format($sumadesc=($codescdedl)+($dasegg), 2, '.', ''); //suma descuentos arriba esto va en descuento 2

echo "25*0.1: " . $english_format_number = number_format($dasegg=floor(($deposito)*($dasegl)*100)/100, 2, '.', ''); //subtototal * aseguradora
 echo  '<br>';
echo "traslado: " . $sumadescb=floor((($deposito)-($dasegg)-100)*100)/100; //suma descuentos arriba esto va en descuento 2
echo  '<br>';
echo "iva: " . $ivat=($sumadescb)*(.16); // iva traslado e impuetos trasladados




$cdesc=($sumadesc)/($deposito); // para sacar $ de descuento

$english_format_number = number_format($ivaa=($tprecio-$sumadesc)*(.16), 2, '.', '');//iva 2 traslado de hasta abajo


$english_format_number = number_format($totar=($deposito-$sumadesc), 2, '.', '');//



$english_format_number = number_format($tprec=$deposito, 2, '.', '');////se cnvierte en subtotal 2
     //fin operaciones



//parte de arriba termino



//nuevo conceptos
$english_format_number = number_format($iim=$rowf['precio']*$rowf['cantidad'], 6, '.', '');

// $english_format_number = number_format($iim=$rowf['total'], 6, '.', '');

//$tra=($cdesc/$tprec); //sma de descuentos

$cadar=($cdesc)*($deposito); //descuento de  cada concepto


$trasbasecon=($deposito)-($tra); // impo concep - total descuento ESTO VA EN  base traslado

$importt=$english_format_number = number_format(floor(($trasbasecon)*(.16)*100)/100,2, '.', ''); // traslado base *.16 = importe de traslado



$trasbase= $english_format_number = number_format(($tprec-$sumadesc),2, '.', ''); // total descuento ESTO VA EN  TRASLADO BASE DE total de impuestos

$basec=($deposito - $cadar); //base or concepto
$importeconcepto=($basec)*(.16); //base or concepto

$sumaconcepto=floor(($deposito+$importt)*100)/100;

$tot=($sumadescb+$ivat);



$insertconc=mysqli_query($conexion,'INSERT INTO gen_concepto_fact(id_atencion,id_usua,codigo,cantidad,descripcion,codescded,iva,precio,importe_traslado,clave_unidad,unidad,obj_impuesto,fecha,tip_concepto,total) values ('.$id_at.','.$id_usua.',"85101501","1","SERVICIOS HOSPITALARIOS DE EMERGENCIA O QUIRÚRGICOS","'.$codescdedl.'","'.$iva.'","'.$tprec.'","'.$trasl.'","E48","SERVICIO","'.$obj_impuestoo.'","'.$fecha_actual.'","Global A","'.$tot.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));

if($id_dat_gen_ff==null){
    $folio=1;
}

$xml ='<?xml version="1.0" encoding="utf-8"?>
<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Moneda="'.$moneda.'" TipoCambio="1" Total="'.$english_format_number = number_format($tot, 2, '.', '').'" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" Exportacion="01" MetodoPago="'.$metodo_pago.'" Descuento="'.$english_format_number = number_format($sumadesc, 2, '.', '').'" TipoDeComprobante="'.$tip_cfdi.'" SubTotal="'.$english_format_number = number_format($deposito, 2, '.', '').'" FormaPago="'.$forma_pago.'" LugarExpedicion="52140" Fecha="'.$FechaCompleta.'" Folio="'.$folio.'" Serie="A" Version="4.0" xmlns:cfdi="http://www.sat.gob.mx/cfd/4">

<cfdi:Emisor Rfc="GADE680108TS9" Nombre="EDITH GARDUÑO DIAZ" RegimenFiscal="612"/>
  <cfdi:Receptor Rfc="'.$rfc.'" Nombre="'.$razon_s.'" DomicilioFiscalReceptor="'.$cod_postal.'" RegimenFiscalReceptor="'.$reg_fiscal.'" UsoCFDI="'.$uso_cfdi.'"/>
  <cfdi:Conceptos>';

// parte conceptos


$result_xml = $conexion->query("SELECT * from gen_concepto_fact WHERE id_atencion=$id_at ORDER BY id_con_sat DESC") or die($conexion->error);

 while ($rowf = $result_xml->fetch_assoc()) {

$codigp=$row['codigo'];
    $clave_unidad=$row['clave_unidad'];
      $unidad=$row['unidad'];

$english_format_number = number_format($iim=$deposito, 6, '.', '');

$importeconceptos=($iim*.16);
 $cdesc=($sumadesc)*($iim);


}
        $xml .= '<cfdi:Concepto ClaveProdServ="85101501" Cantidad="1" ClaveUnidad="'.$clave_unidad.'" Unidad="'.$unidad.'" Descripcion="SERVICIOS HOSPITALARIOS DE EMERGENCIA O QUIRÚRGICOS" ValorUnitario="'.$english_format_number = number_format($iim, 6, '.', '').'" Importe="'.$english_format_number = number_format($iim, 6, '.', '').'" Descuento="'.$english_format_number = number_format($sumadesc, 6, '.', '').'" ObjetoImp="'.$obj_impuestoo.'">
        

<cfdi:Impuestos>   
        <cfdi:Traslados>
          <cfdi:Traslado Base="'.$english_format_number = number_format($sumadescb, 6, '.', '').'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="'.$english_format_number = number_format($ivat, 2, '.', '').'"/>
        </cfdi:Traslados>
      </cfdi:Impuestos>

    </cfdi:Concepto>';
    

    //fin conceptos
  $xml .= '</cfdi:Conceptos>
  <cfdi:Impuestos TotalImpuestosTrasladados="'.$english_format_number = number_format($ivat, 2, '.', '').'">
    <cfdi:Traslados>
      <cfdi:Traslado Base="'.$english_format_number = number_format($sumadescb, 2, '.', '').'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="'.$english_format_number = number_format($ivat, 2, '.', '').'"/>
    </cfdi:Traslados>
  </cfdi:Impuestos>
</cfdi:Comprobante>';
$nnombre= "datos.xml";
$arch=fopen($nnombre, "w");
fwrite($arch, $xml);
fclose($arch);
  //xml
//termino de creacion de xml


//TIMBRADO
//$ws="https://v2.timbracfdi33.mx:1449/Timbrado.asmx?wsdl";
$ws = "https://pruebas.timbracfdi33.mx/Timbrado.asmx?wsdl";/*<- Esta ruta es para el servicio de pruebas, para pasar a productivo cambiar por https://v2.timbracfdi33.mx:1449/Timbrado.asmx*/
$response = '';
$workspace="../cuenta_paciente/";
//$workspace="F:\DemoPHPTimbraCFDI\ArchivosservicioIntegracionTimbrado//";/*<- Configurar la ruta en donde se encuentra nuestro kit de integración para localizar correctamente el archivo V40_Ingreso.xml*/
/* Ruta del comprobante a timbrar*/
$rutaArchivo = $workspace.'datos.xml';
//$rutaArchivo = $workspace.'V40_Ingreso.xml';
/* El servicio recibe el comprobante (xml) codificado en Base64, el rfc del emisor deberá configurarlo según su necesidad*/ 
$base64Comprobante = file_get_contents($rutaArchivo);
$base64Comprobante = base64_encode($base64Comprobante);
try
{
$params = array();
/*Nombre del usuario integrador asignado, para efecto de pruebas utilizaremos 'mvpNUXmQfK8=' <- Este usuario es para el servicio de pruebas, para pasar a productivo cambiar por el que le asignarán posteriormente*/
$params['usuarioIntegrador'] = 'mvpNUXmQfK8=';

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
file_put_contents($workspace.'comprobanteTimbrado.xml', $xmlTimbrado);

/*Guardamos codigo qr*/
file_put_contents($workspace.'codigoQr.jpg', $codigoQr);

/*Guardamos cadena original del complemento de certificacion del SAT*/
file_put_contents($workspace.'cadenaOriginal.txt', $cadenaOriginal);

print_r("Timbrado exitoso");

$fecha_c = date("Y-m-d H:i:s");

//insert a comprobantes
$file_factura = "comprobanteTimbrado.xml";

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

// insert data
$insertconc=mysqli_query($conexion,'INSERT INTO comprobantes(id_atencion,id_usua,fecha,cadenaor,sellosat,sellocfd,nocertificado,version, subtotal, total, moneda, sello, rfc_emisor, rfc_receptor,uuid,iva,descuento,descuento_aseg) values ('.$id_at.','.$id_usua.',"'.$xml_data["fecha"].'","'.$cadenaOriginal.'","'.$xml_data["sellosat"] .'","'.$xml_data["cfd"].'","'.$xml_data["nocertificado"].'","'.$xml_data["version"].'","'.$xml_data["subtotal"].'","'.$xml_data["total"].'","'.$xml_data["moneda"].'","'.$xml_data["sello"].'","'.$xml_data["rfc_emisor"].'","'.$xml_data["rfc_receptor"].'","'.$xml_data["uuid"].'","'.$xml_data["impuestos"].'","'.$sumadesc.'","'.$codescdedl.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));


//$sql = "INSERT INTO comprobantes(sellosat,sellocfd)VALUES (:sellosat,:cfd)";
$stm = $conexion->prepare($insertconc);
$stm->execute($xml_data); 
print_r("Registro agregado"); exit;

//termino de insert a comprobantes


?>
<h2>Insert XML Data to MySql Table Output</h2>
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
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
}


echo '<script type="text/javascript">window.location.href ="facturacion.php?id_atencion='.$id_at.'" ;</script>';
  
    
}else{


number_format($SUB=$deposito/1.16, 2);
number_format($IVAd=$SUB*.16, 2);

number_format($totfina=$IVAd+$SUB, 2);



    
//sin descuentos global
$insertconc=mysqli_query($conexion,'INSERT INTO gen_concepto_fact(id_atencion,id_usua,codigo,cantidad,descripcion,codescded,iva,precio,importe_traslado,clave_unidad,unidad,obj_impuesto,fecha,tip_concepto,total) values ('.$id_at.','.$id_usua.',"84111506","1","ANTICIPO DEL BIEN O SERVICIO","'.$codescdedl.'","'.$IVAd.'","'.$deposito.'","'.$trasl.'","ACT","ACTIVIDAD","'.$obj_impuestoo.'","'.$fecha_actual.'","Global A","'.$totfina.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
//ANTICIPO DEL BIEN O SERVICIO
//84111506


//85101501
//SERVICIOS HOSPITALARIOS DE EMERGENCIA O QUIRÚRGICOS

$resultadof = $conexion->query("SELECT * from gen_factura where id_atencion=$id_at") or die($conexion->error);

                while($f3f = mysqli_fetch_array($resultadof)){
$id_genf=$f3f['id_dat_gen_f'];
$fol=$f3f['folio'];
$razonpublica=$f3f['razon_s'];
                }


if($razonpublica=="PUBLICO EN GENERAL"){
   $razon_s=$pac_papell.' ' .$pac_sapell.' '.$pac_nom_pac;
}else{
    $razon_s=$razonpublica;
}
//CLINICA MEDICA SI CMS1501012H9

$xml ='<?xml version="1.0" encoding="utf-8"?>
<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" Moneda="'.$moneda.'" TipoCambio="1" Total="'.$english_format_number = number_format($totfina, 2, '.', '').'" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" Exportacion="01" MetodoPago="'.$metodo_pago.'" Descuento="'.$english_format_number = number_format($sumadesc, 2, '.', '').'" TipoDeComprobante="'.$tip_cfdi.'" SubTotal="'.$english_format_number = number_format($SUB, 2, '.', '').'" FormaPago="'.$forma_pago.'" LugarExpedicion="52140" Fecha="'.$FechaCompleta.'" Folio="'.$folio.'" Serie="A" Version="4.0" xmlns:cfdi="http://www.sat.gob.mx/cfd/4">





<cfdi:Emisor Rfc="CMS1501012H9" Nombre="CLINICA MEDICA SI" RegimenFiscal="601"/>
  <cfdi:Receptor Rfc="'.$rfc.'" Nombre="'.$razon_s.'" DomicilioFiscalReceptor="'.$cod_postal.'" RegimenFiscalReceptor="'.$reg_fiscal.'" UsoCFDI="'.$uso_cfdi.'"/>
  <cfdi:Conceptos>';

// parte conceptos


$result_xml = $conexion->query("SELECT * from gen_concepto_fact  WHERE id_atencion=$id_at ORDER BY id_con_sat DESC") or die($conexion->error);

 while ($rowf = $result_xml->fetch_assoc()) {


    

$english_format_number = number_format($iim=$deposito, 6, '.', '');

$importeconceptos=($iim*.16);
 $cdesc=($sumadesc)*($iim);


}
$obj_impuesto= mysqli_real_escape_string($conexion, (strip_tags($_POST["obj_impuesto"], ENT_QUOTES)));
        $xml .= '<cfdi:Concepto ClaveProdServ="84111506" Cantidad="1" ClaveUnidad="ACT" Unidad="ACTIVIDAD" Descripcion="ANTICIPO DEL BIEN O SERVICIO" ValorUnitario="'.$english_format_number = number_format($SUB, 6, '.', '').'" Importe="'.$english_format_number = number_format($SUB, 6, '.', '').'" Descuento="'.$english_format_number = number_format($cdesc, 6, '.', '').'" ObjetoImp="'.$obj_impuestoo.'">
        

<cfdi:Impuestos>   
        <cfdi:Traslados>
          <cfdi:Traslado Base="'.$english_format_number = number_format($SUB, 6, '.', '').'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="'.$english_format_number = number_format($IVAd, 6, '.', '').'"/>
        </cfdi:Traslados>
      </cfdi:Impuestos>

    </cfdi:Concepto>';
    

    //fin conceptos
  $xml .= '</cfdi:Conceptos>
  <cfdi:Impuestos TotalImpuestosTrasladados="'.$english_format_number = number_format($IVAd, 2, '.', '').'">
    <cfdi:Traslados>
      <cfdi:Traslado Base="'.$english_format_number = number_format($SUB, 2, '.', '').'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="'.$english_format_number = number_format($IVAd, 2, '.', '').'"/>
    </cfdi:Traslados>
  </cfdi:Impuestos>
</cfdi:Comprobante>';
$nnombre= "datos.xml";
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
$rutaArchivo = $workspace.'datos.xml';
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
//$params['usuarioIntegrador'] = 'mvpNUXmQfK8=';
//$params['usuarioIntegrador'] = 'Fwlh2XZwEbz7VQ+hIeo2wQ==';
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
file_put_contents($workspace.'comprobanteTimbrado.xml', $xmlTimbrado);

/*Guardamos codigo qr*/
file_put_contents($workspace.'codigoQr.jpg', $codigoQr);

/*Guardamos cadena original del complemento de certificacion del SAT*/
file_put_contents($workspace.'cadenaOriginal.txt', $cadenaOriginal);

print_r("Timbrado exitoso");

$fecha_c = date("Y-m-d H:i:s");

//insert a comprobantes
$file_factura = "comprobanteTimbrado.xml";

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


$resultadof = $conexion->query("SELECT * from gen_factura where id_atencion=$id_at") or die($conexion->error);

                while($f3f = mysqli_fetch_array($resultadof)){
$id_genf=$f3f['id_dat_gen_f'];
$fol=$f3f['folio'];
                }

// insert data
$insertconc=mysqli_query($conexion,'INSERT INTO comprobantes(id_atencion,id_usua,fecha,cadenaor,sellosat,sellocfd,nocertificado,version, subtotal, total, moneda, sello, rfc_emisor, rfc_receptor,uuid,iva,tipof,id_finan,id_dat_gen_f) values ('.$id_at.','.$id_usua.',"'.$xml_data["fecha"].'","'.$cadenaOriginal.'","'.$xml_data["sellosat"] .'","'.$xml_data["cfd"].'","'.$xml_data["nocertificado"].'","'.$xml_data["version"].'","'.$xml_data["subtotal"].'","'.$xml_data["total"].'","'.$xml_data["moneda"].'","'.$xml_data["sello"].'","'.$xml_data["rfc_emisor"].'","'.$xml_data["rfc_receptor"].'","'.$xml_data["uuid"].'","'.$xml_data["impuestos"].'","pago","'.$id_datfin.'","'.$id_genf.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));


//$sql = "INSERT INTO comprobantes(sellosat,sellocfd)VALUES (:sellosat,:cfd)";
$stm = $conexion->prepare($insertconc);
$stm->execute($xml_data); 
print_r("Registro agregado"); exit;

//termino de insert a comprobantes


?>
<h2>Insert XML Data to MySql Table Output</h2>
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
} else {
    $message = "No records inserted";
}


}
else
{
  echo "else";
  echo "[".$tipoExcepcion."  ".$numeroExcepcion." ".$descripcionResultado."  ei=".$errorInterno." mi=".$mensajeInterno."]" ;
}







echo '<script type="text/javascript">window.location.href ="facturacion.php?id_atencion='.$id_at.'" ;</script>';
  }
}




 ?>

  </div>
  
<!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO--><!--COMPLEMENTO-->


<hr>

</p>

</form>
</div>


 <!--INSERT DE COMPLEMENTO COMPLEMENTO COMPLEMENTO COMPLEMENTO COMPLEMENTO COMPLEMENTO COMPLEMENTO-->

 <?php 
if (isset($_POST['factpago'])) {



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

$serie= mysqli_real_escape_string($conexion, (strip_tags($_POST["serie"], ENT_QUOTES)));
$forma_pago= mysqli_real_escape_string($conexion, (strip_tags($_POST["forma_pago"], ENT_QUOTES)));
$moneda= mysqli_real_escape_string($conexion, (strip_tags($_POST["moneda"], ENT_QUOTES)));
//$folio= mysqli_real_escape_string($conexion, (strip_tags($_POST["folio"], ENT_QUOTES)));
$metodo_pago= mysqli_real_escape_string($conexion, (strip_tags($_POST["metodo_pago"], ENT_QUOTES)));
$uso_cfdi= mysqli_real_escape_string($conexion, (strip_tags($_POST["uso_cfdi"], ENT_QUOTES)));
$exportacion= mysqli_real_escape_string($conexion, (strip_tags($_POST["exportacion"], ENT_QUOTES)));
$tip_cfdi= mysqli_real_escape_string($conexion, (strip_tags($_POST["tip_cfdi"], ENT_QUOTES)));

$fecha= mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));


if (isset($_POST['inf_glob'])) {
 $inf_glob=mysqli_real_escape_string($conexion, (strip_tags($_POST["inf_glob"], ENT_QUOTES)));
}else{
  $inf_glob="No";
}

$periodicidad= mysqli_real_escape_string($conexion, (strip_tags($_POST["periodicidad"], ENT_QUOTES)));
$meses= mysqli_real_escape_string($conexion, (strip_tags($_POST["meses"], ENT_QUOTES)));
$anio= mysqli_real_escape_string($conexion, (strip_tags($_POST["anio"], ENT_QUOTES)));
$rfc= mysqli_real_escape_string($conexion, (strip_tags($_POST["rfc"], ENT_QUOTES)));
$razon_s= mysqli_real_escape_string($conexion, (strip_tags($_POST["razon_s"], ENT_QUOTES)));
$calle= mysqli_real_escape_string($conexion, (strip_tags($_POST["calle"], ENT_QUOTES)));
$no_ext= mysqli_real_escape_string($conexion, (strip_tags($_POST["no_ext"], ENT_QUOTES)));
$no_int= mysqli_real_escape_string($conexion, (strip_tags($_POST["no_int"], ENT_QUOTES)));

$estado= mysqli_real_escape_string($conexion, (strip_tags($_POST["estado"], ENT_QUOTES)));
$municipio= mysqli_real_escape_string($conexion, (strip_tags($_POST["municipio"], ENT_QUOTES)));

$cod_postal= mysqli_real_escape_string($conexion, (strip_tags($_POST["cod_postal"], ENT_QUOTES)));
$asenta= mysqli_real_escape_string($conexion, (strip_tags($_POST["asenta"], ENT_QUOTES)));
$reg_fiscal= mysqli_real_escape_string($conexion, (strip_tags($_POST["reg_fiscal"], ENT_QUOTES)));
$nom_c= mysqli_real_escape_string($conexion, (strip_tags($_POST["nom_c"], ENT_QUOTES)));


$resultadof = $conexion->query("SELECT * from gen_factura") or die($conexion->error);

                while($f3f = mysqli_fetch_array($resultadof)){

$id_dat_gen_ff=$f3f['id_dat_gen_f'];
                }
                
  if($id_dat_gen_ff==null){
$insertfac=mysqli_query($conexion,'INSERT INTO gen_factura(id_atencion,id_usua,serie,forma_pago,moneda,folio,metodo_pago,uso_cfdi,tip_cfdi,exportacion,fecha,inf_glob,periodicidad,meses,anio,rfc,razon_s,calle,no_ext,no_int,estado,municipio,cod_postal,asenta,reg_fiscal,nom_c) values ('.$id_at.','.$id_usua.',"A","'.$forma_pago.'","'.$moneda.'",1,"'.$metodo_pago.'","'.$uso_cfdi.'","'.$tip_cfdi.'","'.$exportacion.'","'.$fecha_actual.'","'.$inf_glob.'","'.$periodicidad.'","'.$meses.'","'.$anio.'","'.$rfc.'","'.$razon_s.'","'.$calle.'","'.$no_ext.'","'.$no_int.'","'.$estado.'","'.$municipio.'","'.$cod_postal.'","'.$asenta.'","'.$reg_fiscal.'","'.$nom_c.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
    
}
else if($id_dat_gen_ff>0){
$resultado34 = $conexion->query("SELECT * from gen_factura") or die($conexion->error);

                while($f34 = mysqli_fetch_array($resultado34)){
$folio=$f34['folio'];
                }
                 $folio++;
            
$insertfac=mysqli_query($conexion,'INSERT INTO gen_factura(id_atencion,id_usua,serie,forma_pago,moneda,folio,metodo_pago,uso_cfdi,tip_cfdi,exportacion,fecha,inf_glob,periodicidad,meses,anio,rfc,razon_s,calle,no_ext,no_int,estado,municipio,cod_postal,asenta,reg_fiscal,nom_c) values ('.$id_at.','.$id_usua.',"A","'.$forma_pago.'","'.$moneda.'","'.$folio.'","'.$metodo_pago.'","'.$uso_cfdi.'","'.$tip_cfdi.'","'.$exportacion.'","'.$fecha_actual.'","'.$inf_glob.'","'.$periodicidad.'","'.$meses.'","'.$anio.'","'.$rfc.'","'.$razon_s.'","'.$calle.'","'.$no_ext.'","'.$no_int.'","'.$estado.'","'.$municipio.'","'.$cod_postal.'","'.$asenta.'","'.$reg_fiscal.'","'.$nom_c.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));
           }



//insert a nueva conceptos

$fecha_actual = date("Y-m-d H:i:s");

$cantidad= mysqli_real_escape_string($conexion, (strip_tags($_POST["cantidad"], ENT_QUOTES)));
//$descripcion= mysqli_real_escape_string($conexion, (strip_tags($_POST["descripcion"], ENT_QUOTES)));
//$coaseguro= mysqli_real_escape_string($conexion, (strip_tags($_POST["coaseguro"], ENT_QUOTES)));
$deducible= mysqli_real_escape_string($conexion, (strip_tags($_POST["deducible"], ENT_QUOTES)));
$traslado= mysqli_real_escape_string($conexion, (strip_tags($_POST["traslado"], ENT_QUOTES)));
$iva= mysqli_real_escape_string($conexion, (strip_tags($_POST["iva"], ENT_QUOTES)));
$precio= mysqli_real_escape_string($conexion, (strip_tags($_POST["precio"], ENT_QUOTES)));
//$clave_unidad= mysqli_real_escape_string($conexion, (strip_tags($_POST["clave_unidad"], ENT_QUOTES)));
$obj_impuesto= mysqli_real_escape_string($conexion, (strip_tags($_POST["obj_impuesto"], ENT_QUOTES)));
$otros= mysqli_real_escape_string($conexion, (strip_tags($_POST["otros"], ENT_QUOTES)));

$codescdedl= mysqli_real_escape_string($conexion, (strip_tags($_POST["codescdedl"], ENT_QUOTES)));
$dasegl= mysqli_real_escape_string($conexion, (strip_tags($_POST["dasegl"], ENT_QUOTES)));

$bancoor= mysqli_real_escape_string($conexion, (strip_tags($_POST["bancoor"], ENT_QUOTES)));
$cuentaor= mysqli_real_escape_string($conexion, (strip_tags($_POST["cuentaor"], ENT_QUOTES)));
$montoant= mysqli_real_escape_string($conexion, (strip_tags($_POST["montoant"], ENT_QUOTES)));
$saldoant= mysqli_real_escape_string($conexion, (strip_tags($_POST["saldoant"], ENT_QUOTES)));
$noparcialidad= mysqli_real_escape_string($conexion, (strip_tags($_POST["noparcialidad"], ENT_QUOTES)));
$comentario= mysqli_real_escape_string($conexion, (strip_tags($_POST["comentario"], ENT_QUOTES)));






                         //sin descuentos cmplemento

$resultado = $conexion->query("SELECT * from gen_concepto WHERE id_atencion=$id_at ORDER BY id_conce DESC  LIMIT 1") or die($conexion->error);
              while ($row = $resultado->fetch_assoc()) { 

$resultadoimporte = $conexion->query("SELECT *,sum(importe) as base from gen_concepto WHERE id_atencion=$id_at group by id_atencion") or die($conexion->error);
while ($rowim = $resultadoimporte->fetch_assoc()) {
//$tprecio=$rowim["base"];


$english_format_number = number_format($tprec=$deposito , 2, '.', ''); //subtotal cuenta
$ivaa=($tprec)*(.16); // iva
$english_format_number = number_format($totar=$tprec+$ivaa , 2, '.', ''); //TOTAL CUENTA
$sumadesc=0;
$english_format_number = number_format($sumadesc , 2, '.', ''); //sumadescuentos



$insertconc=mysqli_query($conexion,'INSERT INTO gen_concepto_fact(id_atencion,id_usua,codigo,cantidad,descripcion,codescded,iva,precio,importe_traslado,clave_unidad,unidad,obj_impuesto,fecha,tip_concepto,total) values ('.$id_at.','.$id_usua.',"85101501","1","SERVICIOS HOSPITALARIOS DE EMERGENCIA O QUIRÚRGICOS","'.$codescdedl.'","'.$iva.'","'.$tprec.'","'.$trasl.'","'. $row['clave_unidad'].'","'.$row['unidad'].'","'.$obj_impuesto.'","'.$fecha_actual.'","Complemento","'.$totar.'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));

$xml ='<?xml version="1.0" encoding="utf-8"?>

<cfdi:Comprobante xmlns:cfdi="http://www.sat.gob.mx/cfd/4" Version="4.0" Serie="A" Folio="'.$folio.'" Fecha="'.$FechaCompleta.'" LugarExpedicion="52140" SubTotal="0" TipoDeComprobante="'.$tip_cfdi.'" Exportacion="01" xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd" Total="0" Moneda="'.$moneda.'" xmlns:pago20="http://www.sat.gob.mx/Pagos20" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

<cfdi:Emisor Rfc="CMSI501012H9" Nombre="CLINICA MEDICA SI" RegimenFiscal="601"/>
  <cfdi:Receptor Rfc="'.$rfc.'" Nombre="'.$razon_s.'" DomicilioFiscalReceptor="'.$cod_postal.'" RegimenFiscalReceptor="'.$reg_fiscal.'" UsoCFDI="'.$uso_cfdi.'"/>
  <cfdi:Conceptos>';

// parte conceptos


$result_xml = $conexion->query("SELECT * from gen_concepto_fact  WHERE id_atencion=$id_at ORDER BY id_con_sat DESC") or die($conexion->error);

 while ($rowf = $result_xml->fetch_assoc()) {


    

$english_format_number = number_format($iim=$deposito, 6, '.', '');

$importeconceptos=($iim*.16);
 $cdesc=($sumadesc)*($iim);


}
        $xml .= '<cfdi:Concepto ClaveProdServ="85101501" Cantidad="1" ClaveUnidad="'.$row['clave_unidad'].'" Unidad="'.$row['unidad'].'" Descripcion="SERVICIOS HOSPITALARIOS DE EMERGENCIA O QUIRÚRGICOS" ValorUnitario="'.$english_format_number = number_format($iim, 6, '.', '').'" Importe="'.$english_format_number = number_format($iim, 6, '.', '').'" Descuento="'.$english_format_number = number_format($cdesc, 6, '.', '').'" ObjetoImp="'.$obj_impuesto.'">
        

<cfdi:Impuestos>   
        <cfdi:Traslados>
          <cfdi:Traslado Base="'.$english_format_number = number_format($iim, 6, '.', '').'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="0.160000" Importe="'.$english_format_number = number_format($importeconceptos, 6, '.', '').'"/>
        </cfdi:Traslados>
      </cfdi:Impuestos>

    </cfdi:Concepto>';
    

    //fin conceptos
  $xml .= '</cfdi:Conceptos>
  
  <cfdi:Complemento>
<pago20:Pagos Version="2.0" xmlns:pago20="http://www.sat.gob.mx/Pagos20">
<pago20:Totales MontoTotalPagos="'.$english_format_number = number_format($montoant, 2, '.', '').'"/>
<pago20:Pago Monto="'.$english_format_number = number_format($montoant, 2, '.', '').'" TipoCambioP="1" MonedaP="'.$moneda.'" FormaDePagoP="'.$forma_pago.'" FechaPago="'.$FechaCompleta.'">
<pago20:DoctoRelacionado ObjetoImpDR="'.$obj_impuesto.'" ImpSaldoInsoluto="0" ImpPagado="'.$english_format_number = number_format($montoant, 2, '.', '').'" ImpSaldoAnt="'.$english_format_number = number_format($montoant, 2, '.', '').'" NumParcialidad="'.$noparcialidad.'" EquivalenciaDR="1" MonedaDR="'.$moneda.'" IdDocumento="bfc36522-4b8e-45c4-8f14-d11b289f9eb7"/>
</pago20:Pago>
</pago20:Pagos>
</cfdi:Complemento>
  
  
  
</cfdi:Comprobante>';
$nnombre= "datos.xml";
$arch=fopen($nnombre, "w");
fwrite($arch, $xml);
fclose($arch);
  //xml
//termino de creacion de xml

//nsert a tabla complemento
$insertconc=mysqli_query($conexion,'INSERT INTO Complemento(id_atencion,id_usua,fecha,bancoor,cuentaor,montoant,saldoant,noparcialidad,comentario,serie,folio,moneda,formapago,objetoimp,clave_unidad,unidad,codigo) values ('.$id_at.','.$id_usua.',"'.$fecha_actual.'","'.$bancoor.'","'.$cuentaor.'","'.$montoant.'","'.$saldoant.'","'.$noparcialidad.'","'.$comentario.'","A","'.$folio.'","'.$moneda.'","'.$forma_pago.'","'.$obj_impuesto.'","'. $row['clave_unidad'].'","'.$row['unidad'].'","'.$row['codigo'].'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));

//TIMBRADO
$ws="https://v2.timbracfdi33.mx:1449/Timbrado.asmx";
//$ws = "https://pruebas.timbracfdi33.mx/Timbrado.asmx?wsdl";/*<- Esta ruta es para el servicio de pruebas, para pasar a productivo cambiar por https://v2.timbracfdi33.mx:1449/Timbrado.asmx*/
$response = '';
$workspace="../cuenta_paciente/";
//$workspace="F:\DemoPHPTimbraCFDI\ArchivosservicioIntegracionTimbrado//";/*<- Configurar la ruta en donde se encuentra nuestro kit de integración para localizar correctamente el archivo V40_Ingreso.xml*/
/* Ruta del comprobante a timbrar*/
$rutaArchivo = $workspace.'datos.xml';
//$rutaArchivo = $workspace.'V40_Ingreso.xml';
/* El servicio recibe el comprobante (xml) codificado en Base64, el rfc del emisor deberá configurarlo según su necesidad*/ 
$base64Comprobante = file_get_contents($rutaArchivo);
$base64Comprobante = base64_encode($base64Comprobante);
try
{
$params = array();
/*Nombre del usuario integrador asignado, para efecto de pruebas utilizaremos 'mvpNUXmQfK8=' <- Este usuario es para el servicio de pruebas, para pasar a productivo cambiar por el que le asignarán posteriormente*/
$params['usuarioIntegrador'] = 'mvpNUXmQfK8=';
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
file_put_contents($workspace.'comprobanteTimbrado.xml', $xmlTimbrado);

/*Guardamos codigo qr*/
file_put_contents($workspace.'codigoQr.jpg', $codigoQr);

/*Guardamos cadena original del complemento de certificacion del SAT*/
file_put_contents($workspace.'cadenaOriginal.txt', $cadenaOriginal);

print_r("Timbrado exitoso");

$fecha_c = date("Y-m-d H:i:s");

//insert a comprobantes
$file_factura = "comprobanteTimbrado.xml";

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

// insert data
$insertconc=mysqli_query($conexion,'INSERT INTO comprobantes(id_atencion,id_usua,fecha,cadenaor,sellosat,sellocfd,nocertificado,version, subtotal, total, moneda, sello, rfc_emisor, rfc_receptor,uuid,iva) values ('.$id_at.','.$id_usua.',"'.$xml_data["fecha"].'","'.$cadenaOriginal.'","'.$xml_data["sellosat"] .'","'.$xml_data["cfd"].'","'.$xml_data["nocertificado"].'","'.$xml_data["version"].'","'.$xml_data["subtotal"].'","'.$xml_data["total"].'","'.$xml_data["moneda"].'","'.$xml_data["sello"].'","'.$xml_data["rfc_emisor"].'","'.$xml_data["rfc_receptor"].'","'.$xml_data["uuid"].'","'.$xml_data["impuestos"].'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));


//$sql = "INSERT INTO comprobantes(sellosat,sellocfd)VALUES (:sellosat,:cfd)";
$stm = $conexion->prepare($insertconc);
$stm->execute($xml_data); 
print_r("Registro agregado"); exit;

//termino de insert a comprobantes


?>
<h2>Insert XML Data to MySql Table Output</h2>
<?php
if ($affectedRow > 0) {
    $message = $affectedRow . " records inserted";
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
}


echo '<script type="text/javascript">window.location.href ="facturacion_i.php?id_atencion='.$id_at.'" ;</script>';
  
}




 ?>












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