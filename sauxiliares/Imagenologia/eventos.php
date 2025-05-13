<?php
session_start();

header('content-type: application/Json; charset=utf-8');
header('Access-Control-Allow-Origin: *');

//$pdo=new PDO("mysql:dbname=u542863078_sanisidro;host=localhost","u542863078_sima_sanisidro","SimaT0ols2022");
$pdo=new PDO("mysql:dbname=u542863078_msanisidro;host=localhost","u542863078_sima_msi","R809b@x/u");

$accion= (isset($_GET['accion']))?$_GET['accion']:'leer';
switch ($accion) {

	case 'agregar':
		// instruccion agregar
	$sentenciaSQL=$pdo->prepare("INSERT INTO agenda(title,descripcion,color,textColor,start,end,tipo,medico,enfermera,quirofano,duracion,estatus)
		VALUES(:title,:descripcion,:color,:textColor,:start,:end,:tipo,:medico,:enfermera,:quirofano,:duracion,:estatus)");


		$respuesta=$sentenciaSQL->execute(array(
			"title" =>$_POST['title'],
			"descripcion" =>$_POST['descripcion'],
			"color" =>$_POST['color'],
			"textColor" =>$_POST['textColor'],
			"start" =>$_POST['start'],
			"end" =>$_POST['end'],
			"tipo" =>$_POST['tipo'],
			"medico" =>$_POST['medico'],
			"enfermera" =>$_POST['enfermera'],
			"quirofano" =>$_POST['quirofano'],
			"duracion" =>$_POST['duracion'],
			"estatus" =>"Activa"
			
		));

		echo json_encode($respuesta);
		break;

	case'eliminar':
		// instruccion eliminar
		$respuesta=false;
		if(isset($_POST['id'])){
			$sentenciaSQL=$pdo->prepare("DELETE FROM agenda WHERE ID=:ID");
			$respuesta=$sentenciaSQL->execute(array("ID"=>$_POST['id']));
		}
		echo json_encode($respuesta);
		break;

	case 'modificar':
		// instruccion modificar
		$sentenciaSQL=$pdo->prepare("UPDATE agenda SET
			title=:title,
			descripcion=:descripcion,
			color=:color,
			textColor=:textColor,
			start=:start,
			end=:end,
			tipo=:tipo,
			medico=:medico,
			enfermera=:enfermera,
			quirofano=:quirofano,
			duracion=:duracion,
			estatus=:estatus,
			motivo=:motivo
			WHERE ID=:ID
			");

		$respuesta=$sentenciaSQL->execute(array(
			"ID"=>$_POST['id'],	
			"title" =>$_POST['title'],
			"descripcion" =>$_POST['descripcion'],
			"color" =>$_POST['color'],
			"textColor" =>$_POST['textColor'],
			"start" =>$_POST['start'],
			"end" =>$_POST['end'],
			"tipo" =>$_POST['tipo'],
			"medico" =>$_POST['medico'],
			"enfermera" =>$_POST['enfermera'],
			"quirofano" =>$_POST['quirofano'],
			"duracion" =>$_POST['duracion'],
			"estatus" =>"Activa",
			"motivo" =>$_POST['motivo']
		));

		echo json_encode($respuesta);

		break;

case 'reprogramar':
		// instruccion reprgamar
		$sentenciaSQL=$pdo->prepare("UPDATE agenda SET
			title=:title,
			descripcion=:descripcion,
			color=:color,
			textColor=:textColor,
			start=:start,
			end=:end,
			tipo=:tipo,
			medico=:medico,
			enfermera=:enfermera,
			quirofano=:quirofano,
			duracion=:duracion,
			estatus=:estatus,
			motivo=:motivo
			WHERE ID=:ID
			");

		$respuesta=$sentenciaSQL->execute(array(
			"ID"=>$_POST['id'],	
			"title" =>$_POST['title'],
			"descripcion" =>$_POST['descripcion'],
			"color" =>$_POST['color'],
			"textColor" =>$_POST['textColor'],
			"start" =>$_POST['start'],
			"end" =>$_POST['end'],
			"tipo" =>$_POST['tipo'],
			"medico" =>$_POST['medico'],
			"enfermera" =>$_POST['enfermera'],
			"quirofano" =>$_POST['quirofano'],
			"duracion" =>$_POST['duracion'],
			"estatus" =>"Reprogramada",
			"motivo" =>$_POST['motivo']
		));

		echo json_encode($respuesta);

		break;

case 'cancelar':
		// instruccion cancelar
		$sentenciaSQL=$pdo->prepare("UPDATE agenda SET
			color=:color,
			estatus=:estatus
			WHERE ID=:ID
			");

		$respuesta=$sentenciaSQL->execute(array(
			"ID"=>$_POST['id'],	
			"color" =>'#989994',
			"estatus" =>"Cancelada"
			
		));

		echo json_encode($respuesta);

		break;

	default:
			//seleccionar eventos del calendario
			$sentenciaSQL=$pdo->prepare("SELECT * FROM agenda");
			$sentenciaSQL->execute();
			$resultado=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($resultado);
		break;
}






?>



