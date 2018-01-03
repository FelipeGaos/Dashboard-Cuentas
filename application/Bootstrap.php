<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	protected $_config=null;	
	
	protected function _initConfig() {
		/* NO AGREGAR LOG EN ESTA FUNCION, SI SE AGREGA, EL WSDL NO SE GENERA CORRECTAMENTE */
		$this->_config = new Zend_Config($this->getOptions(), true);
		Zend_Registry::set('config', $this->_config);
		return $this->_config;
	}
}
