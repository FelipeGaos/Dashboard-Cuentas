/**
 * Funciones base para el proyecto.
 * IDEAL mantener solo JS, SIN uso de JQUERY para utilizar en paginas donde este ultimo no se encuentre cargado
 */

/**
 * Devuelve elemento con los atributos creados
 * @param string tipo
 * @param ARRAY atributos
 * @returns {elemento|Element}
 */
crearElementoHTML = function(tipo, atributos){
    elemento = document.createElement(tipo);
    for(var atr in atributos) {
        elemento.setAttribute(atr, atributos[atr]);
    }
    return elemento;
};
//largo de objeto (JSSON)
largoObject = function(obj){
    var key, count = 0;
    for(key in obj) {
        if( obj.hasOwnProperty(key) ) {
            count++;
        }
    }
    return count;
};
/**
 * recibe como parametro la fecha en formato dd/mm/yyyy
 * @returns fecha formato Javascript
 */
fechaJS = function(fechaEntrada){
    var entrada = fechaEntrada.split('/');
    var fechaSalida = new Date();
    fechaSalida.setDate(entrada[0]);
    fechaSalida.setMonth(parseInt(entrada[1])-1);
    fechaSalida.setFullYear(entrada[2]);
    return fechaSalida;
};

concatenaJson = function(json1, json2){
    for (var key in json2) {
        json1[key] = json2[key];
    }
    return json1;
};

/* extenciones jQuery */
$.fn.clearForm = function() {
    return this.each(function() {
    var type = this.type, tag = this.tagName.toLowerCase();
    if (tag == 'form')
        return $(':input',this).clearForm();
    if (type == 'text' || type == 'password' || tag == 'textarea' || type == 'hidden')
        this.value = '';
    else if (type == 'checkbox' || type == 'radio')
        this.checked = false;
    else if (tag == 'select')
        this.selectedIndex = -1;
    });
};


imprimirTablaJson = function(jsonData){
    var tabla = crearElementoHTML("table",{"class":"estado"});
    $.each(jsonData, function(item){
        var tr = crearElementoHTML("tr", {});
        var tdTitle = crearElementoHTML("td", {"class":"title", "colspan":"2"});
        var td1 = crearElementoHTML("td",{"class":"estado"});
        var td2 = crearElementoHTML("td",{"class":"estado"});
        if(jsonData[item].type == "title"){
            console.log(jsonData[item].key);
            tdTitle.textContent = jsonData[item].key;
            tr.appendChild(tdTitle);
        } else{
            td1.textContent = jsonData[item].key;
            tr.appendChild(td1);
            td2.textContent = jsonData[item].val;
            tr.appendChild(td2);
        }
        tabla.appendChild(tr);
        if(jsonData[item].detail != undefined){
//                console.log(jsonData[item].detail);
            tdTitle.textContent = jsonData[item].key;
            var trDetail = crearElementoHTML("tr", {"class":"detail"});
            var td = crearElementoHTML("td", {"class":"td-detail", "colspan":"2"});
            var elTableDetail = detalleTablaJson(jsonData[item].detail);
            td.appendChild(elTableDetail);
            trDetail.appendChild(td);
            tabla.appendChild(trDetail);
        }
    });
    return tabla;
};
detalleTablaJson = function(jsonData){
    var tabla = crearElementoHTML("table", {"class":"table-detail"});
    $.each(jsonData, function(item){
        var tr = crearElementoHTML("tr", {});
        $.each(jsonData[item], function(itemdet){
//                console.log(jsonData[item][itemdet]);
            var td = crearElementoHTML("td");
            td.innerHTML = jsonData[item][itemdet].replace(/(?:\r\n|\r|\n)/g, '<br />');
            tr.appendChild(td);
        });
        tabla.appendChild(tr);
    });
    return tabla;
};