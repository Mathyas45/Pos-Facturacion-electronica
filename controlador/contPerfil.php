<?php
require_once('../modelo/clsPerfil.php');
$accion = $_POST['accion'];

controlador($accion);

function controlador($accion){
    $objPer = new clsPerfil();
    
    switch($accion){
        case 'NUEVO':
            $resultado = array();
            try {
                $nombre = isset($_POST['nombre'])? strtoupper($_POST['nombre']):"";
                $estado = isset($_POST['estado'])? $_POST['estado']:"";
                
                $existePerfil = $objPer->verificarDuplicado($nombre);
                if($existePerfil->rowCount()>0){
                    throw new Exception(", ya existe un perfil registrado con el mismo nombre");
                }
                $objPer->insertarPerfil($nombre,$estado);
                $resultado['correcto'] = 1;
                $resultado['mensaje'] = 'Perfil Registrado Correctamente';
                echo json_encode($resultado);
            } catch (Exception $e) {
                $resultado['correcto'] = 0;
                $resultado['mensaje'] = 'Error al registrar'.$e->getMessage();
                echo json_encode($resultado);
            }
            break;
        case 'ACTUALIZAR':
            $resultado = array();
            try {
                $idperfil = isset($_POST['idperfil'])?$_POST['idperfil']:"";
                $nombre = isset($_POST['nombre'])? strtoupper($_POST['nombre']):"";
                $estado = isset($_POST['estado'])? $_POST['estado']:"";
                
                $existePerfil = $objPer->verificarDuplicado($nombre,$idperfil);
                if($existePerfil->rowCount()>0){
                    throw new Exception(", ya existe un perfil registrado con el mismo nombre");
                }
                $objPer->actualizarPerfil($idperfil,$nombre,$estado);
                $resultado['correcto'] = 1;
                $resultado['mensaje'] = 'Perfil Actualizado Correctamente';
                echo json_encode($resultado);
            } catch (Exception $e) {
                $resultado['correcto'] = 0;
                $resultado['mensaje'] = 'Error al actualizar el perfil'.$e->getMessage();
                echo json_encode($resultado);
            }
            break;
        case 'CAMBIAR_ESTADO_PERFIL':
            $resultado = array();
            try {
                $idperfil = isset($_POST['idperfil'])?$_POST['idperfil']:"";
                $estado = isset($_POST['estado'])?$_POST['estado']:"";
                $arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');
                $objPer->cambiarEstadoPerfil($idperfil,$estado);
				$resultado = array('correcto'=>1, 'mensaje'=>'el perfil ha sido '.$arrayEstado[$estado].' de forma satisfactoria');
                echo json_encode($resultado);
            } catch (Exception $e) {
                $resultado['correcto'] = 0;
                $resultado['mensaje'] = 'Error al cambiar el estado del perfil'.$e->getMessage();
                echo json_encode($resultado);
            }
            break;
    }

}