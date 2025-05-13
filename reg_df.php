<?php
require "estados.php";
?>
<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<link rel="shortcut icon" href="logp.png">
</head>
<br>
<body>

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
            <label for="">ESTADO DE RESIDENCIA:</label>
            <select id="id_estado" class="form-control" name="id_edo">
                <option value="">SELECCIONAR</option>
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
                <label for="">MUNICIPIO:</label>
                <select id="idmunicipios" class="form-control" name="id_mun">
                    <option value="">SELECCIONAR</option>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector('#id_estado').addEventListener('change', event => {
        fetch('idmunicipios.php?id_estado='+event.target.value)
            .then(res => {
                if(!res.ok) {
                    throw new Error('Hubo un error en la respuesta');
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
                document.querySelector('#idmunicipios').innerHTML = html;
            })
            .catch(error => {
                console.error('Ocurrió un error '+error);
            });
    });
</script>
</body>
</html>
