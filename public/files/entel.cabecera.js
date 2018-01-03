$(document).ready(function() {
	
	//PNGFix para explorer 6
	if($.browser.msie && $.browser.version < 7){
		if (DD_belatedPNG) {
			DD_belatedPNG.fix('.pngfix');
		}
	}
	
	//Buscador
	if($('#q').val() != "") {
		$('#q').val('').removeClass('activo');
	}
	
	$('#q').focus(function() {
		$(this).addClass('activo');
	}).blur(function() {
		if($(this).val() == "") $(this).removeClass('activo');
	}).keypress(function(e) {
		if(e.keyCode == 13) {
			if($('#q').val() != "") {
				$('#cse-search-box')[0].submit();
			} else {
				return false;
			}
		}
	});
	
	$('#btnFormBuscadorEntel').click(function() {
		if ($('#q').val() != "") {
			$('#cse-search-box')[0].submit();
		}
		return false;
	});
	
	//Ventana Modal de Login
	$("a.LB_login").fancybox({
		'overlayOpacity'		:	0.5,
		'overlayColor'			:	'#000000',
		'hideOnContentClick'	: 	false,
		'hideOnOverlayClick' 	: 	false,
		'frameWidth' : 450,
		'frameHeight' : 410
	});
	
	$("a.LB_login_ancho").fancybox({
		'overlayOpacity'		:	0.5,
		'overlayColor'			:	'#000000',
		'hideOnContentClick'	: 	false,
		'hideOnOverlayClick' 	: 	false,
		'frameWidth' : 760,
		'frameHeight' : 392
	});
	
	$("a.LB_login_callcenter").fancybox({
		'overlayOpacity'		:	0.5,
		'overlayColor'			:	'#000000',
		'hideOnContentClick'	: 	false,
		'hideOnOverlayClick' 	: 	false,
		'frameWidth' : 300,
		'frameHeight' : 130
	});
	
	$('a.enlace_interconectividad').fancybox({
		'overlayOpacity'		:	0.5,
		'overlayColor'			:	'#000000',
		'hideOnContentClick'	: 	false,
		'hideOnOverlayClick' 	: 	false,
		'padding'				: 	0,
		'scrolling'				: 	'no',
		'frameWidth' : 500,
		'frameHeight' : 480
	});
	
	setTimeout(function(){
	 $("#mensaje_mi_entel").fadeOut(500);
	},5000); 
	
});