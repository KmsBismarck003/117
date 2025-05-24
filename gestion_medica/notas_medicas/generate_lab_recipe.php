<?php
require_once "../../vendor/autoload.php";

use Dompdf\Dompdf;

session_start();
include "../../conexionbd.php";

if (!isset($_SESSION['hospital'])) {
    header("Location: ../login.php");
    exit();
}

$id_atencion = $_SESSION['hospital'];
$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.fecnac, p.Id_exp, p.folio, di.fecha FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp AND di.id_atencion = ?";
$stmt = $conexion->prepare($sql_pac);
$stmt->bind_param("i", $id_atencion);
$stmt->execute();
$result_pac = $stmt->get_result();
$row_pac = $result_pac->fetch_assoc();
$pac_papell = $row_pac['papell'];
$pac_sapell = $row_pac['sapell'];
$pac_nom_pac = $row_pac['nom_pac'];
$pac_fecnac = $row_pac['fecnac'];
$folio = $row_pac['folio'];
$pac_fecing = $row_pac['fecha'];
$id_exp = $row_pac['Id_exp'];
$stmt->close();

$studies = [];
if (!empty($_POST['biometria_hematica'])) $studies[] = "Biometría Hemática";
if (!empty($_POST['quimica_sanguinea'])) $studies[] = "Química Sanguínea (" . $_POST['quimica_sanguinea_valores'] . " elementos)";
if (!empty($_POST['tiempos_coagulacion'])) $studies[] = "Tiempos de Coagulación (TP/TT)";
if (!empty($_POST['hemoglobina_glucosilada'])) $studies[] = "Hemoglobina Glucosilada";
if (!empty($_POST['examen_general_orina'])) $studies[] = "Examen General de Orina";
if (!empty($_POST['electroitos_sericos'])) $studies[] = "Electrolitos Séricos";
if (!empty($_POST['pruebas_funcion_tiroidea'])) $studies[] = "Pruebas de Función Tiroidea";
if (!empty($_POST['otros_laboratorio'])) $studies[] = trim($_POST['otros_laboratorio']);

$studies_list = implode("\n", $studies);

$fecha_actual = date("d/m/Y H:i:s");
$medico = "Francisco Uriel Martinez Gonzalez";

$html = <<<EOD
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud de Estudios de Laboratorio</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; }
        .details { margin-top: 20px; }
        .signature { margin-top: 50px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <img src="https://via.placeholder.com/50" alt="Hospital Logo">
        <h3>Médica San Isidro</h3>
        <p>Calle José Ortiz de Domínguez #444, Coaxustenco, Metepec Estado de México C.P. 52140<br>Tel: (722) 235 0175 / 235 0212 / 902 0390<br>https://medicasanisidro.com</p>
        <p>Especialidad M.C. Eva María Ortiz Ramírez<br>R.F.C. 30610565 C.E. 4860151<br>Universidad Nacional Autónoma de México<br>Licencia Sanitaria 17-AM-15-054-0003</p>
    </div>
    <div class="details">
        <h4>SOLICITUD DE ESTUDIOS DE LABORATORIO</h4>
        <p>Paciente: $folio - $pac_papell $pac_sapell $pac_nom_pac</p>
        <p>Signos vitales:<br>Presión arterial: /mmHG &nbsp; Frecuencia respiratoria: Resp/min &nbsp; Temperatura: °C &nbsp; Saturación oxígeno: %</p>
        <p>Edad: 35 años &nbsp; Sexo: Mujer &nbsp; Fecha de ingreso: $fecha_actual</p>
        <p>Fecha de solicitud: 20/05/2025 14:47 pm &nbsp; Fecha y hora de solicitud: 20/05/2025 16:06 pm</p>
        <p>Médico tratante: Cédula Prof.</p>
        <p>Solicita: $medico</p>
        <p>Estudio(s) solicitado(s):</p>
        <p>$studies_list</p>
        <p>Detalle de estudio:</p>
        <p>Diagnóstico probable: Consulta</p>
        <p>Solicita: Dr. Francisco Uriel Martinez Gonzalez</p>
    </div>
    <div class="signature">
        <p>_____________________<br>Página 1/1</p>
    </div>
</body>
</html>
EOD;

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("solicitud_estudios_" . $folio . ".pdf", array("Attachment" => 0));
?>