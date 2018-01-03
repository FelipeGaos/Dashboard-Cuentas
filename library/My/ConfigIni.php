<?php

Class My_ConfigIni {
	
    protected static $_config = null;
	
    public static function init() {	
		self::$_config=Zend_Registry::get('config');
	}
	
    /*
	 * return Zend_Config_Ini
	 */
	public static function getConfig() {
		self::init();
		return self::$_config;
	}
	
    public static function get($param) {
		self::init();
		return self::$_config->$param;
	}
} // End Class

//print_r($config);exit;
//echo $config->database->params->host;   // prints "dev.example.com"
//echo $config->database->params->dbname; // prints "dbname"