<?php
session_start();
include "../../conexionbd.php";

// Verificar que haya un paciente seleccionado
if (!isset($_SESSION['pac']) || empty($_SESSION['pac'])) {
    $_SESSION['mensaje_error'] = 'No hay paciente seleccionado';
    header('Location: nota_registro_grafico.php');
    exit;
}

// Procesar POST ANTES de cualquier output HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_atencion = $_SESSION['pac'];
        
        // Primero verificar si la cirugía está cancelada
        $check_cancelada = $conexion->query("SELECT cancelada FROM dat_ingreso WHERE id_atencion=$id_atencion");
        
        if (!$check_cancelada) {
            throw new Exception("Error al verificar estado: " . $conexion->error);
        }
        
        $row_cancelada = $check_cancelada->fetch_assoc();
        
        // Si está cancelada, quitar la cancelación primero
        if ($row_cancelada && $row_cancelada['cancelada'] === 'SI') {
            $update_cancelacion = $conexion->query("UPDATE dat_ingreso 
                                                   SET cancelada = NULL, 
                                                       fecha_cancelacion = NULL, 
                                                       usuario_cancelacion = NULL 
                                                   WHERE id_atencion=$id_atencion");
            
            if (!$update_cancelacion) {
                throw new Exception("Error al quitar cancelación: " . $conexion->error);
            }
        }
        
        // Verificación de duplicados para terminación
        $check = $conexion->query("SELECT id_trans_graf FROM dat_trans_grafico 
                                  WHERE id_atencion=$id_atencion AND sistg='CIRUGIA' AND diastg='TERMINADA' LIMIT 1");
        
        if ($check && $check->num_rows > 0) {
            throw new Exception('La cirugía ya ha sido marcada como terminada anteriormente');
        }
        
        // Insertar registro de terminación
        $hora_actual = date('H:i:s');
        $insert = $conexion->query("INSERT INTO dat_trans_grafico 
                                   (id_atencion, id_usua, sistg, diastg, fcardg, frespg, satg, tempg, hora) 
                                   VALUES ($id_atencion, 1, 'CIRUGIA', 'TERMINADA', 'BLOQUEADO', 'BLOQUEADO', 'BLOQUEADO', 'BLOQUEADO', '$hora_actual')");
        
        if ($insert) {
            // Marcar en sesión inmediatamente
            $_SESSION['cirugia_terminada_' . $id_atencion] = true;
            $_SESSION['mensaje_exito'] = 'Cirugía terminada exitosamente';
            
            // Redirección HTTP
            header('Location: nota_registro_grafico.php');
            exit;
        } else {
            throw new Exception("Error en la base de datos: " . $conexion->error);
        }
        
    } catch (Exception $e) {
        $_SESSION['mensaje_error'] = $e->getMessage();
        header('Location: nota_registro_grafico.php');
        exit;
    }
}

// Solo después del procesamiento, incluir header para la vista
include("../header_enfermera.php");

// Si llegamos aquí, es GET - mostrar la vista frontend
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $id_atencion = $_SESSION['pac'];
    $usuario = $_SESSION['login']['nombre'] ?? 'Usuario Sistema';

    // Obtener información del paciente
    $sql_paciente = "SELECT p.*, di.especialidad, di.area, di.motivo_atn, di.fecha, di.cancelada, di.fecha_cancelacion, di.usuario_cancelacion
                     FROM paciente p 
                     INNER JOIN dat_ingreso di ON p.Id_exp = di.Id_exp 
                     WHERE di.id_atencion = ?";
    $stmt_pac = $conexion->prepare($sql_paciente);
    $stmt_pac->bind_param("i", $id_atencion);
    $stmt_pac->execute();
    $paciente = $stmt_pac->get_result()->fetch_assoc();

    // Verificar si ya está terminada
    $sql_terminada = "SELECT COUNT(*) as count FROM dat_trans_grafico WHERE id_atencion = ? AND sistg = 'CIRUGIA' AND diastg = 'TERMINADA'";
    $stmt_term = $conexion->prepare($sql_terminada);
    $stmt_term->bind_param("i", $id_atencion);
    $stmt_term->execute();
    $ya_terminada = $stmt_term->get_result()->fetch_assoc()['count'] > 0;

    $esta_cancelada = $paciente && $paciente['cancelada'] === 'SI';
    $puede_terminar = $esta_cancelada && !$ya_terminada;

    function calculaedad($fechanacimiento) {
        list($ano, $mes, $dia) = explode("-", $fechanacimiento);
        $ano_diferencia = date("Y") - $ano;
        $mes_diferencia = date("m") - $mes;
        $dia_diferencia = date("d") - $dia;
        if ($ano_diferencia > 0) {
            return ($ano_diferencia . " Años");
        }
        return "0 Años";
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminación de Cirugía - Sistema INEO</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <link rel="stylesheet" href="../../css/estilos.css">
    
    <style>
        .status-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .info-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-left: 4px solid #007bff;
        }
        
        .patient-info {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 10px;
            padding: 20px;
            margin: 15px 0;
        }
        
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 0.85em;
        }
        
        .badge-success { background: #28a745; color: white; }
        .badge-warning { background: #ffc107; color: #212529; }
        .badge-danger { background: #dc3545; color: white; }
        .badge-info { background: #17a2b8; color: white; }
        
        .action-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1.1em;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(40,167,69,0.3);
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40,167,69,0.4);
            color: white;
        }
        
        .action-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .process-step {
            display: flex;
            align-items: center;
            padding: 15px;
            margin: 10px 0;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid #17a2b8;
        }
        
        .step-icon {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 1.1em;
        }
        
        .step-completed { background: #28a745; color: white; }
        .step-pending { background: #ffc107; color: #212529; }
        .step-blocked { background: #dc3545; color: white; }
        .step-ready { background: #17a2b8; color: white; }
    </style>
</head>

<body>
    <div class="container mt-4">
        <!-- Header -->
        <div class="status-card">
            <div class="text-center">
                <h2><i class="fas fa-procedures"></i> Terminación de Cirugía</h2>
                <p class="mb-0">Sistema de Gestión Quirúrgica INEO</p>
            </div>
        </div>

        <?php if ($paciente): ?>
        <!-- Información del Paciente -->
        <div class="info-card">
            <h4><i class="fas fa-user-injured text-primary"></i> Información del Paciente</h4>
            <div class="patient-info">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Expediente:</strong> <?php echo $paciente['folio']; ?><br>
                        <strong>Paciente:</strong> <?php echo $paciente['nom_pac'] . ' ' . $paciente['papell'] . ' ' . $paciente['sapell']; ?><br>
                        <strong>Género:</strong> <?php echo $paciente['sexo']; ?><br>
                        <strong>Edad:</strong> <?php echo calculaedad($paciente['fecnac']); ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Fecha Ingreso:</strong> <?php echo date('d/m/Y', strtotime($paciente['fecha'])); ?><br>
                        <strong>Especialidad:</strong> <?php echo $paciente['especialidad']; ?><br>
                        <strong>Área:</strong> <?php echo $paciente['area']; ?><br>
                        <strong>ID Atención:</strong> <?php echo $id_atencion; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estado Actual -->
        <div class="info-card">
            <h4><i class="fas fa-chart-pulse text-primary"></i> Estado Actual de la Cirugía</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <strong class="mr-3">Estado de Cancelación:</strong>
                        <?php if ($esta_cancelada): ?>
                            <span class="status-badge badge-warning">
                                <i class="fas fa-exclamation-triangle"></i> Cancelada
                            </span>
                        <?php else: ?>
                            <span class="status-badge badge-success">
                                <i class="fas fa-check-circle"></i> Activa
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <?php if ($esta_cancelada): ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i>
                            <strong>Cancelada el:</strong> <?php echo $paciente['fecha_cancelacion']; ?><br>
                            <strong>Por:</strong> <?php echo $paciente['usuario_cancelacion']; ?>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        <strong class="mr-3">Estado de Terminación:</strong>
                        <?php if ($ya_terminada): ?>
                            <span class="status-badge badge-success">
                                <i class="fas fa-check-double"></i> Terminada
                            </span>
                        <?php else: ?>
                            <span class="status-badge badge-info">
                                <i class="fas fa-hourglass-half"></i> Pendiente
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proceso de Terminación -->
        <div class="info-card">
            <h4><i class="fas fa-list-check text-primary"></i> Proceso de Terminación</h4>
            
            <div class="process-step">
                <div class="step-icon step-completed">
                    <i class="fas fa-check"></i>
                </div>
                <div>
                    <strong>Verificación de Sesión</strong><br>
                    <small class="text-muted">Paciente y usuario autenticados correctamente</small>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-icon <?php echo $esta_cancelada ? 'step-pending' : 'step-ready'; ?>">
                    <i class="fas <?php echo $esta_cancelada ? 'fa-undo' : 'fa-info'; ?>"></i>
                </div>
                <div>
                    <strong>Eliminación de Cancelación</strong><br>
                    <small class="text-muted">
                        <?php echo $esta_cancelada ? 'Pendiente: Eliminar estado de cancelación' : 'No aplica: Cirugía no cancelada'; ?>
                    </small>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-icon <?php echo $ya_terminada ? 'step-blocked' : 'step-ready'; ?>">
                    <i class="fas <?php echo $ya_terminada ? 'fa-ban' : 'fa-search'; ?>"></i>
                </div>
                <div>
                    <strong>Verificación de Duplicados</strong><br>
                    <small class="text-muted">
                        <?php echo $ya_terminada ? 'Bloqueado: Ya terminada anteriormente' : 'Listo: No hay duplicados'; ?>
                    </small>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-icon <?php echo $puede_terminar ? 'step-ready' : ($ya_terminada ? 'step-completed' : 'step-pending'); ?>">
                    <i class="fas <?php echo $puede_terminar ? 'fa-play' : ($ya_terminada ? 'fa-check' : 'fa-pause'); ?>"></i>
                </div>
                <div>
                    <strong>Inserción de Registro</strong><br>
                    <small class="text-muted">
                        <?php 
                        if ($puede_terminar) echo 'Listo: Preparado para ejecutar';
                        elseif ($ya_terminada) echo 'Completado: Registro ya insertado';
                        else echo 'Pendiente: Esperando condiciones previas';
                        ?>
                    </small>
                </div>
            </div>
        </div>

        <!-- Acción -->
        <div class="info-card text-center">
            <h4><i class="fas fa-play-circle text-primary"></i> Acción de Terminación</h4>
            
            <?php if ($puede_terminar): ?>
                <div class="alert alert-info mb-4">
                    <i class="fas fa-lightbulb"></i>
                    <strong>¡Listo para Terminar!</strong><br>
                    La cirugía está cancelada y puede ser terminada ahora.
                </div>
                
                <form method="POST" onsubmit="return confirmarTerminacion()">
                    <button type="submit" class="action-btn">
                        <i class="fas fa-check-circle mr-2"></i>
                        Terminar Cirugía
                    </button>
                </form>
                
            <?php elseif ($ya_terminada): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <strong>Cirugía Ya Terminada</strong><br>
                    Esta cirugía ya ha sido marcada como terminada exitosamente.
                </div>
                
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>No Disponible</strong><br>
                    Solo se pueden terminar cirugías que hayan sido canceladas previamente.
                </div>
            <?php endif; ?>
            
            <div class="mt-4">
                <a href="nota_registro_grafico.php" class="btn btn-secondary btn-lg">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al Registro Gráfico
                </a>
            </div>
        </div>
        
        <?php else: ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Error:</strong> No se pudo cargar la información del paciente.
        </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        function confirmarTerminacion() {
            return confirm('¿Está seguro que desea terminar esta cirugía?\n\nEsta acción:\n- Eliminará el estado de cancelación\n- Marcará la cirugía como terminada\n- No se puede deshacer');
        }
        
        // Auto-refresh cada 30 segundos
        setTimeout(() => {
            location.reload();
        }, 30000);
    </script>
</body>
</html>

<?php
    $conexion->close();
}
?>
