<?php
require "estados.php";
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


    <meta http-equiv=”Content-Type” content=”text/html; charset=ISO-8859-1″ />

<title>Creación del Paciente </title>
<link rel="shortcut icon" href="logp.png">
</head>
<br>
<body>


    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
            <label for="">Estado de residencia:</label>
            <select id="id_estado" class="form-control" name="id_edo" required>
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
                <label for="">Municipio:</label>
                <select id="municipios" class="form-control" name="id_mun" required>
                    <option value="">Seleccionar</option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="loc">Localidad:</label>
                               <input type="text" placeholder="Localidad de residencia" name="loc" id="loc" class="form-control" required  value="" onkeypress="return SoloLetras(event);" maxlength="50" >
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
                let html = '<option value="">Seleccionar MUNICIPIO</option>';
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
</body>
</html>