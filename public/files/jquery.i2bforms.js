
$.fn.selectBox = function(options){
    return this.each(function(){
        var w = $(this).css('width');
        w = (/[0-9]*px/i.test(w)) ? parseInt(w) : 200;
        var opt = {
            'border': 'none',
            'background': 'transparent',
            'height': 22,
            'width': w,
            'textAlign': 'left'			
        }
        
        if ($(this).attr('opt')) {
            $.extend(opt, eval('(' + $(this).attr('opt') + ')'));
        }
        
        var select = $(this).hide();
        var options = select[0].options;
        var input_s = $('<input readonly="readonly" type="text" />').css({
            'border': opt.border,
            'background': opt.background
        });
        var container = select.parent();
        
        var css_divs = {
            'float': 'left',
            'backgroundImage': 'url(/personas/img/i2bforms/bg_input.gif)',
            'backgroundRepeat': 'no-repeat',
            'width': 4,
            'height': opt.height
        };
		var css_divs_error = {
            'backgroundImage': 'url(/personas/img/i2bforms/bg_input_error.gif)'
		};
        var css_arrow = {
            'backgroundImage': 'url(/personas/img/i2bforms/img_select_arrow.gif)',
            'width': 18,
            'height': opt.height
        };
		var css_arrow_error = {
			'backgroundImage': 'url(/personas/img/i2bforms/img_select_arrow_error.gif)'
		};
        var css_option = {
            'height': 20,
            'color': '#444',
            'background': '#fff',
            'cursor': 'pointer',
            'fontSize': '11px',
            'fontFamily': 'Arial',
            'paddingLeft': 10,
            'paddingRight': 10
        };
        var css_option_over = {};
        $.extend(css_option_over, css_option)
        css_option_over.color = '#fff';
        css_option_over.background = '#555';
        
        var drop_down = function(){
            options = select[0].options;
            if (options.length > 0) {
                divl.css('backgroundImage', 'url(/personas/img/i2bforms/bg_input.gif)');
                divc.css('backgroundImage', 'url(/personas/img/i2bforms/bg_input.gif)');
                diva.css('backgroundImage', 'url(/personas/i2bforms/bg_input.gif)');
                divr.css('backgroundImage', 'url(/personas/img/i2bforms/bg_input.gif)');
				arrow.css('backgroundImage', css_arrow.backgroundImage);
                options_div.empty().show();
                
                if (options.length > 6) 
                    options_div.css({
                        'overflowY': 'scroll',
                        'overflowX': 'hidden',
                        'height': css_option.height * 6
                    })
                var table = $('<table></table>').appendTo(options_div).css('borderCollapse', 'collapse');
                $.each(options, function(i, val){
                    var tr = $('<tr></tr>').appendTo(table);
                    var td = $('<td></td>').attr({
                        'align': 'left',
                        'value': val.value
                    }).html(val.text).appendTo(tr).css(css_option).bind('mouseover', function(){
                        $(this).css(css_option_over);
                    }).bind('mouseout', function(){
                        $(this).css(css_option);
                    }).bind('mousedown', function(){
                        select.attr('value', $(this).attr('value'));
                        input_s.val($(this).html());
                        
                        if (select.change) {
                            select.change();
                        }
                    });
                });
                
                $(document).bind('mousedown', function(e){
                    if (!$(e.target).is('.options_div')) {
                        /*divl.css('backgroundImage', css_divs.backgroundImage);
                        divc.css('backgroundImage', css_divs.backgroundImage);
                        diva.css('backgroundImage', css_divs.backgroundImage);
                        divr.css('backgroundImage', css_divs.backgroundImage);
						arrow.css('backgroundImage', css_arrow.backgroundImage);*/
                        options_div.hide();
                        input_s.focus();
                        $(document).unbind('mousedown');
                    }
                });
            }
        }
        
        var div = $('<div></div>').appendTo(container).css({
            'zIndex': 5000,
            'float': 'left',
            'position': 'relative',
            'height': css_divs.height,/*'width':opt.width,*/
            'cursor': 'pointer'
        }).bind('click', drop_down);
        var divl = $('<div></div>').appendTo(div).css(css_divs).css({
            'backgroundPosition': '0px 0px'
        });
        var divc = $('<div></div>').appendTo(div).css(css_divs).css({
            'backgroundPosition': '-' + css_divs.width + 'px 0px',
            'width': opt.width - css_arrow.width - (css_divs.width * 2)
        });
        var diva = $('<div></div>').appendTo(div).css(css_divs).css({
            'backgroundPosition': '-' + css_divs.width + 'px 0px',
            'width': css_arrow.width
        });
        var divr = $('<div></div>').appendTo(div).css(css_divs).css({
            'backgroundPosition': 'right 0px'
        });
        var arrow = $('<div></div>').appendTo(diva).css(css_arrow);
        
        // Solo para centrar verticalmente el input ******
        var table = $('<table></table>').appendTo(divc).css({
            'height': '100%',
            'width': opt.width - css_arrow.width - (css_divs.width * 2)
        });
        var tr = $('<tr></tr>').appendTo(table);
        var td = $('<td></td>').appendTo(tr);
        // *****************
        
        input_s.appendTo(td).css({
            'cursor': 'pointer',
            'textAlign': opt.textAlign,
            'width': opt.width - css_arrow.width - (css_divs.width * 2),
			'font-family': 'Trebuchet MS, Arial, Helvetica, sans-serif',
			'font-size': '1.2em',
			'font-style': 'oblique'
        }).bind('blur', function(){
            divl.css('backgroundImage', css_divs.backgroundImage);
            divc.css('backgroundImage', css_divs.backgroundImage);
            diva.css('backgroundImage', css_divs.backgroundImage);
            divr.css('backgroundImage', css_divs.backgroundImage);
            options_div.hide();
        });
        
        // Options **********
        var css_options_div = {
            'position': 'absolute',
            'background': '#555',
            'width': opt.width-5,
            'top': 22,
            'left': 2,
            'border': '1px solid #d6d6d6',
            'overflowX': 'hidden',
            'zIndex': 5001,
			'font-family': 'Trebuchet MS, Arial, Helvetica, sans-serif',
			'font-size': '1.2em',
			'font-style': 'oblique'
        }
        
        var options_div = $('<div></div>').addClass('options_div').appendTo(div).css(css_options_div).hide();
        // ******************
        
        if(options.length > 0) {
            input_s.val(options[0].text);
            select.val(options[0].value);
        }
        
        var div_disabled = $('<div></div>').hide().appendTo(div).css({
            position: 'absolute',
            top: 0,
            left: 0,
            width: ($.browser.msie && $.browser.version == '6.0') ? opt.width + 4 : opt.width,
            height: opt.height,
            background: '#ccc',
            opacity: 0.7
        });
        
        this.enable = function(){
            div_disabled.hide();
            div.bind('click', drop_down);
        };
        this.disable = function(){
            div_disabled.show().css('cursor', 'default');
            div.unbind('click', drop_down);
        };
        this.setValue = function(v){
            select.attr('value', v);
            input_s.val(select[0].options[select[0].selectedIndex].text);
        };
		
		this.enableError = function() {
			divl.css('backgroundImage', css_divs_error.backgroundImage);
			divc.css('backgroundImage', css_divs_error.backgroundImage);
			diva.css('backgroundImage', css_divs_error.backgroundImage);
			divr.css('backgroundImage', css_divs_error.backgroundImage);
			arrow.css('backgroundImage', css_arrow_error.backgroundImage);
		};
		
		this.disableError = function() {
			divl.css('backgroundImage', css_divs.backgroundImage);
			divc.css('backgroundImage', css_divs.backgroundImage);
			diva.css('backgroundImage', css_divs.backgroundImage);
			divr.css('backgroundImage', css_divs.backgroundImage);
			arrow.css('backgroundImage', css_arrow.backgroundImage);
		};
        
        if (select.attr('disabled')) {
            this.disable();
        }
    });
};



