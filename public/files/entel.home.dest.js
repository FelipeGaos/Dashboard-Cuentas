var indice = 1;
var ItemRand = 1;

$(document).ready(function() {
//	var url = 0;
//	$('.tienda_carrusel').click(function(){
//		var url = 'http://tiendavirtual.entelpcs.com/tv_portal/asp_new/carro/tpel_agregar_carro.asp?prdid='+$(this).attr('prdid')+'&idequip='+$(this).attr('idequip');
//		window.open(url, '_self');
//	});

	/*
	 * Carga AJAX por XML de destacados
	 */
	/*$.ajax({
	    type: "GET",
	    url: "./carrusel/data.xml",
	    dataType: "xml",
	    success: respuesta
	});*/
	
});

/*
 * 	Procesa datos del XML (data.xml)
 */
function respuesta(xml) {
	
	var htmlDestacado = '<div id="wrap">';
	htmlDestacado += '	<div class="jcarousel-skin-tango">';
	htmlDestacado += '		<div style="visibility: visible; display: block;" class="destacado_home clearfix pngfix jcarousel-container jcarousel-container-horizontal" id="mycarousel">';
	htmlDestacado += '			<div class="jcarousel-clip jcarousel-clip-horizontal">';
	htmlDestacado += '				<ul class="jcarousel-list jcarousel-list-horizontal" style="width: 2304px; left: 0px;">';
	
	var htmlImagenes = '';
	var htmlControles = '';
	
	//Busca cada banner y obtiene los datos
	var index = 1;
	/*.sort(function(){
		return Math.random()*10 > 5 ? 1 : -1;		
	})*/
	var ItemCant = 0;
	$(xml).find("banner").each(function(){
		ItemCant++;	
		var texto = $(this).find("texto").text();
		var destacado = $(this).find("destacado").text();
		var thumb = $(this).find("thumb").text();
		var enlace = $(this).find("enlace").text();
		var target = $(this).find("target").text();
		
		var trackevent = "['_trackEvent'";
		var mercadoactividad = $(this).find("mercadoactividad").text();
		var nombrecampana = $(this).find("nombrecampana").text();
		var fuenteaccion = $(this).find("fuenteaccion").text();		
		
		var cierrega = "]);"
		
		if (index == 1){
			indiceText = '1';
		}else if (index == 2) {
			indiceText = '2';
		}else if (index == 3) {
			indiceText = '3';
		}else if (index == 4) {
			indiceText = '4';
		}else if (index == 5) {
			indiceText = '5';
		}else if (index == 6) {
			indiceText = '6';
		}
		
		htmlImagenes += '<li class="jcarousel-item jcarousel-item-horizontal jcarousel-item-' + indiceText + ' jcarousel-item-' + indiceText + '-horizontal" jcarouselindex="' + indiceText + '"><a href="' + enlace + '" target="' + target + '" onclick="_gaq.push('+ trackevent +', '+ "'" + mercadoactividad + "'" + ', ' + "'" + nombrecampana + "'" + ', ' + "'" + fuenteaccion + "']);" + '"><img src="' + destacado + '" alt="' + texto + '" /></a></li>';
		
		/*if (index == 1) { //enlace_seleccionado
			htmlControles += '<a href="#" class="enlace_destacado clearfix enlaceMargen" id="id_' + indiceText + '"></a>';
		}
		else {*/
			htmlControles += '<a href="#" class="enlace_destacado clearfix enlaceMargen" id="id_' + indiceText + '"></a>';
		//}
		
		index = index + 1;
	});
	ItemRand = Math.floor((Math.random()*ItemCant)+1);
	indice = ItemRand;
	htmlDestacado += htmlImagenes + '</ul></div><div style="position: relative;" class="jcarousel-control clearfix">' + htmlControles + '</div></div></div></div>';
	
	setTimeout(function(){
		$("#bannerPrincipal_home").append(htmlDestacado);
		ejecutaCarrusel();
	}, 100);
}												

