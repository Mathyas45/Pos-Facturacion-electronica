<?php
require_once('../modelo/clsCategoria.php');
$accion = $_POST['accion'];

controlador($accion);

function controlador($accion){
    $objCat = new clsCategoria();

    switch ($accion) {
        case 'NUEVO':
            $resultado =array();
            try {
                $nombre = isset($_POST['nombre'])?$_POST['nombre']:"";
                $estado = isset($_POST['estado'])?$_POST['estado']:"";

                $existeCategoria = $objCat->verificarDuplicado($nombre);
                if($existeCategoria->rowCount()>0){
                    throw new Exception(", ya existe una categoria registrada con el mismo nombre");
                }
                $objCat->InsertarCategoria($nombre,$estado);
                $resultado['correcto']=1;
                $resultado['mensaje']='Categoria Registrada Correctamente';
                echo json_encode($resultado);
            } catch (Exception $e) {
                $resultado['correcto']=0;
                $resultado['mensaje']='Error al registrar'.$e->getMessage();
                echo json_encode($resultado);
            }

            break;
        case 'ACTUALIZAR':
            $resultado =array();
            try {
                $idcategoria = isset($_POST['idcategoria'])?$_POST['idcategoria']:"";
                $nombre = isset($_POST['nombre'])?$_POST['nombre']:"";
                $estado = isset($_POST['estado'])?$_POST['estado']:"";

                $existeCategoria = $objCat->verificarDuplicado($nombre,$idcategoria);
				if($existeCategoria->rowCount()>0){
					throw new Exception(", ya existe una categoria registrada con el mismo nombre");
				}

                $objCat->ActualizarCategoria($idcategoria,$nombre,$estado);
                $resultado['correcto']=1;
                $resultado['mensaje']='Categoria Actualizada Correctamente';
                echo json_encode($resultado);
            } catch (Exception $e) {
                $resultado['correcto']=0;
                $resultado['mensaje']='Error al actualizar la categoria'.$e->getMessage();
                echo json_encode($resultado);
            }

            break;
        
        case 'CAMBIAR_ESTADO_CATEGORIA':
            $resultado =array();
            try {
                $idcategoria = isset($_POST['idcategoria'])?$_POST['idcategoria']:"";
                $estado = isset($_POST['estado'])?$_POST['estado']:"";

				$arrayEstado = array('ANULADA','ACTIVADA','ELIMINADA');
                $objCat->ActualizarEstadoCategoria($idcategoria,$estado);
                $resultado['correcto']=1;
				$resultado = array('correcto'=>1, 'mensaje'=>'La categoria ha sido '.$arrayEstado[$estado].' de forma satisfactoria');
                echo json_encode($resultado);
            } catch (Exception $e) {
                $resultado['correcto']=0;
                $resultado['mensaje']='Error al actualizar la categoria'.$e->getMessage();
                echo json_encode($resultado);
            }
            break;

}
}