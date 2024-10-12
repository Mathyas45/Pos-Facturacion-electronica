<?php
require_once('../modelo/clsProducto.php');
require_once('../modelo/clsCategoria.php');

$objPro = new clsProducto();
$objCat = new clsCategoria();
$accion = $_GET['accion'];
$id = 0;
$nombreBoton = 'Registrar';

$arrayUnidad = $objPro->consultarUnidad();
$arrayUnidad = $arrayUnidad->fetchAll(PDO::FETCH_NAMED);

$arrayCategoria = $objCat->listarCategoria('', 1);
$arrayCategoria = $arrayCategoria->fetchAll(PDO::FETCH_NAMED);

$arrayAfectacion = $objPro->consultarAfectacion(); //Si se va utilar la data una sola vez no es necesario convertirlo en un array


if ($accion == 'ACTUALIZAR') {
	$id = $_GET['idcategoria'];
	$categoria = $objCat->consultarCategoriaPorId($id);
	$categoria = $categoria->fetch(PDO::FETCH_NAMED);
	$nombreBoton = 'Actualizar';
}

?>
<form name="formProducto" id="formProducto">
	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label for="codigobarra">Codigo de Barra</label>
				<input type="text" class="form-control" name="codigobarra" id="codigobarra" value="<?php if ($accion == 'ACTUALIZAR') {
																										echo $producto['codigobarra'];
																									} ?>" autocomplete="off">
				<input type="hidden" class="form-control" name="idproducto" id="idproducto" value="<?= $id; ?>">
			</div>
			<div class="form-group">
				<label for="nombre">Producto</label>
				<input type="text" class="form-control" name="nombre" id="nombre" value="<?php if ($accion == 'ACTUALIZAR') {
																								echo $producto['nombre'];
																							} ?>" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="idunidad">Unidad</label>
				<select class="form-control" name="idunidad" id="idunidad">
					<option value="">- Seleccione -</option>
					<?php foreach ($arrayUnidad as $k => $v) { ?>
						<option value="<?php echo $v['idunidad'] ?>"><?php echo $v['descripcion'] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="idcategoria">Categoria</label>
				<select class="form-control" name="idcategoria" id="idcategoria">
					<option value="">- Seleccione -</option>
					<?php foreach ($arrayCategoria as $k => $v) { ?>
						<option value="<?php echo $v['idcategoria'] ?>"><?php echo $v['nombre'] ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="pventa">Precio de Venta</label>
				<input type="number" step="0.01" class="form-control" name="pventa" id="pventa" value="<?php if ($accion == 'ACTUALIZAR') {
																											echo $producto['pventa'];
																										} ?>" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="pcompra">Precio de Compra</label>
				<input type="number" step="0.01" class="form-control" name="pcompra" id="pcompra" value="<?php if ($accion == 'ACTUALIZAR') {
																												echo $producto['pcompra'];
																											} ?>" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="stock">Stock</label>
				<input type="number" class="form-control" name="stock" id="stock" value="<?php if ($accion == 'ACTUALIZAR') {
																											echo $producto['stock'];
																										} ?>" autocomplete="off">
			</div>
			<div class="form-group">
				<label for="stockseguridad">Stock de Seguridad</label>
				<input type="number" class="form-control" name="stockseguridad" id="stockseguridad" value="<?php if ($accion == 'ACTUALIZAR') {
																															echo $producto['stockseguridad'];
																														} ?>" autocomplete="off">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label for="idafectacion">Afectacion del IGV</label>
				<select class="form-control" name="idafectacion" id="idafectacion">
					<option value="">- Seleccione -</option>
					<?php foreach ($arrayAfectacion as $k => $v) { ?>
						<option value="<?php echo $v['idafectacion'] ?>"><?php echo $v['descripcion'] ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="afectoicbper">¿Es Afecto al ICBPER?</label>
				<select class="form-control" name="afectoicbper" id="afectoicbper">
					<option value="1">SI</option>
					<option value="0" selected>NO</option>
				</select>
			</div>
			<div class="form-group">
				<label for="estado">Estado</label>
				<select class="form-control" name="estado" id="estado">
					<option value="1">ACTIVO</option>
					<option value="0">ANULADO</option>
				</select>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 text-center">
			<button type="button" class="btn btn-primary" onclick="registrarProducto()"><i class="fa fa-save"></i> <?= $nombreBoton; ?></button>
			<button type="button" data-dismiss="modal" class="btn btn-danger"><i class="fa fa-times"></i> Cerrar</button>
		</div>
	</div>
</form>
<script>
	<?php if ($accion == 'ACTUALIZAR') { ?>
		$('#estado').val('<?php echo $categoria['estado']; ?>');
	<?php } ?>


	function registrarProducto() {
		var datax = $('#formProducto').serializeArray();
		datax.push({
			name: 'accion',
			value: '<?php echo $accion; ?>'
		});

		$.ajax({
				method: 'POST',
				url: 'controlador/contProducto.php',
				data: datax,
				dataType: 'json'
			})
			.done(function(resultado) {
				// console.log(resultado);
				if (resultado.correcto == 1) {
					toastr.success(resultado.mensaje);
					verListado();
					CloseModal('divmodal1');
				} else {
					toastr.error(resultado.mensaje);
				}
			});
	}
</script>