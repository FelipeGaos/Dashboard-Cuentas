<html>
  <head>
    <link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
	<link href="./scripts/jtable/themes/metro/blue/jtable.css" rel="stylesheet" type="text/css" /> 
	<script src="./scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
    <script src="./scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
    <script src="./scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
 	
 	<script type="text/javascript"><!-- Linkear JS a un archivo unico -->
		$(document).ready(function () {
			$('#grilla_inventario').jtable({
				title: 'Parametros Extraidos',
	            sorting: true,// CON ORDENAR COLUMNAS
	            defaultSorting: "id ASC",//ORDENAR POR EL CAMPO ID ASC
	            paging: true,// CON PAGINACION
	            pageSize: 20,//MOSTRAR 20 REEGISTROS
	            multiselect: true,//HABILITAMOS MULTISELECCION
	            selecting : true,
	            selectingCheckboxes: true,//SELECCION MULTIPLE CON CHECKBOX
	            selectOnRowClick : false,//por defecto TRUE
	            deleteConfirmation: function(data) {
				    data.deleteConfirmMessage = 'Éstas seguro de querer eliminar el ITEM con ID: ' + data.record.id + ' ?';
				},
	            actions: {
					listAction: '../../../index.php/index/crud/operacion/list',
					createAction: '../../../index.php/index/crud/operacion/create',
					updateAction: '../../../index.php/index/crud/operacion/update',
					deleteAction: '../../../index.php/index/crud/operacion/delete'
				},
				fields: {
					'id': {
						'key': true,
						'list': true
					},
					<?php
						$fechaHoy = date('d-m-Y');
						##Campos que queremos listar de la base de datos(esto datos tienen que ser los mismo de la bd ya uqe se utiliza para el CRUD)
						$COLS_INVENTARIO = array ('id', 'id_ir21', 'login', 'type', 'valor', 'status', 'last_date_modify');
						$st = "";
						
						foreach ($COLS_INVENTARIO as $col) {
							if ($col != 'id' && $col != 'last_date_modify') {
								 $st .= "'$col':{\n";
								 $st .= "'title':'$col',\n";
								 $st .= "'inputClass': 'mi_input_class'\n";
								 $st .= "},\n";
							}else if($col == 'doc_fecha_fin'){//CAMPOS DE FECHA
								$st .= "'$col':{\n";
								$st .= "'title':'$col',\n";
								$st .= "'type':'date',\n";
								$st .= "'inputClass': 'mi_input_class',\n";
								$st .= "'displayFormat':'dd-mm-yy',\n";
								$st .= "'defaultValue':'".$fechaHoy."'\n";
								$st .= "},\n";
							}
						}
						if (strlen($st)>0) {
							$st = substr($st, 0, -2);
						}
						echo $st;
					?>
				},
				//ver el detalle de las filas seleccionadas antes de eliminarlas comentado: CG y AD no sirve
				/*selectionChanged: function(){
					var $selectedRows = $("#grilla_inventario").jtable("selectedRows");
					$('#bodySelectedRowList').empty();
                    $("#totalSelected").text($selectedRows.length);
	                if ($selectedRows.length > 0) {
	                    $selectedRows.each(function () {
	                        var record = $(this).data('record');
	                        //console.dir(record);
	                        $('#bodySelectedRowList').append(
	                            '<span style="color: #1C78DE;font-weight:bold;">Elemento id<span>: <code>' + record.id +
	                            '</code><br /><span style="color: #1C78DE;font-weight:bold;">Estado Doc</span>: <code>' + record.doc_estado + '</code><br /><hr>'
	                        );
	                    });
	                } else {
		                $("#totalSelected").text("0");
	                    $('#bodySelectedRowList').append('<span style="color: red;">No se han seleccionado filas para eliminar!</span>');
	                }
				}*/
			});
			/*
			/Method for grilla inventario
			*/
			//Eliminar varios registros de la BD
		    $('#eliminarFilasSeleccionadas').click(function (e) {
		    	e.preventDefault();
	            var $selectedRows = $('#grilla_inventario').jtable('selectedRows');
	            $('#grilla_inventario').jtable('deleteRows', $selectedRows);
	        });
	        $('#agregarNewRecord').click(function(e){
		        e.preventDefault();
				$('#grilla_inventario').jtable('showCreateForm');
		    });
	        //Load grilla inventario
	         $('#btnCargaGrilla').click(function (e) {
	            e.preventDefault();
	            $('#grilla_inventario').jtable('load');
		        /* $('#grilla_inventario').jtable('load', {
	                "doc_tp": $('#doc_tp').val()//enviamos los parametros que sean necesarios para filtrar atraves de un objeto javascript
	            });*/
	        });
	        //trigger Load grilla
	        $('#btnCargaGrilla').click();
	     	pintar_cabecera_jtable();   
		});
		
	function pintar_cabecera_jtable(){
		var $textHeader = null;//obj jquery
		var textHeader = "";
		var lengthText = 0;
		var posicionInicial = 0;
		var sufijoHeader = "";
		$(".jtable thead tr th").each(function(index, value){
			$textHeader = $(value).children().children()[0];
			textHeader = $($textHeader).text();//get cadena
			lengthText = textHeader.length;//largo de la cadena
			posicionInicial = textHeader.indexOf('_');//encuentra la primera posicion del caracter que es pasado a la funcion
			sufijoHeader = textHeader.substring(0,posicionInicial+1);
			textHeader = textHeader.substring(posicionInicial+1, lengthText);//cortamos la cadena omitimos sufijos.
			$($textHeader).text(textHeader.toUpperCase());//seteamos el nuevo texto 
			$(value).css({
				"color" : "black",
				"font-weight" : "bold",
				"font-family" : "arial", 
				"font-size" : "11px"
			});
	    	if(sufijoHeader == "doc_"){//DOC_ Documentos
			    $(value).css({
		            "background-color" : "yellow"
		        });
		    }
		    if(sufijoHeader == "ia_"){//IA_ Informacion Administrativa
		        $(value).css({
		            "background-color" : "lightblue" 
		        });
		    }
		    if(sufijoHeader == "itca_"){//ITCA_ Informacion Tecnica Compañia A
		        $(value).css({
		            "background-color" : "limegreen"
		        });
		    }
		    if(sufijoHeader == "itcb_" || textHeader == "observaciones"){//ITCB_ Informacion Tecnica Compañia B 
		        $(value).css({
		            "background-color" : "orange"
		        });
		    }
		    if(sufijoHeader == "sm_"){//SM: Sala Movil
		        $(value).css({
		            "background-color" : "lightgrey"
		        });
		    }
		    if(sufijoHeader == "st1_"){//ST1: Sala Transporte 1
		        $(value).css({
		            "background-color" : "lightgrey"
		        });
		    }
		    if(sufijoHeader == "st2_"){//ST2_  Sala Transporte 2
		        $(value).css({
		            "background-color" : "darksalmon"
		        });
		    }
		    if(sufijoHeader == "st3_"){//ST3: Sala Transporte 3 
		        $(value).css({
		            "background-color" : "lightgrey"
		        });
		    }
		});	
	}
	</script>
 	<style type="text/css">
        // Linkear css a un archivo unico
 		form.jtable-dialog-form  {
			width:  900px;
		}
		#jtable-create-form{
			width: 900px;
		}
		div.jtable-input-field-container {
			display: inline-block;
		}
		span.jtable-column-header-text{
			width: 110px;
		}
		.content_grilla_inventario{
			border: 1px solid blue;
			overflow-y: hidden;
			overflow-x: auto;
			margin-left: auto;
			margin-right: auto; 
		}
		.contentSelectedRowList{
			font-family: "Open Sans";
			border:1px solid blue;
			margin: 5px auto 0px auto;
		}
		.contentSelectedRowList .title{
			background-color: #1C78DE;
			border: 1px solid lightblue;
			color:white;
			font-size: 15px;
			padding: 5px;
			margin-bottom: 5px;
		}
		.contentSelectedRowList .footer{
			font-size: 13px;
		}
		.contentActionDeleteAllRows{
			background-color: #1C78DE;
			border: 1px solid lightblue;
			color:white;
			font-size: 15px;
			padding: 5px;
			margin-top: 5px;
			text-align: right;
		}
		.contentActionDeleteAllRows #eliminarFilasSeleccionadas:hover{
			text-decoration: underline;
			cursor: pointer;
		}
		.contentSelectedRowList .body{
			padding: 0 5 0 5px;
		}
		.btn_standar{
			font-family:'Open Sans';
			border: 1px solid lightblue;
			background-color: #1C78DE;
			color: snow;
			padding: 3px;
			font-size: 14.2px;
			text-decoration: none;
			cursor: pointer;
		}
		.btn_standar:hover{
			text-decoration: underline;
		}
 	</style>
  </head>
  <body>
  	<div class="filtering">
	        <!--  TP: <input type="text" name="doc_tp" id="doc_tp" /> -->
	        <!-- Mis botones de cabecera -->
	        <a href="../../../index.php/index/tablaiventariointercon" target="_blank" style="text-decoration: none;"><span class="btn_standar">Ir a vista con filtros</span></a> | 
	        <span id="eliminarFilasSeleccionadas" class="btn_standar"> - Eliminar elementos seleccionados</span> |
	        <a href="#" id="agregarNewRecord" class="btn_standar">+ Agregar un nuevo registro</a> |
	         <button type="button" id="btnCargaGrilla" name="btnCargaGrilla" class="btn_standar">Actualizar</button> 
	</div>
	<br />
  	<div id="content_grilla" class="content_grilla_inventario">
		<div id="grilla_inventario" style="width: auto;"></div>
	</div>
	<!-- DIV CONTEND DETALLE FILAS SELECCIONADAS -->
	<!-- <div id="SelectedRowList" class="contentSelectedRowList">
		<div class="title"><span>Detalle Filas Seleccionadas</span><div style="float: right;font-size:13px;"><span style="color: white;font-weight:bold;">Total filas seleccionadas: </span><code><span id="totalSelected" style="color:white;">0</span></code></div></div>
		<div class="body" id="bodySelectedRowList">
			<span style="color: red;">No se han seleccionado filas para eliminar!</span>
		</div>
		<div class="footer">
		</div>
		<div class="contentActionDeleteAllRows">
			<span id="eliminarFilasSeleccionadas"> - Eliminar Todos los elementos seleccionados</span>
		</div>
	</div> -->
  </body>
</html>
