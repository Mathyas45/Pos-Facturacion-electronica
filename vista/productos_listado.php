<?php
require_once('../modelo/clsProducto.php');

$objPro = new clsProducto();

$nombre = $_POST['nombre'];
$estado = $_POST['estado'];
$codigo = $_POST['codigo'];
$categoria = $_POST['categoria'];

// echo $nombre.'<br>';
// echo $estado;

$dataProducto = $objPro->listarProducto($nombre, $estado, $codigo, $categoria);
$dataProducto = $dataProducto->fetchAll(PDO::FETCH_NAMED);

// echo '<pre>';
// print_r($dataProducto);
// echo '</pre>';

?>
<table class="table table-hover text-nowrap table-striped table-sm" id="tablaProducto">
	<thead>
		<tr class="bg-primary">
			<th>Opciones</th>
			<th>Cod</th>
			<th>Imagen</th>
			<th>Codigo</th>
			<th>Descripción</th>
			<th>Unidad</th>
			<th>Categoria</th>
			<th>P. Venta</th>
			<th>Estado</th>
			<!-- <th>Editar</th>
			<th>Anular</th>
			<th>Eliminar</th> -->
		</tr>
	</thead>
	<tbody>
		<?php foreach ($dataProducto as $k => $v) {
			if ($v['estado'] == 1) {
				$estado = "Activo";
				$clase = "bg-success";
				$class = "";
			} else {
				$estado = "Anulado";
				$clase = "bg-danger";
				$class = "text-danger";
			}

		?>
			<tr class="<?php echo $class; ?>">
				<td>
					<div class="btn-group">
						<button type="button" class="btn bg-maroon btn-sm dropdown-toggle" data-toggle="dropdown">Opciones
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						<div class="dropdown-menu" role="menu">
							<a class="dropdown-item" href="#" onclick="subirImagen(<?php echo $v['idproducto']; ?>)"><i class="fa fa-image"></i> Subir Imagen</a>
							<a class="dropdown-item" href="#" onclick="editarProducto(<?php echo $v['idproducto']; ?>)"><i class="fa fa-edit"></i> Editar</a>
							<?php if ($v['estado'] == 1) { ?>
								<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?php echo $v['idproducto']; ?>,0)"><i class="fa fa-trash"></i> Anular</a>
							<?php } else { ?>
								<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?php echo $v['idproducto']; ?>,1)"><i class="fa fa-check"></i> Activar</a>
							<?php } ?>
							<a class="dropdown-item" href="#" onclick="cambiarEstadoProducto(<?php echo $v['idproducto']; ?>,2)"><i class="fa fa-times"></i> Eliminar</a>
						</div>
					</div>
				</td>
				<td><?php echo $v['idproducto']; ?></td>
				<td>
					<img src="<?php echo $v['urlimagen'] ?>" style="width: 40px; height: 40px;">
				</td>
				<td><?php echo $v['codigobarra']; ?></td>
				<td><?php echo $v['nombre']; ?></td>
				<td><?php echo $v['unidad']; ?></td>
				<td><?php echo $v['categoria']; ?></td>
				<td><?php echo $v['pventa']; ?></td>
				<td class="<?php echo $clase; ?>"><?php echo $estado; ?></td>
				<!-- <td>
				<button type="button" class="btn btn-primary btn-sm" onclick="editarProducto(<?php echo $v['idproducto']; ?>)" ><i class="fa fa-edit"></i> Editar</button>
			</td>
			<td>
				<?php if ($v['estado'] == 1) { ?>
				<button type="button" class="btn btn-warning btn-sm" onclick="cambiarEstadoProducto(<?php echo $v['idproducto']; ?>,0)"><i class="fa fa-trash"></i> Anular</button>
				<?php } else { ?>
				<button type="button" class="btn btn-success btn-sm" onclick="cambiarEstadoProducto(<?php echo $v['idproducto']; ?>,1)"><i class="fa fa-check"></i> Activar</button>
				<?php } ?>
			</td>
			<td>
				<button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstadoProducto(<?php echo $v['idproducto']; ?>,2)"><i class="fa fa-times"></i> Eliminar</button>
				
			</td> -->
			</tr>
		<?php } ?>
	</tbody>
</table>
<script>
	function editarProducto(id) {
		abrirModal('vista/productos_formulario', 'accion=ACTUALIZAR&idproducto=' + id, 'divmodal1', 'Editar Producto');
	}

	function cambiarEstadoProducto(id, estadox) {
		proceso = new Array('ANULAR', 'ACTIVAR', 'ELIMINAR');
		mensaje = "¿Estas seguro de " + proceso[estadox] + " el producto?";
		accion = "EjecutarCambiarEstadoProducto(" + id + "," + estadox + ")";

		mostrarModalConfirmacion(mensaje, accion);
	}

	function EjecutarCambiarEstadoProducto(id, estadox) {
		$.ajax({
				method: 'POST',
				url: 'controlador/contProducto.php',
				data: {
					idproducto: id,
					estado: estadox,
					accion: 'CAMBIAR_ESTADO_PRODUCTO'
				},
				dataType: 'json'
			})
			.done(function(resultado) {
				if (resultado.correcto == 1) {
					toastr.success(resultado.mensaje);
					verListado();
				} else {
					toastr.error(resultado.mensaje);
				}
			})
	}

	$("#tablaProducto").DataTable({
		"responsive": true,
		"lengthChange": true,
		"autoWidth": false,
		"ordering": true,
		"searching": false,
		"lengthMenu": [
			[10, 25, 50, 100, -1],
			[10, 25, 50, 100, 'Todos']
		],
		"language": {
			"decimal": "",
			"emptyTable": "Sin datos",
			"info": "Del _START_ al _END_ de _TOTAL_ filas",
			"infoEmpty": "Del 0 a 0 de 0 filas",
			"infoFiltered": "(filtro de _MAX_ filas totales)",
			"infoPostFix": "",
			"thousands": ",",
			"lengthMenu": "Ver _MENU_ filas",
			"loadingRecords": "Cargando...",
			"processing": "Procesando...",
			"search": "Buscar:",
			"zeroRecords": "No se encontraron resultados",
			"paginate": {
				"first": "Primero",
				"last": "Ultimo",
				"next": "Siguiente",
				"previous": "Anterior"
			},
			"aria": {
				"sortAscending": ": orden ascendente",
				"sortDescending": ": orden descendente"
			}
		},
		"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
	}).buttons().container().appendTo('#tablaProducto_wrapper .col-md-6:eq(0)');
</script>