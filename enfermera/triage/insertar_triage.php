<?php
session_start();
include '../../conexionbd.php';
$usuario = $_SESSION['login'];
$id_usu = $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];

$diab= "";
$h_arterial= "";	
$enf_card_pulm= "";
$cancer= "";	
$emb= "";	
$otro= "";	

    if(isset($_POST['diab'])){
	$diab=$_POST['diab'];
	}else{
		$diab= "";
		
	}
	if(isset($_POST['h_arterial']) ){
	$h_arterial=$_POST['h_arterial'];
	}else{
		$h_arterial= "";	
	}

	if(isset($_POST['enf_card_pulm']) ){
	$enf_card_pulm=$_POST['enf_card_pulm'];
	}else{
		$enf_card_pulm= "";
	}
	if(isset($_POST['cancer']) ){
	$cancer=$_POST['cancer'];
	}else{
		$cancer= "";	
	}

	if(isset($_POST['emb']) ){
	$emb=$_POST['emb'];
	}else{
		$emb= "";	
	}
	if(isset($_POST['otro']) ){
	$otro=$_POST['otro'];
	}else{
		$otro= "";	
	}
	
if (isset($_POST['id_atencion'])and 
    isset($_POST['p_sistolica'])and 
isset($_POST['p_diastolica']) and 
isset($_POST['f_card']) and 
isset($_POST['f_resp']) and 
isset($_POST['temp']) and 
isset($_POST['sat_oxigeno']) and 
isset($_POST['peso']) and 
isset($_POST['talla']) and 
isset($_POST['niv_dolor'])and
isset($_POST['val_total']) and 
isset($_POST['edo_clin']) and 
isset($_POST['urgencia'])){

$id_atencion=($_POST['id_atencion']);
$p_sistolica=($_POST['p_sistolica']);
$p_diastolica=($_POST['p_diastolica']);
$f_card=($_POST['f_card']);
$f_resp=($_POST['f_resp']);
$temp=($_POST['temp']);
$sat_oxigeno=($_POST['sat_oxigeno']);
$peso=($_POST['peso']);
$talla=($_POST['talla']);
$niv_dolor=($_POST['niv_dolor']);
/*
$diab=($_POST['diab']);
$h_arterial=($_POST['h_arterial']);
$enf_card_pulm=($_POST['enf_card_pulm']);
$cancer=($_POST['cancer']);
$emb=($_POST['emb']);*/
$otro=($_POST['otro']);
$val_total=($_POST['val_total']);
$edo_clin=($_POST['edo_clin']);
$imp_diag=($_POST['imp_diag']);

$urgencia=($_POST['urgencia']);

/* $destino=($_POST['destino']);
$id_cam = $_POST['habitacion'];*/




if(isset($_POST['adic_cu'])){
    $adic_cu = $_POST['adic_cu'];
  }else{
    $adic_cu = "";
  }

  if(isset($_POST['tab_cu'])){
    $tab_cu = $_POST['tab_cu'];
  }else{
    $tab_cu = "";
  }

  if(isset($_POST['alco_cu'])){
    $alco_cu = $_POST['alco_cu'];
  }else{
    $alco_cu = "";
  }

  

if(isset($_POST['quir_cu'])){
    $quir_cu = $_POST['quir_cu'];
}else{
    $quir_cu = "";
}

if(isset($_POST['aler_cu'])){
    $aler_cu = $_POST['aler_cu'];
}else{
    $aler_cu = "";
}

if(isset($_POST['trau_cu'])){
    $trau_cu = $_POST['trau_cu'];
}else{
        $trau_cu = "";
}

if(isset($_POST['trans_cu'])){
    $trans_cu = $_POST['trans_cu'];
}else{
        $trans_cu = "";
    }

    if(isset($_POST['diab_pa'])){
    $diab_pa = $_POST['diab_pa'];
}else{
        $diab_pa = "";
    }

    if(isset($_POST['diab_ma'])){
    $diab_ma = $_POST['diab_ma'];
}else{
        $diab_ma = "";
    }

    if(isset($_POST['diab_ab'])){
    $diab_ab = $_POST['diab_ab'];
}else{
        $diab_ab = "";
    }

 if(isset($_POST['hip_pa'])){
    $hip_pa = $_POST['hip_pa'];
}else{
        $hip_pa = "";
    }

 if(isset($_POST['hip_ma'])){
    $hip_ma = $_POST['hip_ma'];
}else{
        $hip_ma = "";
    }

     if(isset($_POST['hip_ab'])){
    $hip_ab = $_POST['hip_ab'];
}else{
        $hip_ab = "";
    }

    if(isset($_POST['can_pa'])){
    $can_pa = $_POST['can_pa'];
}else{
        $can_pa = "";
    }
    if(isset($_POST['can_ma'])){
    $can_ma = $_POST['can_ma'];
}else{
        $can_ma = "";
    }
   
    if(isset($_POST['can_ab'])){
    $can_ab = $_POST['can_ab'];
}else{
        $can_ab = "";
    }

        if(isset($_POST['hc_desc_hom'])){
    $hc_desc_hom = $_POST['hc_desc_hom'];
}else{
        $hc_desc_hom = "";
    }


 
$fecha_actual = date("Y-m-d H:i:s");

  }

