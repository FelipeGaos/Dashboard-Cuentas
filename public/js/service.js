var service = {};

service = {
    init: function(){
        // Funcion de inicio
    },
    // Handler error callbacks request1000 1s  1500
    errorRequest: function(jqXHR, exception, errorThrown) {
        if (jqXHR.status === 0) {
            alert('No hay conexi&oacute;n.\n Verifique su Red.');
        } else if (jqXHR.status === 404) { 
            alert('P&aacute;gina solicitada no encontrada. [404]');
        } else if (jqXHR.status === 500) {
            alert('Error Interno del Servidor [500].');
        } else if (exception === 'parsererror') {
            alert('Fall&oacute; Parse Request JSON.');
        } else if (exception === 'timeout') {
            alert('Error de Time Out.');
        } else if (exception === 'abort') {
            alert('Peticion Ajax Abortada.');
        } else {
            alert('Error Desconocido.\n' + jqXHR.responseText);
        }
    },
    // RETURN DEFERRED!
    getRequest: function(service, data, type, dataType, async) {
        data = data || {};
        type = type || 'POST';
        dataType = dataType || 'json';
        if (async !== false) {
            async = true;
        }
        console.info("SERVICES: " + service + " ASYNC: " + async);
        
        return $.ajax({
            async: async,
            type: type,
            url: BASE_URL + "/index.php/" + service, // BASE_URL Constante JS declarada en el layout
            data: data, // Enviamos un string aunque podriamos haber enviado un json o un objeto js
            dataType: dataType // Output text; puede devolver un TEXT, JSON, XML, HTML. mas info https://api.jquery.com/jQuery.ajax/
        });
    }
};