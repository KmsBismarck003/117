<?php


use PDF as GlobalPDF;

require '../../fpdf/fpdf.php';
include '../../conexionbd.php';


$id = @$_GET['id'];
$id_exp = @$_GET['id_exp'];
$id_atencion = @$_GET['id_atencion'];

$sql_pac = "SELECT p.papell, p.nom_pac, p.sapell, p.edad, p.sexo, p.Id_exp, p.folio, p.dir, p.id_edo, p.id_mun, p.tel, p.ocup, p.resp, p.paren, p.tel_resp, p.fecnac 
            FROM paciente p WHERE p.Id_exp = $id_exp";
$result_pac = $conexion->query($sql_pac);
$row_pac = $result_pac->fetch_assoc();

$papell = $row_pac['papell'];
$nom_pac = $row_pac['nom_pac'];
$sapell = $row_pac['sapell'];
$edad = $row_pac['edad'];
$sexo = $row_pac['sexo'];
$Id_exp = $row_pac['Id_exp'];
$folio = $row_pac['folio'];
$dir = $row_pac['dir'];
$tel = $row_pac['tel'];
$ocup = $row_pac['ocup'];
$fecnac = $row_pac['fecnac'];

$sql_preop = "SELECT * FROM dat_ingreso WHERE id_atencion = $id_atencion";
$result_preop = $conexion->query($sql_preop);
$row_preop = $result_preop->fetch_assoc();

$tipo_a = $row_preop['tipo_a'] ?? '';
$fecha_ing = $row_preop['fecha'] ?? '';
$id_usua = $row_preop['id_usua'] ?? '';

$id_prueba = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id_prueba > 0) {
    $sql_prueba = "SELECT * FROM pruebas_oftalmologicas WHERE id = $id_prueba LIMIT 1";
} else {
    $sql_prueba = "SELECT * FROM pruebas_oftalmologicas WHERE id_atencion = $id_atencion ORDER BY id DESC LIMIT 1";
}
$result_prueba = $conexion->query($sql_prueba);
$row_prueba = $result_prueba->fetch_assoc();

if (!$row_prueba) {
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
        $(document).ready(function() {
            swal({
                title: "NO EXISTE PRUEBA PARA ESTE PACIENTE", 
                type: "error",
                confirmButtonText: "ACEPTAR"
            }, function(isConfirm) { 
                if (isConfirm) {
                    window.close();
                }
            });
        });
    </script>';
    exit;
}
$tipo_prueba = $row_prueba['tipo_prueba'] ?? '';
$resultado = $row_prueba['resultado'] ?? '';
$fecha_consulta = $row_prueba['fecha_consulta'] ?? '';
$observaciones = $row_prueba['observaciones'] ?? '';

$estrabismo_od = $row_prueba['estrabismo_od'] ?? '';
$movimientos_od = $row_prueba['movimientos_od'] ?? '';
$convergencia_od = $row_prueba['convergencia_od'] ?? '';
$prueba_cover_od = $row_prueba['prueba_cover_od'] ?? '';
$vision_estereo_od = $row_prueba['vision_estereo_od'] ?? '';
$worth_od = $row_prueba['worth_od'] ?? '';
$schirmer_od = $row_prueba['schirmer_od'] ?? '';
$trpl_od = $row_prueba['trpl_od'] ?? '';
$fluoresceina_od = $row_prueba['fluoresceina_od'] ?? '';
$contraste_od = $row_prueba['contraste_od'] ?? '';
$ishihara_od = $row_prueba['ishihara_od'] ?? '';
$farnsworth_od = $row_prueba['farnsworth_od'] ?? '';
$amsler_od = $row_prueba['amsler_od'] ?? '';