function ejecutaCarrusel(){
	
	/*
	 * Ejecuta el carrusel
	 */
	$("#mycarousel").jcarousel({
		scroll: 1,
		wrap: 'last',
		auto: 6,		
		start: ItemRand,
		initCallback: mycarousel_initCallback,
		itemFirstOutCallback: {
			onBeforeAnimation: function(data) {
				var total = $('.enlace_destacado').length;
				$('.enlace_destacado').removeClass('enlace_seleccionado');
		  		
				if(indice == total) {
					indice = 0;
				}
				$('.enlace_destacado').eq(indice++).addClass('enlace_seleccionado');
		  	}
		},
		
		// Esto le dice al jCarousel que NO autoconstruya los botones de siguiente y anterior
		buttonNextHTML: null,
		buttonPrevHTML: null
	}).css('visibility','visible');
	
	//Ubica el enlace seleccionado en el destacado del home
	$(".enlace_destacado").each(function(i) {
		$(this).click(function(){
			indice = i+1;
			$(".enlace_destacado").removeClass("enlace_seleccionado");
			$(this).addClass("enlace_seleccionado");
		});
	});	
}

function mycarousel_initCallback(carousel) {
	
	$('.jcarousel-control a').bind('click', function() {
		var id = $(this).attr('id');
		var idNumero = id.split('_');
			
		carousel.scroll($.jcarousel.intval(idNumero[1]));
		return false;
	});

	$('.jcarousel-control a').eq(ItemRand-1).addClass('enlace_seleccionado');
	
	// Pause autoscrolling if the user moves with the cursor over the clip.
    $('.jcarousel-control a').click(function() {
        carousel.stopAuto();
		setTimeout(function(){
			carousel.startAuto();
		},10);
    });

}

