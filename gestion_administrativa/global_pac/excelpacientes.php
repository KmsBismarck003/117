<?php 
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename= lista_pacientes.xls");
 ?>
<head>
	<meta charset="UTF-8"/>
</head>
<table class="table table-bordered table-striped" id="mytable">

                    <thead class="thead" style="background-color: #0c675e">
                    <tr>
                        <th>EXPEDIENTE</th>
                        <th>NOMBRE</th>
                        <th>TELÉFONO</th>
                        <th>DOMICILIO</th>        
                        <th>LOCALIDAD</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include '../../conexionbd.php';
                    $resultado2 = $conexion->query("SELECT * FROM paciente") or die($conexion->error);
                    $no = 1;
                    while ($row = $resultado2->fetch_assoc()) {
                         $date=date_create($row['fecnac']);
                         $fechanac = date_format($date,"d-m-Y");
                         echo '<tr>'
                            . '<td>' . $row['Id_exp'] . '</td>'
                            . '<td>' . $row['papell'] . ' '. $row['sapell'] . ' '. $row['nom_pac'] . '</td>'
                            . '<td>' . $row['tel'] . '</td>'
                            . '<td>' . $row['dir'] . '</td>'
                            . '<td>' . $row['loc'] . '</td>'
                            .'</tr>';
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>