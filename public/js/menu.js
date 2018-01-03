$(function() {    
    /**
     * Llama a la funcion que trae los items que conforman el menu lateral de la aplicacion.
     * @returns {json} 
     */
    getJSONMenu = function() {
        service.getRequest("index/crear-menu", {}, "GET", "json", true)
        .done(renderMenuLateral)
        .error(function(err) {
            console.dir(err);
        })
        .always(function() {
            console.log("TERMINE");
        });
    };
    getJSONMenu();
    
    /**
     * renderMenuLateral recorre las listas entregadas por el JSON y arma el menu.
     * @param {type} JSONData
     * @returns {undefined}
     */
    function renderMenuLateral(JSONData) {
        console.dir(JSONData);
        
        // Verifica que las listas no vengan con problemas.
        if (JSONData["statusController"] === false) {
            console.error("Error en el Controlador.");
            return false;
        }
        else if (JSONData["menu"]["status"] !== "1") {
            console.error("Error en lista de menu.");
            return false;
        }
        else {
            // Extrae la lista de menu.
            var arr_menu = JSONData["menu"]["lista"];
            
            // Recorre lista armando un array con los proyectos.
            var arr_proyectos = [];

            arr_menu.forEach(function(item, i) {
                arr_proyectos[item["nombre_proyecto"]] = item["icono_proyecto"];
            });
//            console.dir(arr_proyectos);
        }
        var html = "";

        // RECORRE CADA PROYECTO:
        for (var proyecto in arr_proyectos) {
            var arrHerramientasProyecto = [], arrItemPadres = [];
            
            // RECORRE CADA HERRAMIENTA:
            arr_menu.forEach( function( herramienta, j ) {
                if ( herramienta['nombre_proyecto'] === proyecto ) {
                    // Agrupa todos los items que pertenecen a un proyecto.
                    arrHerramientasProyecto.push(herramienta);
                    // Genera array con todos los items que son padres.
                    arrItemPadres.push(herramienta['item_padre']);
                }
            });
            
            html += '<li class="treeview">';
            html += '<a href="#"><i class="'+arr_proyectos[proyecto]+'"></i> <span>'+proyecto+'</span><i class="fa fa-angle-left pull-right"></i></a>';


            /**
             * generarMenu crea los elementos HTML de la lista del menu.
             * @param {type} itemPadre
             * @returns {undefined}
             */
            function generarMenu(itemPadre) {
                var tieneHijos = false;
                
                for (var indice in arrHerramientasProyecto){
                    if (arrHerramientasProyecto[indice]['item_padre'] === itemPadre){
                        if(tieneHijos === false) {
                            tieneHijos = true;
                            html += '<ul class="treeview-menu">';
                        }
                        if(arrHerramientasProyecto[indice]['item_padre'] === 0 && arrItemPadres.indexOf(arrHerramientasProyecto[indice]['id_herramienta']) !== -1) {
                            html += '<li><a href="#">'+arrHerramientasProyecto[indice]['nombre_herramienta']+'<i class="fa fa-angle-left pull-right"></i></a>';
                        }
                        else if(arrHerramientasProyecto[indice]['item_padre'] !== 0 && arrItemPadres.indexOf(arrHerramientasProyecto[indice]['id_herramienta']) !== -1) {
                            html += '<li><a href="#">'+arrHerramientasProyecto[indice]['nombre_herramienta']+'<i class="fa fa-angle-left pull-right"></i></a>';
                        }
                        else {
                            html += '<li><a href="#">'+arrHerramientasProyecto[indice]['nombre_herramienta']+'</a>';
                        }
                        generarMenu(arrHerramientasProyecto[indice]['id_herramienta']);
                        html += '</li>';
                    }
                }
                
                if(tieneHijos === true) {
                    html += '</ul>';
                }
            } // End generarMenu()
            
            // Se llama a si misma indicando como id inicial 0.
            generarMenu(0);
        } // End FOR proyectos
        
        // Agrega los elementos al DOM.
        $("#menu-proyectos").html(html);
        // Inicializa el menu llamando la funcion de app.js
        $.AdminLTE.tree('.sidebar');
    } // End renderMenuLateral()
    
}); // End Document Ready