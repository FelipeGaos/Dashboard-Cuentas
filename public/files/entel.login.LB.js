var action = {
	loginEntelPCS: 		"http://www.vas.entelpcs.cl/acceso_emp/entrada_emp.php",
	loginEntelSA: 		"http://mientelredfija.entel.cl/Login/login.aspx",
	ConoceVerBeta: 		"http://mientelredfija.entel.cl/Login/login.aspx",
	solicitarClaveEPCS: "http://recaudacion.entelpcs.com/portal_empresas_jsp/do/claves/recuperarClave?public=true"
	
}
var action2 = {
	loginEntelFijo:		"http://mientelredfija.entel.cl/login/autenticacion.aspx",
	solicitarClaveFijo:	"http://mientelredfija.entel.cl/login/solicitarclave.aspx",		
}
$(document).ready(function() {
	
	$('input.inputBox').each(function() {
		if(!$(this).parent().is('td')) {
			$(this).inputBox();
		}
	});

	/*
	 * Ingresar
	 */
	//EPCS
	$('#LB_btnLoginEntel').click(function() {
		if ($("form#LB_formLoginEntel").valid()) {
			$("form#LB_formLoginEntel").attr('action',action.loginEntelPCS).attr('target', '_top');
			$("form#LB_formLoginEntel")[0].submit();
			
		}
		return false;
	});
	
	//Login Fijo Prueba 
	$('#LB_btnLoginEntelFijo').click(function() {
		if ($("form#LB_formLoginEntelFijo").valid()) {
			
			var TEMP1 = $("form#LB_formLoginEntelFijo").find('input[name=EMPATRUT2]').val().split('-');
			var RUT1 = TEMP1[0].split(".").join("");
			
			$("form#LB_formLoginEntelFijo").find('input[name=dvEmp]').val(TEMP1[1]);
			$("form#LB_formLoginEntelFijo").find('input[name=rutEmp]').val(RUT1);
			
			var TEMP2 = $("form#LB_formLoginEntelFijo").find('input[name=USURUT2]').val().split('-');
			var RUT2 = TEMP2[0].split(".").join("");
			
			$("form#LB_formLoginEntelFijo").find('input[name=dvAdm]').val(TEMP2[1]);
			$("form#LB_formLoginEntelFijo").find('input[name=rutAdm]').val(RUT2);
			
			var TEMP3 = $("form#LB_formLoginEntelFijo").find('input[name=USUPAS2]').val();
			
			$("form#LB_formLoginEntelFijo").find('input[name=clav]').val(TEMP3);
			
			var prueba = $("form#LB_formLoginEntelFijo").find('input[name=dvEmp]').val();
			
			$("form#LB_formLoginEntelFijo").attr('action',action2.loginEntelFijo).attr('target', '_top');
			$("form#LB_formLoginEntelFijo")[0].submit();
		}
		return false;
	});
	
	//Entel SA
	$('#LB_btnLoginSA').click(function() {
		if ($("form#LB_formLoginSA").valid()) {	
			var TEMP = $("form#LB_formLoginSA").find('input[name=RutSA]').val().split('-');
			var RUT = TEMP[0].split(".").join("");
			
			$("form#LB_formLoginSA").find('input[name=dv]').val(TEMP[1]);
			$("form#LB_formLoginSA").find('input[name=rut]').val(RUT);
			
			$("form#LB_formLoginSA").attr('action',action.loginEntelSA);
			$("form#LB_formLoginSA")[0].submit();
		}
		return false;
	});
	
	//Conoce la version beta
	$('#LB_btConoceVerBeta').click(function() {		
		if ($("form#LB_formLoginSA").valid()) {	
			var TEMP = $("form#LB_formLoginSA").find('input[name=RutSA]').val().split('-');
			var RUT = TEMP[0].split(".").join("");
			
			$("form#LB_formLoginSA").find('input[name=dv]').val(TEMP[1])
			$("form#LB_formLoginSA").find('input[name=rut]').val(RUT)
			
			$("form#LB_formLoginSA").attr('action',action.ConoceVerBeta);
			$("form#LB_formLoginSA")[0].submit();
		}
		
		return false;
	});
	
	/*
	 * Ingresar por Evento
	 */
	
	//EPCS
	$('form#LB_formLoginEntel input[name=EMPATRUT],form#LB_formLoginEntel input[name=USURUT],form#LB_formLoginEntel input[name=USUPAS]').keypress(function(e) {
		if (e.keyCode == 13 && $("form#LB_formLoginEntel").valid()) {
			formatearRut('EMPATRUT');
			formatearRut('USURUT');
			$("form#LB_formLoginEntel").attr('action', action.loginEntelPCS);
			$("form#LB_formLoginEntel")[0].submit();
		}
	});
	
	//Login Fijo Prueba 
	$('form#LB_formLoginEntelFijo input[name=EMPATRUT2],form#LB_formLoginEntelFijo input[name=USURUT2],form#LB_formLoginEntelFijo input[name=USUPAS2]').keypress(function(e) {
		if (e.keyCode == 13 && $("form#LB_formLoginEntelFijo").valid()) {
			formatearRut('EMPATRUT2');
			formatearRut('USURUT2');
			
			var TEMP1 = $("form#LB_formLoginEntelFijo").find('input[name=EMPATRUT2]').val().split('-');
			var RUT1 = TEMP1[0].split(".").join("");
			
			$("form#LB_formLoginEntelFijo").find('input[name=dvEmp]').val(TEMP1[1]);
			$("form#LB_formLoginEntelFijo").find('input[name=rutEmp]').val(RUT1);
			
			var TEMP2 = $("form#LB_formLoginEntelFijo").find('input[name=USURUT2]').val().split('-');
			var RUT2 = TEMP2[0].split(".").join("");
			
			$("form#LB_formLoginEntelFijo").find('input[name=dvAdm]').val(TEMP2[1]);
			$("form#LB_formLoginEntelFijo").find('input[name=rutAdm]').val(RUT2);
			
			var TEMP3 = $("form#LB_formLoginEntelFijo").find('input[name=USUPAS2]').val();
			
			$("form#LB_formLoginEntelFijo").find('input[name=clav]').val(TEMP3);
			
			$("form#LB_formLoginEntelFijo").attr('action', action2.loginEntelFijo);
			$("form#LB_formLoginEntelFijo")[0].submit();
		}
	});
	
	//Entel SA
	$("form#LB_formLoginSA input[name=RutSA]").keypress(function(e) {
		if (e.keyCode == 13 && $("form#LB_formLoginSA").valid()) {
			formatearRut('RutSA');
			
			var TEMP = $("form#LB_formLoginSA").find('input[name=RutSA]').val().split('-');
			var RUT = TEMP[0].split(".").join("");
			
			$("form#LB_formLoginSA").find('input[name=dv]').val(TEMP[1]);
			$("form#LB_formLoginSA").find('input[name=rut]').val(RUT);
			
			$("form#LB_formLoginSA").attr('action',action.loginEntelSA);
			$("form#LB_formLoginSA")[0].submit();
		}
	});
	
	//Conoce la version beta
	$("form#LB_btConoceVerBeta input[name=RutSA]").keypress(function(e) {
		if (e.keyCode == 13 && $("form#LB_formLoginSA").valid()) {
			formatearRut('RutSA');
			
			var TEMP = $("form#LB_formLoginSA").find('input[name=RutSA]').val().split('-');
			var RUT = TEMP[0].split(".").join("");
			
			$("form#LB_formLoginSA").find('input[name=dv]').val(TEMP[1]);
			$("form#LB_formLoginSA").find('input[name=rut]').val(RUT);
			
			$("form#LB_formLoginSA").attr('action',action.ConoceVerBeta);
			$("form#LB_formLoginSA")[0].submit();
		}
	});
	
	/*
	 * Solicitar Clave Mi EPCS
	 */
	//EPCS
	$('#LB_btnSolicitarClaveEntel').click(function() {
		$("form#LB_formLoginEntel").attr('action',action.solicitarClaveEPCS);
		$("form#LB_formLoginEntel")[0].submit();
	});
	//Login Fijo Prueba
	$('#LB_btnSolicitarClaveEntelFijo').click(function() {
		$("form#LB_formLoginEntelFijo").attr('action',action2.solicitarClaveFijo);
		$("form#LB_formLoginEntelFijo")[0].submit();
	});
	
	/*------------------------------------
			     Validacion
	------------------------------------*/
	$('input').keypress(function(e) {
		if (e.keyCode != 13) {
			$('#globoError, #globoErrorAlternativo').fadeOut();
			if ($(this).get(0).disableError) 
				$(this).get(0).disableError();
		}					 
	});
		
});

