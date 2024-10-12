<?php
require_once('../modelo/clsPerfil.php');
$objPerfil = new clsPerfil();
$nombre = $_POST['txtBusquedaNombre'];
$estado = $_POST['cboBusquedaEstado'];
$editar = $_POST['editar'];
$anular = $_POST['anular'];
$eliminar = $_POST['eliminar'];


$dataPerfil = $objPerfil->listarPerfiles($nombre, $estado);
$dataPerfil = $dataPerfil->fetchAll(PDO::FETCH_ASSOC);
// echo'pre';
// print_r($dataCategoria);
// echo'pre';
?>

<table class="table table-striped table-hover text-nowrap table-sm">
    <thead>
        <tr>
            <th>N°</th>
            <th>nombre</th>
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
        $numero = 1;
        foreach($dataPerfil as $k=>$v){
        $clase = $v['estado']==0?'text-danger':"";
        ?>
        <tr class="<?=$clase?>">
            <td><?=$numero ++;?></td>
            <td><?=$v['nombre']?></td>
            <td><?=$v['estado']==1?'activo':'anulado';?></td>
            <?php if($editar){?>
            <td><button type="button" class="btn btn-warning btn-sm" onclick="editarPerfi(<?= $v['idperfil']?>)"><i class="fa fa-edit"></i>Editar</button></td>
            <?php } ?>
            <?php if($anular){
            $claseEstado = $v['estado'] == 0 ? 'btn btn-danger btn-sm' : "btn btn-success btn-sm";
            $estado = $v['estado'] == 0 ? 'activar' : "anular";
            $cambiarEstado = $v['estado'] == 0 ? 1 : 0;
            $icono = $v['estado'] == 1 ? 'fa fa-check' : 'fa fa-times';
            ?>
            <td><button type="button" class="<?= $claseEstado; ?>" onclick="cambiarEstadoPerfil(<?= $v['idperfil']; ?> ,<?= $cambiarEstado ?>)"><i class="<?= $icono; ?>"></i> <?= $estado; ?></button></td>
            <?php } ?>
            <?php if($eliminar){ ?>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="cambiarEstadoPerfil(<?= $v['idperfil'] ?>, 2)"><i class="fa fa-trash"></i> Eliminar</button></td>
            <?php } ?>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    function editarPerfi(idperfil){
        abrirModal('vista/perfiles_formulario',  'accion=ACTUALIZAR&idperfil='+idperfil, 'divmodal1', 'Editar Perfil');
    }
    function cambiarEstadoPerfil(id, estadox) {
        proceso = new Array('ANULAR', 'ACTIVAR', 'ELIMINAR');
        mensaje = "¿Estas seguro de " + proceso[estadox] + " la categoria?";
        accion = "ejecutaCambiarEstadoPerfil(" + id + "," + estadox + ")";

        mostrarModalConfirmacion(mensaje, accion);
    }
    function ejecutaCambiarEstadoPerfil(id, estadox) {
        $.ajax({
                method: 'POST',
                url: 'controlador/contPerfil.php',
                data: {
                    accion: 'CAMBIAR_ESTADO_PERFIL',
                    idperfil: id,
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
</script>