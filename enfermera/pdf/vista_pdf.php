<?php
session_start();
//include "../../conexionbd.php";
include "../header_enfermera.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
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
  <section class="content container-fluid">

    <div class="container box">
      <div class="content">


        <?php

        include "../../conexionbd.php";



        // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios";

        //  $result = $conn->query($sql);

        $resultado2 = $conexion->query("SELECT id_usua, curp_u, nombre, papell,sapell,fecnac,mat,cedp,cargp,email,u_activo FROM reg_usuarios") or die($conexion->error);
        ?>


        <!--Fin de los filtros-->

<center>
                    <a href="../../template/menu_enfermera.php" class="btn-sm btn-danger">REGRESAR...</a>
                   
                </center>
                <p>
                <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 24px;">
  <center><strong>IMPRESIÓN DE DOCUMENTOS (NOTAS DE ENFERMERIA)</strong></center><p>
</div> 
<?php
$usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {


  ?>
EXPEDIENTE: <strong><?php echo $row['Id_exp']; ?></strong>
NOMBRE: <strong><?php echo $row['nom_pac'] . ' ' . $row['papell'] . ' '. $row['sapell'];?></strong>

<?php }}?>


<div class="container" style="background-color:  #ffd1dc; color:#2b2d7f;">
  <div class="row">
    <div class="col-sm"><p></p>
        <?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              $id_atencion = $_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              

              ?>
<hr>
<strong>15. Enfermería</strong><p></p>
<?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_regclin.php"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'
                 
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_regclin.php"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
15.01 Hospitalización

<p></p>
<?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../registro_quirurgico/pdf_cirugia_segura.php?id=' . $row['id_atencion'] . '&id_exp=' . $row['Id_exp'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'

                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../registro_quirurgico/pdf_cirugia_segura.php?id=' . $row['id_atencion'] . '&id_exp=' . $row['Id_exp'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
15.02 Cirugía segura
<p></p>
      <?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_quir_area.php"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_quir_area.php"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
      15.03 Quirófano
<p></p>

<?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_pediatria.php"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'
                 
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_pediatria.php"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
15.06 Pediátrico/Neonatal
<p></p>
<?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_transpdf.php"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'

                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_transpdf.php"
                     ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
15.07 Transfusión sanguínea
<p></p>
<?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../registro_quirurgico/pdf_quirpiezas.php?id_atencion=' . $row['id_atencion'] . '&id_exp=' . $row['Id_exp'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../registro_quirurgico/pdf_quirpiezas.php?id_atencion=' . $row['id_atencion'] . '&id_exp=' . $row['Id_exp'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
15.08 Piezas Anatomopatológicas
<p></p>
<?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp  and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../signos_vitales/signos.php"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'
                  
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../signos_vitales/signos.php"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
15.09 Signos vitales

<p></p>
<?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
          
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_dietas.php"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'
                 
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../pdf/pdf_dietas.php"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
                  . '</tr>';
                $no++;
              }
              }
              ?>
<strong>16. Relación de dietas</strong>
<p></p>
<?php
              // ../../gestion_medica/cartas_consentimientos/pdf_consent_BI_medico.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '
              $id_atencion = $_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT * FROM paciente P, dat_ingreso DI WHERE DI.id_atencion=$id_atencion and P.Id_exp=DI.Id_exp ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                 echo '<tr>'

               
               . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../../gestion_medica/cartas_consentimientos/pdf_alta.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
                  </strong></td>';
                $no++;
              }
              ?>
<strong>17. Aviso de alta</strong>


    </div>
    
    
  </div>
</div>
   <!--     
        <div class="table-responsive">
     

          <table class="table table-bordered table-striped" id="mytable">
            <thead class="thead" style="background-color: #2b2d7f;color:white;">
              <tr>
                <th>Expediente</th>
                <th>Nombre del paciente</th>
                <th>Ficha de Identificación</th>
               
                <th>Registro Clínico de Enfermería</th>
                <th>Registro Clínico Enfermería Área Quirúrgica</th>
                <th>Registro Clínico Enfermería / Medicamentos y Equipos </th>
                <th>Registro Clínico Enfermería Unidad de Cuidados Intensivos </th>
                <th>Registro de Transfuciones Sanguíneas</th>
                  <th>Registro Clínico Neonatal</th>
              </tr>
            </thead>
            <tbody>

              <?php
              $usuario=$_SESSION['login'];
              $id_atencion=$_SESSION['pac'];
              // $sql = "SELECT id_usua, curp_u, nombre, papell,sapell,fecha,mat,cedp,cargp,email,u_activo FROM reg_usuarios;";
              //  $result = $conn->query($sql);
              $resultado2 = $conexion->query("SELECT P.Id_exp, P.nom_pac, P.papell, P.sapell, DI.id_atencion  FROM paciente P, dat_ingreso DI WHERE P.Id_exp=DI.Id_exp AND DI.activo ='SI' and DI.id_atencion=$id_atencion ") or die($conexion->error);

              $no = 1;
              while ($row = $resultado2->fetch_assoc()) {
                if ($usuario['id_rol']==5 || $usuario['id_rol']==12) {
                  echo '<tr>'
                  . '<td>' . $row['Id_exp'] . '</td>'
                  . '<td>' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac'] . '</td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../../gestion_administrativa/fichas/pdf_ficha_identifica.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'/*
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_dietas.php"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'*/
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_regclin.php"><span class="fa fa-file-pdf-o"></span></a>
              </strong>

              <a type="submit" class="btn btn-warning btn-sm" href="../vistas_update/vista_regclin.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_quir.php" ><span class="fa fa-file-pdf-o"></span></a>
              </strong>

              <a type="submit" class="btn btn-warning btn-sm" href="../vistas_update/vista_quirurgico.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_quir_area.php" ><span class="fa fa-file-pdf-o"></span></a>
              </strong></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../transfucion_de_sangre/pdf_transf.php?id_atencion=' . $row['id_atencion'] . '&id_exp=' . $row['Id_exp'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"></span></a>
              </strong>
              <a type="submit" class="btn btn-warning btn-sm" href="../vistas_update/vista_transangre.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../registro_clinico_neonatal/pdf_neonatal.php?id_atencion=' . $row['id_atencion'] . '&id_exp=' . $row['Id_exp'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"></span></a>
              </strong>
              <a type="submit" class="btn btn-warning btn-sm" href="../vistas_update/vista_neonatal.php"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>'

                  . '</tr>';
                $no++;
                }else{
                echo '<tr>'
                  . '<td>' . $row['Id_exp'] . '</td>'
                  . '<td>' . $row['papell'] . ' ' . $row['sapell'] . ' ' . $row['nom_pac'] . '</td>'
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../../gestion_administrativa/fichas/pdf_ficha_identifica.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'/*
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="pdf_dietas.php"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'*/
                  . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_regclin.php"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_quir.php" ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../vistas_doc/vista_quir_area.php" ><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../transfucion_de_sangre/pdf_transf.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'
              . '<td> <strong>
                  <a type="submit" class="btn btn-danger btn-sm"
                     href="../registro_clinico_neonatal/pdf_neonatal.php?id_exp=' . $row['Id_exp'] . '&id_atencion=' . $row['id_atencion'] . '"
                     target="_blank"><span class="fa fa-file-pdf-o"
                                           style="font-size:28px"></span></a>
              </strong></td>'

                  . '</tr>';
                $no++;
              }

              }

              ?>


            </tbody>
          </table>

        </div>
-->

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








</body>

</html>