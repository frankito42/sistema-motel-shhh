<!--Modal: modalConfirmDelete-->
<div class="modal fade" id="<?php echo "as".$key['idCarrito']?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-notify modal-danger" role="document">
    <!--Content-->
    <div class="modal-content text-center">
      <!--Header-->
      <div class="modal-header d-flex justify-content-center">
        <p class="heading">Esta seguro de borrar <?php echo $key['nombre']?>?</p>
      </div>

      <!--Body-->
      <div class="modal-body">

        <i class="fas fa-times fa-4x animated rotateIn"></i>

      </div>

      <!--Footer-->
      <div class="modal-footer flex-center">
        <a href="moduloCajaTicket/borrarArticuloTicket.php?idCarrito=<?php echo $key['idCarrito']?>" class="btn  btn-danger">Si</a>
        <a type="button" class="btn  btn-blue waves-effect" data-dismiss="modal">No</a>
      </div>
    </div>
    <!--/.Content-->
  </div>
</div>
<!--Modal: modalConfirmDelete-->