$estrabismo_oi = $row_prueba['estrabismo_oi'] ?? '';
$movimientos_oi = $row_prueba['movimientos_oi'] ?? '';
$convergencia_oi = $row_prueba['convergencia_oi'] ?? '';
$prueba_cover_oi = $row_prueba['prueba_cover_oi'] ?? '';
$vision_estereo_oi = $row_prueba['vision_estereo_oi'] ?? '';
$worth_oi = $row_prueba['worth_oi'] ?? '';
$schirmer_oi = $row_prueba['schirmer_oi'] ?? '';
$trpl_oi = $row_prueba['trpl_oi'] ?? '';
$fluoresceina_oi = $row_prueba['fluoresceina_oi'] ?? '';
$contraste_oi = $row_prueba['contraste_oi'] ?? '';
$ishihara_oi = $row_prueba['ishihara_oi'] ?? '';
$farnsworth_oi = $row_prueba['farnsworth_oi'] ?? '';
$amsler_oi = $row_prueba['amsler_oi'] ?? '';

$ojo_preferente = $row_prueba['ojo_preferente'] ?? '';
$detalle_prueba = $row_prueba['detalle_prueba'] ?? '';
$fecha_prueba = $row_prueba['fecha_consulta'] ?? date('Y-m-d H:i:s');
$GLOBALS['fecha_prueba'] = $fecha_prueba;

$sql_med = "SELECT * FROM reg_usuarios WHERE id_usua = $id_usua";
$result_med = $conexion->query($sql_med);
$row_med = $result_med->fetch_assoc();
$nom_med = $row_med['nombre'] ?? '';
$app_med = $row_med['papell'] ?? '';
$apm_med = $row_med['sapell'] ?? '';
$pre_med = $row_med['pre'] ?? '';
$firma = $row_med['firma'] ?? '';
$ced_p = $row_med['cedp'] ?? '';
$cargp = $row_med['cargp'] ?? '';

