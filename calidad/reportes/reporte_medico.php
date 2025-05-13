<?php
session_start();
//include "../conexionbd.php";
include "../header_calidad.php";
$resultado=$conexion->query("select * from reg_usuarios") or die($conexion->error);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
              integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
              crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
                integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
                crossorigin="anonymous"></script>
        <!--  Bootstrap  -->
        <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
              integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
              crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/select2.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="js/select2.js"></script>



   
        <script>
            // Write on keyup event of keyword input element
            $(document).ready(function () {
                $("#search").keyup(function () {
                    _this = this;
                    // Show only matching TR, hide rest of them
                    $.each($("#mytable tbody tr"), function () {
                        if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                            $(this).hide();
                        else
                            $(this).show();
                    });
                });
            });
        </script>
    <title>REPORTES MEDICOS</title>
</head>
<body>
    <center><h3><strong>REPORTE DE DIAGNÓSTICO MENSUAL Y ANUAL</strong></h3></center>
    <!-- seccion de reporte mensual-->
<section>
<form action="pdf_reporte_medico.php" target="_blank" method="POST">
    <div class="container box">
        <h5><strong>REPORTE MENSUAL</strong></h5><hr>
    <div class="row">
        <div class="container">
            <div class="row">
              <div class="col-sm-4">
            <label>SELECCIONAR MES</label><br>
            <select class="form-control" name="mes" required="">
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
        <div class="col-sm-4">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-danger">PDF</button>
         </div> 
            </div>
            <br>
        </div>
    </div>
 
</form>
<form action="reporte_medico_grafico.php" target="_blank" method="POST">
   
        <h5><strong>REPORTE MENSUAL / GRÁFICO</strong></h5><hr>
    <div class="row">
        <div class="container">
            <div class="row">
              <div class="col-sm-4">
            <label>SELECCIONAR MES</label><br>
            <select class="form-control" name="mes" required="">
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
        <div class="col-sm-4">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-info">VER GRÁFICA</button>
         </div> 
            </div>
            <br>
        </div>
    </div>
    </div>
</form>
</section>
<!-- seccion de reporte anual -->
<section>
    <form action="pdf_anual.php" target="_blank" method="POST">
    <div class="container box">
        <h5><strong>REPORTE ANUAL</strong></h5><hr>
    <div class="row">
        <div class="container">
            <div class="row">
        <div class="col-sm-4">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-danger">PDF</button>
         </div> 
            </div>
        </div>
    </div>
    <br>
    
</form>
   <form action="anual_grafico.php" target="_blank" method="POST">
   
        <h5><strong>REPORTE ANUAL 15 PRINCIPALES DIAGNÓSTICOS/ GRÁFICO</strong></h5><hr>
    <div class="row">
        <div class="container">
            <div class="row">
        <div class="col-sm-4">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-info">VER GRÁFICA</button>
         </div> 
            </div>
        </div>
    </div>
    <br>
    </div>
</form>
</section>
<h3><center><strong>REPORTE POR DIAGNÓSTICO </strong></center></h3>
<!-- seccion de reporte por diagnostico mensual-->
<section>
    <form action="pdf_diagnostico_men.php" target="_blank" method="POST">
    <div class="container box">
        <h5><strong>REPORTE POR DIAGNÓSTICO MENSUAL</strong></h5><hr>
    <div class="row">
         <div class="col-sm-4">
      <label>DIAGNÓSTICO</label><br>
        <select name="diag" class="form-control" data-live-search="true" id="mibuscador" style="width : 100%; heigth : 100%">
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_diag ";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['diagnostico'] . "'>" . $row['diagnostico'] . "</option>";
}
 ?></select>
    </div>
        <div class="col-sm-3">
            <label>SELECCIONAR MES</label><br>
            <select class="form-control" name="mes" required="">
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
        <div class="col-sm-3">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-success">BUSCAR</button>
         </div> 
            </div>
    <br>
    </div>
