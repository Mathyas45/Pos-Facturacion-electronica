<?php
require_once('conexion.php');

class clsPerfil{

	function listarOpcionesMenu($idperfil){
		$sql = "SELECT op.*, t3.descripcion as 'modulo', t3.icono as 'modulo_icono', t3.idopcion as 'idmodulo' FROM opcion op INNER JOIN acceso ac ON op.idopcion=ac.idopcion INNER JOIN opcion t3 ON op.idopcion_ref=t3.idopcion WHERE op.estado=1 AND ac.estado=1 AND ac.idperfil=:idperfil ORDER BY op.idopcion_ref ASC, op.idopcion ASC";
		$parametros = array(':idperfil'=>$idperfil);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}
	function listarPerfiles($nombre, $estado){
		$sql = "SELECT * from perfil where estado<2 ";
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

	function seleccionarOpcionPorId($idopcion){
		$sql ="SELECT * FROM opcion where idopcion = :idopcion " ;
		$parametros = array(':idopcion'=>$idopcion);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}
	function insertarPerfil($nombre,$estado){
		$sql = "INSERT INTO perfil(nombre,estado) VALUES(:nombre,:estado)";
		$parametros = array(':nombre'=>$nombre,':estado'=>$estado);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}
	function verificarDuplicado($nombre,$idperfil=0){
		$sql = "SELECT * FROM perfil WHERE estado<2 AND nombre=:nombre AND idperfil<>:idperfil";
		$parametros = array(':nombre'=>$nombre,':idperfil'=>$idperfil);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}
	function consultarPerfilPorId($id){
		$sql = "SELECT * FROM perfil WHERE idperfil = :idperfil ";
		$parametros = array(':idperfil'=>$id);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}
	function actualizarPerfil($idperfil,$nombre,$estado){
		$sql = "UPDATE perfil SET nombre=:nombre, estado=:estado WHERE idperfil=:idperfil ";
		$parametros = array(':nombre'=>$nombre, ':estado'=>$estado, ':idperfil'=>$idperfil);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}
	function cambiarEstadoPerfil($idperfil,$estado){
		$sql = "UPDATE perfil SET estado=:estado WHERE idperfil=:idperfil ";
		$parametros = array(':estado'=>$estado, ':idperfil'=>$idperfil);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}

}

