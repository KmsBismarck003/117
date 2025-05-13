<?php

session_start();


//include "../../conexionbd.php";
include "../header_enfermera.php";
$resultado = $conexion->query("select * from reg_usuarios") or die($conexion->error);


  
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  <!--  Bootstrap  -->
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.0/css/font-awesome.css" rel="stylesheet">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

  <!---
  <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.11.2/css/bootstrap-select.min.css'>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
-->
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script>
        function habilitar(value){
            if(value=="OBSERVACION" || value==true){
                // habilitamos
                document.getElementById("cama2").disabled=false;
                document.getElementById("cama2").style.visibility = "visible";
            }else if(value!="OBSERVACION"   || value==false){
                // deshabilitamos
                document.getElementById("cama2").disabled=true;
                document.getElementById("cama2").style.visibility = "hidden";
            }

            if(value=="HOSPITALIZACION" || value==true){
                // habilitamos
                document.getElementById("cama").disabled=false;
                 document.getElementById("cama").style.visibility = "visible";
            }else if(value!="HOSPITALIZACION"   || value==false){
                // deshabilitamos
                document.getElementById("cama").disabled=true;
                document.getElementById("cama").style.visibility = "hidden";
            }
            if(value=="CONSULTA DE URGENCIAS" || value==true){
                // habilitamos
                document.getElementById("cama3").disabled=false;
                document.getElementById("cama3").style.visibility = "visible";
            }else if(value!="CONSULTA DE URGENCIAS"   || value==false){
                // deshabilitamos
                document.getElementById("cama3").disabled=true;
                document.getElementById("cama3").style.visibility = "hidden";
            }

        }
    </script>

  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search").keyup(function() {
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#mytable3 tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#searche").keyup(function() {
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#mytable4 tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>
  <script>
    // Write on keyup event of keyword input element
    $(document).ready(function() {
      $("#search_dep").keyup(function() {
        _this = this;
        // Show only matching TR, hide rest of them
        $.each($("#mytable tbody tr"), function() {
          if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
            $(this).hide();
          else
            $(this).show();
        });
      });
    });
  </script>
  <title>REGISTRO CLINICO DE ENFERMERIA</title>
  <style type="text/css">
   

#im{
margin-left: 178px;

}

#nuev1{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 215px; left:370px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}


#nuev2{
position: absolute;
top:222px; left:360px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
 
  border: 0;
   outline: none;
border:1px solid steelblue;

}


#nuev3{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 215px; left:312px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#nuev4{
position: absolute;
top:222px; left:260px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
   outline: none;
border:1px solid steelblue;

}

#nuev5{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 185px; left:312px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#nuev6{
position: absolute;
top:190px; left:260px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
   outline: none;
border:1px solid steelblue;

}

#nuev7{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 185px; left:342px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#nuev8{
position: absolute;
top:195px; left:310px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
   outline: none;
border:1px solid steelblue;

}

#nuev9{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 185px; left:370px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#nuev10{
position: absolute;
top:195px; left:360px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
   outline: none;
border:1px solid steelblue;
}

#nuev11{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 155px; left:370px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#nuev12{
position: absolute;
top:147px; left:380px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
   outline: none;
border:1px solid steelblue;
}

#nuev13{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 155px; left:342px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#nuev14{
position: absolute;
top:165px; left:320px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
   outline: none;
border:1px solid steelblue;
}

#nuev15{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 155px; left:312px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#nuev16{
position: absolute;
top:165px; left:270px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
   outline: none;
border:1px solid steelblue;
}

#uno{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 268px; left: 342px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

 #contenido1{
position: absolute;
top: 264px; left: 349px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#dos{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 245px; left: 353px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

 #contenido2{
position: absolute;
top: 240px; left: 360px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#tres{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 138px; left: 352px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#contenido3{
position: absolute;
top: 136px; left: 357px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#cuatro{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 88px; left: 359px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#contenido4{
position: absolute;
top: 83px; left: 366px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#cin{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 48px; left: 343px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#contenido5{
position: absolute;
top: 43px; left: 150px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#se{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 37px; left: 330px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#contenido6{
position: absolute;
top: 25px; left: 244px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#sie{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 217px; left: 244px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#contenido7{
position: absolute;
top: 210px; left: 156px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


/*ESPALDA*/
#oc{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 190px; left: 795px;  
padding: 1px 1px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;
}

#contenido8{
position: absolute;
top: 186px; left: 805px;  
 font-size: 10px;
background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#cero{
position: absolute;
top: -197px; left: 145px;  
 font-size: 20px;
}

#doso{
position: absolute;
top: -197px; left: 275px;  
 font-size: 20px;
}

#cuatroc{
position: absolute;
top: -197px; left: 412px;  
 font-size: 20px;
}

#seis{
position: absolute;
top: -197px; left: 543px;  
 font-size: 20px;
}

#ocho{
position: absolute;
top: -197px; left: 680px;  
 font-size: 20px;
}
#diez{
position: absolute;
top: -197px; left: 802px;  
 font-size: 20px;
}

#pi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 504px; left: 304px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipi{
position: absolute;
top: 500px; left: 216px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#pid{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 504px; left: 380px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipid{
position: absolute;
top: 501px; left: 390px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#toi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 482px; left: 312px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#tobi{
position: absolute;
top: 475px; left: 223px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#to{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 482px; left: 372px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#tobd{
position: absolute;
top: 476px; left: 380px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#roi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 370px; left: 308px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iroi{
position: absolute;
top: 366px; left: 223px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#brod{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 370px; left: 376px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#irod{
position: absolute;
top: 366px; left: 384px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#mui{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 314px; left: 306px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imi{
position: absolute;
top: 309px; left: 224px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#mud{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 310px; left: 377px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imd{
position: absolute;
top: 305px; left: 381px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#ingi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 245px; left: 331px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ingli{
position: absolute;
top: 240px; left: 248px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#domen{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 215px; left: 342px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#idomen{
position: absolute;
top: 209px; left: 346px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#ddoi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 254px; left: 202px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iddi{
position: absolute;
top: 250px; left: 118px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#ddoid{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 278px; left: 210px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iddid{
position: absolute;
top: 272px; left: 125px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#ditr{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 295px; left: 214px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iditr{
position: absolute;
top:298px; left:133px;  
 font-size: 10px;
 background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#dic{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 293px; left: 223px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#idic{
position: absolute;
top:295px; left:227px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#dicin{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 282px; left: 231px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#idicin{
position: absolute;
top:277px; left:236px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#bddu{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 254px; left: 482px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iddu{
position: absolute;
top:248px; left:485px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#bpmai{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 254px; left: 227px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipmai{
position: absolute;
top:249px; left:230px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#bmuñi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 235px; left: 236px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imuñi{
position: absolute;
top:230px; left:152px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#bbri{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 172px; left: 262px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ibri{
position: absolute;
top:168px; left:180px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#bbric{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 140px; left: 276px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ibric{
position: absolute;
top:135px; left:192px;  
 font-size: 10px;
    background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#bhomi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 110px; left: 276px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ihomi{
position: absolute;
top:105px; left:192px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#bcpi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 138px; left: 333px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icpi{
position: absolute;
top:150px; left:279px;  
 font-size: 10px;
  background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}


#bcpei{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 125px; left: 315px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icpei{
position: absolute;
top:120px; left:235px;  
 font-size: 10px;
   background-color: transparent;
  border: 0;
   font-weight: bold;
   outline: none;
border:1px solid steelblue;
}

#bcped{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 125px; left: 367px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icped{
position: absolute;
top:120px; left:370px;  
 font-size: 10px;
   font-weight: bold;
  background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcvi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 88px; left: 322px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icvi{
position: absolute;
top:79px; left:230px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}


#bddos{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 281px; left: 478px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iddos{
position: absolute;
top:276px; left:483px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}


