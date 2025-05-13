<?php
session_start();
//include "../../conexionbd.php";
include "../header_administrador.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$id_atencion=$_GET['id_atencion'];
$id_exp=$_GET['id_exp'];
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="gb18030">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!--  Bootstrap  -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <script src="../../js/jquery-3.3.1.min.js"></script>
  <script src="../../js/jquery-ui.js"></script>
  <script src="../../js/popper.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/jquery.magnific-popup.min.js"></script>
  <script src="../../js/aos.js"></script>
  <script src="../../js/main.js"></script>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search").keyup(function() {
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#mytable tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>

  <title>DOCUMENTACIÓN </title>

</head>
<!--seccion urgencias-->

<body>

  <section class="container">

    
          <a href="pac_global.php" class="btn-sm btn-danger">Regresar...</a>
   
     <p>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 22px;">
  <center><strong>IMPRESIÓN DE DOCUMENTOS</strong></center><p>
</div> 
     <div class="container">

     <?php

        include "../../conexionbd.php";

        
        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        ?>

        <!--Fin de los filtros-->
       

           <?php
        //      $id_atencion = $_SESSION['hospital'];
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'
                  . '<td>' . 'Expediente: '. '</td>' 
                  . '<td><strong>' . $row['folio'] . '</strong></td>'
                  . '<td>' . '  Paciente: '. '</td>' 
                  . '<td><strong>' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac'] . '</strong></td><br>'
                  . '</tr>';
                $no++;
              }

              ?>
             <hr>
       </div>
  </section>


<section class="Container">

  
    <div class="container box">
    

        <?php

        include "../../conexionbd.php";

        // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

        //  $result = $conn->query($sql);

        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        ?>

        <!--Fin de los filtros-->
       
      
        

<div class="container" style="background-color:  #5880B4; color:white;">
  <div class="row" >
    <div class="col" >
     <p></p>
 <?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             // $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../../gestion_administrativa/cartas_consentimientos/pdf_hoja_inicial.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                       style="font-size:20px"></span></a>
                  </strong></td>';
                
                


                $no++;
              }

              ?>

              <strong>1. Hoja Inicial</strong>
              <p><p>
                       
             <?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             // $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../../gestion_administrativa/cartas_consentimientos/pdf_hoja_frontal.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                       style="font-size:20px"></span></a>
                  </strong></td>';
                
                
                $no++;
              }

              ?>
               <strong>2. Hoja Frontal </strong>
              <p><p>
              <?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="./buscar_hc.php?id_exp=' .$row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';

                $no++;
              }

              ?>
      <strong>3. Historia clínica  </strong>
              <hr>

<strong>4. Observación</strong>
      <p></p>   


      <strong>5. Notas médicas</strong>
      <p></p>
<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             // $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="vista_ingreso.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                
                


                $no++;
              }

              ?>
5.01 Nota de ingreso  
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_evo_pdf.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                
                


                $no++;
              }

              ?>

5.02 Notas de evolución
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_inter_pdf.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
     

5.03 Nota de interconsulta
<p></p>



       <?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             // $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_traslado.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>


5.04 Nota de referencia/traslado
<p></p>

       <?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_neona_pdf.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>


5.05 Nota neonatológica
<p></p>



       <?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_parto_pdf.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>


5.06 Partograma
<p></p>


<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_egreso.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>

5.07 Nota de egreso
<p></p>



<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_nutricion.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
5.08 Nota de nutrición
<p></p>


<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_def.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>



5.09 Nota de defunción/muerte fetal
<p></p>
<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_resumen.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
5.10 Resumen clínico
<hr>

 </div>

    <div class="col">
      <p></p>

<strong>6. Notas quirúrgicas</strong>
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_notapreop_pdf.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>


6.01 Nota preoperatoria
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_notinquir_pdf.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>


6.02 Nota de descripción quirúrgica
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             // $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_notinquir_pdf.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
6.03 Nota postoperatoria
<p></p>
<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_notapreopqx_pdf.php?id_exp=' . $row['Id_exp'] . '&id=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>


6.04 Programación quirúrgica
<p></p>
<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             // $id_atencion = $_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="../global_pac/vista_hpquir.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>


6.05 Hoja de Programación quirúrgica

<hr>
<strong>7. Notas anestésicas</strong>
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_valpre_pdf.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
7.01 Nota pre-anestésica
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_2daev_pdf.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
7.02 Evaluación pre-anestésica
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_trans_pdf.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>

7.03 Registro descriptivo trans-anestésico

<p></p>

<?php/*
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../nota_anestesica/nota_registro_grafico.php"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }*/
              ?>
<!--7.04 Registro Gráfico tras antestésico-->
<p></p>


<?php
               //../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
            // $id_atencion = $_SESSION['hospital'];
               //$sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
               // $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_recup_pdf.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>

7.05 Hoja anestésia completa
<p></p>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                    href="vista_postanest_pdf.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>

7.05 Nota post-anestésica
<hr>


<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
             // $id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="vista_ordenes_med.php?Id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
<strong>8. Indicaciones Médicas</strong>
<hr>
 <!--<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../estudios/estudios.php"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:18px"></span></a>
                  </strong></td>
<strong>9. Resultados de estudios</strong>
<hr>--><!--
<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_alta.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
<strong>10. Aviso de alta</strong>-->
<!--<hr>

<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              //$id_atencion = $_SESSION['hospital'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/vista_recetas_med.php"
                     target=""><span class="fa fa-file-pdf-o"
                                           style="font-size:20px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
<strong>11. Recetas hospitalización </strong>-->

 </div>


<div class="col">
      <p></p>


<p></p>

</div>
<!-- 3ER COLUMNA TERMINO-->
  </div>
</div>
<BR>

  </section>


  </div>

  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>

  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>


</strong><script language=javascript>
function closer() {
var ventana = window.self;
ventana.opener = window.self;
ventana.close();
}
</script>





</body>

</html>