</form>
</section>
<!-- seccion de reporte por diagnostico anual -->
<section>
    <form action="pdf_diagnostico.php?q=anio" target="_blank" method="POST">
    <div class="container box">
        <h5><strong>REPORTE POR DIAGNÓSTICO ANUAL</strong></h5><hr>
    <div class="row">
         <div class="col-sm-4">
      <label>DIAGNÓSTICO</label><br>
        <select name="diag" class="form-control" data-live-search="true" id="mibuscador4" style="width : 100%; heigth : 100%">
<?php
include "../../conexionbd.php";
$sql_diag="SELECT * FROM cat_diag ";
$result_diag=$conexion->query($sql_diag);
while($row=$result_diag->fetch_assoc()){
    echo "<option value='" . $row['diagnostico'] . "'>" . $row['diagnostico'] . "</option>";
}
 ?></select>
    </div>
        <div class="col-sm-4">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
       
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-success">BUSCAR</button>
         </div> 
            </div>
    <br>
    </div>
</form>
</section>

<h3><center><strong>REPORTE DE DIAGNÓSTICO POR MÉDICO </strong></center></h3>
<!-- seccion de reporte por diagnostico mensual-->
<section>
    <form action="pdf_med_mens.php" target="_blank" method="POST">
    <div class="container box">
        <h5><strong>REPORTE POR MÉDICO MENSUAL</strong></h5><hr>
    <div class="row">
         <div class="col-sm-4">
      <label>MÈDICO</label><br>
        <select name="id_usua" class="form-control" data-live-search="true" id="mibuscador2" style="width : 100%; heigth : 100%">
        
    <?php
     $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where id_rol=2 or id_rol=12 order by sapell ASC")or die($conexion->error);
     ?>
    <?php foreach ($resultado1 as $opciones):?>
    <option value="<?php echo $opciones['id_usua']?>"><?php echo $opciones['sapell']?> <?php echo $opciones ['papell']?> <?php echo $opciones['nombre']?></option>
  
                                           <?php endforeach?>
                                  </select>
    </div>
        <div class="col-sm-3">
            <label>SELECCIONAR MES</label><br>
            <select class="form-control" name="mes" required="">
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
            </select>
        </div>
        <div class="col-sm-3">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-success">BUSCAR</button>
         </div> 
            </div>
    <br>
    </div>
</form>
</section>
<!-- seccion de reporte por diagnostico anual -->
<section>
    <form action="pdf_med_anual.php" target="_blank" method="POST">
    <div class="container box">
        <h5><strong>REPORTE POR MÉDICO ANUAL</strong></h5><hr>
    <div class="row">
         <div class="col-sm-4">
      <label>MÉDICO</label><br>
        <select name="id_usua" class="form-control" data-live-search="true" id="mibuscador3" style="width : 100%; heigth : 100%">
             <?php
            $resultado1 = $conexion ->query("SELECT * FROM reg_usuarios where id_rol=2 or id_rol=12 order by sapell ASC")or die($conexion->error);
            ?>
            <?php foreach ($resultado1 as $opciones):?>
             <option value="<?php echo $opciones['id_usua']?>"><?php echo $opciones['sapell']?> <?php echo $opciones ['papell']?> <?php echo $opciones['nombre']?></option>
  <?php endforeach?>
                                  </select>
    </div>
        <div class="col-sm-4">
            <?php
            echo '<label>SELECCIONAR AÑO</label><br>';
    echo "<select name='anio' class='form-control'>";
        for($i=2021;$i<=date("Y");$i++)
        {
            echo "<option value='".$i."'>".$i."</option>";
        }
    echo "</select>";
    ?>
        </div>
       
         <div class="col-sm-4">
            <br><button type="submit" class="btn btn-success">BUSCAR</button>
         </div> 
            </div>
    <br>
    </div>
</form>
</section>

</div>
<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>
<!-- FastClick -->
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
<script>
    document.oncontextmenu = function () {
        return false;
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador2').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador3').select2();
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#mibuscador4').select2();
    });
</script>
</body>
</html>