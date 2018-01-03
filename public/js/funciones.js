/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * Debe contener el path de la aplicacion como Global
 */
var clearTimeOutMensaje;
function mensaje(msg, opcion, timeShow) {
    if(clearTimeOutMensaje){
        stopTimeOutMensaje(clearTimeOutMensaje);
    }
    timeShow = typeof timeShow !== 'undefined' ? timeShow : -1;
    $("#mensaje").html("<div id='msj'></div>");
    if (opcion == 'OK') {
        $("#msj").attr('class', 'alert alert-success alert-dismissible');
    }
    if (opcion == 'INF') {
        $("#msj").attr('class', 'alert alert-warning alert-dismissible');
    }
    if (opcion == 'ERR') {
        $("#msj").attr('class', 'alert alert-danger alert-dismissible');
    }
    $("#msj").html(' <button type="button" class="close" data-dismiss="alert">&times;</button>');
    $("#msj").append(msg);
    //setTimeout(expression, timeout);
    $("#mensaje").show();
    if(timeShow != -1){
        clearTimeOutMensaje = setTimeout(function(){
            if($('#mensaje').is(':visible')){
                $('#mensaje').slideUp();
            }
        }, timeShow);
    }
};

function stopTimeOutMensaje(clearTimeOutMensaje){
    clearTimeout(clearTimeOutMensaje);
};
function esperaON(msg) {
    // alert(path_base+"/img/busy.gif");
    var msj = msg || 'Cargando..';
    $.blockUI({message: '<h4><img src="' + path_base + '/img/busy1.gif" /> ' + msj + '</h4>'});
}
function esperaOFF() {
    $.unblockUI();
}

function mensaje_espera(msg, estado, capa) {
    var estado = estado || 'ON';
    var estado = capa || '';
    if (estado == 'ON') {
        if (capa != '') {
            $('#' + capa).block({message: '<h1><img src="<?php echo $this->baseUrl();?>/img/busy.gif" /> ' + msg + '</h1>'});
        } else
            $.blockUI({message: '<h1><img src="<?php echo $this->baseUrl();?>/img/busy.gif" /> ' + msg + '</h1>'});
    } else
    if (capa != '')
        $('#' + capa).unblock();
    else
        $.unblockUI();
}
