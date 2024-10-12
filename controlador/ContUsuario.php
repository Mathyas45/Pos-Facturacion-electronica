<?php
require_once('../modelo/clsUsuario.php');
$accion = $_POST['accion'];

controlador($accion);

function controlador($accion){
	$objUsu = new clsUsuario();

	switch ($accion) {
		case 'INICIAR_SESION':
			
			$usuario = $_POST['usuario'];
			$clave = $_POST['clave'];

			$respuesta = array();

			$datoUsuario = $objUsu->verificarUsuario($usuario, $clave);
			if($datoUsuario->rowCount()>0){

				$datos = $datoUsuario->fetch(PDO::FETCH_NAMED);
				$_SESSION['idusuario'] = $datos['idusuario'];
				$_SESSION['nombre'] = $datos['nombre'];
				$_SESSION['usuario'] = $datos['usuario'];
				$_SESSION['idperfil'] = $datos['idperfil'];
				$_SESSION['perfil'] = $datos['perfil'];

				$respuesta['correcto']=1;
				$respuesta['mensaje']='Usuario y Contraseña Correcta';
			}else{
				$respuesta['correcto']=0;
				$respuesta['mensaje']='Usuario o Contraseña Incorrecta';
			}

			echo json_encode($respuesta);

			break;

		case 'ACTUALIZAR':
			$resultado = array();
			

			break;
		
		default:
			// code...
			break;
	}

}

?>