class PDF extends FPDF
{
    function Header()
    {
        include '../../conexionbd.php';
        $resultado = $conexion->query("SELECT * from img_sistema ORDER BY id_simg DESC") or die($conexion->error);
        while ($f = mysqli_fetch_array($resultado)) {
            $this->Image("../../configuracion/admin/img2/" . $f['img_ipdf'], 7, 11, 40, 25);
            $this->Image("../../configuracion/admin/img3/" . $f['img_cpdf'], 58, 15, 109, 24);
            $this->Image("../../configuracion/admin/img4/" . $f['img_dpdf'], 168, 16, 38, 14);

        }
        $this->SetY(38);
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(40, 40, 40);
        $this->Cell(0, 6, utf8_decode('NOTA DE PRUEBAS OFTALMOLÓGICAS'), 0, 1, 'C');
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 3, utf8_decode('Fecha: ') . date('d/m/Y H:i', strtotime($GLOBALS['fecha_prueba'])), 0, 1, 'R');
        $this->Ln(1);
    }
    function Footer()
    {
        $this->SetY(-20);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
        $this->Cell(0, 10, utf8_decode('INEO-000'), 0, 1, 'R');
    }
    function SetWidths($w)
{
    // Set the array of column widths
    $this->widths = $w;
}
function Row($data)
{
    $nb = 0;
    for($i=0;$i<count($data);$i++)
        $nb = max($nb, $this->NbLines($this->widths[$i],$data[$i]));
    $h = 5 * $nb;
    $this->CheckPageBreak($h);
    for($i=0;$i<count($data);$i++)
    {
        $w = $this->widths[$i];
        $a = 'L';
        $x = $this->GetX();
        $y = $this->GetY();
        $this->Rect($x,$y,$w,$h);
        $this->MultiCell($w,5,$data[$i],0,$a);
        $this->SetXY($x+$w,$y);
    }
    $this->Ln($h);
}
function CheckPageBreak($h)
{
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}
function NbLines($w,$txt)
{
    $cw = &$this->CurrentFont['cw'];
    if($w==0)
        $w = $this->w-$this->rMargin-$this->x;
    $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
    $s = str_replace("\r",'',$txt);
    $nb = strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $nl = 1;
    while($i<$nb)
    {
        $c = $s[$i];
        if($c=="\n")
        {
            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep = $i;
        $l += $cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i = $sep+1;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

function tablasLadoALado($datosOD, $datosOI, $titulo1, $titulo2) {
    $y_inicial = $this->GetY();
    $ancho_tabla = 85;
    $x_tabla1 = 15;
    $x_tabla2 = 110;
    
    // Título OD
    $this->SetXY($x_tabla1, $y_inicial);
    $this->SetFont('Arial', 'B', 8);
    $this->SetFillColor(245, 245, 245);
    $this->Cell($ancho_tabla, 5, utf8_decode($titulo1), 0, 1, 'C', true);
    
    // Título OI
    $this->SetXY($x_tabla2, $y_inicial);
    $this->Cell($ancho_tabla, 5, utf8_decode($titulo2), 0, 1, 'C', true);
    
    $y_actual = $y_inicial + 5;
    
    // Encabezados
    $this->SetFont('Arial', '', 7);
    $this->SetXY($x_tabla1, $y_actual);
    $this->Cell(35, 4, utf8_decode('Parámetro'), 1, 0, 'C', true);
    $this->Cell(50, 4, 'Valor', 1, 0, 'C', true);
    
    $this->SetXY($x_tabla2, $y_actual);
    $this->Cell(35, 4, utf8_decode('Parámetro'), 1, 0, 'C', true);
    $this->Cell(50, 4, 'Valor', 1, 0, 'C', true);
    
    $y_actual += 4;
    
    // Datos
    $max_filas = max(count($datosOD), count($datosOI));
    for ($i = 0; $i < $max_filas; $i++) {
        // Tabla OD
        $this->SetXY($x_tabla1, $y_actual);
        if ($i < count($datosOD)) {
            $this->Cell(35, 4, $datosOD[$i][0], 1, 0, 'L');
            $this->Cell(50, 4, utf8_decode($datosOD[$i][1]), 1, 0, 'L');
        } else {
            $this->Cell(35, 4, '', 1, 0, 'L');
            $this->Cell(50, 4, '', 1, 0, 'L');
        }
        
        // Tabla OI
        $this->SetXY($x_tabla2, $y_actual);
        if ($i < count($datosOI)) {
            $this->Cell(35, 4, $datosOI[$i][0], 1, 0, 'L');
            $this->Cell(50, 4, utf8_decode($datosOI[$i][1]), 1, 0, 'L');
        } else {
            $this->Cell(35, 4, '', 1, 0, 'L');
            $this->Cell(50, 4, '', 1, 0, 'L');
        }
        
        $y_actual += 4;
    }
    
    $this->SetY($y_actual + 2);
}
}

$pdf = new PDF('P', 'mm', 'Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 30);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(230, 240, 255);
$pdf->Cell(0, 6, 'Datos del Paciente:', 0, 1, 'L', true);

$pdf->SetFont('Arial', '', 8);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(35, 5, 'Servicio:', 0, 0, 'L');
$pdf->Cell(55, 5, utf8_decode($tipo_a), 0, 0, 'L');
$pdf->Cell(35, 5, 'Fecha de registro:', 0, 0, 'L');
$pdf->Cell(0, 5, date('d/m/Y H:i', strtotime($fecha_ing)), 0, 1, 'L');
$pdf->Cell(35, 5, 'Paciente:', 0, 0, 'L');
$pdf->Cell(55, 5, utf8_decode($folio . ' - ' . $papell . ' ' . $sapell . ' ' . $nom_pac), 0, 0, 'L');
$pdf->Cell(35, 5, utf8_decode('Teléfono:'), 0, 0, 'L');
$pdf->Cell(0, 5, utf8_decode($tel), 0, 1, 'L');

$pdf->Cell(35, 5, utf8_decode('Fecha de nacimiento:'), 0, 0, 'L');
$pdf->Cell(30, 5, date('d/m/Y', strtotime($fecnac)), 0, 0, 'L');
$pdf->Cell(10, 5, utf8_decode('Edad:'), 0, 0, 'L');
$pdf->Cell(15, 5, utf8_decode($edad), 0, 0, 'L');
$pdf->Cell(15, 5, utf8_decode('Género:'), 0, 0, 'L');
$pdf->Cell(20, 5, utf8_decode($sexo), 0, 0, 'L');
$pdf->Cell(20, 5, utf8_decode('Ocupación:'), 0, 0, 'L');
$pdf->Cell(0, 5, utf8_decode($ocup), 0, 1, 'L');

$pdf->Cell(20, 5, utf8_decode('Domicilio:'), 0, 0, 'L');
$pdf->Cell(0, 5, utf8_decode($dir), 0, 1, 'L');
$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(220, 230, 250);
$pdf->Cell(0, 6, utf8_decode('Datos de la Prueba Oftalmológica'), 0, 1, 'L', true);

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(50, 5, 'Tipo de Prueba:', 1, 0, 'L');
$pdf->Cell(60, 5, utf8_decode($row_prueba['tipo_prueba']), 1, 0, 'L');
$pdf->Cell(30, 5, 'Resultado:', 1, 0, 'L');
$pdf->Cell(0, 5, utf8_decode($row_prueba['resultado']), 1, 1, 'L');

$pdf->Cell(50, 5, 'Fecha de Consulta:', 1, 0, 'L');
$pdf->Cell(60, 5, date('d/m/Y H:i', strtotime($row_prueba['fecha_consulta'])), 1, 0, 'L');
$pdf->Cell(30, 5, 'Ojo Preferente:', 1, 0, 'L');
$pdf->Cell(0, 5, utf8_decode($row_prueba['ojo_preferente']), 1, 1, 'L');

$pdf->Cell(50, 5, 'Observaciones:', 1, 0, 'L');
$pdf->Cell(0, 5, utf8_decode($row_prueba['observaciones']), 1, 1, 'L');
$pdf->Ln(2);

$datosOD = [
    ['Estrabismo', $row_prueba['estrabismo_od']],
    ['Movimientos', $row_prueba['movimientos_od']],
    ['Convergencia', $row_prueba['convergencia_od']],
    ['Prueba Cover', $row_prueba['prueba_cover_od']],
    ['Visión Estéreo', $row_prueba['vision_estereo_od']],
    ['Worth', $row_prueba['worth_od']],
    ['Schirmer', $row_prueba['schirmer_od']],
    ['TRPL', $row_prueba['trpl_od']],
    ['Fluoresceína', $row_prueba['fluoresceina_od']],
    ['Contraste', $row_prueba['contraste_od']],
    ['Ishihara', $row_prueba['ishihara_od']],
    ['Farnsworth', $row_prueba['farnsworth_od']],
    ['Amsler', $row_prueba['amsler_od']]
];

$datosOI = [
    ['Estrabismo', $row_prueba['estrabismo_oi']],
    ['Movimientos', $row_prueba['movimientos_oi']],
    ['Convergencia', $row_prueba['convergencia_oi']],
    ['Prueba Cover', $row_prueba['prueba_cover_oi']],
    ['Visión Estéreo', $row_prueba['vision_estereo_oi']],
    ['Worth', $row_prueba['worth_oi']],
    ['Schirmer', $row_prueba['schirmer_oi']],
    ['TRPL', $row_prueba['trpl_oi']],
    ['Fluoresceína', $row_prueba['fluoresceina_oi']],
    ['Contraste', $row_prueba['contraste_oi']],
    ['Ishihara', $row_prueba['ishihara_oi']],
    ['Farnsworth', $row_prueba['farnsworth_oi']],
    ['Amsler', $row_prueba['amsler_oi']]
];

$pdf->tablasLadoALado($datosOD, $datosOI, 'Resultados OD (Ojo Derecho)', 'Resultados OI (Ojo Izquierdo)');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->Cell(0, 6, utf8_decode('Detalle de la Prueba'), 0, 1, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 5, utf8_decode($row_prueba['detalle_prueba']), 1, 'J', false);

$pdf->SetY(-45);
if (!empty($firma) && file_exists('../../imgfirma/' . $firma)) {
    $imgWidth = 30;
    $imgX = ($pdf->GetPageWidth() - $imgWidth) / 2;
    $pdf->Image('../../imgfirma/' . $firma, $imgX, $pdf->GetY(), $imgWidth);
    $pdf->Ln(16);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 4, utf8_decode(trim($pre_med . ' ' . $app_med . ' ' . $apm_med . ' ' . $nom_med)), 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 4, utf8_decode($cargp), 0, 1, 'C');
$pdf->Cell(0, 4, utf8_decode('Céd. Prof. ' . $ced_p), 0, 1, 'C');
$pdf->Output();