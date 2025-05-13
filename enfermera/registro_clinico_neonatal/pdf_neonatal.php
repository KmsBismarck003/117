<?php
require '../../fpdf/fpdf.php';
include '../../conexionbd.php';
$id_med = @$_GET['id_med'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];
$id_rec_nac = @$_GET['id_rec_nac'];
$fechar = @$_GET['fechar'];

$sql_clin = "SELECT * FROM iden_recnac  where id_atencion = $id_atencion and id_rec_nac=$id_rec_nac and fechab='$fechar'";
$result_clin = $conexion->query($sql_clin);

while ($row_clinreg = $result_clin->fetch_assoc()) {
  $id_rec_nac = $row_clinreg['id_rec_nac'];
}

if(isset($id_rec_nac)){
    $id_rec_nac = $id_rec_nac;
  }else{
    $id_rec_nac ='sin doc';
  }

if($id_rec_nac=="sin doc"){
  echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
                    $(document).ready(function() {
                        swal({
                            title: "NO EXISTE REGISTRO CLÍNICO NEONATAL DE ENFERMERIA PARA ESTE PACIENTE", 
                            type: "error",
                            confirmButtonText: "ACEPTAR"
                        }, function(isConfirm) { 
                            if (isConfirm) {
                                window.close();
                            }
                        });
                    });
                </script>';
}else{

mysqli_set_charset($conexion, "utf8");

class PDF extends FPDF
{
  function Header()
  {
    $id = @$_GET['id'];
    $id_med = @$_GET['id_med'];
    $id_exp = @$_GET['id_exp'];

$id_rec_nac = @$_GET['id_rec_nac'];
    include '../../conexionbd.php';

    $id_atencion = @$_GET['id_atencion'];
include '../../conexionbd.php';
$sql_pac = "SELECT * FROM paciente  where Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $Id_exp = $row_pac['Id_exp'];
 
}

$resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $bas=$f['img_ipdf'];

    $this->Image("../../configuracion/admin/img2/".$bas, 8, 10, 50, 25);
    $this->Image("../../configuracion/admin/img3/".$f['img_cpdf'],57,10, 95, 25);
    $this->Image("../../configuracion/admin/img4/".$f['img_dpdf'], 159, 13, 45, 20);
}
    $this->SetFont('Arial', 'B', 15);
    $this->SetTextColor(43, 45, 127);
  
    $this->Ln(10);
    
  
    $this->Ln(4);
   
    $this->Ln(4);
 
    $this->Ln(4);
    
   $this->Ln(6);
  $this->SetFont('Arial', 'B', 7);
    $this->SetTextColor(43, 45, 127);
        $this->Cell(160, 5, utf8_decode($Id_exp . '-' . $papell . ' ' . $sapell . ' ' . $nom_pac), 0, 'L');
        
        $sql_q = "SELECT * from iden_recnac where id_atencion=$id_atencion";
$result_q = $conexion->query($sql_q); 
while ($row_q = $result_q->fetch_assoc()) {
  $fecha_quir = $row_q['fecha_quir'];
} 
        $date2 = date_create($fecha_quir);
$this->Cell(80, 5, utf8_decode('Fecha de registro: '.date_format($date2, "d-m-Y")),0, 'L');
        $this->Ln(4);
   
  }
  function Footer()
  {
    $this->Ln(8);
    $this->SetY(-15);
    $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}' ), 0, 0, 'C');
    $this->Cell(0, 10, utf8_decode('CMSI-15.06'), 0, 1, 'R');
  }
}

$sql_pac = "SELECT * FROM paciente  where Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);

while ($row_pac = $result_pac->fetch_assoc()) {
  $papell = $row_pac['papell'];
  $nom_pac = $row_pac['nom_pac'];
  $sapell = $row_pac['sapell'];
  $edad = $row_pac['edad'];
  $sexo = $row_pac['sexo'];
  $Id_exp = $row_pac['Id_exp'];
  $dir = $row_pac['dir'];
  $id_edo = $row_pac['id_edo'];
  $id_mun = $row_pac['id_mun'];
  $tel = $row_pac['tel'];
  $ocup = $row_pac['ocup'];
  $resp = $row_pac['resp'];
  $paren = $row_pac['paren'];
  $tel_resp = $row_pac['tel_resp'];
  $fecnac = $row_pac['fecnac'];
   $tip_san = $row_pac['tip_san'];
      $folio = $row_pac['folio'];
}


