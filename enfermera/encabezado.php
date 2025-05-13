<?php
if (isset($_SESSION['pac'])) {
  $id_atencion = $_SESSION['pac'];

  $sql_pac = "SELECT p.sapell, p.papell, p.nom_pac, p.dir, p.id_edo, p.id_mun, p.Id_exp, p.tel, p.fecnac,p.tip_san, di.fecha, di.area, di.alta_med, p.sexo, di.alergias FROM paciente p, dat_ingreso di WHERE p.Id_exp=di.Id_exp and di.id_atencion =$id_atencion";

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
    $pac_fecing = $row_pac['tip_san'];
    $area = $row_pac['area'];
    $alta_med = $row_pac['alta_med'];
    $id_exp = $row_pac['Id_exp'];
    $alergias = $row_pac['alergias'];
  }

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

  function calculaedad($fechanacimiento)
  {
    list($ano, $mes, $dia) = explode("-", $fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
      $ano_diferencia--;
    return $ano_diferencia;
  }

  $edad = calculaedad($pac_fecnac);
?>


  <div class="container box">
    <div class="content">
      <div class="form-group">
        <label class="col-sm-3 control-label">Nombre del paciente: </label>
        <div class="col-md-6">
          <input type="text" name="paciente" class="form-control" value="<?php echo $pac_papell . ' ' . $pac_sapell . ' ' . $pac_nom_pac ?>" disabled>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Fecha de ingreso: </label>
            <div class="col-md-6">
              <input type="text" name="f_ingreso" class="form-control" value="<?php echo $pac_fecing ?>" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Seguro: </label>
            <div class="col-md-6">
              <input type="text" name="seguro" class="form-control" value="<?php $sql_aseg = "SELECT aseg from dat_financieros where id_atencion =$id_atencion ORDER BY fecha DESC limit 1";
                                                                            $result_aseg = $conexion->query($sql_aseg);
                                                                            while ($row_aseg = $result_aseg->fetch_assoc()) {
                                                                              echo $row_aseg['aseg'];
                                                                            } ?>" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Expediente: </label>
            <div class="col-md-6">
              <input type="text" name="exp" class="form-control" value="<?php echo $id_exp ?>" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Área: </label>
            <div class="col-md-6">
              <input type="text" name="area" class="form-control" value="<?php echo $area ?>" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Edad: </label>
            <div class="col-md-6">
              <input type="text" name="exp" class="form-control" value="<?php echo $edad ?>" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Fecha de nacimiento: </label>
            <div class="col-md-6">
              <input type="text" name="area" class="form-control" value="<?php echo $pac_fecnac ?>" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Género: </label>
            <div class="col-md-6">
              <input type="text" name="exp" class="form-control" value="<?php echo $pac_sexo ?>" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Tipo de sangre: </label>
            <div class="col-md-6">
              <input type="text" name="area" class="form-control" value="<?php echo $pac_tip_sang ?>" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Alergías: </label>
            <div class="col-md-6">
              <input type="text" name="exp" class="form-control" value="<?php echo $alergias ?>" disabled>
            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Tiempo de estancia: </label>
            <div class="col-md-6">
              <input type="text" name="timer" class="form-control" value="<?php echo $estancia ?> días" disabled>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Habitación: </label>
            <div class="col-md-6">
              <input type="text" name="num_cama" class="form-control" value="<?php $sql_hab = "SELECT num_cama from cat_camas where id_atencion =$id_atencion";
                                                                              $result_hab = $conexion->query($sql_hab);
                                                                              while ($row_hab = $result_hab->fetch_assoc()) {
                                                                                echo $row_hab['num_cama'];
                                                                              } ?>" disabled>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Peso: </label>
            <input type="number" name="peso" step="0.01" placeholder="Kg." id="peso" class="form-control-sm" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="col-sm-3 control-label">Talla: </label>
            <input type="number" name="talla" step="1" placeholder="CM." id="talla" class="form-control-sm" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="sat_oxigeno">Habitus Exterior: </label>
            <input type="text" name="habitus" placeholder="Edo. de conciencia" id="habitus" class="form-control" style="text-transform:uppercase;" value="" onkeyup="javascript:this.value=this.value.toUpperCase();" required>
          </div>
        </div>
      </div>

    </div>
  </div>

<?php
} else {
  echo '<script type="text/javascript"> window.location.href="../lista_pacientes/lista_pacientes.php";</script>';
}
?>