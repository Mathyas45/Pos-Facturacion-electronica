<?php
require_once('../modelo/clsPerfil.php');
$objPerfil = new clsPerfil();
$opcionMenu = $objPerfil->seleccionarOpcionPorId($_POST['idopcion']);
$opcionMenu = $opcionMenu->fetch(PDO::FETCH_ASSOC);
$registrar = 1;
$editar = 1;
$anular = 1;
$eliminar = 1;

if ($opcionMenu['puederegistrar'] != "") {
	$puederegistrar = explode(",", $opcionMenu['puederegistrar']);
	if (!in_array($_SESSION['idperfil'], $puederegistrar)) {
		$registrar = 0;
	}
}
if ($opcionMenu['puedeeditar'] != "") {
	$puedeeditar = explode(",", $opcionMenu['puedeeditar']);
	if (!in_array($_SESSION['idperfil'], $puedeeditar)) {
		$editar = 0;
	}
}

if ($opcionMenu['puedeanular'] != "") {
	$puedeanular = explode(",", $opcionMenu['puedeanular']);
	if (!in_array($_SESSION['idperfil'], $puedeanular)) {
		$anular = 0;
	}
}
if ($opcionMenu['puedeeliminar'] != "") {
	$puedeeliminar = explode(",", $opcionMenu['puedeeliminar']);
	if (!in_array($_SESSION['idperfil'], $puedeeliminar)) {
		$eliminar = 0;
	}
}
?>
<div class="row">
	<div class="col-md-12">
		<div class="card card-success">
			<div class="card-header">
				<h3 class="card-title">Perfiles</h3>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Nombre</span>
							</div>
							<input type="text" class="form-control" name="txtBusquedaNombre" id="txtBusquedaNombre" onkeyup="verListado()">
						</div>
					</div>
					<div class="col-md-4">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">Estado</span>
							</div>
							<select type="text" class="form-control" name="cboBusquedaEstado" id="cboBusquedaEstado" onchange="verListado()">
								<option value="">- Todos -</option>
								<option value="1">Activo</option>
								<option value="0">Anulados</option>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<button type="button" class="btn btn-primary" onclick="verListado()"><i class="fa fa-search"></i> Buscar</button>
						<?php if($registrar){ ?>
						<button type="button" class="btn btn-success" onclick="nuevoPerfil()"><i class="fa fa-plus"></i> Nuevo</button>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="card card-success">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12" id="divListadoPerfil">
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function verListado(){
		$.ajax({
			method:'POST',
			url: 'vista/perfiles_listado.php',
			data:{
				txtBusquedaNombre:$('#txtBusquedaNombre').val(),
				cboBusquedaEstado:$('#cboBusquedaEstado').val(),
				editar:'<?=$editar?>',
				anular:'<?=$anular?>',
				eliminar:'<?=$eliminar?>',
			}
		})
		.done(function(resultado){
			$('#divListadoPerfil').html(resultado);
		})
	}
	verListado();
	function nuevoPerfil(){
		abrirModal('vista/perfiles_formulario','accion=NUEVO','divmodal1','Nuevo Perfil');
	}
</script>