$sql_ing = "SELECT * FROM dat_ingreso  where id_atencion = $id_atencion";
$result_ing = $conexion->query($sql_ing);
while ($row_ing = $result_ing->fetch_assoc()) {
$especialidad = $row_ing['especialidad'];
  $fechai = $row_ing['fecha'];
  $area= $row_ing['area'];
    $tipo_a= $row_ing['tipo_a'];
  

}

$sql_f = "SELECT enf_fecha FROM enf_reg_clin  where id_atencion = $id_atencion";
$result_f = $conexion->query($sql_f);
while ($row_f = $result_f->fetch_assoc()) {
$enf_fecha = $row_f['enf_fecha'];

  

}

$sql_camas = "SELECT * FROM cat_camas  where id_atencion = $id_atencion";
$result_camas = $conexion->query($sql_camas);
while ($row_camas = $result_camas->fetch_assoc()) {

  $num_cama = $row_camas['num_cama'];
}

$sql_est = "SELECT DATEDIFF(fechab, '$fechai') as estancia FROM iden_recnac where id_atencion = $id_atencion and fechab='$fechar'";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
          $estancia = $row_est['estancia'];
       
      }

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(8, 10, 10);
#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,30);
    $pdf->SetTextColor(43, 45, 127);

  $pdf->SetDrawColor(43, 45, 180);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX(55);
$pdf->Cell(110, 5, utf8_decode('REGISTRO CLÍNICO PEDIÁTRICO/NEONATAL'), 0, 0, 'C');


$fecha_quir = date("d/m/Y H:i:s");
$pdf->SetFont('Arial', '', 8);
//$pdf->Cell(25, 5, utf8_decode('Fecha: '.$fecha_quir), 0, 1, 'L');

$pdf->SetFont('Arial', '', 8);
$pdf->Ln(3);
$date = date_create($fecha);
//$pdf->Cell(110, 5, utf8_decode('Fecha de ingreso al hospital: '.date_format($date, "d-m-Y H:i a")),0, 'L');



