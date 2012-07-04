<?PHP
/**
* Clase Conexion
*/
class Conexion
{
	/* variables de conexión */
	private $BaseDatos;
	private $db_server;
	private $db_user;
	private $db_password;
	private $T_log;
	/* identificador de conexión y consulta */
	private $Conexion_ID = 0;
	private $Consulta_ID = 0;
	/* número de error y texto error */
	private $Errno = 0;
	private $Error = "";
	/* email administrador */
	private $Email_Admin= "parradojohn1421727@gmail.com";
	/*encriptacion*/
	private $KEY = "\xc8\xd9\xb9\x06\xd9\xe8\xc9\xd2"; # Change this
	function __construct($bd = "gusuarios", $host = "localhost", $user = "root", $pass = "", $log="") 
		{
			$this->BaseDatos = $bd;
			$this->db_server = $host;
			$this->db_user = $user;
			$this->db_password = $pass;
			$this->T_log = $log;
			$this->conectar();
		}
	/*Conexión a la base de datos*/
	function conectar($bd="", $host="", $user="", $pass="", $log="")
		{
			
			if ($bd != "") $this->BaseDatos = $bd;
			if ($host != "") $this->db_server = $host;
			if ($user != "") $this->db_user = $user;
			if ($pass != "") $this->db_password = $pass;
			if ($log != "") $this->T_log = $log;
			//echo "server".$this->db_server." ".$this->db_user." ".$this->db_password;
			// Conectamos al db_server
			$this->Conexion_ID =mysql_connect($this->db_server, $this->db_user, $this->db_password);
			if (!$this->Conexion_ID) 
				{
					$this->Error = "Ha fallado la conexión.";
					return 0;
				}
			//seleccionamos la base de datos
			if (!mysql_select_db($this->BaseDatos, $this->Conexion_ID)) 
				{
					$this->Error = "Imposible abrir ".$this->BaseDatos ;
					return 0;
				}
			/* Si hemos tenido éxito conectando devuelve el identificador de la conexión, sino devuelve 0 */
			return $this->Conexion_ID;
		}	
	/* Ejecuta un consulta */
	function consulta($sql = "", $m_error=true)
		{
			if ($sql == "") 
				{
					$this->Error = "No ha especificado una consulta SQL";
					return 0;
				}
			//$sql=$this->html_encode($sql);
			//ejecutamos la consulta
			//echo "sql:".$sql."conexion:".$this->Conexion_ID;
			$this->Consulta_ID = mysql_query($sql, $this->Conexion_ID);
			if (!$this->Consulta_ID) 
				{
					if($m_error==true)
						{
							$this->Errno = mysql_errno();
							$this->Error = mysql_error();
							echo "<br><b><font color='red'>ERROR:</b> --> </b>" .
							$this->Errno."</b> - <i>" .$this->Error."</i></font><br>";
							$this->reportar_email();
						}
					return 0;
				}
			/* Si hemos tenido éxito en la consulta devuelve el identificador de la conexión, sino devuelve 0 */
			return $this->Consulta_ID;
		}
	/* reportar al admin sobre errores */
	function reportar_email()
		{
			$subject = "Registro de usuario";
			$headers = "From: ".$this->Email_Admin."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
			$headers .= "\r\n";
            @mail ($this->Email_Admin,
            "Error mysql en".$_SERVER ['PHP_SELF'] ,
            "\n Error-> ".$this->Errno."  ------  ".$this->Error.
            "\n en->".$_SERVER['PHP_SELF'].$_SERVER['QUERY_STRING'].
            "\n a las-> ".date('H:i:s - D-d-m-Y'),$headers);
		}
	/* Devuelve el número de columnas de una consulta */
	function numcolumnas() 
		{
			return mysql_num_fields($this->Consulta_ID);
		}
	/* Devuelve el número de registros de una consulta */
	function numregistros($id="")
		{
			if(@mysql_num_rows($this->Consulta_ID)>0)
				return mysql_num_rows($this->Consulta_ID);
			else
				return 0;
		}
	/* Devuelve el número de registros afectados en alguna peticion sql menos los selects*/
	function filasafectadas()
		{
			return mysql_affected_rows();	
		}
	/* Devuelve el nombre de un campo de una consulta */
	function nombrecampo($numcampo) 
		{
			return utf8_encode(@mysql_field_name($this->Consulta_ID, $numcampo));
		}
	/* Devuelve un array asociativo de la consulta (por nombres de campo envez de por indice de campo) */
	function result_array_asoc()
		{
			$fila='';
			$arr_asoc='';
			@mysql_data_seek($this->Consulta_ID,0);
			while ($fila = mysql_fetch_assoc ($this->Consulta_ID))
				{
					$arr_asoc[] = $fila;
				}
			return ($arr_asoc);
		}
	function mysql_array()
		{
			return mysql_fetch_array($this->Consulta_ID,mysql_ASSOC); 	
		}
	/* Muestra los datos de una consulta */
	function verconsulta() 
		{
			@mysql_data_seek($this->Consulta_ID,0);
			echo "<table border=1>\n";
			// mostramos los nombres de los campos
			for ($i = 0; $i < $this->numcolumnas(); $i++)
				{
					echo "<td><b>".$this->nombrecampo($i)."</b></td>\n";
				}
			echo "</tr>\n";
			// mostrarmos los registros
			while ($row = mysql_fetch_row($this->Consulta_ID)) 
				{
					echo "<tr> \n";
					for ($i = 0; $i < $this->numcolumnas(); $i++)
						{
							echo "<td>".utf8_encode($row[$i])."</td>\n";
						}
					echo "</tr>\n";
				}
		}
	/*htmlentities — Convierte todos los caracteres aplicables a entidades HTML*/
	function html_encode($texto = "")
		{
			return htmlentities ($texto);
		}
	/*html_entity_decode — Convierte todas las entidades HTML a sus caracteres correspondientes*/
	function html_decode($texto = "")
		{
			return html_entity_decode ($texto);
		}
	
