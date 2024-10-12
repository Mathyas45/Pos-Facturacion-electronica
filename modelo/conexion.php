<?php
	session_start();
	if(!isset($_SESSION['idusuario'])){
		if($_POST['accion']!='INICIAR_SESION'){
			header('Location: ./');
		}
	}
	$manejador = "mysql";
	$servidor = "localhost";
	$usuario = "root";
	$pass = "";
	$base = "posFacElectronica";

	$cadena = "$manejador:host=$servidor;dbname=$base";

	$cnx = new PDO($cadena, $usuario, $pass, array(PDO::ATTR_PERSISTENT => "true", PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));

	// $filtro = "1; INSERT INTO usuario VALUES(NULL, 'Juan', 'juan','123456',1,1)";
	// $sql = "SELECT * FROM producto WHERE estado = :valor ";
	// $parametros = array(':valor'=>$filtro);

	// $resultado = $cnx->query($sql);
	// $pre = $cnx->prepare($sql);
	// $pre->execute($parametros);

	// $resultado = $pre;

	// foreach ($resultado as $key => $value) {
	// 	echo $value['nombre'].'<br>';
	// }


?>