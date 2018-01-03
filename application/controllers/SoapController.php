<?php
class SoapController extends Zend_Controller_Action {
    
    // ATRIBUTOS
    // ======================================================
	protected $_return = null;
    
    
    // METODOS
    // ======================================================
    
    
 	public function init() {
        //Zend_Controller_Front::getInstance()->setParam('noViewRenderer', true);
        //$this->_helper->layout->setLayout('emptyLayout');
        // Disable the main layout renderer
        $this->_helper->layout->disableLayout();
        // Do not even attempt to render a view
        $this->_helper->viewRenderer->setNoRender(true);
    }

    
    public function indexAction() {
		ini_set('max_execution_time',300);
		ini_set('default_socket_timeout',300);
		//My_Utils::log("Ingresa a SoapController");
		try {
			$wsdl_parametro=$this->_getParam('wsdl');
			$fullUrl=$this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . $this->getRequest()->getRequestUri();
			//My_Utils::log($fullUrl);
			$searchSt="/soap/index/";
			$soap_uri= substr($fullUrl,0,strpos($fullUrl,$searchSt)+strlen($searchSt));
			//My_Utils::log("soap_uri:".$soap_uri);
            
			if (isset($wsdl_parametro) && $wsdl_parametro == "print") {
				$autodiscover = new Zend_Soap_AutoDiscover();
				$autodiscover->setClass('My_WebServices_SoapFunctions');
				$autodiscover->setUri($soap_uri);
				$autodiscover->handle();
			} 
            else {
				$wsdl_file = $soap_uri ."wsdl/print";
				$soap = new Zend_Soap_Server($wsdl_file, array('encoding' => 'UTF-8'));
				$soap->setClass('My_WebServices_SoapFunctions');
				$soap->setObject(new My_WebServices_SoapFunctions());
				$soap->handle();
			}
		}
		catch (Exception $e) {
			My_Utils::log($e->getMessage(),true);
			My_Utils::log(print_r($e->getTraceAsString(), true),true);
		}		
	}
    
} //  End Class