#bddt{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 293px; left: 471px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iddt{
position: absolute;
top:295px; left:476px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bddc{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 290px; left: 462px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iddc{
position: absolute;
top:285px; left:377px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bddcinco{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 275px; left: 453px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iddcinco{
position: absolute;
top:272px; left:368px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bpalmad{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 254px; left: 457px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipalmad{
position: absolute;
top:249px; left:374px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmund{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 236px; left: 452px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imund{
position: absolute;
top:231px; left:456px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}


#bdbr{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 215px; left: 440px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#idbr{
position: absolute;
top:210px; left:448px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#babd{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 170px; left: 420px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ianbd{
position: absolute;
top:165px; left:430px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcder{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 133px; left: 413px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icder{
position: absolute;
top:128px; left:420px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bhder{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 108px; left: 410px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ihder{
position: absolute;
top:103px; left:419px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmand{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 58px; left: 359px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imand{
position: absolute;
top:53px; left:365px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}


#bmanc{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 67px; left: 343px;  
padding: 0px 0px;
font-size: 8.5px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imanc{
position: absolute;
top:66px; left:348px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmaniz{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 58px; left: 328px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imaniz{
position: absolute;
top:54px; left:242px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmejd{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 37px; left: 357px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imejd{
position: absolute;
top:32px; left:363px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bnariz{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 25px; left: 343px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#inariz{
position: absolute;
top:17px; left:349px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
outline: none;
border:1px solid steelblue;
}

#bfrentei{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 10px; left: 335px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;


}


#ifrentei{
position: absolute;
top:-5px; left:240px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
      outline: none;
border:1px solid steelblue;

height:1%;
}

#bfrented{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 10px; left: 351px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ifrented{
position: absolute;
top:-7px; left:364px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
outline: none;
border:1px solid steelblue;
}


#bppi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 510px; left: 758px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ippi{
position: absolute;
top:505px; left:673px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bppd{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 510px; left: 830px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ippd{
position: absolute;
top:505px; left:839px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#btia{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 480px; left: 765px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#itia{
position: absolute;
top:475px; left:680px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#btda{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 480px; left: 825px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#itda{
position: absolute;
top:475px; left:830px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bpani{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 427px; left: 762px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipani{
position: absolute;
top:422px; left:680px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bpand{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 427px; left: 827px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipand{
position: absolute;
top:422px; left:835px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bpchi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 375px; left: 760px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipchi{
position: absolute;
top:370px; left:675px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bpchd{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 375px; left: 830px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ipchd{
position: absolute;
top:370px; left:840px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmusai{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 325px; left: 765px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imusai{
position: absolute;
top:320px; left:680px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmusad{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 325px; left: 823px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imusad{
position: absolute;
top:320px; left:830px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bglui{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 255px; left: 770px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iglui{
position: absolute;
top:250px; left:685px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bglud{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 255px; left: 817px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iglud{
position: absolute;
top:250px; left:825px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcini{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 215px; left: 774px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icini{
position: absolute;
top:210px; left:692px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcind{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 215px; left: 813px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icind{
position: absolute;
top:210px; left:819px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcosi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 160px; left: 775px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icosi{
position: absolute;
top:155px; left:690px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}


#bcosd{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 160px; left: 815px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icosd{
position: absolute;
top:155px; left:820px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#besai{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 119px; left: 770px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iesai{
position: absolute;
top:115px; left:685px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#besad{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 119px; left: 818px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iesad{
position: absolute;
top:115px; left:825px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#besalt{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 85px; left: 795px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iesalt{
position: absolute;
top:80px; left:800px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}


#bdorsali{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 257px; left: 682px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#idorsali{
position: absolute;
top:252px; left:598px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bdorsald{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 257px; left: 910px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#idorsald{
position: absolute;
top:252px; left:916px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmuneati{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 238px; left: 685px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imuneati{
position: absolute;
top:233px; left:600px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bmuneatd{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 238px; left: 902px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#imuneatd{
position: absolute;
top:233px; left:910px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#banbei{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 220px; left: 698px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ianbei{
position: absolute;
top:215px; left:610px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#banbed{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 220px; left: 892px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ianbed{
position: absolute;
top:215px; left:900px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bccodoi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 185px; left:715px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iccodoi{
position: absolute;
top:180px; left:629px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bccodod{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 185px; left:875px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#iccodod{
position: absolute;
top:180px; left:880px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bbaiz{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 154px; left:716px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ibaiz{
position: absolute;
top:150px; left:630px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bbader{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 154px; left:874px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#ibader{
position: absolute;
top:150px; left:882px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcbajo{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 60px; left:795px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icbajo{
position: absolute;
top:55px; left:805px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcmedio{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 45px; left:795px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icmedio{
position: absolute;
top:40px; left:805px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcabezamedio{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 30px; left:795px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icabezamedio{
position: absolute;
top:25px; left:805px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcabaiz{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 18px; left:780px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icabaiz{
position: absolute;
top:14px; left:695px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#bcabader{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 18px; left:810px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#icabader{
position: absolute;
top:13px; left:816px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#espi{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 430px; left:310px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#cssespi{
position: absolute;
top:425px; left:210px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#espd{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 430px; left:375px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#cssespd{
position: absolute;
top:425px; left:390px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

#coxis{
background-color: transparent;
border: 1px solid transparent;
position: absolute;
top: 240px; left:795px;  
padding: 0px 0px;
font-size: 9px;
cursor: pointer;
color: black;
font-weight: bold;

}

#csscoxis{
position: absolute;
top:235px; left:710px;  
 font-size: 10px;
   font-weight: bold;
   background-color: transparent;
  border: 0;
  outline: none;
border:1px solid steelblue;
}

</style>
</head>
<body>
  <section class="content container-fluid">

    <?php

    include "../../conexionbd.php";
 
    if (isset($_SESSION['pac'])) {
      
        
      $id_atencion = $_SESSION['pac'];

      $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias,p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

      $result_pac = $conexion->query($sql_pac);

      while ($row_pac = $result_pac->fetch_assoc()) {
        $pac_papell = $row_pac['papell'];
        $pac_sapell = $row_pac['sapell'];
        $pac_nom_pac = $row_pac['nom_pac'];
        $pac_dir = $row_pac['dir'];
        $pac_id_edo = $row_pac['id_edo'];
        $pac_id_mun = $row_pac['id_mun'];
        $pac_tel = $row_pac['tel'];
        $pac_fecnac = $row_pac['fecnac'];
        $pac_fecing = $row_pac['fecha'];
        $pac_tip_sang = $row_pac['tip_san'];
        $pac_sexo = $row_pac['sexo'];
        $area = $row_pac['area'];
        $alta_med = $row_pac['alta_med'];
        $id_exp = $row_pac['Id_exp'];
        $alergias = $row_pac['alergias'];
        $folio = $row_pac['folio'];
      }

      $sql_pac = "SELECT * FROM  dat_ingreso WHERE id_atencion =$id_atencion";

          $result_pac = $conexion->query($sql_pac);

          while ($row_pac = $result_pac->fetch_assoc()) {
            $fingreso = $row_pac['fecha'];
             $fegreso = $row_pac['fec_egreso'];
             $alta_med = $row_pac['alta_med'];
             $alta_adm = $row_pac['alta_adm'];
             $activo = $row_pac['activo'];
             $valida = $row_pac['valida'];
          }

if($alta_med=='SI' && $alta_adm=='SI' && $activo=='NO' && $valida=='SI'){
    
    $sql_est = "SELECT DATEDIFF('$fegreso', '$fingreso') as estancia FROM dat_ingreso where id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
          if($row_est['estancia']==0){
               $estancia = $row_est['estancia']+1;
          }else{
              $estancia = $row_est['estancia'];
          }
       
      }
}else{
    
   $sql_now = "SELECT DATE_ADD(NOW(), INTERVAL 12 HOUR) as dat_now FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_now = $conexion->query($sql_now);

      while ($row_now = $result_now->fetch_assoc()) {
        $dat_now = $row_now['dat_now'];
      }

      $sql_est = "SELECT DATEDIFF( '$dat_now' , fecha) as estancia FROM dat_ingreso WHERE id_atencion = $id_atencion";

      $result_est = $conexion->query($sql_est);

      while ($row_est = $result_est->fetch_assoc()) {
        $estancia = $row_est['estancia'];
      } 
}

   


function bisiesto($anio_actual){
    $bisiesto=false;
    //probamos si el mes de febrero del año actual tiene 29 días
      if (checkdate(2,29,$anio_actual))
      {
        $bisiesto=true;
    }
    return $bisiesto;
}


$fecha_actual = date("Y-m-d");
$fecha_nac=$pac_fecnac;
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
           case 10:     $dias_mes_anterior=30; break;
           case 11:     $dias_mes_anterior=31; break;
           case 12:     $dias_mes_anterior=30; break;
    }

    $dias=$dias + $dias_mes_anterior;
}

//ajuste de posible negativo en $meses
if ($meses < 0)
{
    --$anos;
    $meses=$meses + 12;
}

//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";


 ?>
      <div class="container">
        <div class="content">
          
        <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 25px;">
                 <tr><strong><center>HOJA DE OBSERVACIÓN - ENFERMERÍA</center></strong>
        </div>
         <hr>
 <font size="2">
         <div class="container">
  <div class="row">
    <div class="col-sm-6">

      Expediente: <strong><?php echo $folio?> </strong>
   
    Paciente: <strong><?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?></strong>
    </div>
    <div class="col-sm">
      Área: <strong><?php echo $area ?></strong>
    </div>
   <?php $date = date_create($pac_fecing);
   ?>
      <div class="col-sm">
      Fecha de ingreso: <strong><?php echo date_format($date, "d-m-Y") ?></strong>
    </div>
  </div>
</div></font>

 <font size="2">
     <div class="container">
  <div class="row">
    <div class="col-sm">
       <?php $date1 = date_create($pac_fecnac);
   ?>
      Fecha de nacimiento: <strong><?php echo date_format($date1, "d-m-Y") ?></strong>
    </div>
    <div class="col-sm">
    Tipo de sangre: <strong><?php echo $pac_tip_sang ?></strong>
    </div>
   
      <div class="col-sm">
      Habitación: <strong><?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
$result_hab = $conexion->query($sql_hab);                                                                                    while ($row_hab = $result_hab->fetch_assoc()) {
  echo $row_hab['num_cama'];
} ?></strong>
    </div>
    <div class="col-sm">
      Tiempo estancia: <strong><?php echo $estancia ?> Dias</strong>
    </div>
  </div>
</div>
</font>
 <font size="2">

 
  <div class="container">
  <div class="row">
    <div class="col-sm-3">
      Edad: <strong><?php if($anos > "0" ){
   echo $anos." años";
}elseif($anos <="0" && $meses>"0"){
    echo $meses." meses";
}elseif($anos <="0" && $meses<="0" && $dias>"0"){
    echo $dias." dias";
}
?></strong>
    </div>
   <div class="col-sm-3">
Peso: <strong><?php $sql_vit = "SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vit = $conexion->query($sql_vit);
while ($row_vit = $result_vit->fetch_assoc()) {
$peso=$row_vit['peso'];
}if(!isset($peso)){
    $peso=0;
}   echo $peso;?></strong>
    </div>
  
      <div class="col-sm">
      Talla: <strong><?php $sql_vitt =" SELECT * from dat_hclinica where Id_exp=$id_exp ORDER by id_hc DESC LIMIT 1";
$result_vitt = $conexion->query($sql_vitt); 
while ($row_vitt = $result_vitt->fetch_assoc()) {
$talla=$row_vitt['talla'];
}
if(!isset($talla)){
    $talla=0;
}   echo $talla;?></strong>
    </div>
<div class="col-sm">
      Género: <strong><?php echo $pac_sexo ?></strong>
    </div>
    
    
  </div>
</div>
</font>
 <font size="2">
  <div class="container">
  <div class="row">
    <div class="col-sm-3">
      Alergias: <strong><?php echo $alergias ?></strong>
    </div>
    <div class="col-sm-6">
      Estado de salud: <strong><?php $sql_edo = "SELECT edo_salud from dat_ingreso where id_atencion=$id_atencion ORDER by edo_salud DESC LIMIT 1";
$result_edo = $conexion->query($sql_edo);                                                                                    while ($row_edo = $result_edo->fetch_assoc()) {
  echo $row_edo['edo_salud'];
} ?></strong>
    </div>
      
     <div class="col-sm">
    Aseguradora: <strong><?php $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
                                                                                  $result_aseg = $conexion->query($sql_aseg);
                                                                                  while ($row_aseg = $result_aseg->fetch_assoc()) {
                                                                                    echo $row_aseg['aseg'];
                                                                                  } ?></strong>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">

    </div>
  </div>
   <div class="col-sm-6">
 <?php 
$d="";
      $sql_motd = "SELECT diagprob_i from dat_nevol where id_atencion=$id_atencion ORDER by diagprob_i ASC LIMIT 1";
    $result_motd = $conexion->query($sql_motd);
    while ($row_motd = $result_motd->fetch_assoc()) {
        $d=$row_motd['diagprob_i'];
    } ?>
    <?php $sql_mot = "SELECT motivo_atn from dat_ingreso where id_atencion=$id_atencion ORDER by motivo_atn ASC LIMIT 1";
    $result_mot = $conexion->query($sql_mot);
    while ($row_mot = $result_mot->fetch_assoc()) {
    $m=$row_mot['motivo_atn'];
    } ?>

    <?php if ($d!=null) {
       echo '<td> Diagnóstico: <strong>' . $d .'</strong></td>';
    } else{
          echo '<td"> Motivo de atención: <strong>' . $m .'</strong></td>';
    }?>
    </div>
</font>
 


  <?php
      //
      $fecha_actual = date("d-m-Y");
    ?>

<hr>

<!--pestañas-->
<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Signos vitales</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Escala de Glasgow</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Valoración pupilar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="glicemia-tab" data-toggle="tab" href="#glicemia" role="tab" aria-controls="glicemia" aria-selected="false">Glicemia capilar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="eva-tab" data-toggle="tab" href="#eva" role="tab" aria-controls="eva" aria-selected="false">Valoración del dolor (EVA)</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="nota-tab" data-toggle="tab" href="#nota" role="tab" aria-controls="nota" aria-selected="false">Nota de enfermería</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
  
  <form action="" method="POST">
 <div class="container-fluid">
<div class="container">
  
      <div class="row">
        <table class="table table-bordered table-striped" id="mytable">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="9"><center><h5><strong>REGISTRAR SIGNOS VITALES</strong></h5></center></th>
         </tr><th scope="col" class="col-sm-1"><center>Fecha reporte</center></th>   <td><input type="date" class="form-control" name="f_reporte" required="" value="<?php echo $fecha_actual = date("Y-m-d") ?>"></td>
    <tr class="table-active">
      <!--<th scope="col" class="col-sm-1"><center>Tipo</center></th>-->
      
      <th scope="col" class="col-sm-1"><center>Hora</center></th>
      <th scope="col" class="col-sm-2"><center>Presón arterial</center></th>
      <th scope="col" class="col-sm-1"><center>Frecuencia cardiaca</center></th>
      <th scope="col" class="col-sm-1"><center>Frecuencia respiratoria</center></th>
     <th scope="col" class="col-sm-1"><center>Temperatura</center></th>
     <th scope="col" class="col-sm-1"><center>Saturación oxígeno</center></th>
     
     
    </tr>
  </thead>
  <tbody>
    <tr>


      <td>
        <select class="form-control" name="hora_med" style="width : 100%; heigth : 100%" required="">
        <option value="">Seleccionar hora</option>
        <option value="8">8:00 A.M.</option>
         <option value="9">9:00 A.M.</option>
  <option value="10">10:00 A.M.</option>
  <option value="11">11:00 A.M.</option>
  <option value="12">12:00 A.M.</option>
  <option value="13">13:00 P.M.</option>
  <option value="14">14:00 P.M.</option>
  <option value="15">15:00 P.M.</option>
  <option value="16">16:00 P.M.</option>
  <option value="17">17:00 P.M.</option>
  <option value="18">18:00 P.M.</option>
  <option value="19">19:00 P.M.</option>
  <option value="20">20:00 P.M.</option>
  <option value="21">21:00 P.M.</option>
  <option value="22">22:00 P.M.</option>
  <option value="23">23:00 P.M.</option>
  <option value="24">24:00 A.M.</option>
  <option value="1">1:00 A.M.</option>
  <option value="2">2:00 A.M.</option>
  <option value="3">3:00 A.M.</option>
  <option value="4">4:00 A.M.</option>
  <option value="5">5:00 A.M.</option>
  <option value="6">6:00 A.M.</option>
  <option value="7">7:00 A.M.</option>
  

        </select>
      </td>
      <td>
     <div class="row">
  <div class="col losInputTAM"><input type="number" class="form-control" id="sist" name="sist_mat" required=""></div> /
  <div class="col losInputTAM"><input type="number" class="form-control" id="diast" name="diast_mat" required=""></div>
 
</div></td>
      <td><input type="number" class="form-control" name="freccard_mat" required="">
    </div></td>
      <td><input type="number" class="form-control" name="frecresp_mat" required="">
    </div></td>
<td><input type="cm-number" class="form-control" name="temper_mat" required="">
    </div></td>
<td><input type="number"  class="form-control col-sm-12" name="satoxi_mat" required="">
    </div></td>
 
    </div></td>
     
    </tr>
  </tbody>
</table>
     </div>
     <center>
     <input type="submit" name="btnagregarS" class="btn btn-block btn-success col-3" value="Agregar">
    </center>
    </form>
</div>
    <?php

          if (isset($_POST['btnagregarS'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];
$diast_mat=0;
$sist_mat=0;
$tam_m=0;
//$tipo =  mysqli_real_escape_string($conexion, (strip_tags($_POST["tipo"], ENT_QUOTES)));
$hora_med =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_med"], ENT_QUOTES)));
$sist_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["sist_mat"], ENT_QUOTES)));
$diast_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["diast_mat"], ENT_QUOTES)));
$freccard_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["freccard_mat"], ENT_QUOTES)));
$frecresp_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["frecresp_mat"], ENT_QUOTES)));
$temper_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["temper_mat"], ENT_QUOTES)));
$satoxi_mat =  mysqli_real_escape_string($conexion, (strip_tags($_POST["satoxi_mat"], ENT_QUOTES)));
$f_reporte =  mysqli_real_escape_string($conexion, (strip_tags($_POST["f_reporte"], ENT_QUOTES)));



if($hora_med=='8' ||$hora_med=='9' || $hora_med=='10' || $hora_med=='11'|| $hora_med=='12'|| $hora_med=='13' || $hora_med=='14'){
$turno="MATUTINO";
} else if ($hora_med=='15' || $hora_med=='16' || $hora_med=='17'|| $hora_med=='18'|| $hora_med=='19' || $hora_med=='20' || $hora_med=='21') {
  $turno="VESPERTINO";
}else if ($hora_med=='22' || $hora_med=='23' || $hora_med=='24'|| $hora_med=='1'|| $hora_med=='2' || $hora_med=='3' || $hora_med=='4' || $hora_med=='5' || $hora_med=='6' || $hora_med=='7') {
    $turno="NOCTURNO";
}

$fecha_actual = date("Y-m-d H:i:s");

if ($hora_med == '24' || $hora_med == '1' || $hora_med == '2' || $hora_med == '3' || $hora_med == '4' || $hora_med == '5' || $hora_med == '6' || $hora_med == '7') {
   // Restamos un día a la fecha actual
   //$yesterday = date('Y-m-d', strtotime('-1 day')) ; 
   $yesterday = date("Y-m-d H:i"); 
} else { 
   $yesterday = date("Y-m-d"); 
}

$tam_m=($diast_mat+$sist_mat)/2;

$ingresarsignos = mysqli_query($conexion, 'INSERT INTO signos_vitales (
  id_atencion,id_usua,fecha,p_sistol,p_diastol,fcard,fresp,temper,satoxi,tam,hora,tipo,fecha_registro) values (' . $id_atencion . ' , ' . $id_usua . ' ,"' . $f_reporte. '", "' . $sist_mat . '" , "' . $diast_mat . '" , "' . $freccard_mat . '" , "' . $frecresp_mat . '" , "' . $temper_mat . '", "' . $satoxi_mat . '","' . $tam_m . '",' . $hora_med . ',"OBSERVACION","' . $fecha_actual. '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));


           echo '<script type="text/javascript">window.location.href = "reg_urg.php";</script>';
          }
          ?>    
          <div class="col col-12">
          
            <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:20%" id="search" placeholder="BUSCAR...">
            </div>
               <?php


?>
            <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <!--<th scope="col">Pdf</th>-->
                    <th scope="col">Fecha reporte</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Tensión arterial</th>
                    <th scope="col">Frecuencia cardiaca</th>
                    <th scope="col">Frecuencia respiratoria</th>
                    <th scope="col">Temperatura</th>
                    <th scope="col">Saturación oxigeno</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$usua=$usuario['id_usua'];
$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT fecha,id_atencion,id_usua,hora,id_sig,p_sistol,p_diastol,fcard,fresp,temper,satoxi,niv_dolor, tipo from signos_vitales s WHERE s.id_atencion=$id_atencion AND s.tipo='OBSERVACION' group by fecha  ORDER BY id_sig DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_usua=$f['id_usua'];
      $resultado_usua = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua=$id_usua") or die($conexion->error);
        while($row = mysqli_fetch_array($resultado_usua)){

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias,p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

      $result_pac = $conexion->query($sql_pac);

      while ($row_pac = $result_pac->fetch_assoc()) {
        
?>          
                    <tr>
<!--<td class="fondo"><a href="../signos_vitales/signos_vitales_ter.php?id_ord=<?php echo $f['id_sig'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usua?>&fecha=<?php echo $f['fecha']?>&idexp=<?php echo $row_pac['Id_exp']?>"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></td>-->
<td class="fondo"><strong><?php $date=date_create($f['fecha']); echo date_format($date,"d-m-Y");?></strong></td>    
<td class="fondo"><strong><?php echo $f['hora'];?></strong></td>    
<td class="fondo"><strong><?php echo $f['p_sistol'].'/'.$f['p_diastol'];?></strong></td> 
<td class="fondo"><strong><?php echo $f['fcard'];?></strong></td> 
<td class="fondo"><strong><?php echo $f['fresp'];?></strong></td> 
<td class="fondo"><strong><?php echo $f['temper'];?></strong></td>
<td class="fondo"><strong><?php echo $f['satoxi'];?></strong></td>

<td><a href="edit_signos.php?id_mon_s=<?php echo $f['id_sig'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>

<td><a href="el_signos.php?id_mon_s=<?php echo $f['id_sig'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-danger">X </button></td>

<!--<td class="fondo"><strong><?php echo $row['nombre'].' '.$row['papell'].' '.$row['sapell']?></strong></td>-->
                    </tr>
                    <?php
}
    }
        }
                ?>
                
                </tbody>
              
            </table>
            </div>
 <!--TERMINO SIGNOS VITALES-->  
 
                

            </div>    </div>
  </div>
  
  
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <form action="" method="POST">
  <table class="table table-bordered">
  <thead>
     <tr class="table-primary">
      <th colspan="5"><center><h5><strong>ESCALA DE COMA DE GLASGOW</strong></h5></center></th>
    </tr>
 </tr><th scope="col" class="col-sm-1"><center>Fecha reporte</center></th>   <td><input type="date" class="form-control" name="f_reporteg" required="" value="<?php echo $fecha_actual = date("Y-m-d") ?>"></td>
    <tr class="table-active">
      <th scope="col"><center>Variable</center></th>
      <th scope="col"><center>Respuesta</center></th>
      <th scope="col"><center>Valor</center></th>
      <th scope="col"  class="bg-primary"><center><font color="white">Resultado</font></center></th>
     
    </tr>
  </thead>
  <tbody>
    <tr>
      <th class="col-sm-3"><center><br>Apertura ocular</center></th>
      <td class="col-sm-5">Espontánea <br>
        Al hablar<br>
        Al dolor<br>
      No responde</td>

      <td><center>4<br> 3<br>2<br> 1</center></td>
   <td><br><center>
<div class="losInputG">
  <input type="number" name="apecular" class="form-control" min="1" max="4" maxlength="1" onkeypress='return event.charCode >= 49 && event.charCode <= 52' required></div></center></td>
     
   
    </tr>
    <tr>
      <th scope="row"><center><br><br>Motora</center></th>
      <td>Obedece órdenes<br>
        Localiza dolor<br>
        Retira el miembro<br>
        Flexón al dolor<br>
      Extensión al dolor<br>
    No responde</td>
      <td><center>6<br>5<br>4<br>3<br>2<br>1</center></td>
        <td><br><br><center>
          <div class="losInputG">
            <input type="number" name="rmotora" class="form-control" min="1" max="6" maxlength="1" onkeypress='return event.charCode >= 49 && event.charCode <= 54' required></div></center></td>
      
    </tr>
    <tr>
      <th scope="row"><center><br><br>Verbal</center></th>
      <td>Orientada<br>
        Confusa<br>
        Palabras inapropiadas<br>
        Sonidos incomprensibles<br>
      No responde</td>
      <td><center>5<br>4<br>3<br>2<br>1</center></td>
         <td><br><center>
          <div class="losInputG">
            <input type="number" name="rverbal" class="form-control" min="1" max="5" maxlength="1" onkeypress='return event.charCode >= 49 && event.charCode <= 53' required></div></center></td>
      
    </tr>
    
      
   <tr>
    <th colspan="1" ><center>Hora:</center></th>
      <th colspan="1" >
        <input type="time" name="hora_glas" class="form-control" required></th>

    <th colspan="1" ><center><button type="button" class="btn btn-success btn-sm" id="playttl"><i class="fas fa-play"></button></i>
Total:</center></th>
<td colspan="2">
  <center>
    <div class="inputTotalG"><input type="text" name="" class="form-control" disabled id="txttot11">
    </div>
  </center>
</td>
   </tr>
<script type="text/javascript">
const txttot11 = document.getElementById('txttot11');
const btnPlayText1t1 = document.getElementById('playttl');

btnPlayText1t1.addEventListener('click', () => {
        leerTexto(txttot11.value);
});

function leerTexto(txttot11){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttot11;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  </tbody>
</table>
<center><input type="submit" name="btnagregarG" class="btn btn-block btn-success col-3" value="Agregar"></center>
</form>
<?php

          if (isset($_POST['btnagregarG'])) {
            include "../../conexionbd.php";
            $usuario = $_SESSION['login'];
            $id_usua= $usuario['id_usua'];
            $id_atencion = $_SESSION['pac'];
            
$apecular =  mysqli_real_escape_string($conexion, (strip_tags($_POST["apecular"], ENT_QUOTES)));
$rmotora =  mysqli_real_escape_string($conexion, (strip_tags($_POST["rmotora"], ENT_QUOTES)));
$rverbal =  mysqli_real_escape_string($conexion, (strip_tags($_POST["rverbal"], ENT_QUOTES)));
$hora_glas =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_glas"], ENT_QUOTES)));
$f_reporteg =  mysqli_real_escape_string($conexion, (strip_tags($_POST["f_reporteg"], ENT_QUOTES)));

$fecha_actual = date("Y-m-d H:i:s");

$ingresarglas = mysqli_query($conexion, 'INSERT INTO glasgow_o (id_usua,id_atencion,fecha_reporte,fecha_registro,apecular,rmotora,rverbal,hora_glas) values (' . $id_usua . ' , ' . $id_atencion . ' ,"' . $f_reporteg. '", "' . $fecha_actual . '" , "' . $apecular . '" , "' . $rmotora . '" , "' . $rverbal . '" , "' . $hora_glas . '") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

           echo '<script type="text/javascript">window.location.href = "reg_urg.php";</script>';
          }
          ?><hr>
           <div class="table-responsive">

            <table class="table table-bordered table-striped" id="mytable">
                <thead class="thead bg-navy">
              
                    <!--<th scope="col">Pdf</th>-->
                    <th scope="col">Fecha reporte</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Apertura ocular</th>
                    <th scope="col">Motora</th>
                    <th scope="col">Verbal</th>
                    <th scope="col">Total</th>
                    <th scope="col">Editar</th>
                    <th scope="col">Eliminar</th>
               
                </tr>
                </thead>
                <tbody>

<?php
include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$usua=$usuario['id_usua'];
$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from glasgow_o s WHERE s.id_atencion=$id_atencion  ORDER BY id_gla DESC") or die($conexion->error);
while($f = mysqli_fetch_array($resultado)){
       $id_usua=$f['id_usua'];
      $resultado_usua = $conexion->query("SELECT * FROM reg_usuarios WHERE id_usua=$id_usua") or die($conexion->error);
        while($row = mysqli_fetch_array($resultado_usua)){

$sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias,p.folio FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

      $result_pac = $conexion->query($sql_pac);

      while ($row_pac = $result_pac->fetch_assoc()) {
        
?>          
                    <tr>
<!--<td class="fondo"><a href="../signos_vitales/signos_vitales_ter.php?id_ord=<?php echo $f['id_sig'];?>&id_atencion=<?php echo $f['id_atencion'];?>&id_usua=<?php echo $usua?>&fecha=<?php echo $f['fecha']?>&idexp=<?php echo $row_pac['Id_exp']?>"><button type="button" class="btn btn-danger"> <i class="fa fa-file-pdf-o" style="font-size:28px"  aria-hidden="true"></i> </button></td>-->
<td class="fondo"><strong><?php $date=date_create($f['fecha_reporte']); echo date_format($date,"d-m-Y");?></strong></td>    
<td class="fondo"><strong><?php echo $f['hora_glas'];?></strong></td>    
<td class="fondo"><strong><?php echo $f['apecular'];?></strong></td> 
<td class="fondo"><strong><?php echo $f['rmotora'];?></strong></td> 
<td class="fondo"><strong><?php echo $f['rverbal'];?></strong></td>
<td class="fondo"><strong><?php echo $f['apecular']+$f['rmotora']+$f['rverbal'];?></strong></td>

<td><a href="edit_glas.php?id_mon_s=<?php echo $f['id_gla'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>

<td><a href="el_glas.php?id_mon_s=<?php echo $f['id_gla'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-danger">X </button></td>

                    </tr>
                    <?php
}
    }
        }
                ?>
                
                </tbody>
              
            </table>
            </div>
  </div>
  
  
  
  <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
  <form action="" method="POST">
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
     <tr class="table-warning">
      <th colspan="18"><center><h5><strong>DIÁMETRO PUPILAR</strong></h5></center></th>
    </tr>
    <tr class="table-active">
      <th scope="col" colspan="1"><center>Hora</center></th>
      <th scope="col" colspan="1"><center>Ojo</center></th>
      <th scope="col" colspan="1" >Tamaño</th>
  
    </tr>

  </thead>
  <tbody>
    <tr>
      <td><select class="form-control" name="hora" style="width : 100%; heigth : 100%" required="">
        <option value="">Seleccionar hora</option>
        <option value="8">8:00 A.M.</option>
         <option value="9">9:00 A.M.</option>
  <option value="10">10:00 A.M.</option>
  <option value="11">11:00 A.M.</option>
  <option value="12">12:00 A.M.</option>
  <option value="13">13:00 P.M.</option>
  <option value="14">14:00 P.M.</option>
  <option value="15">15:00 P.M.</option>
  <option value="16">16:00 P.M.</option>
  <option value="17">17:00 P.M.</option>
  <option value="18">18:00 P.M.</option>
  <option value="19">19:00 P.M.</option>
  <option value="20">20:00 P.M.</option>
  <option value="21">21:00 P.M.</option>
  <option value="22">22:00 P.M.</option>
  <option value="23">23:00 P.M.</option>
  <option value="24">24:00 A.M.</option>
  <option value="1">1:00 A.M.</option>
  <option value="2">2:00 A.M.</option>
  <option value="3">3:00 A.M.</option>
  <option value="4">4:00 A.M.</option>
  <option value="5">5:00 A.M.</option>
  <option value="6">6:00 A.M.</option>
  <option value="7">7:00 A.M.</option>
  

        </select></td>
      <th scope="row" colspan="1">  <select name="lado" class="form-control" required>
        <option value="">Seleccionar lado de ojo</option>
         <option value="Ojo izquierdo">Ojo izquierdo</option>
          <option value="Ojo Derecho">Ojo Derecho</option>
          
               
      </select>
    </th>
<td class="col-5"><input type="text" name="tamano" class="form-control"></td>
</tr>
</tbody>

</table>

</div>
<img src="../../imagenes/val_pupilar.jpg" class="img-fluid"><p></p>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
     <strong>Fecha de reporte:</strong>
    </div>
    <div class="col-sm-3">
      <input type="date" value="<?php echo $fecha_actual = date("Y-m-d") ?>" name="fecha" class="form-control" required>
    </div>
  </div>
</div><p></p>
<center><input type="submit" name="btnojo" class="btn btn-block btn-success col-3" value="Agregar"></center>

</form><hr>    
      <?php
if(isset($_POST['btnojo'])){
     include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];
$hora =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora"], ENT_QUOTES)));
$lado =  mysqli_real_escape_string($conexion, (strip_tags($_POST["lado"], ENT_QUOTES)));
$tamano =  mysqli_real_escape_string($conexion, (strip_tags($_POST["tamano"], ENT_QUOTES)));
$fecha =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha"], ENT_QUOTES)));
$fecha_registro = date("Y-m-d H:i");

   $ingresar4 = mysqli_query($conexion, 'INSERT INTO d_pupilar (id_atencion,id_usua,hora,lado,tamano,fecha_registro,fecha_reporte,obs) values ('.$id_atencion.',' . $id_usua . ',"' . $hora . '","' . $lado . '","'.$tamano.'","'.$fecha_registro.'","'.$fecha.'","Si") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

      echo '<script type="text/javascript">window.location.href = "reg_urg.php";</script>';
    }
    ?>
    
    <div class="form-group">
                <input type="text" class="form-control pull-right" style="width:19%" id="search" placeholder="BUSCAR...">
            </div>
 <?php

include "../../conexionbd.php";
$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from d_pupilar WHERE id_atencion=$id_atencion and obs='Si' ORDER BY id_pupilar DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
?>

<table class="table table-bordered table-striped" id="mytable3">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="10"><center><h5><strong>DIÁMETRO PUPILAR</strong></h5></center></th>
         </tr>
    <tr class="table-success">
            <th scope="col"><center>Fecha de registro</center></th>
       <th scope="col"><center>Fecha reporte</center></th>
     <th scope="col" >Hora</th>
      <th scope="col" >Lado</th>
      <th scope="col">Tamaño</th>
       <th scope="col"><center>Editar</center></th>
       <th scope="col"><center>Eliminar</center></th>
    </tr>
  </thead>
  <tbody>
      <?php
                while($f = mysqli_fetch_array($resultado)){
                    
                    ?>
<tr>
    <td><center><strong> <?php $fech_r=date_create($f['fecha_registro']); echo date_format($fech_r,"d-m-Y H:i a");?> </strong></center></td>
<td><center><strong> <?php $fech_rr=date_create($f['fecha']); echo date_format($fech_rr,"d-m-Y");?> </strong></center></td>
<td><center><strong> <?php echo $f['hora'];?> </strong></center></td>
<td><center><strong> <?php echo $f['lado'];?> </strong></center></td>

<td><center><strong> <?php echo $f['tamano'];?> </strong></center></td>




<td><a href="edit_pupilar.php?id_mon_s=<?php echo $f['id_pupilar'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>

<td><a href="el_pupilar.php?id_mon_s=<?php echo $f['id_pupilar'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-danger">X </button></td>
 
    </tr>
       <?php
                }
                 
                ?>
  </tbody>
</table>  
      
  </div>
  
  <div class="tab-pane fade" id="glicemia" role="tabpanel" aria-labelledby="glicemia-tab">
  
  <form action="" method="POST">
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
     <tr class="table-warning">
      <th colspan="18"><center><h5><strong>GLICEMIA CAPILAR</strong></h5></center></th>
    </tr>
    <tr class="table-active">
      <th scope="col" colspan="1"><center>Fecha reporte</center></th>
      <th scope="col" colspan="1"><center>Hora</center></th>
      <th scope="col" colspan="1" >Valor</th>
  
    </tr>

  </thead>
  <tbody>
      
    <tr>
<td class="col-5">  <input type="date" value="<?php echo $fecha_actual = date("Y-m-d") ?>" name="fecha_reporte" class="form-control" required></td>
<td class="col-5"><input type="time" name="hora_g" class="form-control"></td>
<td class="col-5"><input type="text" name="valor" class="form-control"></td>
</tr>
</tbody>

</table>
</div>
<center><input type="submit" name="btngca" class="btn btn-block btn-success col-3" value="Agregar"></center>

</form><hr>
        <?php
if(isset($_POST['btngca'])){
     include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];
$fecha_reporte =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_reporte"], ENT_QUOTES)));
$hora_g =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_g"], ENT_QUOTES)));
$valor =  mysqli_real_escape_string($conexion, (strip_tags($_POST["valor"], ENT_QUOTES)));
$fecha_registro = date("Y-m-d H:i");
   $ingresargg = mysqli_query($conexion, 'INSERT INTO glic_ca (id_atencion,id_usua,fecha_reporte,fecha_registro,hora_g,valor) values ('.$id_atencion.',' . $id_usua . ',"' . $fecha_reporte . '","' . $fecha_registro . '","'.$hora_g.'","'.$valor.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

      echo '<script type="text/javascript">window.location.href = "reg_urg.php";</script>';
    }
    ?>
    
     <?php

include "../../conexionbd.php";
$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from glic_ca WHERE id_atencion=$id_atencion ORDER BY id_glc DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
    <table class="table table-bordered table-striped" id="mytable3">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="10"><center><h5><strong>Glicemia capilar</strong></h5></center></th>
         </tr>
    <tr class="table-success">
            <th scope="col"><center>Fecha de registro</center></th>
       <th scope="col"><center>Fecha reporte</center></th>
     <th scope="col" >Hora</th>
      <th scope="col" >Valor</th>
       <th scope="col"><center>Editar</center></th>
       <th scope="col"><center>Eliminar</center></th>
    </tr>
  </thead>
  <tbody>
      <?php
                while($f = mysqli_fetch_array($resultado)){
                    
                    ?>
<tr>
    <td><center><strong> <?php $fech_r=date_create($f['fecha_registro']); echo date_format($fech_r,"d-m-Y H:i a");?> </strong></center></td>
<td><center><strong> <?php $fech_rr=date_create($f['fecha_reporte']); echo date_format($fech_rr,"d-m-Y");?> </strong></center></td>
<td><center><strong> <?php echo $f['hora_g'];?> </strong></center></td>
<td><center><strong> <?php echo $f['valor'];?> </strong></center></td>
<td><a href="edit_gli.php?id_mon_s=<?php echo $f['id_glc'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>
<td><a href="el_gli.php?id_mon_s=<?php echo $f['id_glc'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-danger">X </button></td>
 
    </tr>
       <?php
                }
                 
                ?>
  </tbody>
</table> 
  </div>
  
  
  <div class="tab-pane fade" id="eva" role="tabpanel" aria-labelledby="eva-tab">
  
  <div class="container">
  <div class="row">
    <div class="col-sm">
   <h5> <center><strong>VALORACIÓN DEL DOLOR - ESCALA VISUAL ANÁLOGA (EVA)</strong></center></h5>
    </div>
    
  </div>
</div>
  <form action="" method="POST">
      
<div class="container">
  <div class="row">
     <center>
    <div class="col-sm">
   <img src="../../imagenes/caras.png" width="800">
    </div>
    </center>
    <div class="col-sm-3">
      
<input class="form-check-input" type="radio" name="eseva" id="cero" value="0" required>
<input class="form-check-input" type="radio" name="eseva" id="doso" value="2">
<input class="form-check-input" type="radio" name="eseva" id="cuatroc" value="4">
<input class="form-check-input" type="radio" name="eseva" id="seis" value="6">
<input class="form-check-input" type="radio" name="eseva" id="ocho" value="8">
<input class="form-check-input" type="radio" name="eseva" id="diez" value="10">
    </div>
  </div>
</div>

 <div class="row">
    <div class="col-sm-4">
     Fecha reporte
     <input type="date" value="<?php echo $fecha_actual = date("Y-m-d") ?>" name="fecha_reporte" class="form-control" required>
    </div>
    <div class="col-sm-4">
        Hora
        <input type="time" class="form-control" name="hora_eva">
    </div>
    <div class="col-sm"><br>
    <center><input type="submit" name="btneva" class="btn btn-block btn-success col-3" value="Agregar"></center>
    </div>
   
  </div>


  </form>
       <?php
if(isset($_POST['btneva'])){
     include "../../conexionbd.php";
$usuario = $_SESSION['login'];
$id_usua= $usuario['id_usua'];
$id_atencion = $_SESSION['pac'];
$fecha_reporte =  mysqli_real_escape_string($conexion, (strip_tags($_POST["fecha_reporte"], ENT_QUOTES)));
$hora_eva =  mysqli_real_escape_string($conexion, (strip_tags($_POST["hora_eva"], ENT_QUOTES)));
$eseva =  mysqli_real_escape_string($conexion, (strip_tags($_POST["eseva"], ENT_QUOTES)));

$fecha_registro = date("Y-m-d H:i");
   $ingresareva = mysqli_query($conexion, 'INSERT INTO eva (id_atencion,id_usua,fecha_reporte,fecha_registro,hora_eva,eseva) values ('.$id_atencion.',' . $id_usua . ',"' . $fecha_reporte . '","' . $fecha_registro . '","'.$hora_eva.'","'.$eseva.'") ') or die('<p>Error al registrar</p><br>' . mysqli_error($conexion));

      echo '<script type="text/javascript">window.location.href = "reg_urg.php";</script>';
    }
    ?>
  <hr>
  
     <?php

include "../../conexionbd.php";
$id_atencion=$_SESSION['pac'];
$resultado = $conexion->query("SELECT * from eva WHERE id_atencion=$id_atencion ORDER BY id_eva DESC") or die($conexion->error);
$usuario = $_SESSION['login'];
?>
    <table class="table table-bordered table-striped" id="mytable3">
       <thead class="thead">
         <tr class="table-primary">
            <th colspan="10"><center><h5><strong>Glicemia capilar</strong></h5></center></th>
         </tr>
    <tr class="table-success">
            <th scope="col"><center>Fecha de registro</center></th>
       <th scope="col"><center>Fecha reporte</center></th>
     <th scope="col" >Hora</th>
      <th scope="col" >Valor</th>
       <th scope="col"><center>Editar</center></th>
       <th scope="col"><center>Eliminar</center></th>
    </tr>
  </thead>
  <tbody>
      <?php
                while($f = mysqli_fetch_array($resultado)){
                    
                    ?>
<tr>
    <td><center><strong> <?php $fech_r=date_create($f['fecha_registro']); echo date_format($fech_r,"d-m-Y H:i a");?> </strong></center></td>
<td><center><strong> <?php $fech_rr=date_create($f['fecha_reporte']); echo date_format($fech_rr,"d-m-Y");?> </strong></center></td>
<td><center><strong> <?php echo $f['hora_eva'];?> </strong></center></td>
<td><center><strong> <?php echo $f['eseva'];?> </strong></center></td>
<td><a href="edit_eva.php?id_mon_s=<?php echo $f['id_eva'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-warning"><i class="fas fa-edit"></i></button></td>
<td><a href="el_eva.php?id_mon_s=<?php echo $f['id_eva'];?>&id_atencion=<?php echo $f['id_atencion'];?>"><button type="button" class="btn btn-danger">X </button></td>
 
    </tr>
       <?php
                }
                 
                ?>
  </tbody>
</table> 
  
  </div>
  
  <div class="tab-pane fade" id="nota" role="tabpanel" aria-labelledby="nota-tab">
      <form action="ins_enf_urg.php" method="POST">
      <div class="container">
    <div class="row">
<div class="col-sm-1">
         <th><h5>Fecha: </h5></th>
    </div>
    <div class="col-sm-3">
      <input type="date" name="datet" class="form-control" required>
    </div>
    <div class="col-sm-1">
         <th><h5>Hora: </h5></th>
    </div>
     <div class="col-sm">
      <input type="time" name="hor" class="form-control" required>
      
    </div>
    </div>
    </div>
    <p></p>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>DIETA</center></strong>
</div>
<p>

  <div class="col-sm-5">
                    <div class="form-group">
                        <label for="dieta1"><strong>Dieta:</strong></label>
                        <select class="form-control" name="dieta" required id="dieta1">
                           <option value="">Seleccionar dieta</option>
                        <?php
                        $sql_d = "SELECT DISTINCT id_dieta,dieta FROM cat_dietas WHERE dieta_activo='SI'";
                            $result_d = $conexion->query($sql_d);
                            while ($row_d = $result_d->fetch_assoc()) {
                                echo "<option value='" . $row_d['dieta'] . "'>" . $row_d['dieta'] . "</option>";
                        }
                        ?>
                        </select>
                    </div>
                </div>


 <script type="text/javascript">
const dieta1 = document.getElementById('dieta1');
const btnPlayTextdai = document.getElementById('playddd');

btnPlayTextdai.addEventListener('click', () => {
        leerTexto(dieta1.value);
});

function leerTexto(dieta1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= dieta1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>ESTUDIOS DE LABORATORIO</center></strong>
</div>

  <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="btnStartRecord"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="btnStopRecord"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playesttt"><i class="fas fa-play"></button></i>
</div>
  <textarea rows="3" class="form-control" name="sol_es" id="texto"></textarea>
  <script type="text/javascript">
const btnStartRecord = document.getElementById('btnStartRecord');
const btnStopRecord = document.getElementById('btnStopRecord');
const texto = document.getElementById('texto');

const btnPlayTextest = document.getElementById('playesttt');

btnPlayTextest.addEventListener('click', () => {
        leerTexto(texto.value);
});

function leerTexto(texto){
    const speech = new SpeechSynthesisUtterance();
    speech.text= texto;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let recognition = new webkitSpeechRecognition();
      recognition.lang = "es-ES";
      recognition.continuous = true;
      recognition.interimResults = false;

      recognition.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        texto.value += frase;
      }

      btnStartRecord.addEventListener('click', () => {
        recognition.start();
      });

      btnStopRecord.addEventListener('click', () => {
        recognition.abort();
      });
</script>
 
      <div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>ESTUDIOS DE GABINETE</center></strong>
</div>  
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="gabg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="tes"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playgabesba"><i class="fas fa-play"></button></i>
</div>
  <textarea rows="3" class="form-control" name="sol_gab" id="txtedg"></textarea>
         <script type="text/javascript">
const gabg = document.getElementById('gabg');
const tes = document.getElementById('tes');
const txtedg = document.getElementById('txtedg');

const btnPlayTextggb = document.getElementById('playgabesba');

btnPlayTextggb.addEventListener('click', () => {
        leerTexto(txtedg.value);
});

function leerTexto(txtedg){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtedg;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rega = new webkitSpeechRecognition();
      rega.lang = "es-ES";
      rega.continuous = true;
      rega.interimResults = false;

      rega.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtedg.value += frase;
      }

      gabg.addEventListener('click', () => {
        rega.start();
      });

      tes.addEventListener('click', () => {
        rega.abort();
      });
</script>
<hr>

     <hr>

<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>VALORACIÓN DE LA PIEL</center></strong>
</div>
<p>
  <div class="container">
  <div class="row">
    <div class="col-sm-2">
    Mucosa oral:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="humeda" id="humeda" name="mucosa">
  <label class="form-check-label" for="humeda">
   húmeda
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="seca" id="seca" name="mucosa">
  <label class="form-check-label" for="seca">
    seca
  </label>
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>


<div class="container">
  <div class="row">
    <div class="col-sm-2">
    Dientes:
  </div>
    <div class="col-sm">
        <input type="checkbox" name="dientes[]" value="limpios" id="limpios" class="form-check-input">
  <label class="form-check-label" for="limpios">
   limpios
  </label>
    </div>
    <div class="col-sm">
        <input type="checkbox" name="dientes[]" value="sucios" id="sucios" class="form-check-input">
  <label class="form-check-label" for="sucios">
    sucios
  </label>
    </div>
    <div class="col-sm">
         <input type="checkbox" name="dientes[]" value="caries" id="caries" class="form-check-input">
  <label class="form-check-label" for="caries">
    caries
  </label>
    </div>
    <div class="col-sm">
    </div>
<div class="col-sm">
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
    Cabeza:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="limpia" id="limpia" name="cabeza">
  <label class="form-check-label" for="limpia">
   limpia
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="sucia" id="sucia" name="cabeza">
  <label class="form-check-label" for="sucia">
    sucia
  </label>
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
    Orejas:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="limpias" id="limpiaso" name="orejas">
  <label class="form-check-label" for="limpiaso">
   limpias
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="sucias" id="suciaso" name="orejas">
  <label class="form-check-label" for="suciaso">
    sucias
  </label>
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
   Ojos:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="enrojecidos" id="enrojecidos" name="ojos">
  <label class="form-check-label" for="enrojecidos">
   enrojecidos
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="lagrimeo" id="lagrímeo" name="ojos">
  <label class="form-check-label" for="lagrímeo">
    lagrímeo
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="secrecion" id="secreción" name="ojos">
  <label class="form-check-label" for="secreción">
    secreción
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="sin alteracion" id="sinalteración" name="ojos">
  <label class="form-check-label" for="sinalteración">
    sin alteración
  </label>
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>

<strong>PIEL</strong>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
   Higiene:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="limpia" id="limpiah" name="higiene">
  <label class="form-check-label" for="limpiah">
   limpia
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="sucia" id="suciah" name="higiene">
  <label class="form-check-label" for="suciah">
    sucia
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="hidratada" id="hidratada" name="higiene">
  <label class="form-check-label" for="hidratada">
    hidratada
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="seca" id="secah" name="higiene">
  <label class="form-check-label" for="secah">
    seca
  </label>
    </div>
    <div class="col-sm">
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-2">
  Coloración
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="normal" id="normalc" name="col">
  <label class="form-check-label" for="normalc">
   normal
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="palida" id="palida" name="col">
  <label class="form-check-label" for="palida">
    pálida
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="ictericia" id="ictericia" name="col">
  <label class="form-check-label" for="ictericia">
    ictericia
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="cianotica" id="cianotica" name="col">
  <label class="form-check-label" for="cianotica">
    cianótica
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="marmorea" id="marmorea" name="col">
  <label class="form-check-label" for="marmorea">
    marmórea
  </label>
    </div>
  </div>
</div>
<hr>

<div class="container">
  <div class="row">
    <div class="col-sm">

<!-- BOT 1-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" id="uno" >
  X
  </a>
<div class="collapse collapse-horizontal" id="collapseExample">
    <input type="text" name="mara" class="form-control form-control-sm col-sm-1" id="contenido1">
</div>
<!-- TER BOT 1-->

<!-- BOT 2-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cdos" role="button" aria-expanded="false" aria-controls="cdos" id="dos" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cdos">
    <input type="text" name="marb" class="form-control form-control-sm col-sm-1"  id="contenido2">
</div>
<!-- TER BOT 2-->

<!-- BOT 3-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ctres" role="button" aria-expanded="false" aria-controls="ctres" id="tres" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ctres">
    <input type="text" name="marc" class="form-control form-control-sm col-sm-1" id="contenido3">
</div>
<!-- TER BOT 3-->

<!-- BOT 4-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ccua" role="button" aria-expanded="false" aria-controls="ccua" id="cuatro" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ccua">
    <input type="text" name="mard" class="form-control form-control-sm col-sm-1" id="contenido4">
</div>
<!-- TER BOT 4-->


<!-- BOT 5-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cco" role="button" aria-expanded="false" aria-controls="cco" id="cin" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cco">
    <input type="text" name="mare" class="form-control form-control-sm col-sm-1" id="contenido5">
</div>
<!-- TER BOT 5-->

<!-- BOT 6-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#sei" role="button" aria-expanded="false" aria-controls="sei" id="se" >
  X
  </a>
<div class="collapse collapse-horizontal" id="sei">
    <input type="text" name="marf" class="form-control form-control-sm col-sm-1" id="contenido6">
</div>
<!-- TER BOT 6-->

<!-- BOT 7-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#csie" role="button" aria-expanded="false" aria-controls="csie" id="sie" >
  X
  </a>
<div class="collapse collapse-horizontal" id="csie">
    <input type="text" name="marg" class="form-control form-control-sm col-sm-1" id="contenido7">
</div>
<!-- TER BOT 7-->

<!-- espalda BOT 8-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#coch" role="button" aria-expanded="false" aria-controls="coch" id="oc" >
  X
  </a>
<div class="collapse collapse-horizontal" id="coch">
    <input type="text" name="marh" class="form-control form-control-sm col-sm-1" id="contenido8">
</div>
<!-- TER BOT 8-->


<!-- pie-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#pie" role="button" aria-expanded="false" aria-controls="pie" id="pi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="pie">
    <input type="text" name="pie" class="form-control form-control-sm col-sm-1" id="ipi">
</div>
<!-- pie-->


<!-- pie d-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#pied" role="button" aria-expanded="false" aria-controls="pied" id="pid" >
  X
  </a>
<div class="collapse collapse-horizontal" id="pied">
    <input type="text" name="pied" class="form-control form-control-sm col-sm-1" id="ipid">
</div>
<!-- pie d-->

<!-- tob I-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#tobiz" role="button" aria-expanded="false" aria-controls="tobiz" id="toi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="tobiz">
    <input type="text" name="tod" class="form-control form-control-sm col-sm-1" id="tobi">
</div>
<!-- tob I-->

<!-- tob d-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#tob" role="button" aria-expanded="false" aria-controls="tob" id="to" >
  X
  </a>
<div class="collapse collapse-horizontal" id="tob">
    <input type="text" name="toi" class="form-control form-control-sm col-sm-1" id="tobd">
</div>
<!-- tob d-->

<!-- rodilla i-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#rod" role="button" aria-expanded="false" aria-controls="rod" id="roi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="rod">
    <input type="text" name="rodi" class="form-control form-control-sm col-sm-1" id="iroi">
</div>
<!-- rodilla i-->

<!-- rodilla d-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#rd" role="button" aria-expanded="false" aria-controls="rd" id="brod" >
  X
  </a>
<div class="collapse collapse-horizontal" id="rd">
    <input type="text" name="rodd" class="form-control form-control-sm col-sm-1" id="irod">
</div>
<!-- rodilla d-->

<!-- muslo i-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#muslo" role="button" aria-expanded="false" aria-controls="muslo" id="mui" >
  X
  </a>
<div class="collapse collapse-horizontal" id="muslo">
    <input type="text" name="musloi" class="form-control form-control-sm col-sm-1" id="imi">
</div>
<!-- muslo i-->

<!-- muslo d-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#muslod" role="button" aria-expanded="false" aria-controls="muslod" id="mud" >
  X
  </a>
<div class="collapse collapse-horizontal" id="muslod">
    <input type="text" name="muslod" class="form-control form-control-sm col-sm-1" id="imd">
</div>
<!-- muslo d-->

<!-- ingle i-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#inglec" role="button" aria-expanded="false" aria-controls="inglec" id="ingi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="inglec">
    <input type="text" name="inglei" class="form-control form-control-sm col-sm-1" id="ingli">
</div>
<!-- ingle i-->


<!-- ombligo-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ombligo" role="button" aria-expanded="false" aria-controls="ombligo" id="domen" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ombligo">
    <input type="text" name="iabdomen" class="form-control form-control-sm col-sm-1" id="idomen">
</div>
<!-- ombligo-->


<!-- dedoi-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dedoi" role="button" aria-expanded="false" aria-controls="dedoi" id="ddoi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dedoi">
    <input type="text" name="ddi" class="form-control form-control-sm col-sm-1" id="iddi">
</div>
<!-- dedoi-->

<!-- dedoi2-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dedoidos" role="button" aria-expanded="false" aria-controls="dedoidos" id="ddoid" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dedoidos">
    <input type="text" name="ddidos" class="form-control form-control-sm col-sm-1" id="iddid">
</div>
<!-- dedoi2-->


<!-- dedoi3-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dedoitres" role="button" aria-expanded="false" aria-controls="dedoitres" id="ditr" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dedoitres">
    <input type="text" name="dditres" class="form-control form-control-sm col-sm-1" id="iditr">
</div>
<!-- dedoi3-->

<!-- dedoi4-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dedoic" role="button" aria-expanded="false" aria-controls="dedoic" id="dic" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dedoic">
    <input type="text" name="ddicuatro" class="form-control form-control-sm col-sm-1" id="idic">
</div>
<!-- dedoi4-->

<!-- dedoi5-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dedoicin" role="button" aria-expanded="false" aria-controls="dedoicin" id="dicin" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dedoicin">
    <input type="text" name="ddicinco" class="form-control form-control-sm col-sm-1" id="idicin">
</div>
<!-- dedoi5-->

<!-- dedod1-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ddu" role="button" aria-expanded="false" aria-controls="ddu" id="bddu" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ddu">
    <input type="text" name="ddoderu" class="form-control form-control-sm col-sm-1" id="iddu">
</div>
<!-- dedod1-->

<!-- palmai-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#pma" role="button" aria-expanded="false" aria-controls="pma" id="bpmai" >
  X
  </a>
<div class="collapse collapse-horizontal" id="pma">
    <input type="text" name="palmai" class="form-control form-control-sm col-sm-1" id="ipmai">
</div>
<!-- palmai-->


<!-- mulecai-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#m" role="button" aria-expanded="false" aria-controls="m" id="bmuñi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="m">
    <input type="text" name="munei" class="form-control form-control-sm col-sm-1" id="imuñi">
</div>
<!-- muñecai-->

<!-- brazoicodo-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#br" role="button" aria-expanded="false" aria-controls="br" id="bbri" >
  X
  </a>
<div class="collapse collapse-horizontal" id="br">
    <input type="text" name="brazi" class="form-control form-control-sm col-sm-1" id="ibri">
</div>
<!-- brazoicodo-->

<!-- brazoci-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cjo" role="button" aria-expanded="false" aria-controls="cjo" id="bbric" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cjo">
    <input type="text" name="brazci" class="form-control form-control-sm col-sm-1" id="ibric">
</div>
<!-- brazoci-->

<!-- hombroi-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#hbroi" role="button" aria-expanded="false" aria-controls="hbroi" id="bhomi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="hbroi">
    <input type="text" name="homi" class="form-control form-control-sm col-sm-1" id="ihomi">
</div>
<!-- hombroi-->

<!-- peci-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cpi" role="button" aria-expanded="false" aria-controls="cpi" id="bcpi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cpi">
    <input type="text" name="peci" class="form-control form-control-sm col-sm-1" id="icpi">
</div>
<!-- peci-->

<!-- pecti-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cpei" role="button" aria-expanded="false" aria-controls="cpei" id="bcpei" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cpei">
    <input type="text" name="pecti" class="form-control form-control-sm col-sm-1" id="icpei">
</div>
<!-- pecti-->

<!-- pectd-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cped" role="button" aria-expanded="false" aria-controls="cped" id="bcped" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cped">
    <input type="text" name="pectd" class="form-control form-control-sm col-sm-1" id="icped">
</div>
<!-- pectd-->

<!-- clavi-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cvi" role="button" aria-expanded="false" aria-controls="cvi" id="bcvi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cvi">
    <input type="text" name="cvi" class="form-control form-control-sm col-sm-1" id="icvi">
</div>
<!-- clavi-->

<!-- dedod2-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ddos" role="button" aria-expanded="false" aria-controls="ddos" id="bddos" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ddos">
    <input type="text" name="dedodos" class="form-control form-control-sm col-sm-1" id="iddos">
</div>
<!-- dedod2-->

<!-- dedod3-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ddtres" role="button" aria-expanded="false" aria-controls="ddtres" id="bddt" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ddtres">
    <input type="text" name="dedotres" class="form-control form-control-sm col-sm-1" id="iddt">
</div>
<!-- dedod3-->

<!-- dedod4-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ddcuatro" role="button" aria-expanded="false" aria-controls="ddcuatro" id="bddc" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ddcuatro">
    <input type="text" name="dedocuatro" class="form-control form-control-sm col-sm-1" id="iddc">
</div>
<!-- dedod4-->

<!-- dedod5-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#ddcinco" role="button" aria-expanded="false" aria-controls="ddcinco" id="bddcinco" >
  X
  </a>
<div class="collapse collapse-horizontal" id="ddcinco">
    <input type="text" name="dedocincoo" class="form-control form-control-sm col-sm-1" id="iddcinco">
</div>
<!-- dedod5-->

<!-- palmaderecha-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#palmad" role="button" aria-expanded="false" aria-controls="palmad" id="bpalmad" >
  X
  </a>
<div class="collapse collapse-horizontal" id="palmad">
    <input type="text" name="palmad" class="form-control form-control-sm col-sm-1" id="ipalmad">
</div>
<!-- palmaderecha-->

<!-- muñecaderecha-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#munecader" role="button" aria-expanded="false" aria-controls="munecader" id="bmund" >
  X
  </a>
<div class="collapse collapse-horizontal" id="munecader">
    <input type="text" name="munecad" class="form-control form-control-sm col-sm-1" id="imund">
</div>
<!-- muñecaderecha-->

<!-- brazoderecho-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dbrazo" role="button" aria-expanded="false" aria-controls="dbrazo" id="bdbr" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dbrazo">
    <input type="text" name="derbraz" class="form-control form-control-sm col-sm-1" id="idbr">
</div>
<!-- brazoderecho-->


<!-- antebrazoder-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#anteder" role="button" aria-expanded="false" aria-controls="anteder" id="babd" >
  X
  </a>
<div class="collapse collapse-horizontal" id="anteder">
    <input type="text" name="annbraz" class="form-control form-control-sm col-sm-1" id="ianbd">
</div>
<!-- antbrazoder-->

<!-- conder-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#conejod" role="button" aria-expanded="false" aria-controls="conejod" id="bcder" >
  X
  </a>
<div class="collapse collapse-horizontal" id="conejod">
    <input type="text" name="cconder" class="form-control form-control-sm col-sm-1" id="icder">
</div>
<!-- conder-->

<!-- hombroderecho-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#hombroderecho" role="button" aria-expanded="false" aria-controls="hombroderecho" id="bhder" >
  X
  </a>
<div class="collapse collapse-horizontal" id="hombroderecho">
    <input type="text" name="hombrod" class="form-control form-control-sm col-sm-1" id="ihder">
</div>
<!-- hombroderecho-->


<!-- mandibulader-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#mander" role="button" aria-expanded="false" aria-controls="mander" id="bmand" >
  X
  </a>
<div class="collapse collapse-horizontal" id="mander">
    <input type="text" name="mandiderr" class="form-control form-control-sm col-sm-1" id="imand">
</div>
<!-- mandibulader-->


<!-- mandibulacentro-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#mancentro" role="button" aria-expanded="false" aria-controls="mancentro" id="bmanc" >
  X
  </a>
<div class="collapse collapse-horizontal" id="mancentro">
    <input type="text" name="mandicentroo" class="form-control form-control-sm col-sm-1" id="imanc">
</div>
<!-- mandibulacentro-->

<!-- mandibulaizquierda-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#manizquierda" role="button" aria-expanded="false" aria-controls="manizquierda" id="bmaniz" >
  X
  </a>
<div class="collapse collapse-horizontal" id="manizquierda">
    <input type="text" name="mandiizqui" class="form-control form-control-sm col-sm-1" id="imaniz">
</div>
<!-- mandibulaizquierda-->

<!-- mejilla derecha-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#mejillad" role="button" aria-expanded="false" aria-controls="mejillad" id="bmejd" >
  X
  </a>
<div class="collapse collapse-horizontal" id="mejillad">
    <input type="text" name="mejderecha" class="form-control form-control-sm col-sm-1" id="imejd">
</div>
<!-- mejilla derecha-->

<!--nariz-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#conariz" role="button" aria-expanded="false" aria-controls="conariz" id="bnariz" >
  X
  </a>
<div class="collapse collapse-horizontal" id="conariz">
    <input type="text" name="narizc" class="form-control form-control-sm col-sm-1" id="inariz">
</div>
<!--nariz-->

<!--frenteizq-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#frentei" role="button" aria-expanded="false" aria-controls="frentei" id="bfrentei" >
  X
  </a>
<div class="collapse collapse-horizontal" id="frentei">
    <input type="text" name="frenteizquierda" class="form-control form-control-sm col-sm-1" id="ifrentei">
</div>
<!--frenteizq-->

<!--frenteder-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#frented" role="button" aria-expanded="false" aria-controls="frented" id="bfrented" >
  X
  </a>
<div class="collapse collapse-horizontal" id="frented">
    <input type="text" name="frentederecha" class="form-control form-control-sm col-sm-1" id="ifrented">
</div>
<!--frenteder-->

 <a class="btn btn-primary" data-bs-toggle="collapse" href="#nuev" role="button" aria-expanded="false" aria-controls="nuev" id="nuev1" >
  X
  </a>

<div class="collapse collapse-horizontal" id="nuev">
    <input type="text" name="nuevo" class="form-control form-control-sm col-sm-1" id="nuev2">
</div>


<a class="btn btn-primary" data-bs-toggle="collapse" href="#nn" role="button" aria-expanded="false" aria-controls="nn" id="nuev3" >
  X
  </a>
<div class="collapse collapse-horizontal" id="nn">
    <input type="text" name="nuevo1" class="form-control form-control-sm col-sm-1" id="nuev4">
</div>
<a class="btn btn-primary" data-bs-toggle="collapse" href="#nnn" role="button" aria-expanded="false" aria-controls="nnn" id="nuev5" >
  X
  </a>
<div class="collapse collapse-horizontal" id="nnn">
    <input type="text" name="nuevo2" class="form-control form-control-sm col-sm-1" id="nuev6">
</div>

<a class="btn btn-primary" data-bs-toggle="collapse" href="#nnnn" role="button" aria-expanded="false" aria-controls="nnnn" id="nuev7" >
  X
  </a>
<div class="collapse collapse-horizontal" id="nnnn">
    <input type="text" name="nuevo3" class="form-control form-control-sm col-sm-1" id="nuev8">
</div>

<a class="btn btn-primary" data-bs-toggle="collapse" href="#nnnnn" role="button" aria-expanded="false" aria-controls="nnnnn" id="nuev9" >
  X
  </a>
<div class="collapse collapse-horizontal" id="nnnnn">
    <input type="text" name="nuevo4" class="form-control form-control-sm col-sm-1" id="nuev10">
</div>

<a class="btn btn-primary" data-bs-toggle="collapse" href="#nnnnn1" role="button" aria-expanded="false" aria-controls="nnnnn1" id="nuev11" >
  X
  </a>
<div class="collapse collapse-horizontal" id="nnnnn1">
    <input type="text" name="nuevo5" class="form-control form-control-sm col-sm-1" id="nuev12">
</div>

<a class="btn btn-primary" data-bs-toggle="collapse" href="#nnnnn12" role="button" aria-expanded="false" aria-controls="nnnnn12" id="nuev13" >
  X
  </a>
<div class="collapse collapse-horizontal" id="nnnnn12">
    <input type="text" name="nuevo6" class="form-control form-control-sm col-sm-1" id="nuev14">
</div>

<a class="btn btn-primary" data-bs-toggle="collapse" href="#nnnnn14" role="button" aria-expanded="false" aria-controls="nnnnn14" id="nuev15" >
  X
  </a>
<div class="collapse collapse-horizontal" id="nnnnn14">
    <input type="text" name="nuevo7" class="form-control form-control-sm col-sm-1" id="nuev16">
</div>
<!---------- ESPALDA------------>

<!--plantapie-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#plantapiei" role="button" aria-expanded="false" aria-controls="plantapiei" id="bppi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="plantapiei">
    <input type="text" name="plantapiea" class="form-control form-control-sm col-sm-1" id="ippi">
</div>
<!--plantapie-->

<!--plantapieder-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#plantapieder" role="button" aria-expanded="false" aria-controls="plantapieder" id="bppd" >
  X
  </a>
<div class="collapse collapse-horizontal" id="plantapieder">
    <input type="text" name="plantapieader" class="form-control form-control-sm col-sm-1" id="ippd">
</div>
<!--plantapieder-->


<!--tobati-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#tobilloiz" role="button" aria-expanded="false" aria-controls="tobilloiz" id="btia" >
  X
  </a>
<div class="collapse collapse-horizontal" id="tobilloiz">
    <input type="text" name="tobilloati" class="form-control form-control-sm col-sm-1" id="itia">
</div>
<!--tobati-->

<!--tobatd-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#tobilloder" role="button" aria-expanded="false" aria-controls="tobilloder" id="btda" >
  X
  </a>
<div class="collapse collapse-horizontal" id="tobilloder">
    <input type="text" name="tobilloatd" class="form-control form-control-sm col-sm-1" id="itda">
</div>
<!--tobatd-->

<!--pti-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#chami" role="button" aria-expanded="false" aria-controls="chami" id="bpani" >
  X
  </a>
<div class="collapse collapse-horizontal" id="chami">
    <input type="text" name="ptiatras" class="form-control form-control-sm col-sm-1" id="ipani">
</div>
<!--pti-->

<!--ptd-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#chamd" role="button" aria-expanded="false" aria-controls="chamd" id="bpand" >
  X
  </a>
<div class="collapse collapse-horizontal" id="chamd">
    <input type="text" name="ptdatras" class="form-control form-control-sm col-sm-1" id="ipand">
</div>
<!--ptd-->


<!--piernaiespalda-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#piernaiespalda" role="button" aria-expanded="false" aria-controls="piernaiespalda" id="bpchi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="piernaiespalda">
    <input type="text" name="pierespaldai" class="form-control form-control-sm col-sm-1" id="ipchi">
</div>
<!--piernaiespalda-->

<!--piernadespalda-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#piernadespalda" role="button" aria-expanded="false" aria-controls="piernadespalda" id="bpchd" >
  X
  </a>
<div class="collapse collapse-horizontal" id="piernadespalda">
    <input type="text" name="pierespaldad" class="form-control form-control-sm col-sm-1" id="ipchd">
</div>
<!--piernadespalda-->

<!--musloatrasi-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#musloatrasi" role="button" aria-expanded="false" aria-controls="musloatrasi" id="bmusai" >
  X
  </a>
<div class="collapse collapse-horizontal" id="musloatrasi">
    <input type="text" name="musloatrasiz" class="form-control form-control-sm col-sm-1" id="imusai">
</div>
<!--musloatrasi-->

<!--musloatrasd-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#musloatrasd" role="button" aria-expanded="false" aria-controls="musloatrasd" id="bmusad" >
  X
  </a>
<div class="collapse collapse-horizontal" id="musloatrasd">
    <input type="text" name="musloatrasder" class="form-control form-control-sm col-sm-1" id="imusad">
</div>
<!--musloatrasd-->

<!--gluteosi-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#gluteosi" role="button" aria-expanded="false" aria-controls="gluteosi" id="bglui" >
  X
  </a>
<div class="collapse collapse-horizontal" id="gluteosi">
    <input type="text" name="glutiz" class="form-control form-control-sm col-sm-1" id="iglui">
</div>
<!--gluteosi-->

<!--gluteosd-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#gluteosd" role="button" aria-expanded="false" aria-controls="gluteosd" id="bglud" >
  X
  </a>
<div class="collapse collapse-horizontal" id="gluteosd">
    <input type="text" name="glutder" class="form-control form-control-sm col-sm-1" id="iglud">
</div>
<!--gluteosd-->


<!--cinturai-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cinturai" role="button" aria-expanded="false" aria-controls="cinturai" id="bcini" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cinturai">
    <input type="text" name="cinturaiz" class="form-control form-control-sm col-sm-1" id="icini">
</div>
<!--cinturai-->

<!--cinturad-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cinturad" role="button" aria-expanded="false" aria-controls="cinturad" id="bcind" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cinturad">
    <input type="text" name="cinturader" class="form-control form-control-sm col-sm-1" id="icind">
</div>
<!--cinturad-->

<!--costillasai-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#costillasai" role="button" aria-expanded="false" aria-controls="costillasai" id="bcosi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="costillasai">
    <input type="text" name="costilliz" class="form-control form-control-sm col-sm-1" id="icosi">
</div>
<!--costillasai-->

<!--costillasad-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#costillasad" role="button" aria-expanded="false" aria-controls="costillasad" id="bcosd" >
  X
  </a>
<div class="collapse collapse-horizontal" id="costillasad">
    <input type="text" name="costillder" class="form-control form-control-sm col-sm-1" id="icosd">
</div>
<!--costillasad-->

<!--espaldarribai-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#espaldarribai" role="button" aria-expanded="false" aria-controls="espaldarribai" id="besai" >
  X
  </a>
<div class="collapse collapse-horizontal" id="espaldarribai">
    <input type="text" name="espaldarribaiz" class="form-control form-control-sm col-sm-1" id="iesai">
</div>
<!--espaldarribai-->

<!--espaldarribad-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#espaldarribad" role="button" aria-expanded="false" aria-controls="espaldarribad" id="besad" >
  X
  </a>
<div class="collapse collapse-horizontal" id="espaldarribad">
    <input type="text" name="espaldaarribader" class="form-control form-control-sm col-sm-1" id="iesad">
</div>
<!--espaldarribad-->

<!--espaldalta-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#espaldalta" role="button" aria-expanded="false" aria-controls="espaldalta" id="besalt" >
  X
  </a>
<div class="collapse collapse-horizontal" id="espaldalta">
    <input type="text" name="espaldaalta" class="form-control form-control-sm col-sm-1" id="iesalt">
</div>
<!--espaldalta-->

<!--dorsaliz mano-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dorsaliz" role="button" aria-expanded="false" aria-controls="dorsaliz" id="bdorsali" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dorsaliz">
    <input type="text" name="dorsaliz" class="form-control form-control-sm col-sm-1" id="idorsali">
</div>
<!--dorsaliz-->

<!--dorsalder mano-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#dorsalder" role="button" aria-expanded="false" aria-controls="dorsalder" id="bdorsald" >
  X
  </a>
<div class="collapse collapse-horizontal" id="dorsalder">
    <input type="text" name="dorsalder" class="form-control form-control-sm col-sm-1" id="idorsald">
</div>
<!--dorsalder-->

<!--munecaatrasi-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#munecaatrasi" role="button" aria-expanded="false" aria-controls="munecaatrasi" id="bmuneati" >
  X
  </a>
<div class="collapse collapse-horizontal" id="munecaatrasi">
    <input type="text" name="munecaatrasiz" class="form-control form-control-sm col-sm-1" id="imuneati">
</div>
<!--munecaatrasi-->

<!--munecaatrasd-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#munecaatrasd" role="button" aria-expanded="false" aria-controls="munecaatrasd" id="bmuneatd" >
  X
  </a>
<div class="collapse collapse-horizontal" id="munecaatrasd">
    <input type="text" name="munecaatrasder" class="form-control form-control-sm col-sm-1" id="imuneatd">
</div>
<!--munecaatrasd-->

<!--antebiesp-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#antebiesp" role="button" aria-expanded="false" aria-controls="antebiesp" id="banbei" >
  X
  </a>
<div class="collapse collapse-horizontal" id="antebiesp">
    <input type="text" name="antebiesp" class="form-control form-control-sm col-sm-1" id="ianbei">
</div>
<!--antebiesp-->

<!--antebdesp-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#antebdesp" role="button" aria-expanded="false" aria-controls="antebdesp" id="banbed" >
  X
  </a>
<div class="collapse collapse-horizontal" id="antebdesp">
    <input type="text" name="antebdesp" class="form-control form-control-sm col-sm-1" id="ianbed">
</div>
<!--antebdesp-->

<!--casicodoi-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#casicodoi" role="button" aria-expanded="false" aria-controls="casicodoi" id="bccodoi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="casicodoi">
    <input type="text" name="casicodoi" class="form-control form-control-sm col-sm-1" id="iccodoi">
</div>
<!--casicodoi-->

<!--casicododer-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#casicododer" role="button" aria-expanded="false" aria-controls="casicododer" id="bccodod" >
  X
  </a>
<div class="collapse collapse-horizontal" id="casicododer">
    <input type="text" name="casicododer" class="form-control form-control-sm col-sm-1" id="iccodod">
</div>
<!--casicododer-->

<!--brazalti-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#brazalti" role="button" aria-expanded="false" aria-controls="brazalti" id="bbaiz" >
  X
  </a>
<div class="collapse collapse-horizontal" id="brazalti">
    <input type="text" name="brazalti" class="form-control form-control-sm col-sm-1" id="ibaiz">
</div>
<!--brazalti-->

<!--brazaltder-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#brazaltder" role="button" aria-expanded="false" aria-controls="brazaltder" id="bbader" >
  X
  </a>
<div class="collapse collapse-horizontal" id="brazaltder">
    <input type="text" name="brazaltder" class="form-control form-control-sm col-sm-1" id="ibader">
</div>
<!--brazaltder-->

<!--cuelloatrasbajo-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cuelloatrasbajo" role="button" aria-expanded="false" aria-controls="cuelloatrasbajo" id="bcbajo" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cuelloatrasbajo">
    <input type="text" name="cuellatrasb" class="form-control form-control-sm col-sm-1" id="icbajo">
</div>
<!--cuelloatrasbajo-->

<!--cuelloatrasmedio-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cuelloatrasmedio" role="button" aria-expanded="false" aria-controls="cuelloatrasmedio" id="bcmedio" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cuelloatrasmedio">
    <input type="text" name="cuellatrasmedio" class="form-control form-control-sm col-sm-1" id="icmedio">
</div>
<!--cuelloatrasmedio-->

<!--cabezadorsalmedia-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cabezadorsalmedia" role="button" aria-expanded="false" aria-controls="cabezadorsalmedia" id="bcabezamedio" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cabezadorsalmedia">
    <input type="text" name="cabedorsalm" class="form-control form-control-sm col-sm-1" id="icabezamedio">
</div>
<!--cabezadorsalmedia-->

<!--cabezaaltaizquierda-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cabezaaltaizquierda" role="button" aria-expanded="false" aria-controls="cabezaaltaizquierda" id="bcabaiz" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cabezaaltaizquierda">
    <input type="text" name="cabealtaizqu" class="form-control form-control-sm col-sm-1" id="icabaiz">
</div>
<!--cabezaaltaizquierda-->

<!--cabezaaltadercha-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#cabezaaltadercha" role="button" aria-expanded="false" aria-controls="cabezaaltadercha" id="bcabader" >
  X
  </a>
<div class="collapse collapse-horizontal" id="cabezaaltadercha">
    <input type="text" name="cabezaaltader" class="form-control form-control-sm col-sm-1" id="icabader">
</div>
<!--cabezaaltadercha-->


<!--espinillaizquierda-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#espinillaizquierda" role="button" aria-expanded="false" aria-controls="espinillaizquierda" id="espi" >
  X
  </a>
<div class="collapse collapse-horizontal" id="espinillaizquierda">
    <input type="text" name="espizq" class="form-control form-control-sm col-sm-1" id="cssespi">
</div>
<!--espinillaizquierda-->


<!--espinillader-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#espinillader" role="button" aria-expanded="false" aria-controls="espinillader" id="espd" >
  X
  </a>
<div class="collapse collapse-horizontal" id="espinillader">
    <input type="text" name="espder" class="form-control form-control-sm col-sm-1" id="cssespd">
</div>
<!--espinillader-->

<!--coxix-->
  <a class="btn btn-primary" data-bs-toggle="collapse" href="#coxix" role="button" aria-expanded="false" aria-controls="coxix" id="coxis" >
  X
  </a>
<div class="collapse collapse-horizontal" id="coxix">
    <input type="text" name="coxis" class="form-control form-control-sm col-sm-1" id="csscoxis">
</div>
<!--coxix-->


 <center><img src="../../img/marcaje_qx.jpg" height="550" id="im"></center>
     
    </div>
     
  </div>
</div>
<p>
Observaciones:
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="obg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="cioness"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playobse1"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" rows="3" name="obse" id="txtseee"></textarea>
<script type="text/javascript">
const obg = document.getElementById('obg');
const cioness = document.getElementById('cioness');
const txtseee = document.getElementById('txtseee');

const btnPlayTextosbe = document.getElementById('playobse1');

btnPlayTextosbe.addEventListener('click', () => {
        leerTexto(txtseee.value);
});

function leerTexto(txtseee){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtseee;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let ro = new webkitSpeechRecognition();
      ro.lang = "es-ES";
      ro.continuous = true;
      ro.interimResults = false;

      ro.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtseee.value += frase;
      }

      obg.addEventListener('click', () => {
        ro.start();
      });

      cioness.addEventListener('click', () => {
        ro.abort();
      });
</script>
<hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>EVALUACIÓN DE ABUSO / MALTRATO / AGRESIÓN</center></strong></tr>
</div>
<p>
<div class="container">
  <div class="row">
<div class="col-sm-5">
 Datos de agresión física:
</div> 
<div class="col-sm">
    <input class="form-check-input" type="radio" value="SI" id="datag" name="datag">
  <label class="form-check-label" for="datag">
   SI
  </label>
    </div>
    <div class="col-sm">
    <input class="form-check-input" type="radio" value="NO" id="datagn" name="datag">
  <label class="form-check-label" for="datagn">
   NO
  </label>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
<div class="col-sm-5">
 Datos de temor o inquietud al acercamiento físico:
</div> 
<div class="col-sm">
    <input class="form-check-input" type="radio" value="SI" id="dati" name="dati">
  <label class="form-check-label" for="dati">
   SI
  </label>
    </div>
    <div class="col-sm">
    <input class="form-check-input" type="radio" value="NO" id="datin" name="dati">
  <label class="form-check-label" for="datin">
   NO
  </label>
    </div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-1">
      Explique:

    </div>
    <div class="col-sm">
<div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="queg"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="lis"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playexplique"><i class="fas fa-play"></button></i>
</div>
<textarea class="form-control" name="ex" id="txtexp"></textarea>
<script type="text/javascript">
const queg = document.getElementById('queg');
const lis = document.getElementById('lis');
const txtexp = document.getElementById('txtexp');

const btnPlayTextqueex = document.getElementById('playexplique');

btnPlayTextqueex.addEventListener('click', () => {
        leerTexto(txtexp.value);
});

function leerTexto(txtexp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtexp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rq = new webkitSpeechRecognition();
      rq.lang = "es-ES";
      rq.continuous = true;
      rq.interimResults = false;

      rq.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtexp.value += frase;
      }

      queg.addEventListener('click', () => {
        rq.start();
      });

      lis.addEventListener('click', () => {
        rq.abort();
      });
</script>
    </div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
<div class="col-sm-2">
 Caso legal:
</div> 
<div class="col-sm">
    <input class="form-check-input" type="radio" value="SI" id="cas" name="cas">
  <label class="form-check-label" for="cas">
   SI
  </label>
    </div>
    <div class="col-sm">
    <input class="form-check-input" type="radio" value="NO" id="casn" name="cas">
  <label class="form-check-label" for="casn">
   NO
  </label>
    </div>
    <div class="col-sm-3">
 Reportado al MP:
</div>
<div class="col-sm">
    <input class="form-check-input" type="radio" value="SI" id="rep" name="rep">
  <label class="form-check-label" for="rep">
   SI
  </label>
    </div>
    <div class="col-sm">
    <input class="form-check-input" type="radio" value="NO" id="repn" name="rep">
  <label class="form-check-label" for="repn">
   NO
  </label>
    </div>
  </div>
</div>
<hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>VALORACIÓN PSICOLÓGICA</center></strong></tr>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-3">
  El paciente se encuentra:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="calmado y relajado" id="cal" name="penc">
  <label class="form-check-label" for="cal">
   calmado/relajado
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="cooperador" id="cooperador" name="penc">
  <label class="form-check-label" for="cooperador">
    cooperador
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="ansioso" id="ansioso" name="penc">
  <label class="form-check-label" for="ansioso">
    ansioso
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="hostil" id="hostil" name="penc">
  <label class="form-check-label" for="hostil">
    hostil
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="combativo" id="combativo" name="penc">
  <label class="form-check-label" for="combativo">
    combativo
  </label>
    </div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-3">
  Agresivo a:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="si mismo" id="sim" name="agre">
  <label class="form-check-label" for="sim">
   si mismo
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="terceros" id="terceros" name="agre">
  <label class="form-check-label" for="terceros">
    terceros
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="infraestructura" id="infraestructura" name="agre">
  <label class="form-check-label" for="infraestructura">
    infraestructura
  </label>
    </div>
 <div class="col-sm">
</div>
<div class="col-sm">
</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-3">
  Origen:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="psiquiatrico" id="psiquiátrico" name="origen">
  <label class="form-check-label" for="psiquiátrico">
   psiquiátrico
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="neurologico" id="neurológico" name="origen">
  <label class="form-check-label" for="neurológico">
    neurológico
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="toxicologico" id="toxicológico" name="origen">
  <label class="form-check-label" for="toxicológico">
    toxicológico
  </label>
    </div>
 <div class="col-sm">
</div>
<div class="col-sm">
</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-3">
  Alucinaciones:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="SI" id="alucsi" name="aluc">
  <label class="form-check-label" for="alucsi">
   SI
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="NO" id="aluno" name="aluc">
  <label class="form-check-label" for="aluno">
    NO
  </label>
    </div>
    <div class="col-sm">
    </div>
 <div class="col-sm">
</div>
<div class="col-sm">
</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-3">
  Tipo:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="auditiva" id="auditiva" name="tip">
  <label class="form-check-label" for="auditiva">
   auditiva
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="visual" id="visual" name="tip">
  <label class="form-check-label" for="visual">
    visual
  </label>
    </div>
   <div class="col-sm">
      <input class="form-check-input" type="radio" value="táctiles" id="táctiles" name="tip">
  <label class="form-check-label" for="táctiles">
    táctiles
  </label>
    </div>
 <div class="col-sm">
</div>
<div class="col-sm">
</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-3">
  Ideas suicidas:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="SI" id="isi" name="idea">
  <label class="form-check-label" for="isi">
   SI
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="NO" id="ino" name="idea">
  <label class="form-check-label" for="ino">
    NO
  </label>
    </div>
   <div class="col-sm">
    </div>
 <div class="col-sm">
</div>
<div class="col-sm">
</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-3">
  Ideas homicidas:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="SI" id="isih" name="ideah">
  <label class="form-check-label" for="isih">
   SI
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="NO" id="inoh" name="ideah">
  <label class="form-check-label" for="inoh">
    NO
  </label>
    </div>
   <div class="col-sm">
    </div>
 <div class="col-sm">
</div>
<div class="col-sm">
</div>
  </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-sm-3">
  Estado de ánimo:
  </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="facie triste" id="facie triste" name="edoan">
  <label class="form-check-label" for="facie triste">
   facie triste
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="facie sonriente" id="facie sonriente" name="edoan">
  <label class="form-check-label" for="facie sonriente">
    facie sonriente
  </label>
    </div>
   <div class="col-sm">
      <input class="form-check-input" type="radio" value="facie enojado" id="facie enojado" name="edoan">
  <label class="form-check-label" for="facie enojado">
    facie enojado
  </label>
    </div>
 <div class="col-sm">
      <input class="form-check-input" type="radio" value="inexpresivo" id="inexpresivo" name="edoan">
  <label class="form-check-label" for="inexpresivo">
    inexpresivo
  </label>
    </div>
<div class="col-sm">
</div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
      Comentarios:
    </div>
    <div class="col-sm">
      <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="comge"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="rioss"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playcomeso"><i class="fas fa-play"></button></i>
</div>
<textarea name="com" class="form-control" id="txtcm"></textarea>
 <script type="text/javascript">
const comge = document.getElementById('comge');
const rioss = document.getElementById('rioss');
const txtcm = document.getElementById('txtcm');

const btnPlayTextoscom = document.getElementById('playcomeso');

btnPlayTextoscom.addEventListener('click', () => {
        leerTexto(txtcm.value);
});

function leerTexto(txtcm){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtcm;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rco = new webkitSpeechRecognition();
      rco.lang = "es-ES";
      rco.continuous = true;
      rco.interimResults = false;

      rco.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtcm.value += frase;
      }

      comge.addEventListener('click', () => {
        rco.start();
      });

      rioss.addEventListener('click', () => {
        rco.abort();
      });
</script>
    </div>
  </div>
</div>
<hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>VALORACIÓN FUNCIONAL</center></strong></tr>
</div>
<p>

  <div class="container">
  <div class="row">
    <div class="col-sm-2">
  <strong>Respiratoria:</strong>
  </div>
    <div class="col-sm">
        <input type="checkbox" name="res[]" value="regular" id="regular" class="form-check-input">
  <label class="form-check-label" for="regular">
   regular
  </label>
    </div>
    <div class="col-sm">
        <input type="checkbox" name="res[]" value="estertores" id="estertores" class="form-check-input">
  <label class="form-check-label" for="estertores">
    estertores
  </label>
    </div>
   <div class="col-sm">
        <input type="checkbox" name="res[]" value="disnea" id="disnea" class="form-check-input">
  <label class="form-check-label" for="disnea">
    disnea
  </label>
    </div>
 <div class="col-sm">
      <input type="checkbox" name="res[]" value="aleteo nasal" id="aleteo nasal" class="form-check-input">
  <label class="form-check-label" for="aleteo nasal">
    aleteo nasal
  </label>
    </div>
    <div class="col-sm">
    <input type="checkbox" name="res[]" value="tiraje intercostal" id="tiraje intercostal" class="form-check-input">
  <label class="form-check-label" for="tiraje intercostal">
  tiraje intercostal
  </label>
    </div>
  </div>
</div>
<div class="container">
  <div class="row">
<div class="col-sm-2">
    </div>
    <div class="col-sm">
         <input type="checkbox" name="res[]" value="tos" id="tos" class="form-check-input">
  <label class="form-check-label" for="tos">
    tos
  </label>
    </div>
    <div class="col-sm">
    <input type="checkbox" name="res[]" value="seca" id="seca" class="form-check-input">
  <label class="form-check-label" for="secar">
    seca
  </label>
    </div>
    <div class="col-sm">
     <input type="checkbox" name="res[]" value="productiva" id="productiva" class="form-check-input">
  <label class="form-check-label" for="productiva">
  productiva
  </label>
    </div>
<div class="col-sm-4">
    <input type="checkbox" name="res[]" value="sin alteraciones observadas" id="sin alteraciones observadas" class="form-check-input">
<label class="form-check-label" for="sin alteraciones observadas">
sin alteraciones observadas
</label>
    </div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
<div class="col-sm-2">
  Dispositivo de 02:
    </div>
    <div class="col-sm-2">
      <input class="form-check-input" type="radio" value="SI" id="dsi" name="disvo">
  <label class="form-check-label" for="dsi">
    SI
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="NO" id="dnoo" name="disvo">
  <label class="form-check-label" for="dnoo">
    NO
  </label>
    </div>
    <div class="col-sm-2">
      <button type="button" class="btn btn-success btn-sm" id="playtipo1"><i class="fas fa-play"></button></i> Tipo:
    </div>
<div class="col-sm-5">
<input class="form-control" type="text" name="dtipo" id="txtt1ipo">
    </div>
<script type="text/javascript">
const txtt1ipo = document.getElementById('txtt1ipo');
const btnPlayTextpot = document.getElementById('playtipo1');

btnPlayTextpot.addEventListener('click', () => {
        leerTexto(txtt1ipo.value);
});

function leerTexto(txtt1ipo){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtt1ipo;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  </div>
</div>
<hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>ABDOMEN</center></strong></tr>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playpersis"><i class="fas fa-play"></button></i> Perístalsis:
    </div>
    <div class="col-sm-2">
        <select class="form-control" name="peri" id="txtperi">
            <option value="">Seleccionar perístalsis</option>
            <option value="Presente">Presente</option>
            <option value="Ausente">Ausente</option>
        </select>
      
    </div>
<script type="text/javascript">
const txtperi = document.getElementById('txtperi');
const btnPlayTextyalsis = document.getElementById('playpersis');

btnPlayTextyalsis.addEventListener('click', () => {
        leerTexto(txtperi.value);
});

function leerTexto(txtperi){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtperi;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
     <button type="button" class="btn btn-success btn-sm" id="playevcio"><i class="fas fa-play"></button></i>  Evacuación:
    </div>
    <div class="col-sm-2">
      <input type="text" class="form-control" name="evac" id="evactxt">
    </div>
<script type="text/javascript">
const evactxt = document.getElementById('evactxt');
const btnPlayTextevaca = document.getElementById('playevcio');

btnPlayTextevaca.addEventListener('click', () => {
        leerTexto(evactxt.value);
});

function leerTexto(evactxt){
    const speech = new SpeechSynthesisUtterance();
    speech.text= evactxt;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    
    <!--<div class="col-sm">
      <input class="form-check-input" type="radio" value="presente" id="presente" name="abd">
  <label class="form-check-label" for="presente">
    presente
  </label>
    </div>-->
    <div class="col-sm-2">
       <button type="button" class="btn btn-success btn-sm" id="playfrecc"><i class="fas fa-play"></button></i> Frecuencia:
    </div>
    <div class="col-sm-2">
      <input class="form-control" type="text" id="dno" name="frecu">
    </div>
  </div>
</div>
<script type="text/javascript">
const dno = document.getElementById('dno');
const btnPlayTextdno = document.getElementById('playfrecc');
btnPlayTextdno.addEventListener('click', () => {
        leerTexto(dno.value);
});

function leerTexto(dno){
    const speech = new SpeechSynthesisUtterance();
    speech.text= dno;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<p>

  <div class="container">
  <div class="row">
<div class="col-sm-3">
 <button type="button" class="btn btn-success btn-sm" id="playultie"><i class="fas fa-play"></button></i> Última evacuación:
    </div>
    <div class="col-sm-3">
      <input class="form-control" type="text" id="ulte" name="ulte">
    </div>
    <script type="text/javascript">
const ulte = document.getElementById('ulte');
const btnPlayTextulteevac = document.getElementById('playultie');
btnPlayTextulteevac.addEventListener('click', () => {
        leerTexto(ulte.value);
});

function leerTexto(ulte){
    const speech = new SpeechSynthesisUtterance();
    speech.text= ulte;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<div class="col-sm-2">
   <br><center> <strong>Adbomen</strong></center>
    </div>
    <div class="col-sm-2">
      <input class="form-check-input" type="radio" value="duro" id="duro" name="ultev">
  <label class="form-check-label" for="duro">
    duro
  </label>
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="blandos" id="blandos" name="abd">
  <label class="form-check-label" for="blandos">
    blandos
  </label>
    </div>
  
  
  </div>
</div>

<div class="container">
  <div class="row">
<div class="col-sm-8">
    </div>
    <div class="col-sm">
      <input class="form-check-input" type="radio" value="distendido" id="distendido" name="ultev">
  <label class="form-check-label" for="distendido">
    distendido
  </label>
    </div>
  
    <div class="col-sm">
<input class="form-check-input" type="radio" value="sin alteraciones observadas" id="sin altración observada" name="ultev">
<label class="form-check-label" for="sin altración observada">
sin alteración observada
</label>
    </div>
    <div class="row">
    <div class="col-sm-2">
     Hora:<input type="time" name="hora_estoma" class="form-control">
    </div>
    <div class="col-sm-2">
     Estoma:<input type="text" name="estoma" class="form-control">
    </div>
  </div>
  </div>
  
</div>


<hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>URINARIO</center></strong></tr>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
        <input type="checkbox" name="uri[]" value="incontinencia" id="incontinencia" class="form-check-input">
  <label class="form-check-label" for="incontinencia">
    incontinencia
  </label>
    </div>
    <div class="col-sm">
          <input type="checkbox" name="uri[]" value="tenesmo" id="tenesmo" class="form-check-input">
  <label class="form-check-label" for="tenesmo">
  tenesmo
  </label>
    </div>
<div class="col-sm">
          <input type="checkbox" name="uri[]" value="poliuria" id="poliuria" class="form-check-input">
<label class="form-check-label" for="poliuria">
poliuria
</label>
    </div>
    <div class="col-sm">
         <input type="checkbox" name="uri[]" value="piuria" id="piuria" class="form-check-input">
<label class="form-check-label" for="piuria">
piuria
</label>
    </div>
     <div class="col-sm">
          <input type="checkbox" name="uri[]" value="coliuria" id="coliuria" class="form-check-input">
<label class="form-check-label" for="coliuria">
coliuria
</label>
    </div>
 <div class="col-sm">
      <input type="checkbox" name="uri[]" value="hematuria" id="hematuria" class="form-check-input">
<label class="form-check-label" for="hematuria">
hematuria
</label>
    </div>
     <div class="col-sm">
         <input type="checkbox" name="uri[]" value="retencion" id="retencion" class="form-check-input">
<label class="form-check-label" for="retención">
retención
</label>
    </div>
     <div class="col-sm">
         <input type="checkbox" name="uri[]" value="disuria" id="disuria" class="form-check-input">
<label class="form-check-label" for="disuria">
disuria
</label>
    </div>
     <div class="col-sm">
         <input type="checkbox" name="uri[]" value="oliguria" id="oliguria" class="form-check-input">
<label class="form-check-label" for="oliguria">
oliguria
</label>
    </div>
     <div class="col-sm">
         <input type="checkbox" name="uri[]" value="poliquiuria" id="poliquiuria" class="form-check-input">
<label class="form-check-label" for="poliquiuria">
poliquiuria
</label>
    </div>
  </div>
</div>
<p>
<div class="container">
  <div class="row">
    <div class="col-sm-2">
         <input type="checkbox" name="uri[]" value="nicturia" id="nicturia" class="form-check-input">
  <label class="form-check-label" for="nicturia">
    nicturia
  </label>
    </div>
    <div class="col-sm">
        <input type="checkbox" name="uri[]" value="dialisis" id="dialisis" class="form-check-input">
  <label class="form-check-label" for="diálisis">
  diálisis
  </label>
    </div>
<div class="col-sm">
     <input type="checkbox" name="uri[]" value="hemodialisis" id="hemodialisis" class="form-check-input">
<label class="form-check-label" for="hemodiálisis">
hemodiálisis
</label>
    </div>
     <div class="col-sm-3">
          <input type="checkbox" name="uri[]" value="sin alteracion" id="sao" class="form-check-input">
<label class="form-check-label" for="sao">
sin alteraciones observadas
</label>
    </div>
     <div class="col-sm">
          <input type="checkbox" name="uri[]" value="sonda vesical" id="sonda vesical" class="form-check-input">
<label class="form-check-label" for="sonda vesical">
sonda vesical
</label>
    </div>
    </div><p>
  <div class="container">
  <div class="row">
<div class="col-sm-2">
 <button type="button" class="btn btn-success btn-sm" id="playtipo2"><i class="fas fa-play"></button></i> Tipo:
</div>
<div class="col-sm-2">
<input type="text" class="form-control" name="tipou" id="txtti2p" required>
</div>
<script type="text/javascript">
const txtti2p = document.getElementById('txtti2p');
const btnPlayTextopit = document.getElementById('playtipo2');
btnPlayTextopit.addEventListener('click', () => {
        leerTexto(txtti2p.value);
});

function leerTexto(txtti2p){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtti2p;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<div class="col-sm-2">
 <button type="button" class="btn btn-success btn-sm" id="playno2"><i class="fas fa-play"></button></i> No.:
</div>
<div class="col-sm-2">
  <input type="number" class="form-control" name="no" id="txtnnoo" required>
</div>
<script type="text/javascript">
const txtnnoo = document.getElementById('txtnnoo');
const btnPlayTextono = document.getElementById('playno2');
btnPlayTextono.addEventListener('click', () => {
        leerTexto(txtnnoo.value);
});

function leerTexto(txtnnoo){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtnnoo;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-2">
<button type="button" class="btn btn-success btn-sm" id="playinstal"><i class="fas fa-play"></button></i> Instalación:
    </div>
    <div class="col-sm-2">
      <input class="form-control" type="text" name="inst" id="txtinns" required>
    </div>
  </div>
</div>
<script type="text/javascript">
const txtinns = document.getElementById('txtinns');
const btnPlayTexttalains = document.getElementById('playinstal');
btnPlayTexttalains.addEventListener('click', () => {
        leerTexto(txtinns.value);
});

function leerTexto(txtinns){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtinns;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<hr>

  



<script type="text/javascript">
const txttamd2 = document.getElementById('txttamd2');
const btnPlayText3dert = document.getElementById('playtam22');
btnPlayText3dert.addEventListener('click', () => {
        leerTexto(txttamd2.value);
});

function leerTexto(txttamd2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttamd2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

const txttamiz2d = document.getElementById('txttamiz2d');
const btnPlayTextd2izq = document.getElementById('playtam22');
btnPlayTextd2izq.addEventListener('click', () => {
        leerTexto(txttamiz2d.value);
});

function leerTexto(txttamiz2d){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txttamiz2d;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>



<script type="text/javascript">
const txtglic5 = document.getElementById('txtglic5');
const btnPlayTextccpilarr = document.getElementById('playgllarc');
btnPlayTextccpilarr.addEventListener('click', () => {
        leerTexto(txtglic5.value);
});

function leerTexto(txtglic5){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtglic5;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

</script>
<hr>
<div class="thead" style="background-color: #2b2d7f; color: white; font-size: 20px;">
         <tr><strong><center>CONTROL DE LÍQUIDOS</center></strong>
</div>
<p>


<div class="container">
  <div class="row">
    <div class="col-sm">
    <center> <strong>INGRESOS</strong></center>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col-sm-3"><button type="button" class="btn btn-success btn-sm" id="playsolin4"><i class="fas fa-play"></button></i> Soluciones parenterales</th>
      <th scope="col-sm-3"><div class="losInput"><input type="number" class="form-control" name="solp" id="soltxtp"></div></th>
    </tr>
  </thead>
  <script type="text/javascript">
const soltxtp = document.getElementById('soltxtp');
const btnPlayTextosolp = document.getElementById('playsolin4');
btnPlayTextosolp.addEventListener('click', () => {
        leerTexto(soltxtp.value);
});

function leerTexto(soltxtp){
    const speech = new SpeechSynthesisUtterance();
    speech.text= soltxtp;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  <tbody>
    <tr>
      <th scope="row"><button type="button" class="btn btn-success btn-sm" id="playviorl4"><i class="fas fa-play"></button></i> Vía oral</th>
      <td><div class="losInput"><input type="number" class="form-control" name="voral" id="txtlaro"></div></td>
    </tr>
    <script type="text/javascript">
const txtlaro = document.getElementById('txtlaro');
const btnPlayTextvalor = document.getElementById('playviorl4');
btnPlayTextvalor.addEventListener('click', () => {
        leerTexto(txtlaro.value);
});

function leerTexto(txtlaro){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtlaro;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <tr>
      <th scope="row"><button type="button" class="btn btn-success btn-sm" id="playtotieas"><i class="fas fa-play"></button></i> TOTAL:</th>
      <td><div class="inputTotal" onclick="Sumar(this.value);"><input type="number" class="form-control" name="" id="num1" onclick="Sumar(this.value);" disabled ></div></td>
    </tr>
  </tbody>
</table>
    </div>
 <script type="text/javascript">
const num1 = document.getElementById('num1');
const btnPlayTextn1m = document.getElementById('playtotieas');
btnPlayTextn1m.addEventListener('click', () => {
        leerTexto(num1.value);
});

function leerTexto(num1){
    const speech = new SpeechSynthesisUtterance();
    speech.text= num1;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm">
     <center><strong>EGRESOS</strong></center>

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th scope="col"><button type="button" class="btn btn-success btn-sm" id="playtvomito4"><i class="fas fa-play"></button></i> Vómito</th>
      <th scope="col"><div class="losInput2"><input type="number" class="form-control" name="vomi" id="txt2vo2"></div></th>
    </tr>
    <script type="text/javascript">
const txt2vo2 = document.getElementById('txt2vo2');
const btnPlayTextvmo22 = document.getElementById('playtvomito4');
btnPlayTextvmo22.addEventListener('click', () => {
        leerTexto(txt2vo2.value);
});

function leerTexto(txt2vo2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txt2vo2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  </thead>
  <tbody>
    <tr>
      <th scope="row"><button type="button" class="btn btn-success btn-sm" id="playorina"><i class="fas fa-play"></button></i> Orina</th>
      <td><div class="losInput2"><input type="number" class="form-control" name="orina" id="txtorina4"></div></td>
    </tr>
    <script type="text/javascript">
const txtorina4 = document.getElementById('txtorina4');
const btnPlayTextorin = document.getElementById('playorina');
btnPlayTextorin.addEventListener('click', () => {
        leerTexto(txtorina4.value);
});

function leerTexto(txtorina4){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtorina4;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <tr>
      <th scope="row"><button type="button" class="btn btn-success btn-sm" id="playevacotr"><i class="fas fa-play"></button></i> Evacuación</th>
      <td><div class="losInput2"><input type="number" class="form-control" name="evc" id="txtotraev"></div></td>
    </tr>
    <script type="text/javascript">
const txtotraev = document.getElementById('txtotraev');
const btnPlayTextotraev = document.getElementById('playevacotr');
btnPlayTextotraev.addEventListener('click', () => {
        leerTexto(txtotraev.value);
});

function leerTexto(txtotraev){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtotraev;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <tr>
      <th scope="row"><button type="button" class="btn btn-success btn-sm" id="playotrosr"><i class="fas fa-play"></button></i> Otros</th>
      <td><div class="losInput2"><input type="number" class="form-control" name="ot" id="txtrort"></div></td>
    </tr>
    <script type="text/javascript">
const txtrort = document.getElementById('txtrort');
const btnPlayTextreaor = document.getElementById('playotrosr');
btnPlayTextreaor.addEventListener('click', () => {
        leerTexto(txtrort.value);
});

function leerTexto(txtrort){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtrort;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <tr>
      <th scope="row"><button type="button" class="btn btn-success btn-sm" id="playtotaldos"><i class="fas fa-play"></button></i> TOTAL:</th>
      <td><div class="inputTotal2" onclick="Sumar(this.value);"><input type="number" class="form-control" name="" id="num2" onclick="Sumar(this.value);" disabled></div></td>
    </tr>
    <script type="text/javascript">
const num2 = document.getElementById('num2');
const btnPlayTexttot2ine = document.getElementById('playtotaldos');
btnPlayTexttot2ine.addEventListener('click', () => {
        leerTexto(num2.value);
});

function leerTexto(num2){
    const speech = new SpeechSynthesisUtterance();
    speech.text= num2;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <tr>
      <th scope="row"><button type="button" class="btn btn-success btn-sm" id="playbalance"><i class="fas fa-play"></button></i> BALANCE:</th>
      <td><div class="inputTotalB"><input type="number" class="form-control" name="" id="sum" disabled>
       </div>
      </td>
    </tr>
  </tbody>
</table>
<script type="text/javascript">
const sum = document.getElementById('sum');
const btnPlayTextsumtoteg = document.getElementById('playbalance');
btnPlayTextsumtoteg.addEventListener('click', () => {
        leerTexto(sum.value);
});

function leerTexto(sum){
    const speech = new SpeechSynthesisUtterance();
    speech.text= sum;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    </div>
  </div>
</div>
 
<hr>
<p>
<th><h5><strong>Nota de enfermería</strong></h5>
 <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="notag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="nesea"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playnotenf4"><i class="fas fa-play"></button></i>
</div></th>
<textarea rows="3" class="form-control" name="notenf" value="" id="txtnenf"></textarea>
<script type="text/javascript">
const notag = document.getElementById('notag');
const nesea = document.getElementById('nesea');
const txtnenf = document.getElementById('txtnenf');

const btnPlayTextenfnot4 = document.getElementById('playnotenf4');
btnPlayTextenfnot4.addEventListener('click', () => {
        leerTexto(txtnenf.value);
});

function leerTexto(txtnenf){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtnenf;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let rta = new webkitSpeechRecognition();
      rta.lang = "es-ES";
      rta.continuous = true;
      rta.interimResults = false;

      rta.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtnenf.value += frase;
      }

      notag.addEventListener('click', () => {
        rta.start();
      });

      nesea.addEventListener('click', () => {
        rta.abort();
      });
</script>
<hr>

<div class="container">
  <div class="row">
    <div class="col-sm">
<label for="tra"><button type="button" class="btn btn-success btn-sm" id="playtrasladoa"><i class="fas fa-play"></button></i> Traslado a:</label>
<input type="text" name="tra" class="form-control" id="txtatra">
<script type="text/javascript">
const txtatra = document.getElementById('txtatra');
const btnPlayTextladotras = document.getElementById('playtrasladoa');
btnPlayTextladotras.addEventListener('click', () => {
        leerTexto(txtatra.value);
});

function leerTexto(txtatra){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtatra;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    </div>
<div class="col-sm">
   <label for="habitacion">Observaciones:</label>
   <div class="botones">
<button type="button" class="btn btn-danger btn-sm" id="vag"><i class="fas fa-microphone"></button></i>
<button type="button" class="btn btn-primary btn-sm" id="ocionesss"><i class="fas fa-microphone-slash"></button></i>
<button type="button" class="btn btn-success btn-sm" id="playobse4r"><i class="fas fa-play"></button></i>
</div>

      <textarea class="form-control" rows="2" name="observaciones" id="txtbs"></textarea>
<script type="text/javascript">
const vag = document.getElementById('vag');
const ocionesss = document.getElementById('ocionesss');
const txtbs = document.getElementById('txtbs');

const btnPlayoseber = document.getElementById('playobse4r');
btnPlayoseber.addEventListener('click', () => {
        leerTexto(txtbs.value);
});

function leerTexto(txtbs){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtbs;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}

     let roscons = new webkitSpeechRecognition();
      roscons.lang = "es-ES";
      roscons.continuous = true;
      roscons.interimResults = false;

      roscons.onresult = (event) => {
        const results = event.results;
        const frase = results[results.length -1][0].transcript;
        txtbs.value += frase;
      }

      vag.addEventListener('click', () => {
        roscons.start();
      });

      ocionesss.addEventListener('click', () => {
        roscons.abort();
      });
</script>
</div>

  </div>
</div>
<p>
<div class="container">
  <div class="row"> 
     
     <div class="col-sm-2">
      <th><h5><button type="button" class="btn btn-success btn-sm" id="playentrega"><i class="fas fa-play"></button></i> Entrega: </h5></th>
     </div>
     <div class="col-sm">
<input type="text" class="form-control" name="entrega" id="txtenta">
     </div>
  </div>
</div>
<script type="text/javascript">
const txtenta = document.getElementById('txtenta');
const btnPlayTexttaenr = document.getElementById('playentrega');
btnPlayTexttaenr.addEventListener('click', () => {
        leerTexto(txtenta.value);
});

function leerTexto(txtenta){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtenta;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
<hr>

<p>
<div class="container">
  <div class="row"> 
    <div class="col-sm-4">
    <th><h5><center><button type="button" class="btn btn-success btn-sm" id="playconciencia"><i class="fas fa-play"></button></i> Estado de conciencia: </center><input type="text" name="edocia" class="form-control" id="txtconed"></h5></th>
    </div>
    <script type="text/javascript">
const txtconed = document.getElementById('txtconed');
const btnedocon = document.getElementById('playconciencia');
btnedocon.addEventListener('click', () => {
        leerTexto(txtconed.value);
});

function leerTexto(txtconed){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtconed;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
    <div class="col-sm-8">
       <th><h5><center><button type="button" class="btn btn-success btn-sm" id="playrecibe"><i class="fas fa-play"></button></i> Recibe: </center><input type="text" class="form-control" name="reci" id="txtreccc"></h5></th>
    </div>
  </div>
</div>
<hr>
<script type="text/javascript">
const txtreccc = document.getElementById('txtreccc');
const btnrecibe = document.getElementById('playrecibe');
btnrecibe.addEventListener('click', () => {
        leerTexto(txtreccc.value);
});

function leerTexto(txtreccc){
    const speech = new SpeechSynthesisUtterance();
    speech.text= txtreccc;
    speech.volume=1;
    speech.rate=1;
    speech.pitch=0;
    window.speechSynthesis.speak(speech);
}
</script>
  <div class="form-group col-12">
<center><button type="submit" class="btn btn-primary">Firmar</button>
<button type="button" class="btn btn-danger" onclick="history.back()">Cancelar</button></center>
</div>





</form>
  </div>
</div>
      </div>
  
  
</div>





          


        <?php
      } else {
        echo '<script type="text/javascript"> window.location.href="../../template/select_pac_enf.php";</script>';
      }
      
        ?>
        </div>
      </div>
  </section>
  </div>

  <footer class="main-footer">
    <?php
    include("../../template/footer.php");
    ?>
  </footer>



  <script src="../../template/plugins/jQuery/jQuery-2.1.3.min.js"></script>
  <!-- FastClick -->
  <script src='../../template/plugins/fastclick/fastclick.min.js'></script>
  <!-- AdminLTE App -->
  <script src="../../template/dist/js/app.min.js" type="text/javascript"></script>

 <script  type="text/javascript">
function Sumar() {
            var n1 = document.getElementById('num1').value;
            var n2 = document.getElementById('num2').value;
            var suma = parseInt(n1) - parseInt(n2);
            //alert("La suma es: "+suma)
            document.getElementById('sum').value = suma;
        }

</script>

    <script type="text/javascript">
      
$('.losInput input').on('change', function(){
  var total = 0;
  $('.losInput input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal input').val(total.toFixed());
});

$('.losInput2 input').on('change', function(){
  var total = 0;
  $('.losInput2 input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotal2 input').val(total.toFixed());
});

//GLASGOW
$('.losInputG input').on('change', function(){
  var total = 0;
  $('.losInputG input').each(function() {
    if($( this ).val() != "")
    {
      total = total + parseFloat($( this ).val());
    }
  });
  $('.inputTotalG input').val(total.toFixed());
});



      </script>

     
</body>
</html>