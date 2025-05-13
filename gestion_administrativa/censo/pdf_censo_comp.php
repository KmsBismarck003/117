    <?php
    require '../../fpdf/fpdf.php';
    include '../../conexionbd.php';
    $id_atencion = @$_GET['id_atencion'];
    
    mysqli_set_charset($conexion, "utf8");
    
    class PDF extends FPDF
    {
      function Header()
      {
        $id = @$_GET['id'];
        $id_med = @$_GET['id_med'];
        include '../../conexionbd.php';
    
        $id = @$_GET['id'];
    
      include '../../conexionbd.php';
$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 10, 10, 64, 28);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],129,10, 108, 30);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 300, 14, 40, 18);
    $this->SetFont('Arial', 'B', 10);
    $this->setY(40);
    $this->setX(30);
    $this->Cell(300, 6, utf8_decode('CENSO DIARIO DE PACIENTES'), 0, 0, 'C');
 
    $fecha_actual = date("d/m/Y");
       
    $this->SetFont('Arial', 'B', 8);
    $this->setX(320);
    $this->Cell(18, 6, 'FECHA: ' . date('d/m/Y H:i a'), 0, 1, 'R');
    $this->ln(2);
} 
       
       
      }
      function Footer()
      {
    
        $this->SetFont('Arial', 'B', 8);
        $this->SetY(-18);
    
        $this->Ln(6);
        $this->Cell(0, 6, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
        $this->Cell(0, 6, utf8_decode('CMSI-013'), 0, 1, 'R');
      }
    }
    
     function bisiesto($anio_actual){
        $bisiesto=false;
        //probamos si el mes de febrero del año actual tiene 29 días
          if (checkdate(2,29,$anio_actual))
            $bisiesto=true;
            return $bisiesto;
     }
    
     function calculaedad($fecnac)
     {
    
  
    $fecha_actual = date("Y-m-d");
    $fecha_nac=$fecnac;
    $fecha_de_nacimiento =strval($fecha_nac);
    
    // separamos en partes las fechas
    $array_nacimiento = explode ( "-", $fecha_de_nacimiento );
    $array_actual = explode ( "-", $fecha_actual );
    
    $anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años
    $meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses
    $dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días
    
    //ajuste de posible negativo en $días
    if ($dias < 0)
    {
        --$meses;
    
        //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual
        switch ($array_actual[1]) {
               case 1:     $dias_mes_anterior=31; break;
               case 2:     $dias_mes_anterior=31; break;
               case 3:     
                   if (bisiesto($array_actual[0]))
                    {
                        $dias_mes_anterior=29; break;
                    } else {
                        $dias_mes_anterior=28; break;
                    }
                   
               case 4:     $dias_mes_anterior=31; break;
               case 5:     $dias_mes_anterior=30; break;
               case 6:     $dias_mes_anterior=31; break;
               case 7:     $dias_mes_anterior=30; break;
               case 8:     $dias_mes_anterior=31; break;
               case 9:     $dias_mes_anterior=31; break;
               case 10:    $dias_mes_anterior=30; break;
               case 11:    $dias_mes_anterior=31; break;
               case 12:    $dias_mes_anterior=30; break;
        }
    
        $dias=$dias + $dias_mes_anterior;
    }
    
    //ajuste de posible negativo en $meses
    if ($meses < 0)
    {
        --$anos;
        $meses=$meses + 12;
    }
    
     if($anos > "0" ){
       $edad = $anos;
    }elseif($anos <="0" && $meses>"0"){
       $edad = $meses;
        
    }elseif($anos <="0" && $meses<="0" && $dias>"0"){
        $edad = $dias;
    }
    
     return $edad;
    }
    
    
     function calculadias($fechai)
     {
      $estancia = 0;
  
    $fecha_actuali = date("Y-m-d");
    $fecha_i=date_create($fechai);
    
    $fecha_de_ingreso = date_format($fecha_i,"Y-m-d");
    
    // separamos en partes las fechas
    $array_ingreso = explode ( "-", $fecha_de_ingreso);
    $array_actuali = explode ( "-", $fecha_actuali);
    
    $anosi =  $array_actuali[0] - $array_ingreso[0]; // calculamos años
    $mesesi = $array_actuali[1] - $array_ingreso[1]; // calculamos meses
    $diasi =  $array_actuali[2] - $array_ingreso[2]; // calculamos días
    
    //ajuste de posible negativo en $días
    if ($diasi < 0)
    {
        --$mesesi;
    
        //ahora hay que sumar a $diasi los dias que tiene el mes anterior de la fecha actual
        switch ($array_actuali[1]) {
               case 1:     $dias_mes_anteriori=31; break;
               case 2:     $dias_mes_anteriori=31; break;
               case 3:     
                   if (bisiesto($array_actuali[0]))
                    {
                        $dias_mes_anteriori=29; break;
                    } else {
                        $dias_mes_anteriori=28; break;
                    }
                   
               case 4:     $dias_mes_anteriori=31; break;
               case 5:     $dias_mes_anteriori=30; break;
               case 6:     $dias_mes_anteriori=31; break;
               case 7:     $dias_mes_anteriori=30; break;
               case 8:     $dias_mes_anteriori=31; break;
               case 9:     $dias_mes_anteriori=31; break;
               case 10:    $dias_mes_anteriori=30; break;
               case 11:    $dias_mes_anteriori=31; break;
               case 12:    $dias_mes_anteriori=30; break;
        }
    
        $diasi=$diasi + $dias_mes_anteriori;
    }
    
    //ajuste de posible negativo en $meses
    if ($mesesi < 0)
    {
        --$anosi;
        $mesesi=$mesesi + 12;
    }
    
     if($anosi > "0" ){
       $estancia = $anosi."a";
    }elseif($anosi <="0" && $mesesi>"0"&& $diasi<="0"){
       $estancia = $mesesi ."m";
    }elseif($anosi <="0" && $mesesi<="0" && $diasi>"0"){
        $estancia = $diasi."d";
    }elseif($anosi <="0" && $mesesi>"0" && $diasi>"0"){
        $estancia = $mesesi ."m".' '.$diasi."d";
    }
    
    return $estancia;
    
    }
    
    $pdf = new PDF('L','mm','legal');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    $pdf->SetMargins(10, 10, 10);
    #Establecemos el margen inferior:
    $pdf->SetAutoPageBreak(true,20); 
    
    $pdf->SetTextColor(43, 45, 127);
    $pdf->SetDrawColor(43, 45, 180);
   
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->setX(10);
    $pdf->Cell(338, 5, utf8_decode('HOSPITALIZACIÓN'), 1, 1, 'C');
    
    
    $pdf->SetFont('Arial', 'B', 5.5);
    
    $pdf->Cell(4, 6, utf8_decode('#'), 1, 0, 'C');
    $pdf->Cell(12, 6, utf8_decode('F.INGRESO'), 1, 0, 'C');
    $pdf->Cell(60, 6, utf8_decode('PACIENTE'), 1, 0, 'C');
    $pdf->Cell(11, 6, utf8_decode('F.NACIM'), 1, 0, 'C');
    $pdf->Cell(6, 6, utf8_decode('EDAD'), 1, 0, 'C');
    $pdf->Cell(8, 6, utf8_decode('GEN.'), 1, 0, 'C');
    $pdf->Cell(7, 6, utf8_decode('FOLIO'), 1, 0, 'C');
    $pdf->Cell(6, 6, utf8_decode('DEIH'), 1, 0, 'C');
    $pdf->Cell(50, 6, utf8_decode('DIAGNÓSTICO'), 1, 0, 'C');
    $pdf->Cell(25, 6, utf8_decode('ALERGIAS'), 1, 0, 'C');
    $pdf->Cell(20, 6, utf8_decode('DIETOTERAPIA'), 1, 0, 'C');
    $pdf->Cell(42, 6, utf8_decode('MÉDICO DE GUARDIA'), 1, 0, 'C');
    $pdf->Cell(42, 6, utf8_decode('MÉDICO TRATANTE'), 1, 0, 'C');
    $pdf->Cell(22, 6, utf8_decode('ASEGURADORA'), 1, 0, 'C');
    $pdf->MultiCell(23, 6, utf8_decode('PENDIENTES'), 1, 'C');
    
    $pdf->SetFont('Arial', '', 5.5);
    $sql = "SELECT * from cat_camas where TIPO ='HOSPITALIZACION' ORDER BY num_cama ASC ";
    $result = $conexion->query($sql);
    while ($row = $result->fetch_assoc()) {
      $id_at_cam = $row['id_atencion'];
      $estatus = $row['estatus'];
      if ($row['id_atencion'] <> 0){ 
    
      $sql_tabla = "SELECT p.fecnac,p.Id_exp, p.folio, p.papell, p.sapell,p.nom_pac, p.sexo, di.fecha, di.motivo_atn,di.alergias, di.edo_salud, ru.pre, ru.nombre as nom_doc,ru.papell as papell_doc,ru.sapell as sapell_doc from dat_ingreso di, paciente p, reg_usuarios ru WHERE p.Id_exp = di.Id_exp and di.id_usua = ru.id_usua and di.id_atencion = $id_at_cam LIMIT 1";
      $result_tabla = $conexion->query($sql_tabla);
      $rowcount = mysqli_num_rows($result_tabla);
      
        while ($row_tabla = $result_tabla->fetch_assoc()) {
    
          $estancia = 0;
          $pdf->SetFont('Arial', 'B', 5.5);
          $pdf->Cell(4, 6, utf8_decode($row['num_cama']), 1, 0, 'C');
          $pdf->SetFont('Arial', '', 5.5);
          $fecnac=date_create($row_tabla['fecnac']);
          $fecha_ing=date_create($row_tabla['fecha']);
          $Id_exp = $row_tabla['Id_exp']; 
          
          $pdf->Cell(12, 6, utf8_decode(date_format($fecha_ing,"d/m/Y")), 1, 0, 'L');
          
          $pdf->Cell(60, 6, utf8_decode($row_tabla['papell'] . ' ' . $row_tabla['sapell'] . ' ' .$row_tabla['nom_pac']), 1, 'L');
          $pdf->Cell(11, 6, utf8_decode(date_format($fecnac,"d/m/Y")), 1, 0, 'C');
          $pdf->Cell(6, 6, utf8_decode(calculaedad($row_tabla['fecnac'])), 1, 0, 'C');
          $pdf->Cell(8, 6, utf8_decode($row_tabla['sexo']), 1, 0, 'C');
          $pdf->Cell(7, 6, $row_tabla['folio'], 1, 0, 'C');
          $pdf->Cell(6, 6, utf8_decode(calculadias($row_tabla['fecha'])), 1, 0, 'C');
          
          $diagno = $row_tabla['motivo_atn'];
          $sql_nevol = "SELECT * from dat_nevol where id_atencion = $id_at_cam ORDER BY id_ne DESC LIMIT 1 ";
          $result_nevol = $conexion->query($sql_nevol);
          while ($row_nevol = $result_nevol->fetch_assoc()) {
               $diagno = $row_nevol['diagprob_i'];
          }
    
          $pdf->Cell(50, 6, utf8_decode($diagno), 1, 0, 'L');
    
          $pdf->SetTextColor(255, 0, 2);
          $pdf->SetFont('Arial', 'B', 5.5);
          $pdf->Cell(25, 6, utf8_decode($row_tabla['alergias']), 1, 0, 'L');       
    
          $pdf->SetTextColor(43, 45, 127);
          $pdf->SetFont('Arial', '', 5.5);
    
          $dieta = " ";
          $sql_orden_med = "SELECT * from dat_ordenes_med where id_atencion = $id_at_cam ORDER BY id_ord_med  DESC LIMIT 1 ";
          $result_orden_med = $conexion->query($sql_orden_med);
          while ($row_orden_med = $result_orden_med->fetch_assoc()) {
          $dieta = $row_orden_med['dieta'];
          }
          $pdf->Cell(20, 6, utf8_decode($dieta), 1, 0, 'C');
    
          $medico_guard = " ";
          $sql_dat_ing = "SELECT rug.pre, rug.papell as papell_docg from dat_ingreso dni, reg_usuarios rug,dat_hclinica h WHERE h.id_exp = $Id_exp and h.id_usua = rug.id_usua and dni.id_atencion = $id_at_cam ORDER BY fecha DESC LIMIT 1 ";
         $result_dat_ing = $conexion->query($sql_dat_ing);
         while ($row_dat_ing = $result_dat_ing->fetch_assoc()) {
           $medico_guard = $row_dat_ing['pre'].' '.$row_dat_ing['papell_docg'];
          }
          
          $pdf->Cell(42, 6, utf8_decode($medico_guard), 1, 0, 'L');
          $pdf->Cell(42, 6, utf8_decode($row_tabla['pre'] . ' ' .$row_tabla['papell_doc']), 1, 0, 'L');
    
          $aseguradora = " ";
          $sql_dat_fin = "SELECT * from dat_financieros where id_atencion = $id_at_cam ORDER BY id_atencion ASC LIMIT 1 ";
          $result_dat_fin = $conexion->query($sql_dat_fin);
          while ($row_dat_fin = $result_dat_fin->fetch_assoc()) {
          $aseguradora = $row_dat_fin['aseg'];
          }
          $pdf->SetFont('Arial', '', 5.5);
          $pdf->Cell(22, 6, utf8_decode($aseguradora), 1, 0, 'C');
          $pdf->Cell(23, 6, utf8_decode($row_tabla['edo_salud']), 1, 0, 'C');
          $pdf->Ln(6);
        }
       }
       
      elseif($estatus=="MANTENIMIENTO"){
        $pdf->SetFont('Arial', 'B', 5.5);
        $pdf->Cell(4, 6, utf8_decode($row['num_cama']), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 5.5);
        $pdf->Cell(12, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(11, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(6, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(8, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(7, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(6, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(42, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(42, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(22, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->SetTextColor(255, 0, 2);
        
        $pdf->SetFont('Arial', 'B', 5.5);
        $pdf->Cell(23, 6, utf8_decode('NO DISPONIBLE'), 1, 0, 'L');     
        $pdf->SetTextColor(43, 45, 127);
        $pdf->SetFont('Arial', '', 5.5);
    
        $pdf->Ln(6);
        }
        else {
     
        $pdf->SetFont('Arial', 'B', 5.5);
        $pdf->Cell(4, 6, utf8_decode($row['num_cama']), 1, 0, 'C');
        $pdf->SetFont('Arial', '', 5.5);
        $pdf->Cell(12, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(60, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(11, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(6, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(8, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(7, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(6, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(50, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(25, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(20, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(42, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(42, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(22, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Cell(23, 6, utf8_decode(''), 1, 0, 'L');
        $pdf->Ln(6);
      }
    }
    
    
    
    $pdf->Output();