function showGlobo(el, $padre) {
	$('.columna_lb:first').css('z-index',10);
	
	var $input = $(el);
	var $globo = $('#globoError');
	
	var punto = {};
	punto.left = (parseInt($padre.offset().left) - parseInt($input.offset().left)) + parseInt($input.width()) - 130;
	punto.top = (parseInt($input.offset().top) - parseInt($padre.offset().top)) + (parseInt($input.height())/2 - 43);
	
	if ($globo.is(':hidden')) {
		$globo.fadeIn(200, function() {
			$(el).focus();							
		});
	}
	
	$globo.css({
		'top': punto.top+'px',
		'left': punto.left+'px'
	});
	
	$('input, select').each(function() {
		if(this.disableError) {
   			this.disableError();
		}
	});
	if(el.enableError) {
		el.enableError();
	}
	
	return false;
}

function showGloboAlternativo(el, $padre) {
	$('.columna_lb:first').css('z-index',1);
	
	var $input = $(el);
	var $globo = $('#globoErrorAlternativo');
	
	var punto = {};
	punto.left = (parseInt($padre.offset().left) - parseInt($input.offset().left)) - 188;
	punto.top = (parseInt($input.offset().top) - parseInt($padre.offset().top)) + (parseInt($input.height())/2 - 15);
	
	if ($globo.is(':hidden')) {
		$globo.fadeIn(200, function() {
			$(el).focus();							
		});
	}
	
	$globo.css({
		'top': punto.top+'px',
		'left': punto.left+'px'
	});
	
	$('input, select').each(function() {
		if(this.disableError) {
   			this.disableError();
		}
	});
	if(el.enableError) {
		el.enableError();
	}
	
	return false;
}

