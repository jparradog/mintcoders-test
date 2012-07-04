<?PHP
/**
* Clase Pagina
* Crea toda la estuctura de la pagina.
*/
class Pagina
{
	protected $titulo="Administración de Usuarios";
	protected $objUsuarios;
	protected $menu = array(1 => array( 'url'=>'crear.php', 'icono'=>'icon-user', 'name'=>'Crear', 'modal'=>'true'), 
		2 => array( 'url'=>'editar.php', 'icono'=>'icon-edit', 'name'=>'Editar', 'modal'=>'true'), 
		3 => array( 'url'=>'eliminar.php', 'icono'=>'icon-remove-sign', 'name'=>'Eliminar', 'modal'=>'false'), 
		4 => array( 'url'=>'listar.php', 'icono'=>'icon-th-list', 'name'=>'Listar', 'modal'=>'false'),
		);
	function __construct(Usuarios $objUsuarios)
	{
		$this->objUsuarios=$objUsuarios;
		//echo $this->objUsuarios->value;
	}
	public function CargarPagina()
	{
		$this->CrearHead();
		$this->CrearContenido();
		$this->CrearFooter();
	}
	public function CrearHead()
	{
		$value='
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>'.$this->titulo.'</title>
	<meta name="description" content="">
	<meta name="author" content="John Parrado">

	<meta name="viewport" content="width=device-width">

	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-responsive.min.css">
	<link rel="stylesheet" href="css/style.css">
	
</head>
		';
		echo($value);
	}
	public function CrearContenido()
	{	
?>
<body>
	<div class="container">
		<header>
			<h1>Administración de Usuarios</h1>
		</header>
		<div class="container-fluid">
		  	<div class="row-fluid">
		    	<div class="span2">
		      	<!--Sidebar content-->
<?PHP
		$this->Menu();
?>
		     	</div>
		    	<div class="span10">
		      	<!--Body content-->
<?PHP
		$this->ContenidoMenu();
?>
		    	</div>
		  	</div>
		</div>
	</div>
<?PHP
	}
	public function CrearFooter()
	{
		$value='
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script>window.jQuery || document.write("<script src=js/jquery-1.7.2.min.js><\/script>")</script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
		';
		echo($value);
	}
	public function Menu()
	{
?>
<div class="well" style="padding: 8px 0;">
<?PHP
		$value='
    <ul class="nav nav-list" id="navegacion">
      	<li class="nav-header">Opciones:</li>
		';
		foreach ($this->menu as $m) {
			$value.='
      	<li>
      		<a href="#'.$m['name'].'" data-name="'.$m['name'].'" data-modal="'.$m['modal'].'">
      			<i class="'.$m['icono'].'"></i> 
      			'.$m['name'].'
      		</a>
      	</li>
			';
		}
		$value.='
    </ul>
		';
		echo $value;
?>
</div>
<?PHP
	}
	public function ContenidoMenu()
	{
		foreach ($this->menu as $m) {
			if ($m['url']=='#') {
				echo '<div class="container escondido" id="'.$m['name'].'"></div>';
			} else {
				if ($m['modal']=='true') {
					$this->CrearModal($m);
				} else if($m['modal']=='false') {
					$this->CrearBloque($m);
				}
				
			}
		}
	}
	public function CrearModal($m='')
	{
		echo '
		<div class="container escondido" id="'.$m['name'].'">
			<div class="modal hide" id="'.$m['name'].'_modal">
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">×</button>
			        <h3>'.$m['name'].'</h3>
			    </div>
		    	<div class="modal-body">
		';
		@include("php/".$m['url']);
		echo '
				</div>
			    <div class="modal-footer">
			  	';
		echo '
			        <a href="#" class="btn" data-dismiss="modal" >Cerrar</a>
			        <a href="#" class="btn btn-primary" id="'.$m['name'].'-guardar">Guardar</a>
			    </div>
			</div>
		</div>
		';
	}
	public function CrearBloque($m='')
	{
		echo '<div class="container escondido" id="'.$m['name'].'">
		';
		@include("php/".$m['url']);
		echo '</div>';
	}
	public function CrearListaUsuarios()
	{
		$html='
<table class="table table-condensed">
	<thead>
	  	<tr>
	    	<th>#</th>
	    	<th>Usuario</th>
	    	<th>Contraseña</th>
	    	<th>Email</th>
	    	<th>Estado</th>
	  	</tr>
	</thead>
	<tbody>
		';
		$usuarios=$this->objUsuarios->CargarUsuarios();
		if ($usuarios!=0) {
		    for ($a=0; $a < $this->objUsuarios->conexion->numregistros(); $a++){
		        $html.='
		<tr class="fila_usuario" data-usuario="'.$usuarios[$a]['usuario'].'">
	    	<td>'.$usuarios[$a]['usuario'].'</td>
	    	<td>'.$usuarios[$a]['nombre'].'</td>
	    	<td>'.$usuarios[$a]['contra'].'</td>
	    	<td>'.$usuarios[$a]['email'].'</td>
	    	<td>'.$usuarios[$a]['nombreEstado'].'</td>
	  	</tr>
		        ';
		    }
		}
		$html.='
	</tbody>
</table>
		';
		if ($usuarios==0) {
		    echo '
		        <span class="help-inline">Error: No hay usuarios creados</span>
		    ';
		}
		return $html;
	}
}
?>