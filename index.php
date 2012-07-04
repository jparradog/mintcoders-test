<?PHP
function __autoload($class_name)
{
	include ("php/class/"."$class_name.php");
} 
$conexion=new Conexion;
$usuarios=new Usuarios($conexion);
$pagina=new Pagina($usuarios);
$pagina->CargarPagina();
?>

		    	

