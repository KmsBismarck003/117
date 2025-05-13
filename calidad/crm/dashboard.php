<?php
session_start();
include "../conexionbd.php";

$usuario = $_SESSION['login'];

include "../header_calidad.php";

include_once "encabezado.php";
//include_once "funciones.php";


//$ventasActual = obtenerVentasPorMes();

$anio = date('Y');
$inicio = date("Y-01-01");
$fin = date("Y-12-31");

?>

<?php
$sql_pac = "SELECT COUNT(*) AS conteo FROM paciente";
    $result_pac = $conexion->query($sql_pac);
    while ($row_pac = $result_pac->fetch_assoc()) {
        $totalClientes = $row_pac['conteo'];
    }


$hace30Dias = date("Y-m-d", strtotime("-30 day"));

$sql_30 = "SELECT COUNT(*) AS conteototal FROM dat_ingreso ";
 $result_30 = $conexion->query($sql_30);
    while ($row_30 = $result_30->fetch_assoc()) {
    $atencionestotales = $row_30['conteototal'];
}

$sql_ua = "SELECT COUNT(*) AS conteoua FROM dat_ingreso WHERE (year(fecha)) = '$anio'";
$result_ua = $conexion->query($sql_ua);
    while ($row_ua = $result_ua->fetch_assoc()) {
    $totalClientesUltimoAnio = $row_ua['conteoua'];
}

$totalClientesAniosAnteriores = 100;


$sql_vta = "SELECT COALESCE(SUM(total), 0) AS ventas FROM cta_pagada ";
    $result_vta = $conexion->query($sql_vta);
    while ($row_vta = $result_vta->fetch_assoc()) {
        $totalVentas = $row_vta['ventas'];
    }
    

$sql_vta = "SELECT COALESCE(SUM(total), 0) AS ventasanioa FROM cta_pagada WHERE (year(fecha_cierre)) = '$anio' ";
    $result_vta = $conexion->query($sql_vta);
    while ($row_vta = $result_vta->fetch_assoc()) {
        $ventasAnioActual  = $row_vta['ventasanioa'];
    }
    


$sql_vta = "SELECT *, COALESCE(SUM(deposito), 0) AS depositos FROM dat_financieros 
    WHERE  (banco = 'EFECTIVO' || banco = 'TRANSFERENCIA' || banco = 'TARJETA' ) AND (year(fec_deposito)) = '$anio'";
    $result_vta = $conexion->query($sql_vta);
    while ($row_vta = $result_vta->fetch_assoc()) {
        $depositos = $depositos + $row_vta['depositos'];
    }


$sql_esp = "SELECT tipo_a, COUNT(*) AS espec FROM dat_ingreso GROUP BY tipo_a";
 $result_esp = $conexion->query($sql_esp);
    while ($row_esp = $result_esp->fetch_assoc()) {
   $clientesPorespecialidad = $row_esp['espec'];
}

//$clientesPorespecialidad  = 100;
$clientesPorEdad = 100;

/*********** CUANTIFICA VENTAS DEl ULTIMO AÑO ****************/

$sql_tabla = "SELECT di.*,p.*,df.*,COUNT(df.id_atencion) as cuantos, SUM(deposito) as total 
    FROM dat_financieros df,dat_ingreso di, paciente p 
    WHERE p.Id_exp=di.Id_exp and di.id_atencion=df.id_atencion and YEAR(df.fecha)=$anio 
    GROUP BY 1 HAVING COUNT(df.id_atencion)>=1 ORDER BY total DESC";
  $result_tabla = $conexion->query($sql_tabla);
  $no=0;
  $subtottal=0;
  $total=0;
 while ($row_tabla = $result_tabla->fetch_assoc()) {
  
     
      $total=$row_tabla['total'];
      $subtottal=$subtottal+$total;
      $no++;
    }
$sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo='EFECTIVO' and m.id_pac=p.id_pac and YEAR(m.fecha)=$anio ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $depositos = $depositos + $total;
      $no++;
    }

    $sql_tabla = "SELECT DISTINCT(p.id_pac), p.nombre, m.* FROM pago_serv p , depositos_pserv m WHERE m.tipo='TRANSFERENCIA' and p.id_pac=m.id_pac and YEAR(m.fecha)=$anio ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $depositos = $depositos + $total;
      $no++;
    }
    $sql_tabla_mpserv = "SELECT DISTINCT(p.id_pac), p.nombre, m.*  FROM pago_serv p , depositos_pserv m WHERE  m.tipo='TARJETA' and p.id_pac=m.id_pac and YEAR(m.fecha)=$anio ORDER BY deposito DESC";
  $result_tabla = $conexion->query($sql_tabla_mpserv);
 while ($row_tabla = $result_tabla->fetch_assoc()) {
     
      $total=$row_tabla['deposito'];
      $subtottal=$subtottal+$total;
      $depositos = $depositos + $total;
      $no++;
    }




?>

