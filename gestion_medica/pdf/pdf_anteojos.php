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



$id_receta = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql_receta = "SELECT * FROM recetas_anteojos WHERE id = $id_receta LIMIT 1";$result_receta = $conexion->query($sql_receta);
$row_receta = $result_receta->fetch_assoc();


if (!$row_receta) {
    echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
    echo '<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>';
    echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>';
    echo '<script>
        $(document).ready(function() {
            swal({
                title: "NO EXISTE HISTORIA CLÍNICA PARA ESTE PACIENTE", 
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

$esf_lejana_od = $row_receta['esf_lejana_od'] ?? '';
$cil_lejana_od = $row_receta['cil_lejana_od'] ?? '';
$eje_lejana_od = $row_receta['eje_lejana_od'] ?? '';
$add_lejana_od = $row_receta['add_lejana_od'] ?? '';
$dip_lejana_od = $row_receta['dip_lejana_od'] ?? '';
$prisma_lejana_od = !empty($row_receta['prisma_lejana_od']) ? utf8_decode('Sí') : 'No';

$esf_lejana_oi = $row_receta['esf_lejana_oi'] ?? '';
$cil_lejana_oi = $row_receta['cil_lejana_oi'] ?? '';
$eje_lejana_oi = $row_receta['eje_lejana_oi'] ?? '';
$add_lejana_oi = $row_receta['add_lejana_oi'] ?? '';
$dip_lejana_oi = $row_receta['dip_lejana_oi'] ?? '';
$prisma_lejana_oi = !empty($row_receta['prisma_lejana_oi']) ? utf8_decode('Sí') : 'No';

$esf_intermedia_od = $row_receta['esf_intermedia_od'] ?? '';
$cil_intermedia_od = $row_receta['cil_intermedia_od'] ?? '';
$eje_intermedia_od = $row_receta['eje_intermedia_od'] ?? '';
$dip_intermedia_od = $row_receta['dip_intermedia_od'] ?? '';

$esf_intermedia_oi = $row_receta['esf_intermedia_oi'] ?? '';
$cil_intermedia_oi = $row_receta['cil_intermedia_oi'] ?? '';
$eje_intermedia_oi = $row_receta['eje_intermedia_oi'] ?? '';
$dip_intermedia_oi = $row_receta['dip_intermedia_oi'] ?? '';

$esf_cercana_od = $row_receta['esf_cercana_od'] ?? '';
$cil_cercana_od = $row_receta['cil_cercana_od'] ?? '';
$eje_cercana_od = $row_receta['eje_cercana_od'] ?? '';
$dip_cercana_od = $row_receta['dip_cercana_od'] ?? '';
$prisma_cercana_od = !empty($row_receta['prisma_cercana_od']) ? utf8_decode('Sí') : 'No';

$esf_cercana_oi = $row_receta['esf_cercana_oi'] ?? '';
$cil_cercana_oi = $row_receta['cil_cercana_oi'] ?? '';
$eje_cercana_oi = $row_receta['eje_cercana_oi'] ?? '';
$dip_cercana_oi = $row_receta['dip_cercana_oi'] ?? '';
$prisma_cercana_oi = !empty($row_receta['prisma_cercana_oi']) ? utf8_decode('Sí') : 'No';

$tipo_lente_od = $row_receta['tipo_lente_od'] ?? '';
$tipo_lente_oi = $row_receta['tipo_lente_oi'] ?? '';
$observaciones = $row_receta['observaciones'] ?? '';
$fecha_anteojo = $row_receta['fecha'] ?? date('Y-m-d H:i:s');
$GLOBALS['fecha_anteojo'] = $fecha_anteojo;
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
        $this->Cell(0, 6, utf8_decode('NOTA DE RECETA ANTEOJOS'), 0, 1, 'C');
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(100, 100, 100);
        $this->Cell(0, 3, utf8_decode('Fecha: ') . date('d/m/Y H:i', strtotime($GLOBALS['fecha_anteojo'])), 0, 1, 'R');
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

$pdf->Ln(3);
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(220, 230, 250);
$pdf->Cell(0, 8, utf8_decode('RECETA DE ANTEOJOS'), 0, 1, 'C', true);
$pdf->Ln(1);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(35); 
$pdf->Cell(140, 6, utf8_decode('Lejana'), 0, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(35);
$pdf->Cell(20, 5, '', 1, 0, 'C', true);
$pdf->Cell(20, 5, 'Esfera', 1, 0, 'C', true);
$pdf->Cell(20, 5, 'Cilindro', 1, 0, 'C', true);
$pdf->Cell(20, 5, 'Eje', 1, 0, 'C', true);
$pdf->Cell(20, 5, 'Add', 1, 0, 'C', true);
$pdf->Cell(20, 5, 'DIP', 1, 0, 'C', true);
$pdf->Cell(20, 5, 'Prisma', 1, 1, 'C', true);

$pdf->SetX(35);
$pdf->Cell(20, 5, 'OD', 1, 0, 'C');
$pdf->Cell(20, 5, $esf_lejana_od, 1, 0, 'C');
$pdf->Cell(20, 5, $cil_lejana_od, 1, 0, 'C');
$pdf->Cell(20, 5, $eje_lejana_od, 1, 0, 'C');
$pdf->Cell(20, 5, $add_lejana_od, 1, 0, 'C');
$pdf->Cell(20, 5, $dip_lejana_od, 1, 0, 'C');
$pdf->Cell(20, 5, $prisma_lejana_od, 1, 1, 'C');

$pdf->SetX(35);
$pdf->Cell(20, 5, 'OI', 1, 0, 'C');
$pdf->Cell(20, 5, $esf_lejana_oi, 1, 0, 'C');
$pdf->Cell(20, 5, $cil_lejana_oi, 1, 0, 'C');
$pdf->Cell(20, 5, $eje_lejana_oi, 1, 0, 'C');
$pdf->Cell(20, 5, $add_lejana_oi, 1, 0, 'C');
$pdf->Cell(20, 5, $dip_lejana_oi, 1, 0, 'C');
$pdf->Cell(20, 5, $prisma_lejana_oi, 1, 1, 'C');

$pdf->Ln(2);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(35);
$pdf->Cell(140, 6, utf8_decode('Intermedia'), 0, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(35);
$pdf->Cell(28, 5, '', 1, 0, 'C', true);
$pdf->Cell(28, 5, 'Esfera', 1, 0, 'C', true);
$pdf->Cell(28, 5, 'Cilindro', 1, 0, 'C', true);
$pdf->Cell(28, 5, 'Eje', 1, 0, 'C', true);
$pdf->Cell(28, 5, 'DIP', 1, 1, 'C', true);

$pdf->SetX(35);
$pdf->Cell(28, 5, 'OD', 1, 0, 'C');
$pdf->Cell(28, 5, $esf_intermedia_od, 1, 0, 'C');
$pdf->Cell(28, 5, $cil_intermedia_od, 1, 0, 'C');
$pdf->Cell(28, 5, $eje_intermedia_od, 1, 0, 'C');
$pdf->Cell(28, 5, $dip_intermedia_od, 1, 1, 'C');

$pdf->SetX(35);
$pdf->Cell(28, 5, 'OI', 1, 0, 'C');
$pdf->Cell(28, 5, $esf_intermedia_oi, 1, 0, 'C');
$pdf->Cell(28, 5, $cil_intermedia_oi, 1, 0, 'C');
$pdf->Cell(28, 5, $eje_intermedia_oi, 1, 0, 'C');
$pdf->Cell(28, 5, $dip_intermedia_oi, 1, 1, 'C');

$pdf->Ln(2);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->SetX(35);
$pdf->Cell(140, 6, utf8_decode('Cercana'), 0, 1, 'C', true);
$pdf->SetFont('Arial', '', 8);
$pdf->SetX(35);
$pdf->Cell(23, 5, '', 1, 0, 'C', true);
$pdf->Cell(23, 5, 'Esfera', 1, 0, 'C', true);
$pdf->Cell(23, 5, 'Cilindro', 1, 0, 'C', true);
$pdf->Cell(23, 5, 'Eje', 1, 0, 'C', true);
$pdf->Cell(23, 5, 'DIP', 1, 0, 'C', true);
$pdf->Cell(23, 5, 'Prisma', 1, 1, 'C', true);

$pdf->SetX(35);
$pdf->Cell(23, 5, 'OD', 1, 0, 'C');
$pdf->Cell(23, 5, $esf_cercana_od, 1, 0, 'C');
$pdf->Cell(23, 5, $cil_cercana_od, 1, 0, 'C');
$pdf->Cell(23, 5, $eje_cercana_od, 1, 0, 'C');
$pdf->Cell(23, 5, $dip_cercana_od, 1, 0, 'C');
$pdf->Cell(23, 5, $prisma_cercana_od, 1, 1, 'C');

$pdf->SetX(35);
$pdf->Cell(23, 5, 'OI', 1, 0, 'C');
$pdf->Cell(23, 5, $esf_cercana_oi, 1, 0, 'C');
$pdf->Cell(23, 5, $cil_cercana_oi, 1, 0, 'C');
$pdf->Cell(23, 5, $eje_cercana_oi, 1, 0, 'C');
$pdf->Cell(23, 5, $dip_cercana_oi, 1, 0, 'C');
$pdf->Cell(23, 5, $prisma_cercana_oi, 1, 1, 'C');

$pdf->Ln(3);

$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->Cell(0, 6, utf8_decode('Tipo de Lente'), 0, 1, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(40, 5, 'OD: ' . utf8_decode($tipo_lente_od), 0, 1, 'L');
$pdf->Cell(40, 5, 'OI: ' . utf8_decode($tipo_lente_oi), 0, 1, 'L');

$pdf->Ln(1);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetFillColor(245, 245, 245);
$pdf->Cell(0, 6, utf8_decode('Observaciones'), 0, 1, 'L', true);
$pdf->SetFont('Arial', '', 8);
$pdf->MultiCell(0, 5, utf8_decode($observaciones), 1, 'J', false);

$pdf->SetY(-42);
if (!empty($firma) && file_exists('../../imgfirma/' . $firma)) {
    $imgWidth = 30;
    $imgX = ($pdf->GetPageWidth() - $imgWidth) / 2;
    $pdf->Image('../../imgfirma/' . $firma, $imgX, $pdf->GetY(), $imgWidth);
    $pdf->Ln(2);
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0, 4, utf8_decode(trim($pre_med . ' ' . $app_med . ' ' . $apm_med . ' ' . $nom_med)), 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 4, utf8_decode($cargp), 0, 1, 'C');
$pdf->Cell(0, 4, utf8_decode('Céd. Prof. ' . $ced_p), 0, 1, 'C');
$pdf->Output();