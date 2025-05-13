<?php
session_start();

//include "../../conexionbd.php";
include "../header_imagen.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
<!DOCTYPE html>
<html>
<head>

<meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″/>

   

          <!--BOOTSTRAP CALENDAR-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<!--js CALENDAR-->
<script src="js/jquery.min.js"></script>
<script src="js/moment.min.js"></script>

<!--full CALENDAR-->

<link rel="stylesheet" href="css/fullcalendar.min.css">
<script src="js/fullcalendar.min.js"></script>
<script src="js/es.js"></script> <!--Idioma español Fullcalendar-->
   
<!--relog-->
<script src="js/bootstrap-clockpicker.js"></script>
<link rel="stylesheet" href="css/bootstrap-clockpicker.css">

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

</head>

<body>
     <?php
    if ($usuario1['id_rol'] == 4) {
        ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
           <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_sauxiliares.php">Regresar</a> 
        </div>
    </div>
</div>
        

        <?php
    } else if ($usuario1['id_rol'] == 8) {

        ?>
<div class="container">
    <div class="row">
        <div class="col-sm-4">
         <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_ceye.php">Regresar</a>   
        </div>
    </div>
</div>
        

        <?php
    }else if ($usuario1['id_rol'] == 5) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_gerencia.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    } else if ($usuario1['id_rol'] == 12) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_residente.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    }else if ($usuario1['id_rol'] == 3) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_enfermera.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    }else if ($usuario1['id_rol'] == 10) {

        ?>
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                <a type="submit" class="btn btn-danger btn-sm" href="../../template/menu_imagenologia.php">Regresar</a>    
                </div>
            </div>
        </div>
        

        <?php
    }


    ?>
        <br>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>PROGRAMACIÓN QUIRÚRGICA</center></strong>
      </div>
<hr>

<!--calendario-->



<div class="container">
<!--<div class="alerta">Valor seleccionado:
<input type="date" name="" disabled class="form-control">
</div>-->

    <div class="row">
        <div class="col-sm"><ol class="list-group list-group-numbered">
  <li class="list-group-item d-flex justify-content-between align-items-start">
       <center><span class="badge bg-light rounded-pill">Leyenda de agenda</span></center>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Pendiente </div>
    
    </div>
    <span class="badge bg-danger rounded-pill" style="font-size:40px;"> </span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Cancelado</div>
    </div>
    <span class="badge bg-secondary rounded-pill" style="font-size:40px;"> </span>
  </li>
  <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Quirófano 1</div>
    </div>
    <span class="badge bg-primary rounded-pill" style="font-size:40px;"> </span>
  </li>
   <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Quirófano 2</div>
    </div>
    <span class="badge bg-success rounded-pill" style="font-size:40px;"> </span>
  </li>
   <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Quirófano 3</div>
    </div>
    <span class="badge rounded-pill" style="background-color:#A305B0; font-size:40px;"> </span>
  </li>
   <li class="list-group-item d-flex justify-content-between align-items-start">
    <div class="ms-2 me-auto">
      <div class="fw-bold">Quirófano 4</div>
    </div>
    <span class="badge rounded-pill" style="background-color:#E09734; font-size:40px;"> </span>
  </li>
</ol>
</div>
        <div class="col-sm-7"><div id="CalendarioWeb"></div></div>
        <div class="col-sm"></div>
    </div>
</div>
<!-- fin calendario-->
<br>

