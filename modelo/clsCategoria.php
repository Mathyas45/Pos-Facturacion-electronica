<?php
require_once('conexion.php');

class clsCategoria{

    function listarCategoria($nombre, $estado){
        $sql = "SELECT * FROM categoria WHERE estado<2 ";
        $parametros = array();
        if($nombre !=""){
            $sql .= " AND nombre LIKE :nombre ";
            $parametros[':nombre']= '%'.$nombre.'%';
        }
        if($estado !=""){
            $sql .= " AND estado = :estado ";
            $parametros[':estado']=$estado;
        }

        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function InsertarCategoria($nombre, $estado){
        $sql = "INSERT INTO categoria(nombre,estado) VALUES (:nombre, :estado) ";
        $parametros = array(':nombre'=>$nombre, ':estado'=>$estado);
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function verificarDuplicado($nombre, $idcategoria=0){
        $sql= "SELECT * FROM categoria where nombre=:nombre and estado!=2 and idcategoria<>:idcategoria ";
        $parametros = array(':nombre'=>$nombre, ':idcategoria'=> $idcategoria);
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function consultarCategoriaPorId($idcategoria){
        $sql = "SELECT * FROM categoria WHERE idcategoria=:idcategoria ";
        $parametros = array(':idcategoria'=>$idcategoria);
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarCategoria($idcategoria, $nombre, $estado){
        $sql = "UPDATE categoria SET nombre=:nombre, estado=:estado WHERE idcategoria=:idcategoria";
        $parametros = array(':nombre'=>$nombre, ':estado'=>$estado, ':idcategoria'=>$idcategoria);
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
    function ActualizarEstadoCategoria($idcategoria, $estado){
        $sql = "UPDATE categoria SET estado=:estado WHERE idcategoria=:idcategoria";
        $parametros = array(':estado'=>$estado, ':idcategoria'=>$idcategoria);
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }
}