function soloNumeros(evt){
	var key = evt.keyCode ? evt.keyCode : evt.which ;
	return (key <= 31 || (key >= 48 && key <= 57)); 
}

function soloRUT(evt) {
	var key = evt.keyCode ? evt.keyCode : evt.which ;
	return (key <= 31 || (key >= 48 && key <= 57) || key == 75 || key == 107); 
}

function formatearRut(casilla){
	function formatearMillones(nNmb){
		var sRes = "";
		for (var j, i = nNmb.length - 1, j = 0; i >= 0; i--, j++)
		 sRes = nNmb.charAt(i) + ((j > 0) && (j % 3 == 0)? ".": "") + sRes;
		return sRes;
	}
	
	var casillaRut=document.getElementById(casilla);
	
	var rut=casillaRut.value;
	var ultimoDigito=rut.substr(rut.length-1,1);
	var terminaEnK = (ultimoDigito.toLowerCase()=="k");
	rutSinFormato=rut.replace(/\W/g,"");
	rut=rut.replace(/\D/g,"");
	var dv=rut.substr(rut.length-1,1);
	if(!terminaEnK){ rut=rut.substr(0,rut.length-1); }
	else{ dv="K"; }
	if(rut && dv) {
		casillaRut.value=formatearMillones(rut)+"-"+dv;
		document.getElementById('buic_rutdv').value=rutSinFormato;
	}
}
