$(document).ready(function() {
	
	$('#enviarCompartir').click(function() {
		var email = $('input[name=destino]').removeClass('error');
		var nombre = $('input[name=nombre_remitente]').removeClass('error');
		var remitente = $('input[name=remitente]').removeClass('error');
		var urlExterna = $('#urlExterna');
		
		if(email.val().length < 3 || !emailValido(email.val())) {
			email.addClass('error').focus();
			return false;
		}
		
		if(nombre.val().length < 3) {
			nombre.addClass('error').focus();
			return false;
		}
		
		if(remitente.val().length < 3 || !emailValido(remitente.val())) {
			remitente.addClass('error').focus();
			return false;
		}
	
		$.ajax({
			url: 'enviar_email.iws',
			type: 'POST',
			data: 'para='+email.val()+'&nombre='+nombre.val()+'&email='+remitente.val()+'&url='+urlExterna.val(),
			success: function() {
				$('#contenido_compartir').hide();
				$('#contenido_exito').show();
			}
		});

		return false;
	});
	
	$('.btnVolver').click(function() {
		$('#contenido_compartir').show();
		$('#contenido_compartir').find('input').val('');
		$('#contenido_exito').hide();	
	});
});


function emailValido(el){ 
	if(/^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i.test(el)) return true;  
	return false; 
}

