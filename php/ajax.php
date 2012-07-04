<?PHP 
function __autoload($class_name)
{
	include ("class/"."$class_name.php");
} 
$conexion=new Conexion;
$usuarios=new Usuarios($conexion);
$pagina=new Pagina($usuarios);

$datos=$conexion->limpiar_todo($_POST);
if ($datos['opcion']==1) {
	$anexo="formCrear-";
	if ($usuarios->BuscarUsuario($datos[$anexo.'usuario'])) {
		# existe el usuario
		echo '
				{ "message": "1" }
			';//ya existe el usuario
	} else {
		# no existe el usuario
		if ($usuarios->CrearUsuario($datos[$anexo.'usuario'], $datos[$anexo.'contra'], $datos[$anexo.'email'], $datos[$anexo.'estado'])) {
			echo '
				{ "message": "2" }
			';//Se creo correctamente
		} else {
			echo '
				{ "message": "3" }
			';//no Se creo correctamente
		}
		
	}
} else {
	# code...
}

?>