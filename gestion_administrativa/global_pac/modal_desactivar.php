                    <!-- Modal Eliminar-->
        <div class="modal fade" id="exampleModal1<?php echo $f['Id_exp']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEliminarLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEliminarLabel">DESACTIVAR</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <form method="POST" action="desact.php">
                        <input type="hidden" name="id" value="<?php echo $f['Id_exp']; ?>">
                        <div class="modal-body">
                        <center><img src="https://img.icons8.com/emoji/48/000000/warning-emoji.png"/></center><br>
                        <center><strong><h4>¿DESEA DESACTIVAR EL REGISTRO?</h4></strong></center><br>
                        <center><strong><font color="red">NOMBRE: <?php echo $f['papell'].' '.$f['sapell'].' '.$f['nom_pac']; ?></font></strong></center><br>
                         <center><strong><font color="red">EXPEDIENTE: <?php echo $f['Id_exp']; ?></font></strong></center><br>
                        <center><strong><br>SI DESACTIVA ESTE REGISTRO <br>NO PODRA VOLVER ACTIVARLO</strong></center>
                    </div>
                    <div class="modal-footer">
                       <div class="row">
                           <div class="col">
                               <center>
                        <button type="button" class="btn btn-success" data-dismiss="modal">CANCELAR</button>
                        <button type="submit" class="btn btn-danger eliminar">DESACTIVAR</button>
                       </center>
                           </div>
                       </div>
                    </div>
                    </form>
                    
                </div>

            </div>
        </div>