	/* Impide que se interpreten los caracteres especiales de HTML (<, >, &) */
	function quitar_html($texto = "")
		{
			return htmlspecialchars($texto);
		}
	/* Eliminamos Espacion en Blanco*/
	function quitar_espacios_blanco($texto = "")
		{
			return trim($texto);
		}
	/* Eliminanos los slashes (/)*/
	function quitar_slas($texto = "")
		{
			return stripslashes($texto);
		}
	/* limpia variables */
	function limpiar_var($texto = "")
		{
			return 	$this->quitar_espacios_blanco($this->quitar_slas($this->quitar_html($texto)));
		}
	/*limpia todos los datos GET y POST*/
	function limpiar_todo($datos)
		{
			if(is_array($datos))
				{
					//$funcion=$this->limpiar_var();
					foreach($datos as $woo => $what){ 
						//strip slashes of the post data 
						$datos[$woo] = $this->limpiar_var($what); 
					} 
					//$datos = array_map($this->limpiar_var,$datos);
				}
			else
				{
					$this->Error = "Error limpiar todo POS y GET";
					return 0;
				}
				return $datos;	
		}
	function encriptar($texto='', $limpiar=false)
		{
			$cifrado = MCRYPT_RIJNDAEL_256;
			$modo = MCRYPT_MODE_ECB;
			if($limpiar==true)
				{
					return $this->limpiar_var(base64_encode(mcrypt_encrypt(
										$cifrado, 
										$this->KEY, 
										$texto, 
										$modo, 
										mcrypt_create_iv(mcrypt_get_iv_size(
														$cifrado, 
														$modo
														), MCRYPT_RAND)
					)));
				}
			else if($limpiar==false)
				{
					return base64_encode(mcrypt_encrypt(
										$cifrado, 
										$this->KEY, 
										$texto, 
										$modo, 
										mcrypt_create_iv(mcrypt_get_iv_size(
														$cifrado, 
														$modo
														), MCRYPT_RAND)
					));
				}
		}
	function decriptar($texto='')
		{
			$texto=base64_decode($texto);
			 $cifrado = MCRYPT_RIJNDAEL_256;
			 $modo = MCRYPT_MODE_ECB;
			 return $this->limpiar_var(mcrypt_decrypt($cifrado, 
			 					   $this->KEY, 
								   $texto, 
								   $modo,
			 					   mcrypt_create_iv(mcrypt_get_iv_size(
								   			$cifrado, 
											$modo), MCRYPT_RAND)
			 ));
		}
}
?>