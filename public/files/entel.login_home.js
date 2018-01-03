$(document).ready(function() {
	
	$('input.inputBox').each(function() {
		if(!$(this).parent().is('td')) {
			$(this).inputBox();
		}
	});
	
	//Manejo de tabs
	$(".tab_1").click(function(){
		$(this).addClass("tab_seleccionado");
		$(".tab_2").removeClass("tab_seleccionado");
		$('#globoError, #globoErrorAlternativo').fadeOut();
		
		if (!$(".contenido_tab_1").hasClass("tab_desplegado")){
			$(".contenido_tab_1").fadeIn(300);
			$(".contenido_tab_1").addClass("tab_desplegado");
			
			$(".contenido_tab_2").removeClass("tab_desplegado");
			$(".contenido_tab_2").hide();
		}
		else {
			return false;
		}
	});

	$(".tab_2").click(function(){
		$(this).addClass("tab_seleccionado");
		$(".tab_1").removeClass("tab_seleccionado");
		$('#globoError, #globoErrorAlternativo').fadeOut();
		
		if (!$(".contenido_tab_2").hasClass("tab_desplegado")){
			$(".contenido_tab_2").fadeIn(300);
			$(".contenido_tab_2").addClass("tab_desplegado");
			
			$(".contenido_tab_1").removeClass("tab_desplegado");
			$(".contenido_tab_1").hide();
		}
		else {
			return false;
		}
	});
	
	//Manejo de INPUTS en HOME EMPRESAS
	$("input[name=EMPATRUT]").val("RUT Empresa");
	$("input[name=USURUT]").val("RUT Administrador");
	$("input[name=RutSA]").val("RUT");
	
	$("input[name=EMPATRUT]").focus(function(){
		if ($(this).val() == "RUT Empresa") {
			$(this).val("");
		}
	});
	$("input[name=EMPATRUT]").blur(function(){
		if ($(this).val() == "" ){
			$(this).val("RUT Empresa");
		}
	});
	
	$("input[name=USURUT]").focus(function(){
		if ($(this).val() == "RUT Administrador") {
			$(this).val("");
		}
	});
	$("input[name=USURUT]").blur(function(){
		if ($(this).val() == "" ){
			$(this).val("RUT Administrador");
		}
	});
	
	$("input[name=RutSA]").focus(function(){
		if ($(this).val() == "RUT") {
			$(this).val("");
		}
	});
	$("input[name=RutSA]").blur(function(){
		if ($(this).val() == "" ){
			$(this).val("RUT");
		}
	});
	
	$("input[name=USUPAS]").focus(function(){
		$(this).parents('.item_formulario').find(".clave_texto").hide();
	});
	$("input[name=USUPAS]").blur(function(){
		if ($(this).val() == "" ){
			$(this).parents('.item_formulario').find(".clave_texto").show();
		}
	});
	$(".clave_texto").click(function(){
		$(this).hide();
		$("input[name=USUPAS]").focus();
	});
	
	//Manejo de INPUTS en HOME EMPRESAS Login Fijo
	$("input[name=EMPATRUT2]").val("RUT Empresa");
	$("input[name=USURUT2]").val("RUT Administrador");
	
	$("input[name=EMPATRUT2]").focus(function(){
		if ($(this).val() == "RUT Empresa") {
			$(this).val("");
		}
	});
	$("input[name=EMPATRUT2]").blur(function(){
		if ($(this).val() == "" ){
			$(this).val("RUT Empresa");
		}
	});
	
	$("input[name=USURUT2]").focus(function(){
		if ($(this).val() == "RUT Administrador") {
			$(this).val("");
		}
	});
	$("input[name=USURUT2]").blur(function(){
		if ($(this).val() == "" ){
			$(this).val("RUT Administrador");
		}
	});
	
	$("input[name=USUPAS2]").focus(function(){
		$(this).parents('.item_formulario').find(".clave_texto").hide();
	});
	$("input[name=USUPAS2]").blur(function(){
		if ($(this).val() == "" ){
			$(this).parents('.item_formulario').find(".clave_texto").show();
		}
	});
	$(".clave_texto").click(function(){
		$(this).hide();
		$("input[name=USUPAS2]").focus();
	});
	
	
	function ocultartodo(){
		$('#seleccion').hide();
		$('#mientel-movil').hide();
		$('#mientel-fijo').hide();
		return false;
	}
	
	$(".btn_movil").click(function(){
		ocultartodo();
		$('#mientel-movil').show();
		$("input[name=USURUT]").val("RUT Administrador");
		return false;
	})

	$(".btn_fijo").click(function(){
		ocultartodo();
		$('#mientel-fijo').show();
		return false;
	})

});