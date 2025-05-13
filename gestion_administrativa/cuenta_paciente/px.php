<?php

include "conexionbdf.php";

$file_factura = "comprobanteTimbrado.xml";

$xml_content = file_get_contents($file_factura);

$xml_content = str_replace("<tfd:", "<cfdi:", $xml_content);
$xml_content = str_replace("<cfdi:", "<", $xml_content);
$xml_content = str_replace("</cfdi:", "</", $xml_content);

$xml_content = str_replace("<nomina12:", "<", $xml_content);
$xml_content = str_replace("</nomina12:", "</", $xml_content);
$xml_content = str_replace("<nomina11:", "<", $xml_content);
$xml_content = str_replace("</nomina11:", "</", $xml_content);

$xml_content = str_replace("<pago10:", "<", $xml_content);
$xml_content = str_replace("</pago10:", "</", $xml_content);

$xml_content = str_replace("@attributes", "attributes", $xml_content);


$xml_content = simplexml_load_string(utf8_encode($xml_content));

$xml_content = (array) $xml_content;

// xml data
$xml_data["version"]       = $xml_content["@attributes"]["Version"];
$xml_data["fecha"]       = $xml_content["@attributes"]["Fecha"];
$xml_data["total"]       = $xml_content["@attributes"]["Total"];
$xml_data["subtotal"]       = $xml_content["@attributes"]["SubTotal"] ;
$xml_data["moneda"]       = $xml_content["@attributes"]["Moneda"] ;
$xml_data["sello"]       = $xml_content["@attributes"]["Sello"];

$xml_data["nocertificado"]       = $xml_content["@attributes"]["NoCertificado"];

$xml_content["Emisor"] = (array) $xml_content["Emisor"];
$xml_content["Receptor"] = (array) $xml_content["Receptor"];
$xml_content["Complemento"] = (array) $xml_content["Complemento"];
$xml_content["Complemento"]["TimbreFiscalDigital"] = (array) $xml_content["Complemento"]["TimbreFiscalDigital"];

$xml_data["rfc_emisor"]  = $xml_content["Emisor"]["@attributes"]["Rfc"];
$xml_data["rfc_receptor"]  = $xml_content["Receptor"]["@attributes"]["Rfc"];
$xml_data["uuid"]       = $xml_content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["UUID"];

$xml_data["sellosat"]       = $xml_content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["SelloSAT"];
$xml_data["cfd"]       = $xml_content["Complemento"]["TimbreFiscalDigital"]["@attributes"]["SelloCFD"];

$xml_data["impuestos"]=$xml_content["Impuestos"]["TotalImpuestosTrasladados"];

//print_r ($xml_data);
//echo $xml_data["impuestos"];

// insert data
//$insertconc=mysqli_query($conexion,'INSERT INTO comprobantes(id_atencion,id_usua,fecha,cadenaor,sellosat,sellocfd,nocertificado,version, subtotal, total, moneda, sello, rfc_emisor, rfc_receptor, uuid) values (1,2,"'.$xml_data["fecha"].'",2,"'.$xml_data["sellosat"] .'","'.$xml_data["cfd"].'","'.$xml_data["nocertificado"].'","'.$xml_data["version"].'","'.$xml_data["subtotal"].'","'.$xml_data["total"].'","'.$xml_data["moneda"].'","'.$xml_data["sello"].'","'.$xml_data["rfc_emisor"].'","'.$xml_data["rfc_receptor"].'","'.$xml_data["uuid"].'")') or die ('<p>Error al registrar</p><br>' . mysqli_error($conexion));


//$sql = "INSERT INTO comprobantes(sellosat,sellocfd)VALUES (:sellosat,:cfd)";
//$stm = $conexion->prepare($insertconc);
//$stm->execute($xml_data); 
//print_r("Registro agregado"); exit; 


$daseg=$daseg/100;
//operaciones para descuentos
     echo  $english_format_number = number_format($dasegg=(25552.00)*(.1), 2, '.', ''); //subtototal * aseguradora
 echo '<br>';

  echo $english_format_number = number_format($sumadesc=(100.00)+($dasegg), 2, '.', ''); //suma descuentos arriba esto va en descuento 2
  

  
     echo '<br>';
  echo $cdesc=floor(($sumadesc)/(25552.00)*100)/100; // para sacar $ de descuento
       echo '<br>';
  
   //echo $d=(($sumadesc)/(25552.00)*1000000)/1000000;
     echo '<br>';
   
echo "traslado de hasta abajo:" . floor($ivaa=(25552.00-$sumadesc)*(.16)*100)/100;//iva 2

   echo '<br>';
    echo $english_format_number = number_format($totar=(25552.00-$sumadesc)+($ivaa), 2, '.', '');//TOTAL FINA 2
    
  echo '<br>';
     echo $english_format_number = number_format($tprec=25552.00, 2, '.', '');////se cnvierte en subtotal 2
     //fin operaciones para descuentos
     
     echo '<br>';
     

  echo 'descuento de concepto: ' . $tra=floor((6.01*$cdesc)*100)/100; //subtototal * aseguradora =descuento de concepto
  
  echo '<br>';
 
  echo '<br>';
  
echo "base traslado: " .  $trasbasecon=($sumadesc)-(6.01); // impo concep - total descuento ESTO VA EN  TRASLADO BASE DE CONCEPTOS
  echo '<br>';
echo "importe traslado:" .   $importt=$english_format_number = number_format(($trasbasecon)*(.16),2, '.', ''); // traslado base *.16 = importe de traslado
  
 echo  '<br>';
   $trasbase= $english_format_number = number_format((6.01 - $sumadesc)); // total descuento ESTO VA EN  TRASLADO BASE DE total de impuestos

 echo  '<br>';
   echo "traslado por conceptos: " . $english_format_number = number_format($trasporc=floor(((6.01 - $tra)*.16)*100)/100,2, '.', ''); // total descuento ESTO VA EN  TRASLADO BASE DE total de impuestos

 echo  '<br>';
echo "25*0.1: " . $english_format_number = number_format($dasegg=floor((25552.00)*(0.1)*100)/100, 2, '.', ''); //subtototal * aseguradora
 echo  '<br>';
echo "traslado: " . $english_format_number = number_format($sumadesc=floor(((25552.00)-($dasegg)-100)*100)/100, 2, '.', ''); //suma descuentos arriba esto va en descuento 2
echo  '<br>';
echo "iva: " . $english_format_number = number_format($iva=floor(($sumadesc)*(.16)*100)/100, 2, '.', ''); //suma descuentos arriba esto va en descuento 2
echo  '<br>';

echo "factor:" .$cdesc=((2655.20*100)/(25552.00))/100; // para sacar $ de descuento



echo  '<br>';
echo "var :" .round($ss,2);
echo  '<br>';
echo "tot1:".$total1=(6.01-(6.01*$cdesc))*.16;
echo  '<br>';
echo "tot2:".$total2=(94.06-(94.06*$cdesc))*.16;
echo  '<br>';
echo "tot3:".$total3=(24191.94-(24191.94*$cdesc))*.16;
echo  '<br>';
echo "tot4:".$total4=(1259.99-(1259.99*$cdesc))*.16;

echo  '<br>';
echo "sumatot:".$totdesc=$total1+$total2+$total3+$total4;


?>