/*
$.fn.inputBox = function(){
    return this.each(function(){
        var w = $(this).css('width');
        w = (/[0-9]*px/i.test(w)) ? parseInt(w) : 225;
        var opt = {
            'border': 'none',
            'background': 'transparent',
            'height': 22,
            'width': w,
            'textAlign': 'left',
			'font-family': 'Trebuchet MS, Arial, Helvetica, sans-serif',
			'font-size': '1.2em'
        }
        
        if ($(this).attr('opt')) {
            $.extend(opt, eval('(' + $(this).attr('opt') + ')'));
        }
        
        var input = $(this).css({
            'border': opt.border,
            'background': opt.background,
			'font-family': 'Trebuchet MS, Arial, Helvetica, sans-serif',
			'font-size': '1.2em'
        });
        var container = input.parent();
        
        var css_divs = {
            'float': 'left',
            'backgroundImage': 'url(/wp-content/themes/kraft/img/i2bforms/bg_input.gif)',
            'backgroundRepeat': 'no-repeat',
            'width': 4,
            'height': opt.height
        };
        var css_divs_error = {
            'backgroundImage': 'url(/wp-content/themes/kraft/img/i2bforms/bg_input_error.gif)'
		};
        var div = $('<div></div>').appendTo(container).css({
            'float': 'left',
            'position': 'relative',
            'height': css_divs.height
        });
        var divl = $('<div></div>').appendTo(div).css(css_divs).css({
            'backgroundPosition': '0px 0px'
        });
        var divc = $('<div></div>').appendTo(div).css(css_divs).css({
            'backgroundPosition': '-' + css_divs.width + 'px 0px',
            'width': opt.width - (css_divs.width * 2)
        });
        var divr = $('<div></div>').appendTo(div).css(css_divs).css({
            'backgroundPosition': 'right 0px'
        });
        
        // Solo para centrar verticalmente el input ******
        var table = $('<table></table>').appendTo(divc).css({
            'height': '100%',
            'width': opt.width - (css_divs.width * 2)
        });
        var tr = $('<tr></tr>').appendTo(table);
        var td = $('<td></td>').appendTo(tr);
        // *****************
        
        input.appendTo(td).css({
            'textAlign': opt.textAlign,
            'width': opt.width - (css_divs.width * 2)
        }).bind('blur', function(){

        }).val(this.value);
		
		
		this.enableError = function() {
			divl.css('backgroundImage', css_divs_error.backgroundImage);
			divc.css('backgroundImage', css_divs_error.backgroundImage);
			divr.css('backgroundImage', css_divs_error.backgroundImage);
		};
		
		this.disableError = function() {
			divl.css('backgroundImage', css_divs.backgroundImage);
			divc.css('backgroundImage', css_divs.backgroundImage);
			divr.css('backgroundImage', css_divs.backgroundImage);
		};
		
    });
};*/


