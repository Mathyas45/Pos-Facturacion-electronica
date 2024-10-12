<?php
require_once('conexion.php');

class clsProducto{

	function listarProducto($nombre, $estado, $codigo, $categoria){
		$sql = "SELECT pr.*, un.descripcion as 'unidad', ca.nombre as 'categoria' FROM producto pr INNER JOIN categoria ca ON pr.idcategoria=ca.idcategoria INNER JOIN unidad un ON pr.idunidad=un.idunidad WHERE pr.estado<2 ";
		$parametros = array();

		if($nombre!=""){
			$sql .= " AND pr.nombre LIKE :nombre ";
			$parametros[':nombre'] = '%'.$nombre.'%';
		}

		if($estado!=""){
			$sql .= " AND pr.estado=:estado ";
			$parametros[':estado'] = $estado;
		}

		if($codigo!=""){
			$sql .= " AND pr.codigobarra LIKE :codigo ";
			$parametros[':codigo'] = '%'.$codigo.'%';
		}

		if($categoria!=""){
			$sql .= " AND pr.idcategoria=:idcategoria ";
			$parametros[':idcategoria'] = $categoria;
		}

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);
		return $pre;
	}


	function insertarProducto($codigobarra, $nombre,$idunidad,$idcategoria,$pventa,$pcompra,$stock,$stockseguridad,$idafectacion,$afectoicbper,$estado){
        $sql = "INSERT INTO producto(codigobarra, nombre, idunidad, idcategoria, pventa, pcompra, stock, stockseguridad, idafectacion, afectoicbper, estado) VALUES(:codigobarra, :nombre, :idunidad, :idcategoria, :pventa, :pcompra, :stock, :stockseguridad, :idafectacion, :afectoicbper, :estado)";
        $parametros = array(':codigobarra'=>$codigobarra, ':nombre'=>$nombre, ':idunidad'=>$idunidad, ':idcategoria'=>$idcategoria, ':pventa'=>$pventa, ':pcompra'=>$pcompra, ':stock'=>$stock, ':stockseguridad'=>$stockseguridad, ':idafectacion'=>$idafectacion, ':afectoicbper'=>$afectoicbper, ':estado'=>$estado);
        global $cnx;
        $pre = $cnx->prepare($sql);
        $pre->execute($parametros);
        return $pre;
    }

	function verificarDuplicado($nombre, $idproducto=0){
		$sql = "SELECT * FROM producto WHERE estado<2 AND nombre=:nombre AND idproducto<>:idproducto";
		$parametros = array(':nombre'=>$nombre,':idproducto'=>$idproducto);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}

	function consultarCategoriaPorId($idcategoria){
		$sql = "SELECT * FROM categoria WHERE idcategoria = :idcategoria ";
		$parametros = array(':idcategoria'=>$idcategoria);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}

	function actualizarCategoria($idcategoria, $nombre, $estado){
		$sql = "UPDATE categoria SET nombre=:nombre, estado=:estado WHERE idcategoria=:idcategoria ";
		$parametros = array(':nombre'=>$nombre, ':estado'=>$estado, ':idcategoria'=>$idcategoria);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}

	function actualizarEstadoCategoria($idcategoria, $estado){
		$sql = "UPDATE categoria SET estado=:estado WHERE idcategoria=:idcategoria ";
		$parametros = array(':estado'=>$estado, ':idcategoria'=>$idcategoria);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}


	function consultarUnidad(){
		$sql = "SELECT * FROM unidad WHERE estado=1 ";

		global $cnx;
		$pre = $cnx->query($sql);
		return $pre;
	}

	function consultarAfectacion(){
		$sql = "SELECT * FROM afectacion ";

		global $cnx;
		$pre = $cnx->query($sql);
		return $pre;
	}

}

?>