function eventualizaTooltips() {
	/**
	 * Tooltips
	 */
	 
	TOOLTIPS = $(".autoTooltip, .toolTip");
	if(TOOLTIPS.length > 0) {
		
		var html = '<div id="tooltip1" class="tooltip1" style="top: 142px; left: 459px; display: none"><div class="flecha"><div class="texto">tooltip</div></div></div>';
		$('body').append(html);
		if($.browser.msie) {
			$("#tooltip1").css("backgroundImage", $("#tooltip1").css("backgroundImage").replace(/\.png/i, '.gif'));
			var divInterior = $("#tooltip1 div.flecha:first");
			divInterior.css("backgroundImage", divInterior.css("backgroundImage").replace(/\.png/i, '.gif'));
		}

		TOOLTIPS.each(function() {
			var el = $(this);
			el.removeClass('activo');
			el.attr('tooltip', el.attr('title')).removeAttr('title');
			var inlineTooltip = el.hasClass("toolTip"); //si es este tipo de tooltip entonces el texto esta en el <a>(.*)</a>
			if (inlineTooltip) {
				el.data("tooltipText", el.html()).html("&nbsp &nbsp &nbsp").addClass("ico_interrogacionNuevo").addClass("visible").css("display", "inline-block");
			}
		});
	 
		TOOLTIPS.hover(function(){
			
			var el = $(this);
			var tt = $('#tooltip1');
			var xy = el.offset();
			var text = el.attr('tooltip');
			var inlineTooltip = el.hasClass("toolTip"); //si es este tipo de tooltip entonces el texto esta en el <a>(.*)</a>
			
			var href = el.attr('href');
			//var activo = (tt.find('div').text() == text || (href == tempTooltip && href != 'javascript:;' && href != '#')) && tt.is(':visible'); //estoy haciendo click a un tooltip que esta activo ?
			var activo = (el.hasClass('activo')) && tt.is(':visible');
			
			if (activo) {
				
				var buttonBackg = el.css('backgroundImage').replace('tooltip/ico_x.gif', 'icons/ico_interrogacion.gif');
				el.css('backgroundImage', buttonBackg);
				
				var startTop = tt.offset().top;
				
				//if($.browser.msie && $.browser.version <= 6.0) {
				//	tt.hide();
					
				//} else {
					tt.animate({
						opacity: 0,
						top: startTop + 50 + 'px'
					}, 150);
				//}			
				
				tt.queue(function() {
					$(this).css('display','none').dequeue();
				});
				
				TOOLTIPS.removeClass('activo');
				tempTooltip = null;
			}
			else {
				
				if(el.hasClass("ext")) {
					tt.addClass("extendido");
				} else {
					tt.removeClass("extendido");
				}
				
				TOOLTIPS.each(function() {
					var buttonBackg = $(this).css('backgroundImage').replace('tooltip/ico_x.gif', 'icons/ico_interrogacion.gif');
					$(this).css('backgroundImage', buttonBackg);
				});
				
				var buttonBackg = el.css('backgroundImage').replace('icons/ico_interrogacion.gif', 'tooltip/ico_x.gif');
				el.css('backgroundImage', buttonBackg);
				
				if (inlineTooltip) {
					text = el.data("tooltipText");
				} else {
				var idTooltip = el.attr('href');
					if(/^[#]{1,}(\s|[a-zA-Z])*/i.test(idTooltip)) {
						text = $(idTooltip).html();
					}
				}
				
				TOOLTIPS.removeClass('activo');
				el.addClass('activo');
				tempTooltip = idTooltip;
				
				tt.find('div.texto:first').html(text)
					.end().css({
						top: xy.top - tt.height(),
						left: xy.left - 100,
						display: 'block',
						zIndex: 149,
						opacity: 0
					});
					
				xy.top -= (parseInt(tt.height()) + 15);
				xy.left -= 112;
				
				if($.browser.msie && $.browser.version <= 5.0) {
					tt.css('opacity',1).css({
						top: xy.top,
						left: xy.left
					});
					
				} else {
					tt.css({ top: xy.top-50 });
					tt.animate({
						top: xy.top, 
						opacity: 1
					}, 100);
				}
			}
			
			return false;
		}, function(){
			
			//cerrarTooltip();
			
		});
	 }
	/*------------------ FIN TOOLTIP -----------------*/	
}
function eventualizaTextoTooltips() {
	/**
	 * Tooltips
	 */
	if($(".autoTextoTooltip").length > 0) {
		
		var html = '';
		html += '<div id="tooltip1" class="tooltip1" style="top: 142px; left: 459px; display: none">';
		html += '	<a href="#" class="tooltipCerrar" onclick="return cerrarTooltip()">cerrar</a>';
		html += '	<div class="flecha">';
		html += '		<div class="texto">tooltip</div>';
		html += '	</div>';
		html += '</div>';
		$('body').append(html);

		$(".autoTextoTooltip").each(function() {
			var el = $(this);
			el.removeClass('activo');
			//el.attr('tooltip', el.attr('title')).removeAttr('title');
		});
	 
		$(".autoTextoTooltip").hover(function(){
			
			var el = $(this);
			var tt = $('#tooltip1');
			var xy = el.offset();
			//var text = el.attr('tooltip');
			
			var href = el.attr('href');
			var activo = (el.hasClass('activo')) && tt.is(':visible');
			
			if (activo) {				
				var startTop = tt.offset().top;
				
				if($.browser.msie && $.browser.version <= 6.0) {
					tt.hide();
					
				} else {
					tt.animate({
						opacity: 0,
						top: startTop + 50 + 'px'
					}, 150);
				}			
				
				tt.queue(function() {
					$(this).css('display','none').dequeue();
				});
				
				$(".autoTextoTooltip").removeClass('activo');
				tempTooltip = null;
			}
			else {
				
				if(el.hasClass("ext")) {
					tt.addClass("extendido");
				} else {
					tt.removeClass("extendido");
				}
				
				var idTooltip = el.attr('href');
				if(/^[#]{1,}(\s|[a-zA-Z])*/i.test(idTooltip)) {
					text = $(idTooltip).html();
				}
				
				$(".autoTextoTooltip").removeClass('activo');
				el.addClass('activo');
				tempTooltip = idTooltip;
				
				//alert((parseInt(xy.left) - parseInt(tt.width())/2 + parseInt(el.width()/2)));
				
				tt.find('div.texto:first').html(text)
					.end().css({
						top: xy.top - tt.height(),
						left: (parseInt(xy.left) - parseInt(tt.width())/2 + parseInt(el.width()/2))+'px',
						display: 'block',
						zIndex: 149,
						opacity: 0
					});
					
				xy.top -= (parseInt(tt.height()) + 15);
				//xy.left -= (parseInt(xy.left) - parseInt(tt.width())/2 + parseInt(el.width()/2));
				
				if($.browser.msie && $.browser.version <= 6.0) {	
					tt.css('opacity',1).css({
						top: xy.top,
						left: (parseInt(xy.left) - parseInt(tt.width())/2 + parseInt(el.width()/2))+'px'
					});
					
				} else {
					tt.css({ top: xy.top-50 });
					tt.animate({
						top: xy.top, 
						opacity: 1
					}, 100);
				}
			}
			
			return false;
		});
	 }
	/*------------------ FIN TOOLTIP -----------------*/	
}

/*------------------ Esta rutina Inicializa los tooltip -----------------*/	
var tempTooltip;
$(document).ready(function(){
	eventualizaTooltips();
	eventualizaTextoTooltips();
	
});

function cerrarTooltip() {
	$('.tooltip1').hide();
	$(".autoTextoTooltip").removeClass('activo');
	return false;
}