<script>
$(document).ready(function(){
    $('#CalendarioWeb').fullCalendar({
        
header:{
                left:'month,agendaWeek,agendaDay',
                center:'title',
                rigth:'today,prev,next'
            },
            dayClick:function(date,jsEvent,view){
            $('#btnAgregar').prop("hidden",false);
              $('#btnModificar').prop("hidden",true);
                 $('#btnEliminar').prop("hidden",true);
                $('#btnCancelar').prop("hidden",true);
                $('#btnReprogramar').prop("hidden",true);
                limpiarFormulario();
                $('#txtFecha').val(date.format());
                $('#txtfechaend').val(date.format());
                

                $("#ModalEventos").modal();

            }, 

events:'eventos.php',

eventClick:function(calEvent,jsEvent,view){
    $('#btnAgregar').prop("hidden",true);
   $('#btnModificar').prop("hidden",false);
    $('#btnEliminar').prop("hidden",false);
    $('#btnCancelar').prop("hidden",false);
$('#btnReprogramar').prop("hidden",false);

//h5
    $('#tituloEvento').html(calEvent.title);
//info del evento en inputs
$('#txtDescripcion').val(calEvent.descripcion);
$('#txtID').val(calEvent.id);
$('#txtTitulo').val(calEvent.title);
$('#txtColor').val(calEvent.color);
$('#txtTipo').val(calEvent.tipo);
$('#txtMedico').val(calEvent.medico);
$('#txtEnf').val(calEvent.enfermera);
$('#txtquirofano').val(calEvent.quirofano);
$('#txtdur').val(calEvent.duracion);
$('#txtMotivo').val(calEvent.motivo);

FechaHora=calEvent.start._i.split(" ");
$('#txtFecha').val(FechaHora[0]);
$('#txtHora').val(FechaHora[1]);


Fechahoraend=calEvent.end._i.split(" ");
$('#txtfechaend').val(Fechahoraend[0]);
$('#txthoraend').val(Fechahoraend[1]);



    $("#ModalEventos").modal();
},
editable:false,
eventDrop:function(calEvent){
$('#txtID').val(calEvent.id);
$('#txtTitulo').val(calEvent.title);
$('#txtColor').val(calEvent.color);
$('#txtDescripcion').val(calEvent.descripcion);
$('#txtTipo').val(calEvent.tipo);
$('#txtMedico').val(calEvent.medico);
$('#txtEnf').val(calEvent.enfermera);
$('#txtquirofano').val(calEvent.quirofano);
$('#txtdur').val(calEvent.duracion);
$('#txtMotivo').val(calEvent.motivo);


var fechaHora=calEvent.start.format().split("T");
$('#txtFecha').val(fechaHora[0]);
$('#txtHora').val(fechaHora[1]);

var fechahoraend=calEvent.end.format().split("T");
$('#txtfechaend').val(fechahoraend[0]);
$('#txthoraend').val(fechahoraend[1]);



RecolectarDatosGUI();
EnviarInformacion('modificar',NuevoEvento,true);

RecolectarDatosGUI();
EnviarInformacion('reprogramar',NuevoEvento,true);
}


    });

});
</script>


<!-- Modal(AGREGAR, MODIFICAR ELIMINAR) -->
<div class="modal fade bd-example-modal-lg" id="ModalEventos" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tituloEvento"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
   
         <input type="hidden" name="txtID" id="txtID" class="form-control" disabled>
         <div class="container">
  <div class="row">
   
    <div class="col-sm-6">
    <strong>Fecha:</strong><input type="text" name="txtFecha" id="txtFecha" class="form-control" disabled>
    </div>
    <div class="col-sm-6">
    <strong>Quirófano</strong><select class="form-control" id="txtquirofano" name="txtquirofano" disabled>
        <option value="">Seleccionar Quirófano</option>
<option value="Quirofano 1">Quirófano 1</option>
<option value="Quirofano 2">Quirófano 2</option>
<option value="Quirofano 3">Quirófano 3</option>
<option value="Quirofano 4">Quirófano 4</option>
         </select>
    </div>
</div>
</div>
    <p>
   <div class="container">
  <div class="row">
   
    <div class="col-sm-9">
     <strong>Nombre del paciente:</strong><input type="text" name="txtTitulo" id="txtTitulo" class="form-control" disabled>
    </div>
    <div class="col-sm-3">
    <strong>Hora Inicio:</strong>
    <div class="input-group">
        <input type="time" value="" name="txtHora" id="txtHora" class="form-control" disabled>
    </div>
    

    </div>
  </div>
