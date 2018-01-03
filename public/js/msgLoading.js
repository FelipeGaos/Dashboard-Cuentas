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

function esperaON(msg) {
    var msj = msg || 'Cargando..';
    $.blockUI({message: '<h4><i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i> &nbsp;' + msj + '</h4>'});
}

function esperaOFF() {
    $.unblockUI();
}