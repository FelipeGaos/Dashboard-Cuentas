<html>
<head>
</head>
<title>Generador WO IR21</title>
<body>
	<div id="body">
		<div id="titulo">
			<div id="txtitulo">
				<center>
					<font size=6> Work Order IR21 </font>
				</center>
			</div>
	   </div>
<?php
$NODO [0] = "CHMBC01";
$NODO [1] = "SAMBC01";
$NODO [2] = "ANMS01";
$NODO [3] = "GMSC01";
$NODO [4] = "GMSS01";
$NODO [5] = "SAMS01";
$NODO [6] = "SAMSS02";
$NODO [7] = "IQMBC01";
$NODO [8] = "VAMSS01";
$NODO [9] = "RAMSS01";
$NODO [10] = "COMSS01";
$NODO [11] = "PMMSS01";
$NODO [12] = "SAMBC02";
$NODO [13] = "PAMS01";
$NODO [14] = "SAH02";
$NODO [15] = "SAH03";
$NODO [16] = "SAH04";
$NODO [17] = "SAH05";
$NODO [18] = "SAH06";
$NODO [19] = "SAH07";
$NODO [20] = "SAH08";
$NODO [21] = "SAH09";
$NODO [22] = "SAH11";
$NODO [23] = "SAMBC02";

// PARA GT
for($i = 0; $i < sizeof ( $NODO ); $i ++) {
	if (isset ( $_POST ['CB1_' . $NODO [$i]] )) {
		$CB1_NODO [$i] = $_POST ['CB1_' . $NODO [$i]];
	} else {
		$CB1_NODO [$i] = "off";
	}
}

// PARA IMSIS
for($i = 0; $i < sizeof ( $NODO ); $i ++) {
	if (isset ( $_POST ['CB2_' . $NODO [$i]] )) {
		$CB2_NODO [$i] = $_POST ['CB2_' . $NODO [$i]];
	} else {
		$CB2_NODO [$i] = "off";
	}
}

// PARA MGT
for($i = 0; $i < sizeof ( $NODO ); $i ++) {
	if (isset ( $_POST ['CB3_' . $NODO [$i]] )) {
		$CB3_NODO [$i] = $_POST ['CB3_' . $NODO [$i]];
	} else {
		$CB3_NODO [$i] = "off";
	}
}

if (isset($_POST ['pais']))
$PAIS = $_POST ['pais'];

if (isset($_POST ['operador']))
$OPERADOR = $_POST ['operador'];

if (isset($_POST ['fechair21']))
$FECHAIR21 = $_POST ['fechair21'];

$FECHA = date ( "d_m_y" );

if (isset($_POST ['nombre']))
$NOMBRE = $_POST ['nombre'];

if (isset($_POST ['fono']))
$FONO = $_POST ['fono'];

if (isset($_POST ['Proveedor']))
$PROVEEDOR = $_POST ['Proveedor'];

if (isset($_POST ['NP1']))
$NP1 = $_POST ['NP1'];

if (isset($_POST ['NP1E']))
$NP1E = $_POST ['NP1E'];

if (isset($_POST ['IMSI']))
$IMSI = $_POST ['IMSI'];

if (isset($_POST ['IMSINP7']))
$IMSINP7 = $_POST ['IMSINP7'];

if (isset($_POST ['NP7']))
$NP7 = $_POST ['NP7'];

if (isset($_POST ['DNS'])){
$DNS = $_POST ['DNS'];}else{
   $DNS = "0";
}

if (isset($_POST ['FW1']))
$FW1 = $_POST ['FW1'];

if (isset($_POST ['FW2']))
$FW2 = $_POST ['FW2'];

if (isset($_POST ['SGSN1A']))
$SGSN1A = $_POST ['SGSN1A'];

if (isset($_POST ['SGSN2A']))
$SGSN2A = $_POST ['SGSN2A'];

if (isset($_POST ['SGSN1B']))
$SGSN1B = $_POST ['SGSN1B'];

if (isset($_POST ['SGSN2B']))
$SGSN2B = $_POST ['SGSN2B'];

$GTA = str_getcsv ( $NP1, "\n" );
$GTE = str_getcsv ( $NP1E, "\n" );

?>


<div id="tabla1">
			<center>
				<div id="espacio1">