</div>
<p>


<div class="container">
  <div class="row">
    <div class="col-sm-6">
    <strong>Cirugía programada:</strong><input type="text" id="txtTipo" name="txtTipo" class="form-control" disabled>
    </div>
    <div class="col-sm">
    <strong>Nombre del médico cirujano:</strong><input type="text" id="txtMedico" name="txtMedico" class="form-control" style="height: 36px;" disabled>
    </div>
  </div>
</div>
<p>
    <div class="container">
  <div class="row">
    <div class="col-sm-6">
    <strong>Enfermera que programa:</strong><input type="text" id="txtEnf" name="txtEnf" class="form-control" disabled>
    </div>
     <div class="col-sm-6">
    <strong>Duración aproximada:</strong><input type="text" id="txtdur" name="txtdur" class="form-control" disabled>
    </div>
  </div>
</div>
<p>
    <div class="container">
  <div class="row">
    <div class="col-sm-4">
      <div class="form-group">
       <label for="txtfechaend"><strong>Fecha final</strong></label>
       <input type="date" name="txtfechaend" class="form-control" id="txtfechaend" disabled>
     </div>
    </div>
    
    <div class="col-sm-4">
      <div class="form-group">
       <label for="txthoraend"><strong>Hora final</strong></label>
       <input type="time" name="txthoraend" class="form-control" id="txthoraend" disabled>
     </div>
    </div>
    
    </div>
    </div>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
    <strong>Observaciones (Material, equipo de laparoscopia, fluoroscopio, etc.):</strong><textarea id="txtDescripcion" rows="2" class="form-control"disabled></textarea>
    </div>
    <!--<div class="col-sm-3">
    <strong>Color:</strong><input type="color" id="txtColor" value="#ff0000" name="" class="form-control" style="height: 36px;">
    </div>-->
  </div>
</div>
<p>
<?php
$resultado2 = $conexion->query("SELECT * from agenda") or die($conexion->error);

while ($row = $resultado2->fetch_assoc()) {
$estatus1=$row['estatus'];
}
?>

<?php 

if ($estatus1=="Cancelada" or $estatus1=="Reprogramada"){
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
    <strong>Motivo de reprogramación:</strong><textarea id="txtMotivo" rows="2" class="form-control"></textarea>
    </div>
  </div>
</div>
<?php  } ?>


<hr>
      </div>
      <!--<div class="modal-footer">

        <button type="button" id="btnAgregar" class="btn btn-success btn-sm">Programar</button>
        <button type="submit" id="btnReprogramar" class="btn btn-primary btn-sm">Reprogramar</button>
        <button type="submit" id="btnModificar" class="btn btn-primary btn-sm">Programar</button>
        <button type="button" id="btnEliminar" class="btn btn-danger btn-sm">Borrar</button>
        <button type="button" id="btnCancelar" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Regresar</button>

      </div>-->
    </div>
  </div>
</div>

</div>
<footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
</footer>





<!-- AdminLTE App -->
<script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

<script>
var NuevoEvento;

$('#btnAgregar').click(function(){
RecolectarDatosGUI();
EnviarInformacion('agregar',NuevoEvento);
});

$('#btnEliminar').click(function(){
RecolectarDatosGUI();
EnviarInformacion('eliminar',NuevoEvento);
});

$('#btnModificar').click(function(){
RecolectarDatosGUI();
EnviarInformacion('modificar',NuevoEvento);
});

$('#btnCancelar').click(function(){
RecolectarDatosGUI();
EnviarInformacion('cancelar',NuevoEvento);
});

$('#btnReprogramar').click(function(){
RecolectarDatosGUI();
EnviarInformacion('reprogramar',NuevoEvento);
});