$pdf->Ln(5);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 5, 'Servicio: ', 0, 'L');  
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(120, 5, utf8_decode($tipo_a) , 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$date2=date_create($fechai);
$pdf->Cell(28, 5, utf8_decode(' Fecha de Ingreso:'),0 , 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 5, date_format($date2,'d/m/Y H:i:s'), 'B', 0, 'C');
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(18, 5, utf8_decode('Expediente: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(15, 5, utf8_decode($folio), 'B', 0, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, ' Paciente: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(146, 5, utf8_decode($papell . ' ' . $sapell . ' ' . $nom_pac), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 8);
$date1=date_create($fecnac);
$pdf->Cell(31, 5, 'Fecha de nacimiento: ', 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5, date_format($date1,"d/m/Y"), 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, ' Edad: ', 0, 'L');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(13, 5, utf8_decode($edad),'B', 'C');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(19, 5, utf8_decode(' Ocupación: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(36, 5,  utf8_decode($ocup), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(16, 5, utf8_decode(' Teléfono: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(21, 5,  utf8_decode($tel), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(13, 5, utf8_decode('Género: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  $sexo, 'B', 'L');
$pdf->Ln(5);
$pesoh="";
$tallah="";
$sql_sig ="select * from dat_hclinica WHERE Id_exp=$id_atencion ORDER by id_hc DESC LIMIT 1";
$result_sig = $conexion->query($sql_sig);
while ($row_hc = $result_sig->fetch_assoc()) {
$pesoh=$row_hc['peso'];
$tallah=$row_hc['talla'];
}

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(10, 5, utf8_decode('Peso: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(14, 5,  utf8_decode($pesoh.' Kilos'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(11, 5, utf8_decode(' Talla: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(18, 5,  utf8_decode($tallah.' Metros'), 'B', 'L');

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17, 5, utf8_decode(' Domicilio: '), 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(125, 5, utf8_decode($dir), 'B', 'L');

$pdf->Ln(5);

$d="";
    $sql_motd = "SELECT diagprob_i from dat_not_ingreso where id_atencion=$id_atencion ORDER by id_not_ingreso DESC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } 
    $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i DESC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } ?>
    <?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
    $result_mot = $conexion->query($sql_mot);
    while ($row_mot = $result_mot->fetch_assoc()) {
    $m=$row_mot['motivo_atn'];
    } 
if ($d!=null) {
    $pdf->SetFont('Arial', 'B', 8);
  $pdf->Cell(20, 5, utf8_decode('Diagnóstico:') , 0, 'C');
  $pdf->SetFont('Arial', '', 9);
     $pdf->Cell(175, 5, utf8_decode($d) , 'B', 'C');
    } else{
        $pdf->SetFont('Arial', 'B',8);
         $pdf->Cell(29, 5, utf8_decode('Motivo de atención:') , 0, 'C');
         $pdf->SetFont('Arial', '', 9);
         $pdf->Cell(166, 5, utf8_decode($m) , 'B', 'C');
    }

$pdf->Ln(6);

$sql_edo = "SELECT edo_salud,alergias from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  $edo_salud=$row_edo['edo_salud'];
  $alergias=$row_edo['alergias'];
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25,3, utf8_decode('Grupo sanguineo: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(23,3, utf8_decode($tip_san),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(17,3, utf8_decode('Habitación: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10,3, utf8_decode($num_cama),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25, 3, 'Tiempo estancia: ', 0, 'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(12, 3, $estancia . ' dias', 'B', 'L');
$pdf->SetFont('Arial', 'B', 8);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(25,3, utf8_decode('Estado de salud: '),0,'L');
$pdf->SetFont('Arial', '', 6);
$pdf->Cell(58,3, utf8_decode($edo_salud),'B','L');
$pdf->Ln(3);


$sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
  $result_aseg = $conexion->query($sql_aseg);
  while ($row_aseg = $result_aseg->fetch_assoc()) {
 $aseg= $row_aseg['aseg'];
}                      
$pdf->SetFont('Arial', 'B', 8);                                               
$pdf->Cell(20,5, utf8_decode('Aseguradora: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60,5, utf8_decode($aseg),'B','L');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15,5, utf8_decode('Alergias: '),0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(100,5, utf8_decode($alergias),'B','L');
$pdf->SetFont('Arial', 'B', 6);
//consulta a bebe


$sql_b = "SELECT * from iden_recnac where id_atencion=$id_atencion and id_rec_nac=$id_rec_nac and fechab='$fechar' ORDER by id_rec_nac DESC LIMIT 1";
$result_b= $conexion->query($sql_b); 
while ($row_b = $result_b->fetch_assoc()) {

  $fechab = $row_b['fechab'];
  $horab = $row_b['horab'];
$tempb = $row_b['tempb'];
$pulsob = $row_b['pulsob'];
$respb = $row_b['respb'];
$sistb = $row_b['sistb'];
$diastb = $row_b['diastb'];

$tam=($sistb+$diastb)/2;
$caidab = $row_b['caidab'];
$dolorb = $row_b['dolorb'];

$sondab = $row_b['sondab'];
$edoconb = $row_b['edoconb'];
$dietab = $row_b['dietab'];
$glucocab = $row_b['glucocab'];

$glucob = $row_b['glucob'];
$insulinab = $row_b['insulinab'];
$canalizab = $row_b['canalizab'];
$solparenb = $row_b['solparenb'];
$solparb = $row_b['solparb'];

$ingmedb = $row_b['ingmedb'];
$viaoralb = $row_b['viaoralb'];
$otrosb = $row_b['otrosb'];
$formb = $row_b['formb'];
$ingtotb = $row_b['ingtotb'];

$diuresisb = $row_b['diuresisb'];
$evacuab = $row_b['evacuab'];
$vomitob = $row_b['vomitob'];
$canalb = $row_b['canalb'];
$perinsenb = $row_b['perinsenb'];

$egtotb = $row_b['egtotb'];
$baltotb = $row_b['baltotb'];

$cuideb = $row_b['cuideb'];
$noteb = $row_b['noteb'];


$apellidos = $row_b['apellidos'];
$nombremadre = $row_b['nombremadre'];
$fecnacr = $row_b['fecnac'];
$horanac = $row_b['horanac'];
$sexobebe = $row_b['sexo'];
$pesobebe = $row_b['peso'];
$tallabebe = $row_b['talla'];
$pie = $row_b['pie'];
$apgar = $row_b['apgar'];
$silverman = $row_b['silverman'];
$capurro = $row_b['capurro'];


} 
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(7);
$fech=date_create($fechab);
$pdf->Cell(55,6,'Fecha/dia hosp: '.date_format($fech,"d-m-Y"),1,'L');
$pdf->Cell(35,6,'Hora: '.$horab,1,'L');
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(32,5,utf8_decode('Alojamiento conjunto:'),0,0,'L');
if($apellidos==null and $nombremadre==null and $fecnacr=='0000-00-00' and $sexobebe==null){
    $pdf->Cell(8,5,utf8_decode('No'),'B',0,'C');
}else{
      $pdf->Cell(8,5,utf8_decode('Si'),'B',0,'C');
      $pdf->Ln(7);
      $pdf->Cell(32,5,utf8_decode('HOJA DE IDENTIFICACIÓN DEL RECIÉN NACIDO'),0,0,'L');
      $pdf->Ln(7);
        $pdf->Cell(49,5,utf8_decode('APELLIDOS DEL RECIÉN NACIDO:'),0,'C');
        $pdf->Cell(141,5,utf8_decode($apellidos),'B','L');
        $pdf->Ln(5.5);
        $pdf->Cell(37,5,utf8_decode('NOMBRE DE LA MADRE:'),0,'C');
        $pdf->Cell(153,5,utf8_decode($nombremadre),'B','L');
        $pdf->Ln(5.5);
        $pdf->Cell(37,5,utf8_decode('FECHA DE NACIMIENTO:'),0,'C');
        $pdf->Cell(59,5,utf8_decode($fecnacr),'B','L');
        $pdf->Cell(35,5,utf8_decode('HORA DE NACIMIENTO:'),0,'C');
        $pdf->Cell(59,5,utf8_decode($horanac),'B','L');
         $pdf->Ln(5.5);
        $pdf->Cell(10,5,utf8_decode('SEXO:'),0,'C');
        $pdf->Cell(46,5,utf8_decode($sexobebe),'B','L');
        $pdf->Cell(10,5,utf8_decode('PESO:'),0,'C');
        $pdf->Cell(35,5,utf8_decode($pesobebe . ' Kg'),'B','L');
        $pdf->Cell(12,5,utf8_decode('TALLA:'),0,'C');
        $pdf->Cell(35,5,utf8_decode($tallabebe . ' cm'),'B','L');
        $pdf->Cell(7,5,utf8_decode('PIE:'),0,'C');
        $pdf->Cell(35,5,utf8_decode($pie . ' cm'),'B','L');
        
         $pdf->Ln(5.5);
        $pdf->Cell(13,5,utf8_decode('APGAR:'),0,'C');
        $pdf->Cell(53,5,utf8_decode($apgar),'B','L');
        $pdf->Cell(19,5,utf8_decode('SILVERMAN:'),0,'C');
        $pdf->Cell(44,5,utf8_decode($silverman),'B','L');
        $pdf->Cell(17,5,utf8_decode('CAPURRO:'),0,'C');
        $pdf->Cell(44,5,utf8_decode($capurro),'B','L');
}




$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(195,6,utf8_decode('Signos vitales'),1,0,'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Ln(6);
$pdf->Cell(10,6,utf8_decode('Hora'),1,'L');
$pdf->Cell(25,6,utf8_decode('Presión arterial'),1,'L');
$pdf->Cell(20,6,utf8_decode('Temperatura'),1,'L');
$pdf->Cell(40,6,utf8_decode('Frecuencia cardiaca'),1,'L');
$pdf->Cell(40,6,utf8_decode('Frecuencia respiratoria'),1,'L');
$pdf->Cell(30,6,utf8_decode('Saturación oxigeno'),1,'L');
$pdf->Cell(30,6,utf8_decode('Nivel de dolor'),1,'L');
$pdf->Ln(6);
$resp = $conexion->query("select * from signos_vitales where id_atencion=$id_atencion and neonato='Si'and fecha='$fechar'") or die($conexion->error);
while ($resp_r = $resp->fetch_assoc()) {
  $pdf->Cell(10,6,utf8_decode($resp_r['hora']),1,'C');
 $pdf->Cell(25,6,utf8_decode($resp_r['p_sistol'].'/'.$resp_r['p_diastol']),1,'L');
$pdf->Cell(20,6,utf8_decode($resp_r['temper']),1,'L');
$pdf->Cell(40,6,utf8_decode($resp_r['fcard']),1,'L');
$pdf->Cell(40,6,utf8_decode($resp_r['fresp']),1,'L');
$pdf->Cell(30,6,utf8_decode($resp_r['satoxi'] .'%'),1,'L');
$pdf->Cell(30,6,utf8_decode($resp_r['niv_dolor']),1,'L');
$pdf->Ln(6);
}

    $pdf->Ln(6);
$pdf->Cell(62,6,utf8_decode('Sondas/catéteres'),1,'L');
$pdf->Cell(60,6,'Estado de salud',1,'L');
$pdf->Cell(28, 6, utf8_decode('Dieta'),1, 'L');
$pdf->Cell(45, 6, utf8_decode('Glusoca capilar'),1, 'L');

$pdf->Ln(6);
$pdf->Cell(62,6,utf8_decode($sondab),1,'L');
$pdf->Cell(60,6,$edoconb,1,'L');
$pdf->Cell(28, 6, utf8_decode($dietab),1, 'L');
$pdf->Cell(45, 6, utf8_decode($glucocab),1, 'L');
$pdf->Ln(8);

$pdf->Cell(62,6,'Glucocetonuria',1,'L');
$pdf->Cell(60,6,'Insulina',1,'L');
$pdf->Cell(73, 6, utf8_decode('Canalizaciones'),1, 'L');

$pdf->Ln(6);
$pdf->Cell(62,6,utf8_decode($glucocab),1,'L');
$pdf->Cell(60,6,$insulinab,1,'L');
$pdf->Cell(73, 6, utf8_decode($canalizab),1, 'L');
$pdf->Ln(8);
$pdf->MultiCell(195,6,'Soluciones parenterales: ' . utf8_decode($solparenb),1,'L');
$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15,6,utf8_decode('Hora'),1,0,'C');
$pdf->Cell(107,6,'Medicamentos',1,0,'C');
$pdf->Cell(40,6,utf8_decode('Dósis'),1,0,'C');
$pdf->Cell(33,6,utf8_decode('Vía'),1,0,'C');

$sql_m = "SELECT * from medica_enf where id_atencion=$id_atencion and fecha_mat='$fechar' and neonato='Si' ORDER by id_med_reg DESC";
$result_m= $conexion->query($sql_m); 
while ($row_m = $result_m->fetch_assoc()) {
      $hora_mat = $row_m['hora_mat'];
  $medicab = $row_m['medicam_mat'];
   $dosisb = $row_m['dosis_mat'];
    $viab = $row_m['via_mat'];
       $unimed = $row_m['unimed'];
    $pdf->SetFont('Arial', '', 8);
$pdf->Ln(6);
  $pdf->Cell(15,6,utf8_decode($hora_mat),1,0,'C');
  $pdf->Cell(107,6,utf8_decode($medicab),1,0,'C');
$pdf->Cell(40,6,utf8_decode($dosisb. ' ' . $unimed),1,0,'C');
$pdf->Cell(33,6,utf8_decode($viab),1,0,'C');
} 
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,6,utf8_decode('INGRESOS'),1,0,'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(35,6,utf8_decode('Hora'),1,'L');
$pdf->Cell(95, 6, utf8_decode('Descripción'),1, 'L');
$pdf->Cell(60, 6, utf8_decode('Cantidad'),1,0,'C');

$pdf->Ln(6);
$resp = $conexion->query("select * from ing_enf_quir where id_atencion=$id_atencion and neonato='Si' and fecha='$fechar'") or die($conexion->error);
while ($resp_r = $resp->fetch_assoc()) {
$pdf->Cell(35,6,utf8_decode($resp_r['hora']),1,'L');
$pdf->Cell(95,6,utf8_decode($resp_r['des']),1,'L');
$pdf->Cell(60,6,utf8_decode($resp_r['cantidad']),1,'L');
$pdf->Ln(6);
}

$pdf->Ln(6);
 $pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190,6,utf8_decode('EGRESOS'),1,0,'C');
$pdf->Ln(6);
 $pdf->SetFont('Arial', '', 8);
 $pdf->Cell(25, 6, utf8_decode('Hora'),1,0,'C');
$pdf->Cell(80,6,utf8_decode('Descripción'),1,'L');
$pdf->Cell(40,6,'Cantidad',1,'L');
$pdf->Cell(45, 6, utf8_decode('Caracteristicas'),1, 'L');
$pdf->Ln(6);

$resp = $conexion->query("select * from eg_enf_quir where id_atencion=$id_atencion and neonato='Si' and fecha_eg='$fechar'") or die($conexion->error);
while ($resp_r = $resp->fetch_assoc()) {
$pdf->Cell(25,6,utf8_decode($resp_r['hora_eg']),1,'L');
$pdf->Cell(80,6,utf8_decode($resp_r['des_eg']),1,'L');
$pdf->Cell(40,6,utf8_decode($resp_r['cant_eg']),1,'L');
$pdf->Cell(45,6,utf8_decode($resp_r['carac']),1,'L');
$pdf->Ln(6);
}


$pdf->Ln(6);
 


$sql_cai = "SELECT * FROM iden_recnac WHERE id_atencion = $id_atencion and id_rec_nac=$id_rec_nac ORDER by id_rec_nac DESC LIMIT 1";
    $result_hum = $conexion->query($sql_cai);
    while ($row_mdum = $result_hum->fetch_assoc()) {
      $edad2 = $row_mdum['edad'];
      $gen = $row_mdum['gen'];
      $dico = $row_mdum['dico'];
      $deter = $row_mdum['deter'];
      $facam = $row_mdum['facam'];
      $cirose = $row_mdum['cirose'];
      $medicac = $row_mdum['medicac'];
      $tot = $row_mdum['tot'];
    }

$pdf->Ln(8);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(195, 6, utf8_decode('RIESGO DE CAIDAS HUMPTY DUMPTY-PACIENTE HOSPITALIZADO'), 0, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode('Parámetro'), 1, 0, 'C');
$pdf->Cell(123, 6, utf8_decode('Criterios'), 1, 0, 'C');
$pdf->Cell(20, 6, utf8_decode('Puntos'), 1, 0, 'C');
$pdf->Cell(25, 6, utf8_decode('Resultado'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode('Edad'), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Menos de 3 años'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('4'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(25, 24, utf8_decode($edad2), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('De 3-7 años'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('De 7-13 años'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Más de 13 años'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode('Género'), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Hombre'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(25, 12, utf8_decode($gen), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Mujer'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode('Diagnóstico'), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Problemas neurológicos'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('4'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(25, 24, utf8_decode($dico), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Alteraciones de oxigenación:
(problemas respiratorios,anemia)
deshidratación, anorexia, vértigo'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Trastornos psíquicos o de
conducta'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Otro diagnostico '), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');

$pdf->Ln(10);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode('Deterioro cognitivo'), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('No conoce sus limitaciones '), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(25, 18, utf8_decode($deter), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Se le olvida sus limitaciones'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Orientado en sus propias
capacidades '), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');

$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',7.1);
$pdf->Cell(27, 6, utf8_decode('Factores Ambientales'), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Historia de caída de bebes o
niños pequeños desde la cama'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('4'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(25, 24, utf8_decode($facam), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Utiliza dispositivos de ayuda en
la cuna, iluminación, muebles'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Paciente en la cama'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Paciente que deambula'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',7.5);
$pdf->Cell(27, 6, utf8_decode('Sedación anestésica'), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Dentro de las 24 horas '), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(25, 18, utf8_decode($cirose), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Dentro de 48 horas'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Mas de 48 horas /ninguna'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode('Medicación'), 1, 0, 'C');
$pdf->SetFont('Arial', '',7.8);
$pdf->Cell(123, 6, utf8_decode('Uso de múltiples medicamentos sedantes (Excluyen pacientes de UCIP con sedantes o relajantes)'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('3'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(25, 18, utf8_decode($medicac), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Uno de los medicamentos antes
mencionados'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('2'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell(123, 6, utf8_decode('Ninguno'), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('1'), 1, 0, 'C');
$pdf->Ln(6);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(123, 6, utf8_decode(''), 1, 0, 'L');
$pdf->SetFont('Arial', 'B',8);
$pdf->Cell(20, 6, utf8_decode('Total:'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',6.8);
$pdf->Cell(25, 6, utf8_decode($tot), 1, 0, 'C');
$pdf->Ln(6);
$pdf->Cell(27, 6, utf8_decode(''), 1, 0, 'C');
$pdf->Cell(123, 6, utf8_decode(''), 1, 0, 'L');
$pdf->Cell(20, 6, utf8_decode('Riesgo de caida:'), 1, 0, 'C');
$pdf->SetFont('Arial', 'B',8);

if ($tot<7) {
    $pdf->SetFont('Arial', 'B',7.5);
   $pdf->Cell(25, 6, utf8_decode('Sin riesgo'), 1, 0, 'C');
}elseif($tot<=7 || $tot<12) {
    $pdf->SetFont('Arial', 'B',7.5);
   $pdf->Cell(25, 6, utf8_decode('Riesgo bajo'), 1, 0, 'C');
}elseif($tot>=12) {
    $pdf->SetFont('Arial', 'B',7.5);
   $pdf->Cell(25, 6, utf8_decode('Riesgo alto'), 1, 0, 'C');
}
$pdf->Ln(6);
$pdf->SetFont('Arial', 'B',6.8);
$pdf->Cell(195, 5, utf8_decode('Riesgo de caidas:
< 7 puntos; Sin riesgo,
7-11 puntos; Riesgo bajo,
> 12 puntos; Riesgo alto'), 1, 0, 'C');



$pdf->Ln(8);
 $pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 6, utf8_decode('Cuidados de enfermería:'),0,'L');
$pdf->Ln(4);
$sql_bE = "SELECT * from nota_enf_obs where id_atencion=$id_atencion and fecha='$fechar' ORDER by id_enf_obs DESC";
$result_bE= $conexion->query($sql_bE); 
while ($row_bE = $result_bE->fetch_assoc()) {
  $turno=$row_bE['turno'];
       $cuidenf=$row_bE['cuidenf'];
     $horab=$row_bE['hora'];
 $pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode('Hora: ' . $horab . ' Turno : ' . $turno . ' ; ' . $cuidenf),0,'L');
}
$pdf->Ln(2);

$pdf->Cell(195, 6, utf8_decode('Notas de enfermería: '),0,'L');
$pdf->Ln(4);
$sql_bEn = "SELECT * from nota_enf_obs where id_atencion=$id_atencion and fecha='$fechar' ORDER by id_enf_obs DESC";
$result_bEn= $conexion->query($sql_bEn); 
while ($row_bEn = $result_bEn->fetch_assoc()) {
    $turno=$row_bEn['turno'];
    $notebebes=$row_bEn['notaenf'];
       $cuidenf=$row_bEn['cuidenf'];
     $horab=$row_bEn['hora'];


 $pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(195, 5, utf8_decode('Hora: ' . $horab . ' Turno : ' . $turno . ' ; ' . $notebebes),0,'L');
}



$sql_med_id = "SELECT id_usua FROM iden_recnac WHERE id_atencion = $id_atencion and id_rec_nac=$id_rec_nac ORDER by id_rec_nac DESC LIMIT 1";
    $result_med_id = $conexion->query($sql_med_id);
    while ($row_med_id = $result_med_id->fetch_assoc()) {
      $id_med = $row_med_id['id_usua'];
    }
    $sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_med";
    $result_med = $conexion->query($sql_med);
    while ($row_med = $result_med->fetch_assoc()) {
      $nom = $row_med['nombre'];
      $app = $row_med['papell'];
      $apm = $row_med['sapell'];
      $pre = $row_med['pre'];
      $firma = $row_med['firma'];
      $ced_p = $row_med['cedp'];
$cargp = $row_med['cargp'];
}

        $pdf->SetY(-42);
        $pdf->SetFont('Arial', 'B', 8);
      //$pdf->Image('../../imgfirma/' . $firma, 83, 240, 25);
      
        if ($firma==null) {
        $pdf->Image('../../imgfirma/FIRMA.jpg', 90, 244 , 25);
        } else {
            $pdf->Image('../../imgfirma/' . $firma, 90, 244 , 25);
        }
      
        $pdf->Ln(6);
      
        $pdf->Cell(200, 3, utf8_decode($pre . '. ' . $app . ' ' . $apm), 0, 0, 'C');
      
        $pdf->SetFont('Arial', 'B', 8);

 
      
       // $pdf->Cell(48, 3, utf8_decode('Cédula profesional. ' . $ced_p), 0, 0, 'C');

        $pdf->Ln(3);
        $pdf->Cell(200, 3, utf8_decode('NOMBRE Y FIRMA ENFERMERÍA'), 0, 0, 'C');
    $pdf->Output(); 
}