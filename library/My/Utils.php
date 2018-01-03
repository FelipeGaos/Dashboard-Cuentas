<?php

class My_Utils {
    /*
     * @return Zend_Db::factory
     */
	const DEFAULT_JPGRAPH_VALUE = null;
	const DEFAULT_MAX = -1;
	const DEFAULT_FORMAT = '%.3f';
	const HTML_DEV = 'dev';
	
	private $iniTime;
	private $endTime;
	    
	public function getendTime() {
	  return $this->endTime;
	}
	
	public function setendTime() {
	  $this->endTime = time();
	}	    
	public function getiniTime() {
	  return $this->iniTime;
	}
	
	public function setiniTime() {
	  $this->iniTime = time();
	}
	public function getTotalTime() {
		return $this->endTime-$this->iniTime;
	}
	
	public static function getLogger() {
		//require_once dirname(__FILE__).'/incluye_common.php';
		$MyLog = new My_Log_Log();
		return $MyLog->getLogger();
	}
    
	/*
	 * Day of Week
	 * $fecha en formato dd/mm/yyyy o dd/mm/yyyy-[HH]
	 */
	public static function dow($fecha) {
		$f = explode("/", $fecha);
		if (count($f) >= 3 && (strpos($f[2], '-') > 0)) {
			$ff = explode("-", $f[2]);
			$f[2] = $ff[0];
		}
		
        $dias = array(1=>'Lunes',2=>'Martes',3=>'Miercoles',4=>'Jueves',5=>'Viernes',6=>'Sabado',0=>'Domingo');
		$dia = strtotime("${f[2]}-${f[1]}-${f[0]}");
		$dia = date('w',$dia);
		return $dias[$dia];	
	}
	
    /*
	 * Day of Week
	 * $fecha en formato yyyy-mm-dd
	 * retorna 0 para el Domingo, 1 para Lunes y 6 para Sabado
	 */
	public static function nDow($fecha) {
		$yyyymmdd = explode("-", $fecha);
		$dia = strtotime("${yyyymmdd[0]}-${yyyymmdd[1]}-${yyyymmdd[2]}");
		$dia = date('w',$dia);
		return $dia;	
	}
		
    public static function connDB($config) {
		//$config = My_ConfigIni::getConfig()->resources->db->plantilla;
		$dbconfig = array(
            'host'     => $config->host,
            'username' => $config->username,
            'password' => $config->password,
            'dbname'   => $config->dbname,
            'port'   => $config->port,
            'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8;')
		);
	
		$db = Zend_Db::factory($config->adapter, $dbconfig);
		return $db;
	}	
	
	/*
	 * EMERG   = 0;  // Emergency: system is unusable
	 * ALERT   = 1;  // Alert: action must be taken immediately
	 * CRIT    = 2;  // Critical: critical conditions
	 * ERR     = 3;  // Error: error conditions
	 * WARN    = 4;  // Warning: warning conditions
	 * NOTICE  = 5;  // Notice: normal but significant condition
	 * INFO    = 6;  // Informational: informational messages
	 * DEBUG   = 7;  // Debug: debug messages
	 */
	public static function log($msg, $force = false, $tipo = Zend_Log::DEBUG) {
		if (My_ConfigIni::get('debug') == "1" || $force) {
			$logger = self::getLogger();
			$logger->log("${msg}", $tipo);
		}
	}

    public static function getMonday($fecha) { // DD/MM/YYYY
		$fd = explode("/", $fecha);
		$fechaTime = strtotime("$fd[2]$fd[1]$fd[0]");
		$week = date('Y\WW', $fechaTime); // retorna YYYYW
		$monday = date('d/m/Y', strtotime("${week}"));
		return $monday; 
	}

    public static function getSunday($fecha) { // DD/MM/YYYY
		$fd = explode("/", $fecha);
		$fechaTime = strtotime("$fd[2]$fd[1]$fd[0]");
		$week = date('Y\WW', $fechaTime); // retorna YYYYW
		$sunday = date('d/m/Y',strtotime("sunday",$fechaTime));
		return $sunday;
	}
	
    public static function echo_memory_usage() {
		$mem_usage = memory_get_peak_usage(true);	
	
        if ($mem_usage < 1024)
			$ret = $mem_usage." B";
		elseif ($mem_usage < 1048576)
			$ret = round($mem_usage/1024,2)." KB";
		else
			$ret = round($mem_usage/1048576,2)." MB";
		
        return $ret;
	}
    
	public static function getFullDate() {
		list($usec, $sec) = explode(" ", microtime());
		return date('Y.m.d H:i:s.',$sec) . floor($usec * 1000);
	}
        
    public static function file_get_curl($url) {
        $ch = curl_init();
        //$headers["Content-Length"] = strlen($postString);
        $headers["User-Agent"] = "Curl/1.0";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, 'admin:');
        curl_setopt($ch,CURLOPT_TIMEOUT,My_ConfigIni::get('curl')->timeout);
        $resultado = curl_exec($ch);
        curl_close($ch);
        return $resultado;
    }
    
    public static function convertArrayKeysToUtf8(array $array) { 
    $convertedArray = array(); 
    foreach($array as $key => $value) { 
        if(!mb_check_encoding($key, 'UTF-8')) 
                $key = utf8_encode($key); 
        
        if(is_array($value)) 
            $value = My_Utils::convertArrayKeysToUtf8($value); 

        $convertedArray[$key] = $value; 
    } 
    return $convertedArray; 
  }
  
    public function fechaDefault($client, &$fechasReq) {
        $fecha = "";
        $fecha_hoy = date('d-m-Y');
        $year = date("Y");
        $fechasReq = $client->getFechasReq($year);
        //My_Utils::log(print_r($fechasReq,1));
  	
        if (isset($fechasReq) && is_array($fechasReq)) {
            $fecha = end($fechasReq);
            My_Utils::log($fecha);
            
            $fecha = date('d-m-Y',strtotime($fecha));
            reset($fechasReq);
        }
        else {
  		$fecha = $fecha_hoy;
  	}
  	My_Utils::log($fecha);
  	return $fecha;
  }
  
  /**
   * Corta la primera linea de un buffer con saltos de linea
   * @param string $buffer
   * @return string
   */
    public static function cutFirstLine($buffer) {
  		// cut first line
  		$buf = "";
  		//My_Utils::log($buffer);
  		
        if (strlen($buffer)>0) {
	  		$buf = explode("\n", $buffer);
	  		//My_Utils::log(print_r($buf,1));
	  		if (count($buf)>0) {
	  			unset($buf[0]);
	  		}
	  		$buf = implode("\n", $buf);
  		}
  		return trim($buf);
  }
  /**
   * Corta la primeras N lineas de un buffer con saltos de linea y retorna un arreglo
   * @param string $buffer
   * @return array
   */
    public static function cutFirstLineArray($buffer, $N = 1) {
  
        // cut first line
        $buf = array(); $buf_new = array();
        //My_Utils::log($buffer);
        if (strlen($buffer) > 0) {
            $buf = explode("\n", $buffer);
            //My_Utils::log(print_r($buf,1));

            if (count($buf)> 0) {
                foreach ($buf as $k => $v) {
                    if ($k < $N)
                        unset($buf[$k]);
                    else
                        break;
                }
                // reordena
                $i = 1;
                foreach ($buf as $k => $v) {
                    //$k=trim($k);
                    $v = trim($v);
                    //$buf[$k] = str_replace("\r", "", $v);
                    $buf_new[$i] = str_replace("\r", "", $v);
                    $i++;
                }
                $buf = $buf_new;	
            }
        }
        return $buf;
    }
  
} // End Class