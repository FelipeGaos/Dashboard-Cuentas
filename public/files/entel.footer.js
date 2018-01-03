$(document).ready(function() {
	//Enlaces Sociales
	$('#footerRSS').click(function() {// - RSS
		window.location.href = 'http://www.entelpcs.cl/noticias/rss.asp';
	});
	$('#footerYouTube').click(function() {// - YouTube
		window.location.href = 'http://www.youtube.com/entelpcs';
	});
	$('#footerFacebook').click(function() {// - Facebook
		window.location.href = 'http://www.facebook.com/pages/entel/352770001124?ref=ts';
	});
	$('#footerTwitter').click(function() {// - Twitter
		window.location.href = 'http://twitter.com/entel_pcs';
	});
	
	//Despliege Caja: Compartir Pagina
	$('#btnCompartirPagina').mousedown(function(e) {
		$('#caja_info_compartir').hide();
		
		var compartir = $('#caja_compartir');
		if(!compartir.is(':visible')) {
			compartir.show();
			$(document).bind('mousedown', function(e){
				if($(e.target).parents('#caja_compartir').length < 1) {
					compartir.hide();
					if(!$('#caja_info_compartir').is(':visible')) $(document).unbind('mousedown');	
					return false;
				}
			});
		} else {
			compartir.hide();
		}
		return false;
	});
	
	//Despliegue Caja: "Que es esto?"
	$('#btnCompartirPaginaInfo').mousedown(function() {
		$('#caja_compartir').hide();

		var info = $('#caja_info_compartir');
		if (!info.is(':visible')) {
			info.show();
			$(document).bind('mousedown', function(e){
				if ($(e.target).parents('#caja_info_compartir').length < 1) {
					info.hide();
					if(!$('#caja_compartir').is(':visible')) $(document).unbind('mousedown');
					return false;
				}
			});
		} else {
			info.hide();
		}
		return false;
	}).click(function() {
		return false;
	});
	
	//Tabs Caja Compartir
	$("#compartir_tab").click(function(){		
		$('#caja_compartir').find(".seleccionado").removeClass("seleccionado");
		$(this).addClass("seleccionado");
		
		$(".contenido_compartir").show();
		$(".marcadores_sociales").hide();	
	});	
	
	$("#marca_sociales_tab").click(function(){		
		$('#caja_compartir').find(".seleccionado").removeClass("seleccionado");
		$(this).addClass("seleccionado");
		
		$(".contenido_compartir").hide();
		$(".marcadores_sociales").show();
	});	
	
	//Cancelar Formulario Compartir
	$('#btnCompartirCancelar').click(function() {
		$('#caja_compartir').hide();
		return false;
	});
	
});
