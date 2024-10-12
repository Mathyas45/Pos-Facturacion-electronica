<?php
require_once('../modelo/clsCategoria.php');
$objCat = new clsCategoria();

$arrayCategoria = $objCat->listarCategoria('',1);
$arrayCategoria = $arrayCategoria->fetchAll(PDO::FETCH_NAMED);
?>
<div class="row">
	<div class="col-md-12">
		<div class="card card-success">
			<div class="card-header">
				<h3 class="card-title">Listado de Productos</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text">Codigo</span>
							</div>
							<input type="text" class="form-control" name="txtBusquedaCodigo" id="txtBusquedaCodigo" onkeyup="if(event.keyCode=='13'){ verListado(); }">
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text">Producto</span>
							</div>
							<input type="text" class="form-control" name="txtBusquedaNombre" id="txtBusquedaNombre" onkeyup="if(event.keyCode=='13'){ verListado(); }">
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text">Categoria</span>
							</div>
							<select class="form-control" name="cboBusquedaCategoria" id="cboBusquedaCategoria" onchange="verListado()">
								<option value="">- Todos -</option>
								<?php foreach($arrayCategoria as $k=>$v){ ?>
								<option value="<?php echo $v['idcategoria']; ?>"><?php echo $v['nombre']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
							<span class="input-group-text">Estado</span>
							</div>
							<select class="form-control" name="cboBusquedaEstado" id="cboBusquedaEstado" onchange="verListado()">
								<option value="">- Todos -</option>
								<option value="1">Activos</option>
								<option value="0">Anulados</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
						<button type="button" class="btn btn-success" onclick="nuevoProducto()" ><i class="fa fa-plus"></i> Nuevo</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card card-success">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12" id="divListadoProducto">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	
	function verListado(){
		$.ajax({
			method: 'POST',
			url: 'vista/productos_listado.php',
			data:{
				nombre: $('#txtBusquedaNombre').val(),
				estado: $('#cboBusquedaEstado').val(),
				codigo: $('#txtBusquedaCodigo').val(),
				categoria: $('#cboBusquedaCategoria').val(),
			}
		})
		.done(function(resultado){
			$("#divListadoProducto").html(resultado);
		})
	}

	verListado();


	function nuevoProducto(){
		abrirModal('vista/productos_formulario','accion=NUEVO','divmodal','Registro de Producto');
	}


</script>