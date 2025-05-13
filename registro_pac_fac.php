<?php
require "estados.php";
?>
<!DOCTYPE html>
<html>
<head>
   
  <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />
<title>Creación del Paciente </title>
<link rel="shortcut icon" href="logp.png">
<script type="text/javascript" src="jquery-1.12.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="jquery-ui.css">
  <script type="text/javascript" src="jquery-ui.js"></script>
</head>
<br>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
            <label for=""><strong>Estado</strong></label>
            <select id="id_estado" class="form-control" name="estado">
                <option value="">Seleccionar</option>
                <?php
                foreach ($estados as $estado) {
                    echo '<option value="'.$estado['id'].'">'.$estado['nombre'].'</option>';
                }//end foreach
                ?>
            </select>
        </div>
    </div>
        <div class="col-sm-4">
            <div class="form-group ">
                <label for=""><strong>Municipio</strong></label>
                <select id="municipios" class="form-control" name="municipios">
                    <option value="">Seleccionar</option>
                </select>
            </div>
        </div>
        
       </div>
    </div>


<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('municipios.php?id_estado='+event.target.value)
            .then(res => {
                if(!res.ok) {
                    throw new Error('ERROR EN LA RESPUESTA');
                }//en if
                return res.json();
            })
            .then(datos => {
                let html = '<option value="">Seleccionar municipio</option>';
                if(datos.data.length > 0) {
                    for (let i = 0; i < datos.data.length; i++) {
                        html += `<option value="${datos.data[i].id}">${datos.data[i].nombre}</option>`;
                    }//end for
                }//end if
                document.querySelector('#municipios').innerHTML = html;
            })
            .catch(error => {
                console.error('OCURRIÓ UN ERROR '+error);
            });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
      var items = <?= json_encode($array) ?>

      $("#tag").autocomplete({
        source: items,
        select: function (event, item) {
          var params = {
            equipo: item.item.value
          };
          $.get("./gestion_administrativa/cuenta_paciente/getEquipo.php", params, function (response) {
            var json = JSON.parse(response);
            if (json.status == 200){
            
$("#id_estado").val(json.estado);
$("#municipios").val(json.municipio);

              
            }else{

            }
          }); // ajax
        }
      });
    });
  </script>
</body>
</html>