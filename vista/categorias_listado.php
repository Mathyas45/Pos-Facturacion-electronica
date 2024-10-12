<?php
require_once('../modelo/clsCategoria.php');
$objCategoria = new clsCategoria();
$nombre = $_POST['txtBusquedaNombre'];
$estado = $_POST['cboBusquedaEstado'];
$editar = $_POST['editar'];
$anular = $_POST['anular'];
$eliminar = $_POST['eliminar'];

$dataCategoria = $objCategoria->listarCategoria($nombre, $estado);
$dataCategoria = $dataCategoria->fetchAll(PDO::FETCH_ASSOC);
// echo'pre';
// print_r($dataCategoria);
// echo'pre';
?>

<table id="tabla-categoria" class="table table-striped table-hover text-nowrap table-sm">
    <thead>
        <tr>
            <th>N°</th>
            <th>Codigo</th>
            <th>Descripción</th>
            <th>Estado</th>
            <?php if($editar){?>
            <th>Editar</th>
            <?php } ?>
            <?php if($anular){?>
            <th>Anular</th>
            <?php } ?>
            <?php if($eliminar){ ?>
			<th>Eliminar</th>
			<?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $numero = 0;
        foreach ($dataCategoria as $k => $v) {
            $clase = $v['estado'] == 0 ? 'text-danger' : "";
        ?>
            <tr class="<?= $clase ?>">
                <td><?= $k; ?></td>
                <td><?=  $v['codigo'] ?></td>
                <td><?= $v['nombre'] ?></td>
                <td><?= ($v['estado']) == 1 ? 'activo' : 'anulado'; ?></td>
                <?php if($editar){?>
                <td><button type="button" class="btn btn-warning btn-sm" onclick="editarCategoria(<?= $v['idcategoria'] ?>)"><i class="fa fa-edit"></i>Editar</button></td>
                <?php } ?>
                <?php
                $claseEstado = $v['estado'] == 0 ? 'btn btn-danger btn-sm' : "btn btn-success btn-sm";
                $estado = $v['estado'] == 0 ? 'activar' : "anular";
                $cambiarEstadoCategoria = $v['estado'] == 0 ? 1 : 0;
                $icono = $v['estado'] == 1 ? 'fa fa-check' : 'fa fa-times';
                ?>
                <?php if($anular){?>
                <td><button type="button" class="<?= $claseEstado; ?>" onclick="cambiarEstadoCategoria(<?= $v['idcategoria']; ?> ,<?= $cambiarEstadoCategoria ?>)"><i class="<?= $icono; ?>"></i> <?= $estado; ?></button></td>
                <?php } ?>
                <?php if($eliminar){ ?>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstadoCategoria(<?= $v['idcategoria'] ?>, 2)"><i class="fa fa-trash"></i> Eliminar</button></td>
                <?php } ?>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    function editarCategoria(idcategoria) {
        abrirModal('vista/categorias_formulario', 'accion=ACTUALIZAR&idcategoria=' + idcategoria, 'divmodal1', 'Editar Categoria');
    }

    function cambiarEstadoCategoria(id, estadox) {
        proceso = new Array('ANULAR', 'ACTIVAR', 'ELIMINAR');
        mensaje = "¿Estas seguro de " + proceso[estadox] + " la categoria?";
        accion = "ejecutaCambiarEstadoCategoria(" + id + "," + estadox + ")";

        mostrarModalConfirmacion(mensaje, accion);
    }

    function ejecutaCambiarEstadoCategoria(id, estadox) {
        $.ajax({
                method: 'POST',
                url: 'controlador/contCategoria.php',
                data: {
                    accion: 'CAMBIAR_ESTADO_CATEGORIA',
                    idcategoria: id,
                    estado: estadox
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

    $("#tabla-categoria").DataTable({
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
    }).buttons().container().appendTo('#tabla-categoria_wrapper .col-md-6:eq(0)');
</script>