// separador

$fecha_actual = date("Y-m-d H:i:s");


function calculaedad($fechanacimiento)
{
  list($ano, $mes, $dia) = explode("-", $fechanacimiento);
  $ano_diferencia  = date("Y") - $ano;
  $mes_diferencia = date("m") - $mes;
  $dia_diferencia   = date("d") - $dia;
  if ($ano_diferencia > 0 )
      return ($ano_diferencia . ' AÑOS');
  else if ($mes_diferencia > 0 || $ano_diferencia < 0)
      return ($mes_diferencia . ' MESES');
   else if ($dia_diferencia > 0 || $mes_diferencia < 0 || $ano_diferencia < 0)
      return ($dia_diferencia . ' DÍAS');
}


 if(isset($_POST['sig'])){
    $p_sistolica=0;
    $p_diastolica=0;
    $f_card=0;
    $f_resp=0;
    $temp=0;
    $sat_oxigeno=0;
    }else{
        $p_sistolica=$_POST['p_sistolica'];
         $p_diastolica=$_POST['p_diastolica'];
         $f_card=$_POST['f_card'];
         $f_resp=$_POST['f_resp'];
         $temp=$_POST['temp'];
         $sat_oxigeno=$_POST['sat_oxigeno'];
    }
 $area=$_POST['area'];
    $ingresar=mysqli_query($conexion,'insert into triage(id_atencion,p_sistolica,p_diastolica,f_card,f_resp,temp,sat_oxigeno,peso,talla,niv_dolor,diab,h_arterial,enf_card_pulm,cancer,emb,otro,val_total,edo_clin,imp_diag,urgencia,fecha_t,id_usua) values
    ("'.$id_atencion.'","'.$p_sistolica.'","'.$p_diastolica.'","'.$f_card.'","'.$f_resp.'","'.$temp.'","'.$sat_oxigeno.'","'.$peso.'","'.$talla.'","'.$niv_dolor.'","'.$diab.'","'.$h_arterial.'","'.$enf_card_pulm.'","'.$cancer.'","'.$emb.'","'.$otro.'","'.$val_total.'","'.$edo_clin.'","'.$imp_diag.'","'.$urgencia.'","'.$fecha_actual.'",' . $id_usu . ')') or die ('<p>Error al registrar</p><br>'.mysqli_error($conexion));

$select="SELECT * FROM triage order by id_triage DESC LIMIT 1";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_triage=$row['id_triage'];
    }


$select="SELECT * FROM recetaurgen order by id_rec_urgen DESC LIMIT 1";
    $result=$conexion->query($select);
    while ($row=$result->fetch_assoc()) {
    $id_rec_urgen=$row['id_rec_urgen'];
    }

echo '<script >window.open("pdf_triage.php?tri='.$id_triage.'&id='.$id_atencion.'&id_med='.$id_usu.'&rec='.$id_rec_urgen.' " , "RECETA AMBULATORIA", "width=1000, height=1000")</script>'.
 '<script type="text/javascript">window.location.href ="vista_usuario_triage.php" ;</script>';
    //redireccion
 


?>

