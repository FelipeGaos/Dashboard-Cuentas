<?php
class My_Log_WriterStream extends Zend_Log_Writer_Stream {

	protected function _write($event) {

		$backtrace = debug_backtrace();

		foreach($backtrace as $traceItem) {
			$class = $traceItem['class'];
			if(!is_subclass_of($class, 'Zend_Log') &&
			!is_subclass_of($class, 'Zend_Log_Writer_Abstract') &&
			$class !== 'Zend_Log' &&
			$class !== 'Zend_Log_Writer_Abstract') {
				break;
			}
		}

		$event['file'] = basename($traceItem['file']); // solo nombre de archivo
		$event['line'] = $traceItem['line']; 
		$event['time'] = My_Utils::getFullDate(); // fecha con milisegundos
		$event['pid']= getmypid(); // process ID
		parent::_write($event); 
	}
}	
?>	