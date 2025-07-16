<?php
session_start();
require "../../conexionbd.php";
require_once 'Curp.php';

// Check if the user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: ../../index.php?error=Por favor inicia sesión");
    exit();
}

// Set character encoding
$conexion->set_charset("utf8mb4");

$usuario = $_SESSION['login'];

// Function to calculate age based on birth date
function calcularEdad($fechaNacimiento) {
    $hoy = new DateTime();
    $nacimiento = new DateTime($fechaNacimiento);
    $edad = $hoy->diff($nacimiento);
    return $edad->y . " años";
}

$curpGenerator = new Curp();



// Sanitize and retrieve form data
$papell = mysqli_real_escape_string($conexion, $_POST['papell']);
$sapell = mysqli_real_escape_string($conexion, $_POST['sapell']);
$nom_pac = mysqli_real_escape_string($conexion, $_POST['nom_pac']);
$fecnac = $_POST['fecnac'];
$edad = calcularEdad($fecnac);
$id_edo_nac = $_POST['estado_nac'] === 'OT' ? 0 : (int)$_POST['estado_nac'];
$sexo = mysqli_real_escape_string($conexion, $_POST['sexo']);
$tip_san = mysqli_real_escape_string($conexion, $_POST['tipo_sangre']);
$nac = 'Mexicana'; // Nationality not provided in the form, set to empty
$id_edo = $_POST['estado_res'] === 'OT' ? 0 : (int)$_POST['estado_res'];
$id_mun = isset($_POST['municipios']) && $_POST['municipios'] !== '' ? (int)$_POST['municipios'] : 0;
$municipio_manual = $_POST['estado_res'] === 'OT' ? mysqli_real_escape_string($conexion, $_POST['municipio_manual']) : null;
$loc = mysqli_real_escape_string($conexion, $_POST['localidad']);
$dir = mysqli_real_escape_string($conexion, $_POST['dir']);
$ocup = ''; // Occupation not provided in the form, set to empty
$tel = mysqli_real_escape_string($conexion, $_POST['tel']);
$fecha = date('Y-m-d H:i:s');
$religion = mysqli_real_escape_string($conexion, $_POST['religion']);
$l_indigena = ''; // Indigenous language not provided, set to empty
$edociv = mysqli_real_escape_string($conexion, $_POST['edociv']);
$resp = mysqli_real_escape_string($conexion, $_POST['resp']);
$paren = mysqli_real_escape_string($conexion, $_POST['paren']);
$tel_resp = mysqli_real_escape_string($conexion, $_POST['tel_resp']);
$dom_resp = mysqli_real_escape_string($conexion, $_POST['dom_resp']);
$curp = $curpGenerator->generarCurp($papell, $sapell, $nom_pac, $fecnac, $sexo, $id_edo_nac);
$folio = 0; // Folio not provided, set to 0
$h_clinica = 'NO'; // Valor por defecto, puedes cambiar según el formulario
$INE = 'NO'; // Igual que arriba
$p_activo = 'SI'; // Paciente activo por defecto


// Start transaction
$conexion->begin_transaction();

