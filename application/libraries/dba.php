<?php
	class DBA
	{
		/*VARIABLES INICIALIZADAS POR EL CONSTRUCTOR*/
		var $path_file;
		var $mode;
		var $dba_handler;
		
		/*VARIABLES INICIALIZADAS POR LOS METODOS DE LA CLASE*/
		var $resource;
				
		function DBA($ruta, $modo = "c", $gestor = "db4")
		{
			$this->path_file = $ruta;
			$this->mode = $modo;
			$this->dba_handler = $gestor;			

			$this->resource = dba_open ($this->path_file, $this->mode, $this->dba_handler);
		}
		/*
		Modos de acceso a archivos DBA:
			'r' : para lectura a una base de datos existente
			'w' : para lectura/escritua a una base de datos existente
			'c' : para acceso de lectura/escritura y creación de base de datos si no existe actualmente
			'n' : para crear, truncar y tener acceso de lectura/escritura
		*/
		
		function __destroy()
		{
			dba_close ($this->resource);
		}
		
		
		function GuardarRegistro ($clave, $valor)//Metodo que guarda/reemplaza un registro del archivo. Devuelve true si lo logro false caso contrario
		{
			$res = false;
	
			if (($clave != "") && ($valor != ""))
			{
				dba_replace ($clave, $valor, $this->resource);				
				$res = true;
			}
			return $res;
		}
		
		function ObtenerTodos ()//Metodo que retorna en un array asociativo del tipo (clave/valor) de todos los registros de un archivo.
		{
			$vector = array();
		
			$clave = dba_firstkey ($this->resource);
			while ($clave != false)
			{
				$valor = dba_fetch ($clave, $this->resource);
				$vector[$clave] = $valor;
				$clave = dba_nextkey ($this->resource);
			}
			return $vector;
		}
		
		function ObtenerValor ($clave)//Metodo que obtiene el valor de una clave especificada
		{
			$res = false;
			
			if ($clave != "")
			{
				$vector = $this->ObtenerTodos();
				
				foreach ($vector as $c => $v)
				{
					if ($clave == $c)
					{
						$res = $v;
					}		
				}
			}
			return $res;
		}
		
		function EliminarRegistro ($clave)//Metodo que elimina un registro del archivo, en caso de exito devuelve true, contrariamente false.
		{
			$res = false;
		
			if (dba_exists ($clave, $this->resource))
			{
				$res = dba_delete ($clave, $this->resource);
			}
			return $res;
		}
		
		function EliminarTodos ()//Metodo que elimina todos los registros de una base de datos, devuelve true en exito, false en fracaso.
		{
			$res = false;
			
			while ($clave = dba_firstkey ($this->resource))
			{
				$res = dba_delete ($clave, $this->resource);
			}
			return $res;
		}
		
		function GestoresDisponibles ()//Metodo que devuelve un array con todos los gestores DBA disponibles en el servidor Web.
		{
			return dba_handlers();
		}
	}
?>