<?php
$fp1 = fopen ( 'WO_' . $FECHA . '_' . $PAIS . '_' . $OPERADOR . '_VOZ.txt', "w+" );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! *** 		       ROAMING DATA 								" . PHP_EOL );
fwrite ( $fp1, "! ***			WO  $FECHAIR21 								" . PHP_EOL );
fwrite ( $fp1, "! ***			PREP  : $NOMBRE 								" . PHP_EOL );
fwrite ( $fp1, "! ***			PHONE : $FONO 								" . PHP_EOL );
fwrite ( $fp1, "! ***			DATE  : $FECHA     							" . PHP_EOL );
fwrite ( $fp1, "! ***			REV   : A 									" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ***			COMMENTS:									" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ***			$PAIS - $OPERADOR 							" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ***			I. E.164 Global Title Series Translation				" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ****************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );

for($i = 0; $i < sizeof ( $CB1_NODO ); $i ++) {
	if ($CB1_NODO [$i] == "on") {
		if ($NODO [$i] == "GMSC01") {
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! ***									$NODO[$i]			" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];								" . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];									" . PHP_EOL );
			}
			fwrite ( $fp1, "C7TZI;															" . PHP_EOL );
			fwrite ( $fp1, "C7TCI;															" . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSE:TT=0, NP=1, NA=4, NS=$GTE[$j];								" . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				if ($PROVEEDOR == 'TATA') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=20;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'SYNIVERSE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=24;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'VODAFONE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=21;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'COMFONE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=29;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
					fwrite ( $fp1, "C7GSC:TT=0, NP=1, NA=4, NS=$GTA[$j], MTT=21, MNP=1, MNA=4;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
			}
			fwrite ( $fp1, "C7TAI;                                                                      " . PHP_EOL );
			fwrite ( $fp1, "C7GSP:COMP;                                                                 " . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];                                " . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];                                " . PHP_EOL );
			}
			fwrite ( $fp1, "" . PHP_EOL );
			fwrite ( $fp1, "!***	C7TAR;	SOLO EN CASO DE PROBLEMAS	                           " . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
		} 

		else if ($NODO [$i] == "GMSS01" && $PROVEEDOR == 'SYNIVERSE') {
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! ***								$NODO[$i]				" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];                                            " . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];                                            " . PHP_EOL );
			}
			fwrite ( $fp1, "C7TZI;                                                                      " . PHP_EOL );
			fwrite ( $fp1, "C7TCI;                                                                      " . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSE:TT=0, NP=1, NA=4, NS=$GTE[$j];                                            " . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				if ($PROVEEDOR == 'TATA') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'SYNIVERSE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=25;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'VODAFONE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'COMFONE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
					// ~ fwrite($fp1, "C7GSC:TT=0, NP=1, NA=4, NS=$GTA[$j], MTT=21, MNP=1, MNA=4; ! $PAIS - $OPERADOR ! " . PHP_EOL);
				}
			}
			fwrite ( $fp1, "C7TAI;                                                                      " . PHP_EOL );
			fwrite ( $fp1, "C7GSP:COMP;                                                                 " . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];								" . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];									" . PHP_EOL );
			}
			fwrite ( $fp1, "																			" . PHP_EOL );
			fwrite ( $fp1, "!***	C7TAR;	SOLO EN CASO DE PROBLEMAS									" . PHP_EOL );
			fwrite ( $fp1, "																			" . PHP_EOL );
		} 

		else if (preg_match ( '#SAH#', $NODO [$i] )) {
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "! ***																		" . PHP_EOL );
			fwrite ( $fp1, "! ***									$NODO[$i]							" . PHP_EOL );
			fwrite ( $fp1, "! ***																		" . PHP_EOL );
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];                                            " . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];                                            " . PHP_EOL );
			}
			fwrite ( $fp1, "C7TZI;                                                                      " . PHP_EOL );
			fwrite ( $fp1, "C7TCI;                                                                      " . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSE:TT=0, NP=1, NA=4, NS=$GTE[$j];                                            " . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				if ($PROVEEDOR == 'TATA') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'SYNIVERSE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=24;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'VODAFONE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
				}
				if ($PROVEEDOR == 'COMFONE') {
					fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
					// ~ fwrite($fp1, "C7GSC:TT=0, NP=1, NA=4, NS=$GTA[$j], MTT=21, MNP=1, MNA=4; ! $PAIS - $OPERADOR ! " . PHP_EOL);
				}
			}
			fwrite ( $fp1, "C7TAI;                                                                      " . PHP_EOL );
			fwrite ( $fp1, "C7GSP:COMP;                                                                 " . PHP_EOL );
			if (! empty ( $GTE [0] )) {
				for($j = 0; $j < sizeof ( $GTE ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];                                     " . PHP_EOL );
				}
			}
			for($j = 0; $j < sizeof ( $GTA ); $j ++) {
				fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];                                         " . PHP_EOL );
			}
			fwrite ( $fp1, "" . PHP_EOL );
			fwrite ( $fp1, "!***	C7TAR;	SOLO EN CASO DE PROBLEMAS	                                 " . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
		} else {
			if ($NODO [$i] != "GMSS01") {
				fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
				fwrite ( $fp1, "! ***													" . PHP_EOL );
				fwrite ( $fp1, "! ***                           $NODO[$i]                                       " . PHP_EOL );
				fwrite ( $fp1, "! ***													" . PHP_EOL );
				fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
				fwrite ( $fp1, "" . PHP_EOL );
				fwrite ( $fp1, "" . PHP_EOL );
				if (! empty ( $GTE [0] )) {
					for($j = 0; $j < sizeof ( $GTE ); $j ++) {
						fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];                                            " . PHP_EOL );
					}
				}
				for($j = 0; $j < sizeof ( $GTA ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];                                            " . PHP_EOL );
				}
				fwrite ( $fp1, "C7TZI;                                                                      " . PHP_EOL );
				fwrite ( $fp1, "C7TCI;                                                                      " . PHP_EOL );
				if (! empty ( $GTE [0] )) {
					for($j = 0; $j < sizeof ( $GTE ); $j ++) {
						fwrite ( $fp1, "C7GSE:TT=0, NP=1, NA=4, NS=$GTE[$j];                                            " . PHP_EOL );
					}
				}
				for($j = 0; $j < sizeof ( $GTA ); $j ++) {
					if ($PROVEEDOR == 'TATA') {
						fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
					}
					if ($PROVEEDOR == 'SYNIVERSE') {
						fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=25;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
					}
					if ($PROVEEDOR == 'VODAFONE') {
						fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
					}
					if ($PROVEEDOR == 'COMFONE') {
						fwrite ( $fp1, "C7GSI:TT=0, NP=1, NA=4, NS=$GTA[$j], GTRC=65;  ! $PAIS - $OPERADOR !            " . PHP_EOL );
						// ~ fwrite($fp1, "C7GSC:TT=0, NP=1, NA=4, NS=$GTA[$j], MTT=21, MNP=1, MNA=4; ! $PAIS - $OPERADOR ! " . PHP_EOL);
					}
				}
				fwrite ( $fp1, "C7TAI;														" . PHP_EOL );
				fwrite ( $fp1, "C7GSP:COMP;													" . PHP_EOL );
				for($j = 0; $j < sizeof ( $GTA ); $j ++) {
					fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTA[$j];					" . PHP_EOL );
				}
				if (! empty ( $GTE [0] )) {
					for($j = 0; $j < sizeof ( $GTE ); $j ++) {
						fwrite ( $fp1, "C7GSP:TT=0, NP=1, NA=4, NS=$GTE[$j];				" . PHP_EOL );
					}
				}
				fwrite ( $fp1, "															" . PHP_EOL );
				fwrite ( $fp1, "!***	C7TAR;	SOLO EN CASO DE PROBLEMAS	                " . PHP_EOL );
				fwrite ( $fp1, "															" . PHP_EOL );
			}
		}
	}
}

fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ***							II. IMSIS					" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );

$largoimsi = strlen ( $IMSI );
for($i = 0; $i < sizeof ( $CB2_NODO ); $i ++) {
	if ($CB2_NODO [$i] == "on") {
		fwrite ( $fp1, "! ************************************************************************* " . PHP_EOL );
		fwrite ( $fp1, "! ***																		" . PHP_EOL );
		fwrite ( $fp1, "! ***								$NODO[$i]								" . PHP_EOL );
		fwrite ( $fp1, "! ***																		" . PHP_EOL );
		fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
		fwrite ( $fp1, "																			" . PHP_EOL );
		fwrite ( $fp1, "MGISP:IMSIS=$IMSI;															" . PHP_EOL );
		fwrite ( $fp1, "MGIZI;																		" . PHP_EOL );
		fwrite ( $fp1, "MGICI;																		" . PHP_EOL );
		fwrite ( $fp1, "MGISI:IMSIS=$IMSI, M=$largoimsi-$IMSINP7, NA=4, ANRES=OBA-300& BO-167& ERIS-0& MAPVER-2& CBA-$IMSINP7[0]$IMSINP7[1]& CBAZ-1$IMSINP7[0]$IMSINP7[1]& CAMEL-0;    ! $PAIS - $OPERADOR ! " . PHP_EOL );
		fwrite ( $fp1, "MGISP:IMSIS=$IMSI,NOP;														" . PHP_EOL );
		fwrite ( $fp1, "MGIAI;																		" . PHP_EOL );
		fwrite ( $fp1, "MGISP:IMSIS=$IMSI;															" . PHP_EOL );
		fwrite ( $fp1, "																			" . PHP_EOL );
	}
}

fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! ***					III. E.214 Mobile Global Title (MGT)		" . PHP_EOL );
fwrite ( $fp1, "! ***													" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp1, "" . PHP_EOL );

for($i = 0; $i < sizeof ( $CB3_NODO ); $i ++) {
	if ($CB3_NODO [$i] == "on") {
		if ($NODO [$i] == "GMSC01") {
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! ***								$NODO[$i]				" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "														" . PHP_EOL );
			
			if ($PROVEEDOR == 'SYNIVERSE') {
				fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;							" . PHP_EOL );
				fwrite ( $fp1, "C7TZI;												" . PHP_EOL );
				fwrite ( $fp1, "C7TCI;												" . PHP_EOL );
				fwrite ( $fp1, "C7GSI:TT=0, NP=7, NA=4, NS=$NP7, GTRC=24;  ! $PAIS - $OPERADOR !		" . PHP_EOL );
				fwrite ( $fp1, "C7TAI;												" . PHP_EOL );
				fwrite ( $fp1, "C7GSP:COMP;											" . PHP_EOL );
				fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                          " . PHP_EOL );
			} else if ($PROVEEDOR == 'COMFONE') {
				fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                          " . PHP_EOL );
			} else {
				fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                          " . PHP_EOL );
				fwrite ( $fp1, "C7TZI;                                                                    " . PHP_EOL );
				fwrite ( $fp1, "C7TCI;                                                                    " . PHP_EOL );
				fwrite ( $fp1, "C7GSI:TT=0, NP=7, NA=4, NS=$NP7, GTRC=20;  ! $PAIS - $OPERADOR !          " . PHP_EOL );
				fwrite ( $fp1, "C7TAI;                                                                    " . PHP_EOL );
				fwrite ( $fp1, "C7GSP:COMP;                                                               " . PHP_EOL );
				fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                          " . PHP_EOL );
			}
			
			fwrite ( $fp1, "														" . PHP_EOL );
			fwrite ( $fp1, "!***	C7TAR;	SOLO EN CASO DE PROBLEMAS	                              " . PHP_EOL );
			fwrite ( $fp1, "														" . PHP_EOL );
		} else if ($NODO [$i] == "GMSS01") {
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! ***								$NODO[$i]				" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
			fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                            " . PHP_EOL );
			fwrite ( $fp1, "C7TZI;                                                                      " . PHP_EOL );
			fwrite ( $fp1, "C7TCI;                                                                      " . PHP_EOL );
			
			if ($PROVEEDOR == 'SYNIVERSE') {
				fwrite ( $fp1, "C7GSI:TT=0, NP=7, NA=4, NS=$NP7, GTRC=25;  ! $PAIS - $OPERADOR !       " . PHP_EOL );
			} else {
				fwrite ( $fp1, "C7GSI:TT=0, NP=7, NA=4, NS=$NP7, GTRC=66;  ! $PAIS - $OPERADOR !       " . PHP_EOL );
			}
			fwrite ( $fp1, "C7TAI;                                                                       " . PHP_EOL );
			fwrite ( $fp1, "C7GSP:COMP;                                                                  " . PHP_EOL );
			fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                             " . PHP_EOL );
			fwrite ( $fp1, "                                                                             " . PHP_EOL );
			fwrite ( $fp1, "!***	C7TAR;	SOLO EN CASO DE PROBLEMAS	                           " . PHP_EOL );
			fwrite ( $fp1, "                                                                             " . PHP_EOL );
		} else {
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! ***								$NODO[$i]				" . PHP_EOL );
			fwrite ( $fp1, "! ***													" . PHP_EOL );
			fwrite ( $fp1, "! *************************************************************************	" . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
			fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                                " . PHP_EOL );
			fwrite ( $fp1, "C7TZI;                                                                          " . PHP_EOL );
			fwrite ( $fp1, "C7TCI;                                                                          " . PHP_EOL );
			
			if ($PROVEEDOR == 'SYNIVERSE') {
				fwrite ( $fp1, "C7GSI:TT=0, NP=7, NA=4, NS=$NP7, GTRC=25;  ! $PAIS - $OPERADOR !    	" . PHP_EOL );
			} else {
				fwrite ( $fp1, "C7GSI:TT=0, NP=7, NA=4, NS=$NP7, GTRC=66;  ! $PAIS - $OPERADOR !   		" . PHP_EOL );
			}
			
			fwrite ( $fp1, "C7TAI;                                                                          " . PHP_EOL );
			fwrite ( $fp1, "C7GSP:COMP;                                                                     " . PHP_EOL );
			fwrite ( $fp1, "C7GSP:TT=0, NP=7, NA=4, NS=$NP7;                                                " . PHP_EOL );
			fwrite ( $fp1, "                                                                                " . PHP_EOL );
			fwrite ( $fp1, "!***	C7TAR;	SOLO EN CASO DE PROBLEMAS                                   " . PHP_EOL );
			fwrite ( $fp1, "" . PHP_EOL );
		}
	}
}
fclose ( $fp1 );
$fp2 = fopen ( 'WO_' . $FECHA . '_' . $PAIS . '_' . $OPERADOR . '_DATOS.txt', "w+" );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! ***																		" . PHP_EOL );
fwrite ( $fp2, "! ***				ROAMING DATA											" . PHP_EOL );
fwrite ( $fp2, "! ***				WO  $FECHAIR21											" . PHP_EOL );
fwrite ( $fp2, "! ***				PREP  : $NOMBRE											" . PHP_EOL );
fwrite ( $fp2, "! ***				PHONE : $FONO											" . PHP_EOL );
fwrite ( $fp2, "! ***				DATE  : $FECHA											" . PHP_EOL );
fwrite ( $fp2, "! ***				REV   : A												" . PHP_EOL );
fwrite ( $fp2, "! ***																		" . PHP_EOL );
fwrite ( $fp2, "! ***				COMMENTS:												" . PHP_EOL );
fwrite ( $fp2, "! ***																		" . PHP_EOL );
fwrite ( $fp2, "! ***				$PAIS - $OPERADOR										" . PHP_EOL );
fwrite ( $fp2, "! ***																		" . PHP_EOL );
fwrite ( $fp2, "! ***																		" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! ***																		" . PHP_EOL );
fwrite ( $fp2, "! ***				I. GPRS DNSs datos a configurar							" . PHP_EOL );
fwrite ( $fp2, "! ***																		" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "! *** Corregir DNS en carpetas ROAMING y HOME, debe quedar identico " . PHP_EOL );
fwrite ( $fp2, "! *** a lo que sigue:" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "$DNS" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );

fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! ***													" . PHP_EOL );
fwrite ( $fp2, "! ***				II. GPRS Firewall datos a configurar			" . PHP_EOL );
fwrite ( $fp2, "! ***													" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "! *** Eliminar los siguientes rangos:" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "$FW1" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "! *** Agregar los siguientes rangos:" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "$FW2" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );

fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! ***                                                                           " . PHP_EOL );
fwrite ( $fp2, "! ***					III.i GPRS DNSs datos SGSN a configurar		" . PHP_EOL );
fwrite ( $fp2, "! ***                                                                           " . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );
if (! empty ( $SGSN1A ) && ! empty ( $SGSN2A )) {
	fwrite ( $fp2, "! *** Configurar los siguientes datos en SASG04, SASG05, SASG06, SASG07, SASG08 y SASG09    " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "SASG04: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	$largosgsn = strlen ( $SGSN1A );
	
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1A " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1A ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1A[3]$SGSN1A[4]$SGSN1A[5].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1A ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1A[3]$SGSN1A[4].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2A " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	
	fwrite ( $fp2, "SASG05: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1A " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1A ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1A[3]$SGSN1A[4]$SGSN1A[5].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1A ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1A[3]$SGSN1A[4].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2A " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	
	fwrite ( $fp2, "SASG06: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1A " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1A ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1A[3]$SGSN1A[4]$SGSN1A[5].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1A ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1A[3]$SGSN1A[4].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2A " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	
	fwrite ( $fp2, "SASG07: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1A " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1A ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1A[3]$SGSN1A[4]$SGSN1A[5].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1A ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1A[3]$SGSN1A[4].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan							: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2A " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	
	fwrite ( $fp2, "SASG08: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1A " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1A ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1A[3]$SGSN1A[4]$SGSN1A[5].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1A ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1A[3]$SGSN1A[4].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan							: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2A " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	
	fwrite ( $fp2, "SASG09: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1A " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1A ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1A[3]$SGSN1A[4]$SGSN1A[5].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1A ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1A[3]$SGSN1A[4].mcc$SGSN1A[0]$SGSN1A[1]$SGSN1A[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2A " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
}

fwrite ( $fp2, "" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "! *** 				III.ii GPRS DNSs datos SGSN a configurar			" . PHP_EOL );
fwrite ( $fp2, "! *************************************************************************	" . PHP_EOL );
fwrite ( $fp2, "" . PHP_EOL );

if (! empty ( $SGSN1B ) && ! empty ( $SGSN2B )) {
	fwrite ( $fp2, "! *** Configurar los siguientes datos en SASG04, SASG05, SASG06, SASG07, SASG08 y SASG09    " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "SASG04: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	$largosgsn = strlen ( $SGSN1B );
	
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1B " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1B ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1B[3]$SGSN1B[4]$SGSN1B[5].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1B ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1B[3]$SGSN1B[4].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2B " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	
	fwrite ( $fp2, "SASG05: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1B " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1B ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1B[3]$SGSN1B[4]$SGSN1B[5].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1B ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1B[3]$SGSN1B[4].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2B " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	
	fwrite ( $fp2, "SASG06: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1B " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1B ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1B[3]$SGSN1B[4]$SGSN1B[5].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1B ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1B[3]$SGSN1B[4].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2B " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	
	fwrite ( $fp2, "SASG07: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1B " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1B ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1B[3]$SGSN1B[4]$SGSN1B[5].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1B ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1B[3]$SGSN1B[4].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2B " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	
	fwrite ( $fp2, "SASG08: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1B " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1B ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1B[3]$SGSN1B[4]$SGSN1B[5].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1B ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1B[3]$SGSN1B[4].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2B " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
	
	fwrite ( $fp2, "SASG09: " . PHP_EOL );
	fwrite ( $fp2, "" . PHP_EOL );
	fwrite ( $fp2, "IMSI Number Series						: $SGSN1B " . PHP_EOL );
	fwrite ( $fp2, "Roaming Status						: Visitor " . PHP_EOL );
	if (strlen ( $SGSN1B ) == 6) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc$SGSN1B[3]$SGSN1B[4]$SGSN1B[5].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	if (strlen ( $SGSN1B ) == 5) {
		fwrite ( $fp2, "Default APN Operator Id				: mnc0$SGSN1B[3]$SGSN1B[4].mcc$SGSN1B[0]$SGSN1B[1]$SGSN1B[2].gprs " . PHP_EOL );
	}
	fwrite ( $fp2, "Numbering Plan						: E.214 " . PHP_EOL );
	fwrite ( $fp2, "Nature of Address						: International " . PHP_EOL );
	fwrite ( $fp2, "No of Digits to Remove					: $largosgsn " . PHP_EOL );
	fwrite ( $fp2, "Digits to Add							: $SGSN2B " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 1						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 2						: " . PHP_EOL );
	fwrite ( $fp2, "Miscellaneous 3						: " . PHP_EOL );
	fwrite ( $fp2, "Allow Camel Phase 3						: true " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap WCDMA						: 1 " . PHP_EOL );
	fwrite ( $fp2, "QoS PolicyMap GSM						: 1 " . PHP_EOL );
}

fclose ( $fp2 );
?>
</div>

				<div id="titulopciones">
					<center>Work Order creada</center>
					<br> <br>
<?php
echo '<center>';
echo 'El proveedor es: ' . $PROVEEDOR . '<br>';
echo '<a href="WO_' . $FECHA . '_' . $PAIS . '_' . $OPERADOR . '_VOZ.txt" target="_blank">Descargar WO de VOZ</a>';
echo '<br>';
echo '<a href="WO_' . $FECHA . '_' . $PAIS . '_' . $OPERADOR . '_DATOS.txt" target="_blank">Descargar WO de DATOS</a>';
echo '</center>';



?>
</div>
		
		</div>
</body>
</html>
