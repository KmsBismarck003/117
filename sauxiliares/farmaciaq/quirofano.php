<?php
session_start();
include "../../conexionbd.php";

// Verificar que el paciente esté seleccionado en la sesión, si no, redirigir
if (!isset($_SESSION['pac'])) {
    echo "<script>window.location.href='select_cama.php';</script>";  // Redirigir si no hay paciente seleccionado
    exit;
}

$usuario = $_SESSION['login'];

// Verificar el rol del usuario
if ($usuario['id_rol'] == 7 || $usuario['id_rol'] == 4 || $usuario['id_rol'] == 5) {
    include "../header_farmaciaq.php";  // Asegúrate de que la ruta sea correcta
} else {
    echo "<script>window.location='../../index.php';</script>";
    exit;
}

$id_atencion = $_SESSION['pac']; // Obtener el ID de atención del paciente desde la sesión

// Consulta para obtener los datos del paciente y la información preoperatoria
$query = "SELECT 
    p.nom_pac, 
    p.papell, 
    p.sapell, 
    ca.num_cama, 
    ca.habitacion,
    dn.nom_medi_cir, 
    dn.anestesia_sug, 
    dn.tipo_cirugia_preop, 
    dn.fecha_cir, 
    dn.hora_cir, 
    dn.fecha_preop
FROM 
    dat_not_preop dn
LEFT JOIN dat_ingreso di ON dn.id_atencion = di.id_atencion
LEFT JOIN paciente p ON di.Id_exp = p.Id_exp
LEFT JOIN cat_camas ca ON di.id_atencion = ca.id_atencion
WHERE ca.estatus = 'ocupada' AND di.id_atencion = ?";  // Filtrar por el paciente seleccionado

$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_atencion);  // Vincular el ID de atención a la consulta
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró algún paciente
if ($result->num_rows > 0) {
    $paciente = $result->fetch_assoc();
} else {
    $paciente = null;  // Si no se encuentra ningún paciente, asignar null
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="imagenes/SIF.PNG">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
<section class="content container-fluid">
    <div class="container box">
        <div class="content">
            <div class="thead" style="background-color: #0c675e; color: white; font-size: 20px;">
                <strong><center>DETALLE DEL PACIENTE Y PROCEDIMIENTO</center></strong>
            </div><br>

            <?php if ($paciente): ?>
                <table class="table table-bordered table-striped">
                    <thead style="background-color: #0c675e; color:white;">
                    <tr>
                        <th>Nombre del Paciente</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Número de Cama</th>
                        <th>Habitación</th>
                        <th>Médico Cirujano</th>
                        <th>Anestesiólogo</th>
                        <th>Tipo de Procedimiento</th>
                        <th>Fecha de Cirugía</th>
                        <th>Hora de Cirugía</th>
                        <th>Hora de Salida</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($paciente['nom_pac']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['papell']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['sapell']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['num_cama']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['habitacion']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['nom_medi_cir']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['anestesia_sug']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['tipo_cirugia_preop']); ?></td>
                        <td><?php echo htmlspecialchars(date("d-m-Y", strtotime($paciente['fecha_cir']))); ?></td>
                        <td><?php echo htmlspecialchars($paciente['hora_cir']); ?></td>
                        <td><?php echo htmlspecialchars($paciente['fecha_preop']); ?></td>
                    </tr>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-warning">No se encontró información disponible.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<footer class="main-footer">
    <?php include("../../template/footer.php"); ?>  <!-- Asegúrate que la ruta sea correcta -->
</footer>

<script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src='../../template/plugins/fastclick/fastclick.min.js'></script>
<script src="../../template/dist/js/app.min.js"></script>
</body>
</html>
