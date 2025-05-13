   <!-- Modal Eliminar-->
        <div class="modal fade" id="exampleModal2<?php echo $row["id_serv"];?>" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarLabel">ELIMINAR <strong><u><?php echo $row['serv_desc'];?></u></strong>  Al KIT:<strong> <u><?php  echo $nombre_paq;?></u></strong></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form method="POST" action="eliminar_est.php">
                        
                          <input type="hidden" name="nom" value="<?php echo $nombre_paq;?>">
                          <input type="hidden" name="id_s" value="<?php echo $row["id_serv"];?>">
                          <input type="hidden" name="id_p" value="<?php echo $row["id_paquete"];?>">

                        <div class="modal-body">
                            <center>
                             <?php //echo $row["id_serv"];?>
                             <?php //echo $row["id_paquete"];?>   
 ¿DESEA ELIMINAR EL ESTUDIO: <strong><?php echo $row['serv_desc'];?></strong> DEL KIT: <strong><?php  echo $nombre_paq;?></strong> ? </center>
                    </div>
                    <div class="modal-footer">
                       <div class="row">
                           <div class="col">
                               <center>
                        <button type="button" class="btn btn-success" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger eliminar">ELIMINAR</button>
                       </center>
                           </div>
                       </div>
                    </div>
                    </form>
                    
                </div>

            </div>
        </div>