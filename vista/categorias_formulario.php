<?php
	require_once('../modelo/clsCategoria.php');

	$objCat = new clsCategoria();
	$accion = $_GET['accion'];
    // echo '<pre>';
	// 	print_r($accion);
	// 	echo '</pre>';
	$id = 0;
	$nombreBoton = 'Registrar';
	if($accion=='ACTUALIZAR'){
		$id = $_GET['idcategoria'];
		$categoria = $objCat->consultarCategoriaPorId($id);
		$categoria = $categoria->fetch(PDO::FETCH_NAMED);
		$nombreBoton = 'Actualizar';
		
	}
?>
<form action="" name="formCategoria" id="formCategoria">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nombre">Nombre Categoria</label>
				<input type="text" class="form-control" name="nombre" id="nombre" value="<?php if($accion=='ACTUALIZAR'){ echo $categoria['nombre']; } ?>" autocomplete="off">
                <input type="hidden" name="idcategoria" id="idcategoria" value="<?=$id;?>"
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
            <button type="button" class="btn btn-primary" onclick="registrarCategoria()"><i class="fa fa-save"></i>
                <?= $nombreBoton; ?></button>
            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>
                Cerrar</button>
        </div>
    </div>
</form>
<script>
    <?php if($accion=='ACTUALIZAR'){ ?>
		$('#estado').val(<?php echo $categoria['estado']; ?>);
	<?php } ?>

    function registrarCategoria() {
        var datax = $('#formCategoria').serializeArray();
        datax.push({
            name: 'accion',
            value: '<?php echo $accion;?>'
        });
        $.ajax({
            method: 'POST',
            url: 'controlador/contCategoria.php',
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