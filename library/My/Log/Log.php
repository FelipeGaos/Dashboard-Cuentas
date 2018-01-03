<?php

class My_Log_Log {

protected $_logger=null;
function __construct() {
	
$stream = @fopen(APPLICATION_PATH . '/../log-'.date('Y.m.d').'.txt', 'a', false);
if (! $stream) {
    throw new Exception('Failed to open stream');
}
//$format = utils::getFullDate() . ' ['.getmypid().'] %priorityName% (%priority%):%file%:%line%:%message%' . PHP_EOL; 
$format = '%time% [%pid%] %priorityName% :%file%:%line%:%message%' . PHP_EOL;
$formatter = new Zend_Log_Formatter_Simple($format);

//$writer = new Zend_Log_Writer_Stream('php://output'); // BROWSER
//$writer = new Zend_Log_Writer_Stream($stream);
$writer = new My_Log_WriterStream($stream);
$writer->setFormatter($formatter);
$this->_logger = new Zend_Log($writer);

/*
$format = '%file% %line% %message%' . PHP_EOL;
$formatter = new Zend_Log_Formatter_Simple($format);
$writer = new My_Log_Writer_Stream('file://' . $traceLogPath);
$writer->setFormatter($formatter);
$log = new Zend_Log($writer);*/

//$logger->info('Informational message');
}
function getLogger() {
	return $this->_logger;
}
}
?>