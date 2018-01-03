<?php

$db = My_Utils::connOsvi();
$username = $this->session->username->username;

if (! empty ( $_POST ["ccndc"] ))
$ccndc	= $_POST ["ccndc"];
$stmt = $db->query( "INSERT INTO _voice_tmp (id_ir21, login, type, valor) VALUES ($id, $username, 'E164', $ccndc)");
echo "Network Nodes Global Titles:<br/>";
echo "<pre>";
print_r ( $ccndc );
echo "</pre>";

if (! empty ( $_POST ["mccmnc"] ))
$mccmnc	= $_POST ["mccmnc"];
$stmt = $db->query( "INSERT INTO _voice_tmp (id_ir21, login, type, valor) VALUES ($id, $username, 'E212', $mccmnc)");
echo "Number Series - (Rangos IMSIS):<br/>";
echo "<pre>";
print_r ( $mccmnc );
echo "</pre>";

if (! empty ( $_POST ["ccnc"] ))
$ccnc	= $_POST ["ccnc"];
$stmt = $db->query( "INSERT INTO _voice_tmp (id_ir21, login, type, valor) VALUES ($id, $username, 'E214', $ccnc)");
echo "Mobile Global Title (MGT):<br/>";
echo "<pre>";
print_r ( $ccnc );
echo "</pre>";

if (! empty ( $_POST ["mncmcc"] ))
$mncmcc	= $_POST ["mncmcc"];
$stmt = $db->query( "INSERT INTO _data_tmp (id_ir21, login, type, valor) VALUES ($id, $username, 'APN', $mncmcc)");
echo "Domain Name System (DNS):<br/>";
echo "<pre>";
print_r ( $mncmcc );
echo "</pre>";

if (! empty ( $_POST ["gprs"] ))
$gprs	= $_POST ["gprs"];
$stmt = $db->query( "INSERT INTO _data_tmp (id_ir21, login, type, valor) VALUES ($id, $username, 'GPRS', $gprs)");
echo "Rangos de IP en Firewall:<br/>";
echo "<pre>";
print_r ( $gprs );
echo "</pre>";

if (! empty ( $_POST ["rif"] ))
$rif	= $_POST ["rif"];
$stmt = $db->query( "INSERT INTO _data_tmp (id_ir21, login, type, valor) VALUES ($id, $username, 'IAR', $rif)");
echo "Serving GPRS Support Node:<br/>";
echo "<pre>";
print_r ( $rif );
echo "</pre>";






?>