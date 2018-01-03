$(function(){
    /**
     * Al hacer click en boton de login, levanta un modal con el formulario
     */
    $("#btn-login").on("click", function() {
        // Configura bootbox
        bootbox.dialog({
            size: "large",
            title: "Iniciar Sesi&oacute;n <span id='load_tables' style='opacity: 1;'>&nbsp;<i class='fa fa-cog fa-spin spin-modal'></i></span>",
            message: 'Cargando...',
            className: "modal-params",
            id : "modal_parametros"
        })
        .on("shown.bs.modal", function() {
            $("#load_tables").show();
        });

        // Peticion para desplegar la vista de login dentro del modal
        service.getRequest("index/display-login-form", {}, "POST", "html", true)
        .done(function(data) {
            $(".bootbox-body").html(data);
            
            // Funcion que capta el submit del formulario de login
            $("#form-login").on("submit", function(event) {
                event.preventDefault();
                console.log("-> SUBMIT FORM");
                var formSerialize = $(this).serialize();
                console.log(formSerialize);
                
                // Llama funcion que autentica los usuarios y eventualmente crea la sesion
                service.getRequest("index/login", formSerialize, "POST", "json", true)
                .done(function(data) {
                    console.dir(data);
                    
                    // Si el estado es 1 = "OK", entonces personaliza menus del usuario
                    if (data["status"].trim() === "1") {
                        getJSONMenu();
                        
                        // Experimento para saber si se creo la sesion del usuario.
                        // *************************************************
                        $("#item-sesion").addClass("dropdown user user-menu"); // Agrega clases al li de usuario
                        
                        var $btnUser = $(document.createElement("a")).attr({"href": "#", "data-toggle": "dropdown", "aria-expanded": "false"}).addClass("dropdown-toggle");
                        $($btnUser).html("<i class='fa fa-user'></i>&nbsp;&nbsp;<span class='hidden-xs'>"+data["username"]+"</span>");
                        $("#btn-login").remove(); // Reemplaza el boton de login por el boton del usuario
                        
                        var $ul = $(document.createElement("ul")).addClass("dropdown-menu");
                        var $liHead = $(document.createElement("li")).addClass("user-header");
                        var $liBody = $(document.createElement("li")).addClass("user-body");
                        var $liFooter = $(document.createElement("li")).addClass("user-footer");
                        var $divLeft = $(document.createElement("div")).addClass("pull-left");
                        var $divRight = $(document.createElement("div")).addClass("pull-right");
                        var $btnSignOut = $(document.createElement("a")).attr("href", "#").addClass("btn btn-default btn-flat").html("<span>Salir</span>");
                        var $btnPerfil = $(document.createElement("a")).attr("href", "#").addClass("btn btn-default btn-flat").html("<span>Perfil</span>");;
                        var $footLeft = $liFooter.append($divLeft.append($btnPerfil));
                        var $footRight = $liFooter.append($divRight.append($btnSignOut));
                        
                        $ul.append($liHead).append($liBody).append($footLeft).append($footRight);
                        
                        $("#item-sesion").append($btnUser).append($ul); // Agrega el boton al li de sesion
                        // *************************************************
                        
                        bootbox.hideAll(); // Cierra modal.
                        console.log("-> LOGIN OK!");
                    }
                    else {
                        console.warn("-> ERROR LOGIN!");
                    }
                })
                .always();
            });
        })
        .always(function() {
            $("#load_tables").css("opacity", 0);
        });
    });
}); // End document ready