<div class="row">
    <div class="col-12 ">
        <h3>Dashboard general</h3>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <img class="img-fluid" src="./img/money.png" alt="">
                    </div>
                </div>
                <h3 class="card-title">$<?php echo number_format($totalVentas, 2) ?></h3>
                <h7 class="card-subtitle mb-2 text-muted">Total Global de Ventas </h7>
            </div>
        </div>
    </div>
    
    <div class="col-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <img class="img-fluid" src="./img/target.png" alt="">
                    </div>
                </div>
                <h3 class="card-title"><?php echo $totalClientes ?></h3>
                <h7 class="card-subtitle mb-2 text-muted">Total de pacientes registrados</h7>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <img class="img-fluid" src="./img/calidad.png" alt="" ">
                    </div>
                </div>
                <br>
                <h3 class="card-title"><?php echo $atencionestotales ?></h3>
                <h7 class="card-subtitle mb-2 text-muted">Total de Atenciones Médicas </h7>
                <br>
            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <img class="img-fluid" src="./img/meeting.png" alt="" >
                    </div>
                </div>
                <h3 class="card-title"><?php echo $no ?></h3>
                <h7 class="card-subtitle mb-2 text-muted">Pacientes en el último año <?php  echo $anio  ?></h7>
            
            </div>
        </div>
    </div>
   
    <div class="col-2">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <img class="img-fluid" src="./img/sales.png" alt="">
                    </div>
                </div>
                <h3 class="card-title">$<?php echo number_format($depositos,2) ?></h3>
                <h7>Total de Pagos del <?php  echo $anio  ?></h7>

            </div>
        </div>
    </div>
    <div class="col-2">
        <div class="card ">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <img class="img-fluid" src="./img/date.png" alt="">
                    </div>
                </div>
                <h3 class="card-title">$<?php  echo number_format($subtottal, 2)  ?></h3>
                <h7>Ventas del  <?php  echo $anio  ?></h7>

            </div>
        </div>
    </div>

    
</div>

<script>
    const clientesPorDepartamento = <?php echo json_encode($clientesPorDepartamento) ?>;
    const clientesPorEdad = <?php echo json_encode($clientesPorEdad) ?>;
    const ventasPorMes = <?php echo json_encode($ventasAnioActual, JSON_NUMERIC_CHECK) ?>;
    // Transformar los meses de número a letra
    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
    ventasPorMes.forEach(v => {
        v.mes = meses[v.mes - 1];
    });
    // Obtener una referencia al elemento canvas del DOM
    const $grafica = document.querySelector("#grafica");
    const $graficaEdad = document.querySelector("#graficaEdad");
    const $graficaVentas = document.querySelector("#graficaVentas");
    const $graficaClientes = document.querySelector("#graficaClientes");

    new Chart($grafica, {
        type: 'pie', // Tipo de gráfica. Puede ser dougnhut o pie
        data: {
            labels: clientesPorDepartamento.map(dato => dato.departamento),
            datasets: [{
                data: clientesPorDepartamento.map(dato => dato.conteo), // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
                backgroundColor: [
                    'rgba(163,221,203,0.2)',
                    'rgba(232,233,161,0.2)',
                    'rgba(230,181,102,0.2)',
                    'rgba(229,112,126,0.2)',
                ], // Color de fondo
                borderColor: [
                    'rgba(163,221,203,1)',
                    'rgba(232,233,161,1)',
                    'rgba(230,181,102,1)',
                    'rgba(229,112,126,1)',
                ], // Color del borde
                borderWidth: 1, // Ancho del borde
            }]
        },
    });
    new Chart($graficaEdad, {
        type: 'pie', // Tipo de gráfica. Puede ser dougnhut o pie
        data: {
            labels: clientesPorEdad.map(dato => dato.etiqueta),
            datasets: [{
                data: clientesPorEdad.map(dato => dato.valor), // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
                backgroundColor: [
                    'rgba(163,221,203,0.2)',
                    'rgba(232,233,161,0.2)',
                    'rgba(230,181,102,0.2)',
                    'rgba(229,112,126,0.2)',
                ], // Color de fondo
                borderColor: [
                    'rgba(163,221,203,1)',
                    'rgba(232,233,161,1)',
                    'rgba(230,181,102,1)',
                    'rgba(229,112,126,1)',
                ], // Color del borde
                borderWidth: 1, // Ancho del borde
            }]
        },
    });
    new Chart($graficaVentas, {
        type: 'bar', // Tipo de gráfica. Puede ser dougnhut o pie
        data: {
            labels: ventasPorMes.map(dato => dato.mes),
            datasets: [{
                label: "Ventas por mes",
                data: ventasPorMes.map(dato => dato.total), // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
                backgroundColor: [
                    'rgba(163,221,203,0.2)',
                    'rgba(232,233,161,0.2)',
                    'rgba(230,181,102,0.2)',
                    'rgba(229,112,126,0.2)',
                ], // Color de fondo
                borderColor: [
                    'rgba(163,221,203,1)',
                    'rgba(232,233,161,1)',
                    'rgba(230,181,102,1)',
                    'rgba(229,112,126,1)',
                ], // Color del borde
                borderWidth: 1, // Ancho del borde
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }],
            },
        }
    });
    new Chart($graficaClientes, {
        type: 'pie', // Tipo de gráfica. Puede ser dougnhut o pie
        data: {
            labels: ["Año actual", "Otros años"],
            datasets: [{
                data: [<?php echo $totalClientesUltimoAnio ?>, <?php echo $totalClientesAniosAnteriores ?>], // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                // Ahora debería haber tantos background colors como datos, es decir, para este ejemplo, 4
                backgroundColor: [
                    'rgba(163,221,203,0.2)',
                    'rgba(232,233,161,0.2)',
                    'rgba(230,181,102,0.2)',
                    'rgba(229,112,126,0.2)',
                ], // Color de fondo
                borderColor: [
                    'rgba(163,221,203,1)',
                    'rgba(232,233,161,1)',
                    'rgba(230,181,102,1)',
                    'rgba(229,112,126,1)',
                ], // Color del borde
                borderWidth: 1, // Ancho del borde
            }]
        },
    });
    
    function obtenerVentasPorMes()
{
    
    $anio = date_create("Y");
    $sentencia = $conexion->prepare("select MONTH(fecha_cierre) AS mes, COUNT(*) AS total from cta_pagada WHERE YEAR(fecha_cierre) = $anio GROUP BY MONTH(fecha_cierre);");
    $sentencia->execute([$anio]);
    return $sentencia->fetchAll();
}
</script>

<?php include_once "pie.php"; ?>