try {
    // Insert into paciente table
    $sql_paciente = "INSERT INTO paciente (
        curp, papell, sapell, nom_pac, fecnac, edad, id_edo_nac, sexo, tip_san, nac, 
        id_edo, id_mun, municipio_manual, loc, dir, ocup, tel, fecha, h_clinica, religion, 
        l_indigena, edociv, resp, paren, tel_resp, dom_resp, INE, p_activo, folio
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";
    $stmt_paciente = $conexion->prepare($sql_paciente);
    $stmt_paciente->bind_param(
        "ssssssissssiisssssssssssssssi",
        $curp, $papell, $sapell, $nom_pac, $fecnac, 
        $edad, $id_edo_nac, $sexo, $tip_san, $nac,
        $id_edo, $id_mun, $municipio_manual, $loc, 
        $dir, $ocup, $tel, $fecha, $h_clinica, $religion,
        $l_indigena, $edociv, $resp, $paren, $tel_resp, $dom_resp, $INE, $p_activo, $folio
    );

    $stmt_paciente->execute();
    $id_exp = $conexion->insert_id; // Get the ID of the newly inserted patient
    $stmt_paciente->close();

    // Insert into dat_ingreso table
    $especialidad = mysqli_real_escape_string($conexion, $_POST['tipo_a']);
    $alergias = mysqli_real_escape_string($conexion, $_POST['alergias']);
    $tipo_a = '';
    $id_usua = $_POST['id_usua1'] === 'OTRO' || empty($_POST['id_usua1']) ? 0 : (int)$_POST['id_usua1'];
    $id_usua2 = isset($_POST['id_usua2']) && $_POST['id_usua2'] !== 'OTRO' && !empty($_POST['id_usua2']) ? (int)$_POST['id_usua2'] : null;
    $id_usua3 = isset($_POST['id_usua3']) && $_POST['id_usua3'] !== 'OTRO' && !empty($_POST['id_usua3']) ? (int)$_POST['id_usua3'] : null;
    $id_usua4 = isset($_POST['id_usua4']) && $_POST['id_usua4'] !== 'OTRO' && !empty($_POST['id_usua4']) ? (int)$_POST['id_usua4'] : null;
    $id_usua5 = isset($_POST['id_usua5']) && $_POST['id_usua5'] !== 'OTRO' && !empty($_POST['id_usua5']) ? (int)$_POST['id_usua5'] : null;
    $area = 'HOSPITALIZACION';
    $motivo_atn = mysqli_real_escape_string($conexion, $_POST['motivo_atn']);
    $cama = (int)$_POST['habitacion'];

    $sql_ingreso = "INSERT INTO dat_ingreso (
        Id_exp, fecha, especialidad, alergias, tipo_a, id_usua, area, motivo_atn, cama, 
        id_usua2, id_usua3, id_usua4, id_usua5
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";
    $stmt_ingreso = $conexion->prepare($sql_ingreso);
    // Use 'i' for integers and 's' for strings, with null handling for optional fields
    $stmt_ingreso->bind_param(
        "isssssssiiiii",
        $id_exp, $fecha, $especialidad, $alergias, $tipo_a, $id_usua, $area, $motivo_atn, $cama,
        $id_usua2, $id_usua3, $id_usua4, $id_usua5
    );
    $stmt_ingreso->execute();
    $id_atencion = $conexion->insert_id; // Get the ID of the newly inserted record
    $stmt_ingreso->close();

    // Update cama status to occupied and link to id_atencion
    $sql_update_cama = "UPDATE cat_camas SET estatus = 'OCUPADA', id_atencion = ? WHERE id = ?";
    $stmt_update_cama = $conexion->prepare($sql_update_cama);
    $stmt_update_cama->bind_param("ii", $id_atencion, $cama);
    $stmt_update_cama->execute();
    $stmt_update_cama->close();


    // Insert into dat_financieros table
    $aseg = (int)$_POST['aseg'];
    $cob = ''; // Cob not provided in the form, set to empty
    $aval = mysqli_real_escape_string($conexion, $_POST['aval']);
    $banco = mysqli_real_escape_string($conexion, $_POST['banco']);
    $cta_banco = 0; // cta_banco not provided, set to 0
    $deposito = (float)$_POST['deposito'];
    $dep_l = ''; // dep_l not provided, set to empty
    $fec_deposito = '';
    $total_cta = (float)$_POST['deposito']; // Assuming total_cta starts with the deposit amount
    $saldo = (float)$_POST['deposito']; // Assuming saldo starts with the deposit amount
    $id_usua_fin = $usuario['id_usua'];

    $sql_financieros = "INSERT INTO dat_financieros (
        id_atencion, aseg, cob, resp, dir_resp, id_edo, id_mun, tel, aval, banco, 
        cta_banco, deposito, dep_l, fec_deposito, total_cta, saldo, fecha, id_usua
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )";
    $stmt_financieros = $conexion->prepare($sql_financieros);
    $stmt_financieros->bind_param(
        "iisssiiisssidsddsi",
        $id_atencion, $aseg, $cob, $resp, $dom_resp, $id_edo, $id_mun, $tel_resp, $aval, $banco,
        $cta_banco, $deposito, $dep_l, $fec_deposito, $total_cta, $saldo, $fecha, $id_usua_fin
    );
    $stmt_financieros->execute();
    $stmt_financieros->close();

    // Insert into dat_ctapac table
    $prod_serv = $motivo_atn; // Using motivo_atn as the service description
    $insumo = 0; // Insumo not provided, set to 0
    $cta_fec = $fecha;
    $cta_cant = 1; // Assuming one unit of service
    $cta_tot = (float)$_POST['deposito']; // Using deposit as the total
    $centro_cto = ''; // centro_cto not provided, set to empty

    $sql_ctapac = "INSERT INTO dat_ctapac (
        id_atencion, prod_serv, insumo, cta_fec, cta_cant, cta_tot, id_usua, centro_cto
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?
    )";
    $stmt_ctapac = $conexion->prepare($sql_ctapac);
    $stmt_ctapac->bind_param(
        "isisiids",
        $id_atencion, $prod_serv, $insumo, $cta_fec, $cta_cant, $cta_tot, $id_usua_fin, $centro_cto
    );
    $stmt_ctapac->execute();
    $stmt_ctapac->close();

    // Commit the transaction
    $conexion->commit();

    // Redirect to a success page or back to the form with a success message
    header("Location: ../gestion_pacientes/registro_pac.php?success=Paciente registrado exitosamente");
    exit();

} catch (Exception $e) {
    // Rollback the transaction on error
    $conexion->rollback();
    // Redirect back with an error message
    header("Location: ../gestion_pacientes/registro_pac.php?error=Error al registrar el paciente: " . urlencode($e->getMessage()));
    exit();
}

// Close the database connection
$conexion->close();
?>