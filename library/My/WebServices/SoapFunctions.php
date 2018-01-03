<?php

class My_WebServices_SoapFunctions {

    
	/**
	 * getAuth: Autentica usuarios
	 * @param string $username
	 * @param string $clave
	 * @return mixed
	 **/
	public function getAuth($username, $clave) {
        My_Utils::log("GET AUTH");
        
		//$usuario = new My_Beans_Template_Usuario();
		//$usuario->setBeanStatus(My_Constantes::STATUS_OK);
		
        try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);


            My_Utils::log('conectado mov '.print_r($config,1));

			
            $sql = "SELECT * FROM usuario WHERE username = '$username' AND clave = MD5('$clave')";
            $stmt = $db->query($sql);

            $row = $stmt->fetchAll();
			//$usuario->setId($row["id"]);
						
			My_Utils::log("  ---  ".print_r($row,1));

			//if (($row = $stmt->fetch())) {
                //$usuario->setUsername($row["usuario"]);
                //$usuario->setId($row["id"]);

                
                
              //  if ($stmt === false) $usuario->setBeanStatus(My_Constantes::STATUS_ERROR_SQL);
			//}
			//else $usuario->setBeanStatus(My_Constantes::STATUS_ERROR_USER_NOTFOUND);
            
			$db->closeConnection();
		}
		catch (Exception $e) {
			//$usuario->setBeanStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}		
		//My_Utils::log("asdsdsdasdsd: " . print_r($usuario["id"]));
		return $row;
	}
    
    
    /**
    * getMenu()
    * Devuelve lista de herramientas publicas
    * @param string $usuario
    * @return mixed
    **/
    function getMenu($usuario = "") {
        // Declara lista
        $lista = new My_Beans_ListaGenerica();
        $lista->setStatus(My_Constantes::STATUS_OK);
        
        try {
            $config = My_ConfigIni::getConfig()->resources->db->sg_operaciones;
            $db = My_Utils::connDB($config);
            
            if ($usuario == "") {
                $sql = "SELECT h.id_herramienta, h.nombre nombre_herramienta, h.url, h.item_padre, h.orden, h.target, p.nombre nombre_proyecto, p.icono icono_proyecto "
                        . "FROM herramienta h INNER JOIN proyecto p ON h.fk_id_proyecto = p.id_proyecto "
                        . "WHERE nivel_acceso = 'publico';";
            }
            else {
                $sql = "SELECT h.id_herramienta, h.nivel_acceso, h.nombre nombre_herramienta, h.url, h.item_padre, h.orden, h.target, pr.nombre nombre_proyecto, pr.icono icono_proyecto "
                        . "FROM permiso p INNER JOIN herramienta h ON p.id_herramienta = h.id_herramienta AND p.username = '$usuario' OR h.nivel_acceso = 'publico' "
                        . "INNER JOIN proyecto pr ON pr.id_proyecto = h.fk_id_proyecto GROUP BY h.id_herramienta;";
            }
            My_Utils::log($sql);
            $stmt = $db->query($sql);
            
            while ($row = $stmt->fetch()) {
                // Instancia Bean de Menu
                $objMenu = new My_Beans_Template_Menu();
                // Setea las propiedades que se necesitan
                $objMenu->setId_herramienta((int)$row["id_herramienta"]);
                $objMenu->setNombre_herramienta($row["nombre_herramienta"]);
                $objMenu->setUrl($row["url"]);
                $objMenu->setItem_padre((int)$row["item_padre"]);
                $objMenu->setOrden((int)$row["orden"]);
                $objMenu->setTarget($row["target"]);
                $objMenu->setNombre_proyecto($row["nombre_proyecto"]);
                $objMenu->setIcono_proyecto($row["icono_proyecto"]);
                
                // Se agrega el Bean a la lista
                $lista->addLista($objMenu);
            }
            
            $db->closeConnection();
        } 
        catch (Exception $e) {
			$lista->setStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $lista;
    }
    
    /**
     * getProyectos retorna lista con todos los proyectos.
     * @return mixed
     **/
    public function getProyectos() {
        // Declara lista
        $lista = new My_Beans_ListaGenerica();
        $lista->setStatus(My_Constantes::STATUS_OK);
        
        try {
            $config = My_ConfigIni::getConfig()->resources->db->sg_operaciones;
            $db = My_Utils::connDB($config);
            
            $sql = "SELECT id_proyecto, nombre, area, url, icono FROM proyecto";
            $stmt = $db->query($sql);
            
            while ($row = $stmt->fetch()) {
                // Instancia Bean de Proyecto
                $objProyectos = new My_Beans_Template_Proyecto();
                $objProyectos->setId_proyecto((int)$row["id_proyecto"]);
                $objProyectos->setNombre($row["nombre"]);
                $objProyectos->setArea($row["area"]);
                $objProyectos->setUrl($row["url"]);
                $objProyectos->setIcono($row["icono"]);
                // Se agrega el Bean a la lista
                $lista->addLista($objProyectos);
            }
        } catch (Exception $e) {
			$lista->setStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $lista;
    }
    
    /**
	 * getUsers retorna una lista de usuarios que tienen cierto perfil o username
	 * @param string $perfil
	 * @param string $username
	 * @param string $area
	 * @return mixed
	 **/
	public function getUsers($perfil = "", $username = "", $area="") {
		$listaUsuarios=new My_Beans_ListaGenerica();
		$listaUsuarios->setStatus(My_Constantes::STATUS_OK);
		
        try {
			$db = My_Utils::connOvas();
			$sql = "select username, e_mail, movil, nombres, ape_paterno, ape_materno,
					perfil_id, estado, area, area2  from users where estado='A'";
			
            if ($perfil != "" && $username !="") {
				$sql .= " and (perfil_id=$perfil or username='$username')";
			}
			elseif ($perfil != "") {
				$sql .= " and perfil_id=$perfil";
			}
			elseif ($username != "") {
				$sql .= " and username='$username'";
			}
            elseif ($area != "") {
            	My_Utils::log("area=$area");
                $areasArray = explode(",", $area);
                My_Utils::log(print_r($areasArray,1));
                $areasSql = join("','", $areasArray);
                $sql .= " and area in ('$areasSql') OR area2 in ('$areasSql')";
                My_Utils::log("areasSql=$areasSql");
            }       
			My_Utils::log("sql=$sql");
			
            $stmt = $db->query($sql);
			if ($stmt === false) {
				$listaUsuarios->setStatus(My_Constantes::STATUS_ERROR_SQL);
			}
			else {	
				while ($row = $stmt->fetch()) {
					$usuario=new My_Beans_Usuarios();
				    
                    if ($username != "") {
						$usuario->setUsername($username);
					}
					else {
						$usuario->setUsername($row['username']);
					}
					$usuario->setE_mail($row['e_mail']);
					$usuario->setMovil($row['movil']);
					$usuario->setNombres($row['nombres']);
					$usuario->setApe_paterno($row['ape_paterno']);
					$usuario->setApe_materno($row['ape_materno']);
					$usuario->setPerfil_id($row['perfil_id']);
					$usuario->setEstado($row['estado']);

					if ($row['area2'] !== '' && $area == 'entel.vasme') {
						My_Utils::log("area change");
						$usuario->setArea($row['area2']);
					}
					else{
						$usuario->setArea($row['area']);
					}

					$listaUsuarios->addLista($usuario, $row['username']);
				}
			}
			$db->closeConnection();
		}
		catch (Exception $e) {
			$listaUsuarios->setStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}		
		return $listaUsuarios;
	}
    
		
	/**
	 * Retorna lista de NetworkElements (Nodos)
	 * @return mixed
	 **/
	function getNodos() {
        $lista=new My_Beans_ListaGenerica();
		try {
			$db = My_Utils::connPortalCore();
			$lista->setStatus("OK");
			$stmt = $db->query("select nodo, tipo, ip, usr, pwd, protocolo, comando from nodos");
			
            while ($row = $stmt->fetch()) {
				$nodo=new My_Beans_Nodos();
				$nodo->setProtocolo($row['protocolo']);
				$nodo->setTipo($row['tipo']);
				$nodo->setNodo($row['nodo']);
				$nodo->setIp($row['ip']);
				$nodo->setUsr($row['usr']);
				$nodo->setPwd($row['pwd']);
				$nodo->setComando($row['comando']);
				
				$lista->addLista($nodo);
			}
			$db->closeConnection();
		}
		catch (Exception $e) {
			$lista->setStatus("ERR");
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
		return $lista;
	}
	
		
	/**
	 * Envia un SMS al movil indicado
	 * @param string $to_number
	 * @param string $mensaje
	 * @return boolean
	 **/
	function sendSMS($to_number, $mensaje) {
		try {
            $status = true;
            $sms_config = My_ConfigIni::get('sms');
            $url_base = $sms_config->url_base;
            $user = $sms_config->user;
            $passwd = $sms_config->passwd;
            $service =  $sms_config->service;
            $from =  $sms_config->from;

            //Construye la url
            $url = $url_base."?user=".$user;
            $url = $url. "&passwd=".$passwd."&service=".$service;
            $url = $url. "&from=".$from ."&to=".$to_number;
            $url = $url. "&text=".urlencode ($mensaje) ;
            My_Utils::log("Enviando url: $url");
            
            //Llama al servicio para enviar sms
            $resultado = My_Utils::file_get_curl($url);
            My_Utils::log("Resultado: $resultado");
		}
		catch (Exception $e) {
			$status=false;
			My_Utils::log("[sendMail]-Resultado: No se puede enviar email");
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}		
		return $status;
		
	}
					
	
	/**
    * Envia email usando PHPMailer
    * @param string $fromName
    * @param string $replyToAddr
    * @param string $replyToName
    * @param string $subject
    * @param string $body
    * @param string $altbody
    * @param string $to
    * @return string
    **/	
	public function sendPHPMailer($fromName, $replyToAddr, $replyToName, $subject, $body, $altbody, $to) {
		require 'PHPMailerAutoload.php';
		
		$mail = new PHPMailer;
		$mail->isSMTP(); // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com'; // Specify main and backup server
		$mail->SMTPAuth = true; // Enable SMTP authentication
		$mail->Username = 'soporte@t2b.cl'; // SMTP username
		$mail->Password = 'T2b.2012'; // SMTP password
		$mail->SMTPSecure = 'tls'; // Enable encryption, 'ssl' also accepted
        $mail->Port = 587;                 
		$mail->FromName = $fromName;
        $mail->addReplyTo($replyToAddr, $replyToName);
		
        $to_array = explode (",", $to);
        
        foreach ($to_array as $i => $recipient) {
            $recipient_array = explode(":", $recipient);

            if (count($recipient_array) == 2) {
                $mail->addAddress($recipient_array[0], $recipient_array[1]);  // Add a recipient
            }
        }
		$mail->addReplyTo('soporte.t2b@t2b.cl', 'Soporte T2B');
		
        //$mail->addCC('cc@example.com');
		//$mail->addBCC('bcc@example.com');
		
		$mail->WordWrap = 50; // Set word wrap to 50 characters
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
		$mail->isHTML(true); // Set email format to HTML
        
		$mail->Subject = $subject;
		$mail->Body    = $body;
		$mail->AltBody = $altbody;
		
		if(!$mail->send()) {
			$error = 'Message could not be sent.';
			$error .= 'Mailer Error: ' . $mail->ErrorInfo;
			return $error;
		}		
		return 'Message has been sent';
	}
	
    
	/**
	 * Envia e-mail con la clave de usuario autogenerada, el input es el nombre de usuario o e-mail
	 * @param string $username
	 * @return string
	 **/
	public function getClave($username) {
		$status = My_Constantes::STATUS_OK;
		try {
            $config = My_ConfigIni::getConfig()->resources->db->plantilla;
			$db = My_Utils::connDB($config);
			$stmt = $db->query("select username, e_mail, nombres, ape_paterno, ape_materno, clave from users where e_mail='$username' or username='$username'" );
	
			if (($row = $stmt->fetch())) {
				$username = $row['username'];
				$e_mail = $row['e_mail'];
				$fullname = $row['nombres'] . " " . $row['ape_paterno'] . " " . $row['ape_materno'];
				$subject = My_ConfigIni::get('mail')->subject->prefijo . " Nueva Clave";
				$nueva_clave = $this->generateRandomString();
				$body = "Su nueva clave es: $nueva_clave"; 
				$altbody = "";
				$to = "$e_mail:$fullname";
                $fromName = 'Soporte T2B';
                $replyToAddr = 'soporte.t2b@t2b.cl';
                $replyToName = 'Soporte T2B';

                $ret = $this->sendPHPMailer($fromName, $replyToAddr, $replyToName, $subject, $body, $altbody, $to);
                My_Utils::log("sendPHPMailer ret:$ret");
                
				$stmt = $db->query("UPDATE users set clave = md5('$nueva_clave') where username='$username'");
			}
			else {
				$status = My_Constantes::STATUS_ERROR_USER_NOTFOUND;
			}
			$db->closeConnection();
		}
		catch (Exception $e) {
			$status = My_Constantes::STATUS_ERROR;
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
		return $status;
	}
	
    
	/**
	 * Genera clave alfanumerica aleatoria
	 *
	 * @param int $length
	 * @return string
	 **/	
	public function generateRandomString($length = 5) {
	    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    
        for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	
    
	/**
	 * Actualiza la clave actual
	 * @param string $username
	 * @param string $clave_actual
	 * @param string $clave_nueva
	 * @param string $clave_nueva2 
	 * @return string
	 **/
	public function setNuevaClave($username, $clave_actual, $clave_nueva, $clave_nueva2) {
		$status = My_Constantes::STATUS_ERROR;
		try {
			My_Utils::log("username: $username, clave_actual: $clave_actual, clave_nueva: $clave_nueva, clave_nueva2: $clave_nueva2");
			//$db = My_Utils::connOvas();
            $config = My_ConfigIni::getConfig()->resources->db->plantilla;
			
            $db = My_Utils::connDB($config);
			
            if ($clave_nueva == $clave_nueva2) {
                $stmt = $db->query("select e_mail, clave, nombres, ape_paterno, ape_materno, clave from users where username='$username'" );
				
                if ($stmt !== false) {
					if (($row = $stmt->fetch())) {
						$email = $row['e_mail'];
						$clave = $row['clave'];
						$fullname = $row['nombres'] . " " . $row['ape_paterno'] . " " . $row['ape_materno'];
						My_Utils::log("clave_bd: $clave, clave_actual: " . md5($clave_actual));
						
                        if ($clave == md5($clave_actual)) {
							$sql = "update users set clave=md5('$clave_nueva') where username='$username'";
							My_Utils::log("sql: $sql");
                            
							$stmt = $db->query($sql);
							$subject = My_ConfigIni::get('mail')->subject->prefijo . " Cambio de Clave";
							$body = "Su clave ha sido actualizada";
							$altbody = "";
							$to = "$email:$fullname";
                            $fromName = 'Soporte T2B';
                            $replyToAddr = 'soporte.t2b@t2b.cl';
                            $replyToName = 'Soporte T2B';
                            $ret = $this->sendPHPMailer($fromName, $replyToAddr, $replyToName, $subject, $body, $altbody, $to);
                            My_Utils::log("sendPHPMailer ret:$ret");

                            $status = My_Constantes::STATUS_OK;
						}
						else {
							$status = My_Constantes::STATUS_ERROR_CLAVEACTUAL_NO_COINCIDE;
						}	
					}	
					else {
						$status = My_Constantes::STATUS_ERROR_USER_NOTFOUND;
					}			
				}
			}
			else {
				$status = My_Constantes::STATUS_ERROR_CLAVENUEVA_NO_COINCIDE;
			}
			$db->closeConnection();
		}
		catch (Exception $e) {
			$status = My_Constantes::STATUS_ERROR;
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
		return My_Constantes::$STATUS_DESC[$status];
	}
    
    
	/**
	 * Retorna los Nombres de columna de una tabla y base de datos especifica 
	 * @param string $base_datos
	 * @param string $tabla
	 * @param mixed $db
	 * @return mixed
	 **/
	public function getColumnas($base_datos, $tabla , $db = null)
	{
		$listaObj=new My_Beans_ListaGenerica();
		try {
			$listaObj->setStatus(My_Constantes::STATUS_OK);
			
            if ($db == null) {
				$db = My_Utils::connOvas();
			}	
			My_Utils::log("base_datos: $base_datos, tabla: $tabla");
			
            $sql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$base_datos' " . 
    				" AND TABLE_NAME='$tabla'";
			My_Utils::log("sql: $sql");
			
            $stmt = $db->query($sql);
			
            if ($stmt !== false) {
				$columnas = array();
				
                while ($row = $stmt->fetch()) {
					$columnas[] = $row['column_name'];
				}
				$listaObj->addLista(join(",", $columnas), "JOIN");
				$listaObj->addLista($columnas, "ITEMS");
			}
			$db->closeConnection();
		}
		catch (Exception $e) {
			$listaObj->setStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			}
		return $listaObj;
	}


	/**
	 * Devuelve lista de BSCs
	 * @return mixed
	 **/
	function getBsc() {
		$lista = new My_Beans_ListaGenerica();
		$valores = array();
		
        try {
			$db = My_Utils::connOvas();
			$sql = "Select * From nodos where tipo = 'bsc'";
			My_Utils::log($sql);
			
            $stmt = $db->query($sql);
			$lista->setStatus(My_Constantes::STATUS_OK);
			$cont = 0;
			
            while ($row = $stmt->fetch()) {
				if($cont == 0) {
                    $lista->addlista(array_keys($row), "header");
                }
				$cont++;
				
                $valores[] = array_values($row);
			}
			if($cont > 0) {
                $lista->addlista($valores, "valores");
            }
		}
		catch (Exception $e) {
			$lista->setStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
		return $lista;
	}

    
	/**
	 * Devuelve lista de RNCs
	 
	 * @return mixed
	 **/
	function getRnc() {
		$lista = new My_Beans_ListaGenerica();
		$valores = array();
		
        try {
			$db = My_Utils::connOvas();
			$sql = "Select * From nodos where tipo = 'rnc'";
			My_Utils::log($sql);
		
            $stmt = $db->query($sql);
			$lista->setStatus(My_Constantes::STATUS_OK);
			$cont = 0;
			
            while ($row = $stmt->fetch()) {
				if($cont == 0) {
                    $lista->addlista(array_keys($row), "header");
                }
				$cont++;
				$valores[] = array_values($row);
			}
			if($cont > 0) {
                $lista->addlista($valores, "valores");
            }
			$db->closeConnection();
		}
		catch (Exception $e) {
			$lista->setStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
		return $lista;
	}
    

/**
	 * Devuelve lista de trabajadores
	 * @param string
	 * @return mixed
	 **/
	function getTrabajadores($periodo) {
		try {
			My_Utils::log("periodo " .($periodo));
			$periodo = explode('-', $periodo);
			My_Utils::log("split ". $periodo[0]. $periodo[1]);

			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			My_Utils::log('parametros');
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado'.print_r($config,1));
	        $stmt = $db->query("SELECT *
								from usuarios u left join 
    								(select id_usuario, sum(m.`salida` - m.`ingreso`) as horas
     								from `maestro_mov` m where MONTH(fecha)='$periodo[1]' and YEAR(fecha)='$periodo[0]'
     									group by id_usuario) as M
     									on u.id = m.`id_usuario`
										group by u.id ");
	        My_Utils::log('consulte');
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}

	/**
	 * Devuelve lista de trabajadores
	 * @param string
	 * @param string
	 * @return mixed
	 **/
	function getHorasActual($id, $periodo){
	try {
			My_Utils::log("periodo " .($periodo));
			$periodo = explode('-', $periodo);
			My_Utils::log("split ". $periodo[0]. $periodo[1]);

			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			My_Utils::log('parametros');
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado'.print_r($config,1));
	        $stmt = $db->query("SELECT *
								from usuarios u left join 
    								(select id_usuario, sum(m.`salida` - m.`ingreso`) as horas
     								from `maestro_mov` m where MONTH(fecha)='$periodo[1]' and YEAR(fecha)='$periodo[0]'
     									group by id_usuario) as M
     									on u.id = m.`id_usuario` where u.id = '$id'
										group by u.id ");
	        My_Utils::log('consulte '. $stmt );
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}

/**
	 * Devuelve lista de trabajadores
	 * @param string id_usuario
	 * @param string fecha
	 * @return mixed
	 **/
	function getHorarioTrabajador($id_usuario, $fecha) {
		try {
			
			My_Utils::log("periodoooooo " .($fecha));
			$fecha = explode('-', $fecha);
			My_Utils::log("splitttttt ". $fecha[0]. $fecha[1]);
			My_Utils::log("idddd ". $id_usuario);
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			My_Utils::log('parametros2');
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado2 '.print_r($config,1));
	        $stmt = $db->query("SELECT * from usuarios u
    						left join
    						(select m.id as id_reg, m.id_usuario, ingreso,salida,fecha,x(ubica_in) as xin,y (ubica_in) as yin, x(ubica_out) as xout ,y(ubica_out) as yout, L1.id as id_ingreso,L2.id as id_salida
								from `maestro_mov` m 
								left join log_edicion L1 on (m.id=L1.id_mov and L1.tipo='ingreso') 
								left join log_edicion L2 on (m.id=L2.id_mov and L2.tipo='salida') 

							where MONTH(fecha)='$fecha[1]' and YEAR(fecha)='$fecha[0]'
     						order by fecha desc) as M
     						on u.id = m.`id_usuario` where u.id = '$id_usuario' group by fecha");

	        My_Utils::log('consulte2 : '. $stmt);
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        My_Utils::log($row);
        return $row;
	}

/**
	 * Devuelve el mov del id solicitado
	 * @param string id_mov
	 * @return mixed
	 **/
	function getHoras($id_mov) {
		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado mov '.print_r($config,1));
	        $stmt = $db->query(	"SELECT * from usuarios u left join maestro_mov m on u.id = m.							id_usuario where m.id = '$id_mov'");
							
	        My_Utils::log('Consulte mov');
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}


/**
	 * Devuelve el log con horas modificadas
	 * @param string fecha
	 * @return mixed
	 **/
	function getHorasModificadas($fecha){

		try {

			$fecha = explode('-', $fecha);
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado mov '.print_r($config,1));
	        $stmt = $db->query("SELECT * from maestro_mov m join 
			(select * from log_edicion l group by id_mov, tipo) as L
			on l.id_mov = m.id where MONTH(fecha)='$fecha[1]' and YEAR(fecha)='$fecha[0]'");
							
	        My_Utils::log('consulte mov');
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}


/**
	 * actualiza el registro con nuevos datos y los agrega a log y modifica hora de ingreso
	 * @param string id_mov
	 * @param string ingreso
	 * @param string ingreso_old
	 * @param string comentario
	 * @param string id_usuario
	 * @param string id_sesion
	 * @return mixed
**/

	function setHoraIngreso($id_mov, $ingreso, $ingreso_old, $comentario, $id_usuario, $id_sesion){

			My_Utils::log("INGRESO :". $ingreso);
            My_Utils::log("INGRESO old :". $ingreso_old);
            My_Utils::log("INGRESO sesion :". $id_sesion);
	try{
		$config = My_ConfigIni::getConfig()->resources->db->ovas;
		$db = My_Utils::connDB($config);
		$stmt = $db->query("update maestro_mov m set m.ingreso = '$ingreso' where m.id = '$id_mov';");

		//agrega el nuevo ingreso
		$stmt2 = $db->query("insert into log_edicion 
		  (id_admin,valor_old,     valor_new,   id_usuario,   id_mov,     tipo,     comentario)
	values(   '$id_sesion',  '$ingreso_old', '$ingreso', '$id_usuario','$id_mov', 'ingreso', '$comentario')");

	}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return false;
		}
        $db->closeConnection();
        return true;
	}
/**
	 * actualiza el registro con nuevos datos y los agrega a log y modifica hora de salida
	 * @param string id_mov
	 * @param string salida_old
	 * @param string salida
	 * @param string comentario
	 * @param string id_usuario
	 * @param string id_sesion
	 * @return mixed
	 **/

	function setHoraSalida($id_mov, $salida, $salida_old, $comentario, $id_usuario, $id_sesion){

		My_Utils::log("SALIDA :". $salida);
        My_Utils::log("SALIDA old :". $salida_old);

	try{
		$config = My_ConfigIni::getConfig()->resources->db->ovas;
		$db = My_Utils::connDB($config);
	   	$stmt = $db->query("update maestro_mov m set salida = '$salida' where m.id = '$id_mov';");
		
	//agrega la nueva salida
		$stmt2 = $db->query("insert into log_edicion 
			(id_admin, valor_old,valor_new,id_usuario,id_mov,tipo,comentario)
	values('$id_sesion',	'$salida_old','$salida', '$id_usuario','$id_mov', 'salida', '$comentario')");
	}
	catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return false;
		}
        $db->closeConnection();
        return true;
    }


/**
	 * Devuelve lista de trabajadores
	 * @param string
	 * @return mixed
	 **/
	function getHorasHoy($periodo) {
		try {
			My_Utils::log("periodo " .($periodo));
			$periodo = explode('-', $periodo);
			My_Utils::log("split ". $periodo[0]. $periodo[1]. $periodo[2]);

			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			My_Utils::log('parametros');
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado'.print_r($config,1));
	        $stmt = $db->query("SELECT *
								from usuarios u join 
    								(select id_usuario, fecha, ingreso as hora, 'Ingreso' as tipo
     								from `maestro_mov` m where MONTH(fecha)='$periodo[1]' and YEAR(fecha)='$periodo[0]' and DAY(fecha)=$periodo[2]
     									group by id_usuario) as M
     									on u.id = m.`id_usuario`
										order by hora ");
	        My_Utils::log('consulte');
	        $row = $stmt->fetchAll();

	        $stmt = $db->query("SELECT *
								from usuarios u join 
    								(select id_usuario, fecha, salida as hora, 'Salida' as tipo
     								from `maestro_mov` m where MONTH(fecha)='$periodo[1]' and YEAR(fecha)='$periodo[0]' and DAY(fecha)='$periodo[2]'
     									group by id_usuario) as M
     									on u.id = m.`id_usuario`
										order by hora ");
	        My_Utils::log('consulte');
	        $row2 =  $stmt->fetchAll();

	        $resultado = array_merge($row,$row2);
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $resultado;
	}

	/**
	*busca fechas de feriados
	*@return mixed
	**/
	function getFestivos(){
		try{

			My_Utils::log("periodo festivo" .($periodo));
			$periodo = explode('-', $periodo);
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			$row=array();	
	        $db = My_Utils::connDB($config);


			$stmt = $db->query("SELECT fecha, nombreFestivo from festivos");

			$row = $stmt->fetchAll();

		}catch (Exception $e) {
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}

		$db->closeConnection();
        return $row;
	}

	/**
	*agrega nuevo feriado
	*@param string
	*@param string
	*@return mixed
	**/
	function setFestivos($fecha,$descripcion){
		try{
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
	        $db = My_Utils::connDB($config);

	        $stmt2 = $db->query("SELECT * from festivos where fecha = '$fecha'");


	        if (!$stmt2->rowCount()){
				$stmt = $db->query("INSERT into festivos (nombreFestivo, fecha)
								values ('$descripcion', '$fecha')");
			}
			else{
				My_Utils::log("no");
				return "No";
			}
		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			
		}


		$db->closeConnection();
		My_Utils::log("ok");
        return "Ok";
	}

	/**
	*eliminar feriado
	*@param string
	*@return string
	**/
	function borrarFestivo($fecha){
		try{
		$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
	    $db = My_Utils::connDB($config);

		$stmt = $db->query("DELETE from festivos where fecha = '$fecha'");

		}catch (Exception $e) {
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}

		$db->closeConnection();
        return "OK";
	}


	/**
	*otener todos los usuarios
	*@return mixed
	**/
	function getUsuarios(){

		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			$row=array();
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado mov '.print_r($config,1));
	        $stmt = $db->query("SELECT u.id as id_usuario, u.nombre, u.correo, u.rut, u.cargo, u.fecha_reg, u.horasMensuales, u.horasDiarias, u.uuid from usuarios u");
							
	        My_Utils::log('consulte usuarios');
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}

	/**
	*guarda nuevo usuario
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@return mixed
	**/	

	function setNuevoUsuario($nombre, $correo, $rut, $cargo, $horas){
		try{
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
	        $db = My_Utils::connDB($config);

	        $stmt2 = $db->query("SELECT id from usuarios where Rut = '$rut'");

	        My_Utils::log($stmt2->rowCount());
	        if ( !$stmt2->rowCount() ) {

			$stmt = $db->query("INSERT into usuarios (nombre, correo, cargo, Rut, horasDiarias)
								values ('$nombre', '$correo', '$cargo','$rut','$horas')");
			}
			else{
				$db->closeConnection();
				return "NO";
			}
		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
			
		}

		$db->closeConnection();
        return "OK";
	}

	/**
	*elimina usuario
	*@param string
	*@return mixed
	**/	
	function EliminarUsuario($id){
		try{

			$config = My_ConfigIni::getConfig()->resources->db->ovas;
	        $db = My_Utils::connDB($config);
			$db->query("DELETE from usuarios where id = '$id'");
			
			
		

		

		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}

		$db->closeConnection();
		return "OK";
	}

	/**
	*otener todos los usuarios
	*@param string
	*@return mixed
	**/
	function getUsuarioSeleccionado($id){

		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado mov '.print_r($config,1));
	        $stmt = $db->query("SELECT u.id as id_usuario, u.nombre, u.correo, u.rut, u.cargo,  u.horasDiarias as horas FROM usuarios u where 
						u.id = '$id'");
							
	        My_Utils::log('consulte usuarios');
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}


	/**
	*otener todos los usuarios
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@return mixed
	**/
	function updateUsuario($id,$nombre,$correo,$rut,$cargo,$horas){
		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			
	        $db = My_Utils::connDB($config);
	        

	        $stmt2 = $db->query("SELECT * from usuarios where
	         	rut = '$rut'");

	        if ( $stmt2->rowCount() ) {
	        	return "NO";
	        }

	        $stmt = $db->query("UPDATE usuarios 
	        	set nombre = '$nombre', correo = '$correo',
	        		cargo = '$cargo', rut = '$rut', horasDiarias = '$horas'
	        	where id = '$id'");
							
	        My_Utils::log('consulte usuarios');
	        
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}
        $db->closeConnection();
        return "OK";
	}
	
	/**
	*otener todos los usuarios
	*@return mixed
	**/
	function getAdmins(){

		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado mov '.print_r($config,1));
	        $stmt = $db->query("SELECT mad.id as id_admin, mad.usuario as nombreUsuario, mad.correo, mad.nombre
	        			FROM usuarios_adm mad");
							
	        My_Utils::log('consulte usuarios');
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}

/**
	*guarda nuevo adm
	*@param string
	*@param string
	*@param string
	*@param string
	*@return mixed
	**/
	function setNuevoAdmin($nombre, $nombre_usuario, $pass, $correo){
		try{
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
	        $db = My_Utils::connDB($config);
	        $stmt2 = $db->query("SELECT * from usuarios_adm where usuario = '$nombre_usuario'");

			if ( $stmt2->rowCount() ) {
	        	return "USUARIO";
	        }



	        $stmt2 = $db->query("SELECT * from usuarios_adm where correo = '$correo'");
			if ( $stmt2->rowCount() ) {
	        	return "CORREO";
	        }
			
			$stmt = $db->query("INSERT into usuarios_adm (nombre, usuario, clave, correo)
				values ('$nombre', '$nombre_usuario', MD5('$pass'), '$correo')");	
			
			
				

		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}
		$db->closeConnection();

		return "OK";
        
	}

	/**
	*elimina usuario
	*@param string
	*@return mixed
	**/	
	function EliminarAdmin($id){
		try{

			$config = My_ConfigIni::getConfig()->resources->db->ovas;
	        $db = My_Utils::connDB($config);
			$db->query("DELETE from usuarios_adm where id = '$id'");
		

		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NO";
		}

		$db->closeConnection();
		return "OK";
	}

	/**
	*otener todos los usuarios admin
	*@param string
	*@return mixed
	**/
	function getAdminSeleccionado($id){

		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			$row=array();	
	        $db = My_Utils::connDB($config);
	        My_Utils::log('conectado mov '.print_r($config,1));
	        $stmt = $db->query("SELECT u.nombre, u.correo, u.usuario, u.id FROM usuarios_adm u where u.id = '$id'");
							
	        My_Utils::log('consulte usuarios');
	        $row = $stmt->fetchAll();
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}


	/**
	*actualizar usuario
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@return mixed
	**/
	function updateAdmin($id,$nombre,$nombre_old,$correo,$correo_old,$usuario,$usuario_old,$pass,$pass_old){

		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			
	        $db = My_Utils::connDB($config);
	        if ($correo != $correo_old){
	        	$stmt2 = $db->query("SELECT * from usuarios_adm where correo = '$correo'");

	        	if ( !$stmt2->rowCount() ) {

                	$stmt = $db->query("UPDATE usuarios_adm 
		        		set correo = '$correo'
		     		   	where id = '$id'");
                }else
                	return "CORREO";
            }
            if ($usuario != $usuario_old) {
	        	$stmt2 = $db->query("SELECT * from usuarios_adm where usuario = '$usuario'");
                
	        	if ( !$stmt2->rowCount() ) {
                	$stmt = $db->query("UPDATE usuarios_adm 
	        			set usuario = '$usuario'
	     		   		where id = '$id'");
                }else{
                	return "USUARIO";
                }
            }

	        if ($nombre != $nombre_old) {
	        	
	        	
	        	
                $stmt = $db->query("UPDATE usuarios_adm 
	        		set nombre = '$nombre'
	     		   	where id = '$id'");
                
            }
            
            
            if ($pass != $pass_old || $pass != "") {
                $stmt = $db->query("UPDATE usuarios_adm 
	        		set clave = md5('$pass')
	     		   	where id = '$id'");
            }
            				
	        My_Utils::log('consulte usuarios:   '. $usuario);
	        
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}
        $db->closeConnection();
        return "OK";
	}


	/**
	*otener hora modificada
	*@param string
	*@return mixed
	**/
	function getHoraLog($id){
		$row = array();
		try{
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
	        $db = My_Utils::connDB($config);

	        $stmt = $db->query("SELECT fecha_modificacion, valor_old, valor_new, comentario
	        	from log_edicion where id = '$id'");

	        $row = $stmt->fetchAll();
		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}


	/**
	*@return mixed
	**/
	function getDependencias(){
		$row = array();
		try{
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
	        $db = My_Utils::connDB($config);

	        $stmt = $db->query("SELECT id, st_asText(area_valida) as area, detalle
	        	from dependencias");

	        $row = $stmt->fetchAll();
	        My_Utils::log(print_r($row,1));

		}catch(Exception $e){
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}
        $db->closeConnection();
        return $row;
	}




	/**
	*actualiza datos de dependencia
	*@param string
	*@param string
	*@param string
	*@param string
	*@param string
	*@return mixed
	**/
	function updateArea($id,$desc,$desc_old,$coord,$coord_old){

		try {
			
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
			
	        $db = My_Utils::connDB($config);
	        

	        if ($desc != $desc_old) {
	        	$stmt2 = $db->query("SELECT * from dependencias where detalle = '$desc'");

	        	if ( !$stmt2->rowCount() ) {
                	$stmt = $db->query("UPDATE dependencias 
	        			set detalle = '$desc'
	     		   		where id = '$id'");
                }else{
                	$db->closeConnection();
                	return "NO";
                }
            }
            My_Utils::log('stmr1:   '.$stmt);
            if ($coord != $coord_old){
                $stmt = $db->query("UPDATE dependencias 
	        		set area_valida = ST_PolygonFromText('$coord')
	     		   	where id = '$id'");
            }
            My_Utils::log('stmr2:   '.$stmt);
        	
            				
	        My_Utils::log('area valida cambiada:   ');
	        $db->closeConnection();
        	return "OK";
				        
		}
        catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}
        
	}
	
	/**
	*guarda nueva area
	*@param string
	*@param string
	*@return mixed
	**/
	function setNuevaArea($desc, $area){
		try{
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
	        $db = My_Utils::connDB($config);
	        $stmt2 = $db->query("SELECT * from dependencias where detalle = '$desc'");


			if ( !$stmt2->rowCount() ) {
				$stmt = $db->query("INSERT into dependencias (detalle, area_valida) values ('$desc', ST_PolygonFromText('$area'))");	
			}
			else
				return "NO";

		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}
		return "OK";
		$db->closeConnection();
	}

	/**
	*elimina area
	*@param string
	*@return mixed
	**/
	function eliminarArea($id){
		try{
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
	        $db = My_Utils::connDB($config);
	        


			
			$stmt = $db->query("DELETE from dependencias where id = '$id'");	
			
		}catch (Exception $e) {
			
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
			return "NOK";
		}
		$db->closeConnection();
		return "OK";
        
	}

	/**
	*elimina area
	*@param string
	*@return mixed
	**/
	function borrarUUID($id){
		try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
			
	        $db = My_Utils::connDB($config);
			
			$stmt = $db->query(" UPDATE usuarios set uuid = null where id = '$id'");			

		} catch (Exception $e) {
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}

		$db->closeConnection();
		return "Ok";
	}
	

	/**
     * getUsuario genera lista con datos de usuario.
     * @param string $user
     * @return mixed
     */
    public function getUsuario($user = null) {

        try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);

            $sql = "SELECT username, nombres, ape_paterno, ape_materno, clave, email, movil, estado FROM usuario";
            if ($user !== null) {
                $sql .= " WHERE username = '$user'";
            }

            $sql .= ";";
            $stmt = $db->query($sql);

# END CLASS WS
            $user = 0;
            while ($row = $stmt->fetch()) {
                // Instancia Bean de Proyecto
                $objUsuario[$user]["username"]      =   $row["username"];
                $objUsuario[$user]["nombres"]       =   $row["nombres"];
                $objUsuario[$user]["ape_paterno"]   =   $row["ape_paterno"];
                $objUsuario[$user]["ape_materno"]   =   $row["ape_materno"];
                $objUsuario[$user]["clave"]          =   $row["clave"];
                $objUsuario[$user]["e_mail"]        =   $row["email"];
                $objUsuario[$user]["movil"]         =   $row["movil"];
                $objUsuario[$user]["estado"]        =   $row["estado"];
                $user++;
            }
            My_Utils::log("LLEGUUEE".print_r($objUsuario,1));
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $objUsuario;
    }



/**
     * ver_lista_tareas genera una lista con las tareas ingresadas previamente a la BD.
     * @return mixed
     */
    public function ver_lista_per() {

        try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);

            $sql = "SELECT id_periodicidad,periodicidad FROM lista_periodicidad order by id_periodicidad";

            $stmt = $db->query($sql);
            
            while ($row = $stmt->fetch()) {
                // Instancia Bean de Proyecto
                $periodicidad[]      =   $row;

            }
            My_Utils::log("LLEGUUEE".print_r($periodicidad,1));
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $periodicidad;
    }



    /**
     * ver_lista_usuarios genera una lista con los usuarios almacenados en la BD
     * @return mixed
     */
    public function ver_lista_usuarios() {

        try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);

            $sql = "SELECT nombres FROM usuario where estado = 'A' ";

            $stmt = $db->query($sql);
            
            while ($row = $stmt->fetch()) {
                // Instancia Bean de Proyecto
                $nombres[]      =   $row["nombres"];

            }
            My_Utils::log("LLEGUUEE2".print_r($nombres,1));
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $nombres;
    }



 /**
     * ver_lista_tareas genera una lista con las tareas ingresadas previamente a la BD.
     * @return mixed
     */
    public function ver_lista_tareas() {

        try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);

            $sql = "SELECT id_tarea,nombre_tarea FROM lista_tareas  where id_tarea >0 order by nombre_tarea";

            $stmt = $db->query($sql);
            
            while ($row = $stmt->fetch()) {
                // Instancia Bean de Proyecto
                $nombre_tarea[]      =   $row;

            }
           // My_Utils::log("LLEGUUEE".print_r($nombre_tarea,1));
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $nombre_tarea;
    }

 	/**
     * desactivaUsuario.
     * @param string $user
     * @return mixed
     */
    public function desactivaUsuario($user) {

        try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);

            $sql = "UPDATE usuario SET estado = 'I' WHERE username = '$user'";


            $stmt = $db->query($sql);

            if($stmt){

            $resul = 'OK';
            }else{

            $resul = 'NOK'; 
            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $resul;
    }

 /**
     * setUsuario inserta o actualiza los datos de usuario.
     * @param string $username
     * @param string $nombres
     * @param string $ape_paterno
     * @param string $ape_materno
     * @param string $clave
     * @param string $e_mail
     * @param string $movil
     * @param string $estado
     * @return boolean
     */
    public function setUsuario($username, $nombres, $ape_paterno, $ape_materno,  $clave, $email, $movil, $estado = 'A') {
        $retorno = false;
        try {

           $config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);
            $sql = "INSERT INTO usuario (username, nombres, ape_paterno, ape_materno, clave, email, movil, estado, fecha_ultimo_acceso) VALUES ('$username','$nombres','$ape_paterno','$ape_materno', MD5('$clave'), '$email','$movil', '$estado', CURRENT_TIMESTAMP) ON DUPLICATE KEY UPDATE nombres = VALUES(nombres), ape_paterno = VALUES(ape_paterno), ape_materno = VALUES(ape_materno), clave = VALUES(clave), email = VALUES(email),  movil = VALUES(movil), estado = VALUES(estado), fecha_ultimo_acceso = CURRENT_TIMESTAMP;";

          //  My_Utils::log($sql);
            $stmt = $db->query($sql);
            if($stmt){
             $this->setPrimerPermiso($username);
             $retorno = true;

            }
            // if ($stmt->rowCount() > 0) {


            // }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $retorno;
    }



    /**
     * set primerpermiso.
     * @return boolean
     */
    public function setPrimerPermiso($username) {
        $retorno = false;
        try {

           $config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);
            $sql = "INSERT INTO permiso (username, id_menu, estado_permiso) "
                    . "VALUES ('$username',5,1) "
                    . "ON DUPLICATE KEY UPDATE estado_permiso = 1";
            $sql .= ";";
          //  My_Utils::log($sql);
            $stmt = $db->query($sql);
            if ($stmt->rowCount() > 0) {
                $retorno = true;
            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        return $retorno;
    }


	/**
	 * setTarea: Autentica usuarios
	 * @param string $id_tarea 
	 * @param string $descripcion 
	 * @param string $prioridad
	 * @param string $periodicidad
	 * @param string $fecha_inicio 
	 * @param string $fecha_hasta 
	 * @param string $responsable
	 * @return mixed
	 **/
	public function setTarea($id_tarea, $descripcion, $prioridad, $periodicidad, $fecha_inicio, $fecha_hasta, $responsable) {
       
        try {
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);


            My_Utils::log('cnc'.print_r($config,1));

			//$fecha=date("y-m-d");
			//sql-mode=”ALLOW_INVALID_DATES”

            $sql = "INSERT INTO nueva_tarea (id_tarea, descripcion, prioridad, periodicidad, fecha_inicio, fecha_hasta, responsable) VALUES ($id_tarea, '$descripcion', '$prioridad', $periodicidad, '$fecha_inicio 03:00:00', '$fecha_hasta 23:00:00', '$responsable')";
            $stmt = $db->query($sql);
          	if ($stmt) {
          		$row["estado"]='OK';
          		if ($periodicidad==5) {
          			//Diario
          		}
          		if ($periodicidad==6) {
          			//Semanal
          			while ($diaInicio<$diaFin || $mesInicio<$mesFin ) {
          					$mod_fecha_inicio= strtotime($fecha_inicio."+ 7 days");
          					//No terminada

          			}
          		}
          		if ($periodicidad==7) {
          			//Mensual
          			$inicio=explode("/", $fecha_inicio);
          			$fin=explode("/", $fecha_hasta);
          			$diaInicio= $inicio[0];  
  					$mesInicio= $inicio[1];  
  					$anyoInicio= $inicio[2]; 

  					$diaFin= $fin[0];  
  					$mesFin= $fin[1];  
  					$anyoFin= $fin[2]; 


  					//DATEPICKER -> DEBE INICIAR CON LA FECHA DONDE SE INICIA LA TAREA
  					// ELIMINAR LOS '0' QUE APARECEN AL INICIO EN TODAS LAS TAREAS
  					// ELIMINAR LA IMAGEN NO CARGADA QUE APARECE AL INSPECCIONAR
  					// ELIMINAR EL 2 DE ENERO DESTACADO
          		}




          	}
          				
			My_Utils::log("  ---  ".print_r($row,1));
            
			$db->closeConnection();
		}
		catch (Exception $e) {
			//$usuario->setBeanStatus(My_Constantes::STATUS_ERROR);
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}		
		//My_Utils::log("asdsdsdasdsd: " . print_r($usuario["id"]));
		return $row;
	}


	/**
	 * getTarea: Obtiene las variables necesarias para pintar el calendario
	 * @return mixed
	 **/
	public function getTarea() {
       
        try {
        	$resultado["estado"]='NOK';
			$config = My_ConfigIni::getConfig()->resources->db->ovas;
            
            $db = My_Utils::connDB($config);


            //My_Utils::log('cnc'.print_r($config,1));

            $sql = "SELECT B.id_tarea, periodicidad, fecha_inicio, fecha_hasta, responsable,B.descripcion
           ,nombre_tarea FROM nueva_tarea A, lista_tareas B WHERE A.id_tarea=B.id_tarea";
            $stmt = $db->query($sql);
          	if ($stmt) {
          	$resultado["estado"]='OK';
          	while ($row = $stmt->fetch()) {
                // Instancia Bean de Proyecto
                $nombre_tarea[]      =   $row;

            }
            $resultado["data"]=$nombre_tarea;
          	}


          				
			My_Utils::log("  ---  ".print_r($row,1));
            
			$db->closeConnection();

		}
		catch (Exception $e) {
			My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
			My_Utils::log($e->getTraceAsString(),false, Zend_Log::ERR);
		}		
		return $resultado;
	}


} // End Class