<?php
	require_once('../modelo/clsPerfil.php');

	$objPer = new clsPerfil();
	$accion = $_GET['accion'];
	$id = 0;
	$nombreBoton = 'Registrar';
	if($accion=='ACTUALIZAR'){
		$id = $_GET['idperfil'];
		$perfil = $objPer->consultarPerfilPorId($id);
		$perfil = $perfil->fetch(PDO::FETCH_NAMED);
		$nombreBoton = 'Actualizar';
	}
?>
<form action="" name="formPerfil" id="formPerfil">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nombre">Nombre del perfil</label>
				<input type="text" class="form-control" name="nombre" id="nombre" value="<?php if($accion=='ACTUALIZAR'){ echo $perfil['nombre']; } ?>" autocomplete="off">
                <input type="hidden" name="idperfil" id="idperfil" value="<?=$id;?>"
                <br>
                <label for="estado">Estado</label>
                <select type="text" class="form-control" name="estado" id="estado">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-primary" onclick="registrarPerfil()"><i class="fa fa-save"></i>
                <?= $nombreBoton; ?></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                Cerrar</button>
        </div>
    </div>
</form>
<script>
    <?php if($accion=='ACTUALIZAR'){ ?>
		$('#estado').val(<?php echo $perfil['estado']; ?>);
	<?php } ?>

    function registrarPerfil() {
        var datax = $('#formPerfil').serializeArray();
        datax.push({
            name: 'accion',
            value: '<?php echo $accion;?>'
        });
        $.ajax({
            method: 'POST',
            url: 'controlador/contPerfil.php',
            data: datax,
            dataType: 'json'
        })
        .done(function(resultado) {
            if (resultado.correcto ==1) {
                toastr.success(resultado.mensaje);
                verListado();
                CloseModal('divmodal1');
            } else {
                toastr.error(resultado.mensaje);
            }
        })
    }
    
</script>