$.fn.inputBox = function(){
    return this.each(function(){
        var w = $(this).css('width');
        w = (/[0-9]*px/i.test(w)) ? parseInt(w) : 225;
		
		/*
		 * Valores por defecto
		 */
        var opt = {
            'height': 26,
            'width': w,
            'textAlign': 'left',
			
			'img': 'url(/personas/img/i2bforms/bg_inputLiquido.gif)',
			'imgError': 'url(/personas/img/i2bforms/bg_inputErrorLiquido.gif)',
			'cornerRadius': 3
        }
        if ($(this).attr('opt')) {
            $.extend(opt, eval('(' + $(this).attr('opt') + ')'));
        }
        
        var input = $(this).css({
            border: 'none',
			background: 'transparent',
			textAlign: opt.textAlign,
            width: opt.width - (opt.cornerRadius * 2),
			display: 'block',
			margin: '-'+opt.cornerRadius+'px 0px'
        });
        var container = input.parent();
        	
		/*
		 * Estilos para las esquinas
		 */	
		var estilosEsquinas = {
			backgroundImage: opt.img,
			width: opt.cornerRadius+'px',
			height: opt.cornerRadius+'px',
			fontSize: '1px'
		};
		
		/*
		 * Construccion de tabla base
		 */
		var tabla = $('<table></table>').appendTo(container).css({
			borderCollapse: 'collapse',
			'float': 'left',
			position: 'relative',
			height: opt.height,
			width: opt.width
		});
		var tbody = $('<tbody></tbody>').appendTo(tabla);
		
		//Fila superior
		var trTop = $('<tr></tr>').appendTo(tbody);
		
		//Esquina superior izquierda
		var tdTopLeft = $('<td></td>').appendTo(trTop).css(estilosEsquinas).css({
			backgroundPosition: '0px 0px'
		});
		//Top
		var tdTop = $('<td></td>').appendTo(trTop).css({
			backgroundImage: opt.img,
			backgroundPosition: '-'+ opt.cornerRadius+'px 0px'
		});
		//Esquina superior derecha
		var tdTopRight = $('<td></td>').appendTo(trTop).css(estilosEsquinas).css({
			backgroundPosition: 'right 0px'
		});
		
		//Fila principal
		var trMain = $('<tr></tr>').appendTo(tbody);
		
		//Left
		var tdMainLeft = $('<td></td>').appendTo(trMain).css({
			backgroundImage: opt.img,
			backgroundPosition: '0px -'+opt.cornerRadius+'px'	
		});
		
		//Centro
		var tdMainCenter = $('<td></td>').appendTo(trMain).css({
			backgroundImage: opt.img,
			backgroundPosition: '-'+opt.cornerRadius+'px -'+opt.cornerRadius+'px'		
		});
		
		//Right
		var tdMainRight = $('<td></td>').appendTo(trMain).css({
			backgroundImage: opt.img,
			backgroundPosition: 'right -'+opt.cornerRadius+'px'
		});
		
		//Fila inferior
		var trBottom = $('<tr></tr>').appendTo(tbody);
		
		//Esquina inferior izquierda
		var tdBottomLeft = $('<td></td>').appendTo(trBottom).css(estilosEsquinas).css({
			backgroundPosition: 'bottom left'
		});
		
		//Bottom
		var tdBottom = $('<td></td>').appendTo(trBottom).css({
			backgroundImage: opt.img,
			backgroundPosition: '-'+opt.cornerRadius+'px bottom'
		});
		
		//Esquina inferior derecha
		var tdBottomRight = $('<td></td>').appendTo(trBottom).css(estilosEsquinas).css({
			backgroundPosition: 'bottom right'
		});
		      	  
		/*
		 * Se agrega el input a la tabla
		 */
        input.appendTo(tdMainCenter).val(this.value);
		
		
		/*
		 * -------
		 * Metodos
		 * -------
		 */
		this.enableError = function() {
			tdTopLeft.css('backgroundImage', opt.imgError);
			tdTop.css('backgroundImage', opt.imgError);
			tdTopRight.css('backgroundImage', opt.imgError);
			tdMainLeft.css('backgroundImage', opt.imgError);
			tdMainCenter.css('backgroundImage', opt.imgError);
			tdMainRight.css('backgroundImage', opt.imgError);
			tdBottomLeft.css('backgroundImage', opt.imgError);
			tdBottom.css('backgroundImage', opt.imgError);
			tdBottomRight.css('backgroundImage', opt.imgError);
		};
		
		this.disableError = function() {
			tdTopLeft.css('backgroundImage', opt.img);
			tdTop.css('backgroundImage', opt.img);
			tdTopRight.css('backgroundImage', opt.img);
			tdMainLeft.css('backgroundImage', opt.img);
			tdMainCenter.css('backgroundImage', opt.img);
			tdMainRight.css('backgroundImage', opt.img);
			tdBottomLeft.css('backgroundImage', opt.img);
			tdBottom.css('backgroundImage', opt.img);
			tdBottomRight.css('backgroundImage', opt.img);
		};
		
    });
};