function RecolectarDatosGUI(){

if ($('#txtquirofano').val()=="Quirofano 1") {
NuevoEvento= {
id:$('#txtID').val(),
title:$('#txtTitulo').val(),
start:$('#txtFecha').val()+" "+$('#txtHora').val(),
color:"#056AB0",
descripcion:$('#txtDescripcion').val(),
textColor:"#FFFFFF",
end: $('#txtfechaend').val()+" "+$('#txthoraend').val(),
tipo:$('#txtTipo').val(),
medico:$('#txtMedico').val(),
enfermera:$('#txtEnf').val(),
quirofano:$('#txtquirofano').val(),
duracion:$('#txtdur').val(),
motivo:$('#txtMotivo').val()


         }
    }

if ($('#txtquirofano').val()=="Quirofano 2") {
NuevoEvento= {
id:$('#txtID').val(),
title:$('#txtTitulo').val(),
start:$('#txtFecha').val()+" "+$('#txtHora').val(),
color:"#29B005",
descripcion:$('#txtDescripcion').val(),
textColor:"#FFFFFF",
end: $('#txtfechaend').val()+" "+$('#txthoraend').val(),
tipo:$('#txtTipo').val(),
medico:$('#txtMedico').val(),
enfermera:$('#txtEnf').val(),
quirofano:$('#txtquirofano').val(),
duracion:$('#txtdur').val(),
motivo:$('#txtMotivo').val()
         }
    }

if ($('#txtquirofano').val()=="Quirofano 3") {
NuevoEvento= {
id:$('#txtID').val(),
title:$('#txtTitulo').val(),
start:$('#txtFecha').val()+" "+$('#txtHora').val(),
color:"#A305B0",
descripcion:$('#txtDescripcion').val(),
textColor:"#FFFFFF",
end: $('#txtfechaend').val()+" "+$('#txthoraend').val(),
tipo:$('#txtTipo').val(),
medico:$('#txtMedico').val(),
enfermera:$('#txtEnf').val(),
quirofano:$('#txtquirofano').val(),
duracion:$('#txtdur').val(),
motivo:$('#txtMotivo').val()
         }
    }

    if ($('#txtquirofano').val()=="Quirofano 4") {
NuevoEvento= {
id:$('#txtID').val(),
title:$('#txtTitulo').val(),
start:$('#txtFecha').val()+" "+$('#txtHora').val(),
color:"#E09734",
descripcion:$('#txtDescripcion').val(),
textColor:"#FFFFFF",
end: $('#txtfechaend').val()+" "+$('#txthoraend').val(),
tipo:$('#txtTipo').val(),
medico:$('#txtMedico').val(),
enfermera:$('#txtEnf').val(),
quirofano:$('#txtquirofano').val(),
duracion:$('#txtdur').val(),
motivo:$('#txtMotivo').val()
         }
    }

}

function EnviarInformacion(accion,ObjEvento,modal){
    $.ajax({
type:'POST',
url:'eventos.php?accion='+accion,
data:ObjEvento,
success:function(msg){
    if(msg){
        $('#CalendarioWeb').fullCalendar('refetchEvents');
        if(!modal){
        $("#ModalEventos").modal('toggle');
        }
        
 }
},
error:function(){
    alert("Hay un error..");
}

    });
}

$('.clockpicker').clockpicker();

function limpiarFormulario(){

    $('#txtID').val('');
    $('#txtTitulo').val('');
    $('#txtColor').val('');
    $('#txtDescripcion').val('');
    $('#txtHora').val('');
    $('#txtFecha').val('');
    $('#txtfechaend').val('');
    $('#txthoraend').val('');
    $('#txtTipo').val('');
    $('#txtMedico').val('');
    $('#txtEnf').val('');
    $('#txtquirofano').val('');
    $('#txtdur').val('');
    $('#txtMotivo').val('');
    
}

</script>

</body>
</html>