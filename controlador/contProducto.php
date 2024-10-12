<?php
require_once('../modelo/clsProducto.php');
$accion = $_POST['accion'];

controlador($accion);
function controlador($accion){
    $objPro = new clsProducto();
    switch ($accion) {
        case 'NUEVO':
            $resultado = array();
            try {
                $codigobarra = isset($_POST['codigobarra'])?$_POST['codigobarra']:"";
                $nombre = isset($_POST['nombre'])?$_POST['nombre']:"";
                $idunidad = isset($_POST['idunidad'])?$_POST['idunidad']:"";
                $idcategoria = isset($_POST['idcategoria'])?$_POST['idcategoria']:"";
                $pventa = isset($_POST['pventa'])?$_POST['pventa']:NULL;
                $pcompra = isset($_POST['pcompra'])?$_POST['pcompra']:NULL;
                $stock  = isset($_POST['stock'])?$_POST['stock']:0;
                $stockseguridad = isset($_POST['stockseguridad'])?$_POST['stockseguridad']:0;
                $idafectacion = isset($_POST['idafectacion'])?$_POST['idafectacion']:NULL;
                $afectoicbper = isset($_POST['afectoicbper'])?$_POST['afectoicbper']:0;
                $estado = isset($_POST['estado'])?$_POST['estado']:"";
                $existeProducto = $objPro->verificarDuplicado($nombre);
                if($existeProducto->rowCount()>0){
                    throw new Exception(", ya existe un producto registrado con el mismo nombre");
                }
                $objPro->insertarProducto($codigobarra, $nombre,$idunidad,$idcategoria,$pventa,$pcompra,$stock,$stockseguridad,$idafectacion,$afectoicbper,$estado);
                $resultado['correcto']=1;
                $resultado['mensaje']='Producto Registrado Correctamente';
                echo json_encode($resultado);
            } catch (Exception $e) {
                $resultado['correcto']=0;
                $resultado['mensaje']='Error al registrar'.$e->getMessage();
                echo json_encode($resultado);
            }
            break;
        }
    }