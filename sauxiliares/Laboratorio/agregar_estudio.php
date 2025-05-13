   <!-- Modal Eliminar-->
        <div class="modal fade" id="exampleModal1<?php echo $row["clave"];?>" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel"><font size="3"><strong>AGREGAR ESTUDIO Al KIT:</strong> <?php  echo $nombre_paq;?></font> </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form method="POST" action="ag_estudio.php">
                        <input type="hidden" name="id" value="<?php echo $row["estudio_id"];?>">
                         <input type="hidden" name="clave" value="<?php echo $row["clave"];?>">
                          <input type="hidden" name="nom" value="<?php echo $nombre_paq;?>">
                        <div class="modal-body">
                         <!-- <div class="container-fluid">
            
                CLAVE DE SERVICIO 
                <input type="text" name="clveserv" class="form-control col-sm-9" placeholder="CLAVE DE SERVICIO" style="text-transform:uppercase;"
                                   onkeyup="javascript:this.value=this.value.toUpperCase();">
                 </div><p>-->
                    <div class="container-fluid"> 
                        <div class="form-group">
                            <label class="control-label " for="">ESTUDIO:</label>
                            <div>
                                <select class="form-control col-9" data-live-search="true" name="serv" required>
                                    <?php
                                    $sql_serv = "SELECT * FROM cat_servicios where tipo =1 and serv_activo = 'SI'";
                                    $result_serv = $conexion->query($sql_serv);
                                    while ($row_serv = $result_serv->fetch_assoc()) {
                                        echo "<option value='" . $row_serv['serv_cve'] . "'>" . $row_serv['serv_desc'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                       
  <!--  COSTO DE SERVICIO $
<input type="number" maxlength="50" name="costo" class="form-control col-sm-9" placeholder="INGRESE EL COSTO DEL SERVICIO" required="" autofocus="">
<br>-->
</div>
<div class="container-fluid">
                      <div class="form-group">
                            <label class="control-label" for="">CANTIDAD:</label>
                            <div>
                                <input type="number" maxlength="50" name="cantidad" class="form-control col-sm-9" id="code"
                                       placeholder="INGRESE LA CANTIDAD" required="" autofocus="">
                            </div>
                        </div>
</div>
                    </div>
                    <div class="modal-footer">
                       <div class="row">
                           <div class="col">
                               <center>
                        <button type="button" class="btn btn-success" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger eliminar">AGREGAR</button>
                       </center>
                           </div>
                       </div>
                    </div>
                    </form>
                    
                </div>

            </div>
        </div>