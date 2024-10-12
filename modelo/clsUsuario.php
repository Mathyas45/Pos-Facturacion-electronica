<?php
require_once('conexion.php');

class clsUsuario{

	function verificarUsuario($usuario, $clave){
		$sql = "SELECT u.*, p.nombre as 'perfil' FROM usuario u INNER JOIN perfil p ON u.idperfil=p.idperfil WHERE u.usuario=:usuario AND u.clave=SHA1(:clave) AND u.estado=1 ";
		$parametros = array(':clave'=>$clave, ':usuario'=>$usuario);

		global $cnx;
		$pre = $cnx->prepare($sql);
		$pre->execute($parametros);

		return $pre;
	}


}
