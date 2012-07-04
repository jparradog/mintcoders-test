<?php  
/**
* Class: Usuarios
* Encargada de gestionar los formularios de los usuarios
*/
class Usuarios
{
	public $conexion;
	function __construct(Conexion $conexion){
		$this->conexion=$conexion;
	}

	public function CargarUsuarios()
	{
		$consulta='
			SELECT u.usuario,
u.nombre,
u.contra,
u.email, 
u.estado, 
e.nombre AS nombreEstado
FROM `usuarios` AS u
INNER JOIN estados AS e ON u.estado=e.estado;
		';
		$this->conexion->consulta($consulta);
		if($this->conexion->numregistros()<1){
				//die("Error: no hay usuarios");
				return (0);
		} else if($this->conexion->numregistros()>=1){
				return $this->conexion->result_array_asoc();
		}
	}
	public function CargarEstados()
	{
		$consulta='
			SELECT e.estado, e.nombre
FROM estados AS e;
		';
		$this->conexion->consulta($consulta);
		if($this->conexion->numregistros()<1){
				//die("Error: no hay Estados");
				return (0);
		} else if($this->conexion->numregistros()>=1){
				return $this->conexion->result_array_asoc();
		}
	}
	public function BuscarUsuario($nombre='')
	{
		$consulta='
			SELECT u.usuario,
u.nombre,
u.contra,
u.email, 
u.estado, 
e.nombre AS nombreEstado
FROM `usuarios` AS u
INNER JOIN estados AS e ON u.estado=e.estado
WHERE u.nombre="'.$nombre.'";
		';
		$this->conexion->consulta($consulta);
		if($this->conexion->numregistros()<1){
				return (false);
		} else if($this->conexion->numregistros()>=1){
				return (true);
		}
	}
	public function CrearUsuario($nombre='', $contra='', $email='', $estado='1')
	{
		$consulta="
			INSERT INTO usuarios (
				usuario, 
				nombre, 
				contra, 
				email, 
				estado) 
			VALUES (NULL, 
				'".$nombre."', 
				'".$contra."', 
				'".$email."', 
				'".$estado."');
		";
		$this->conexion->consulta($consulta);
		if($this->conexion->filasafectadas()<1){
				return (false);
		} else if($this->conexion->filasafectadas()>=1){
				return (true);
		}
	}
}
?>