$(function(){
	$('.show_additional_info').on('click', function(){
		if($('#more_info').is(':checked')){
			$('#additional_info').stop().slideDown(500);
		}else{
			$('#additional_info').stop().slideUp(500);
		}
	});

	$.validity.setup({ outputMode:"label" });
	
	$('form').submit(function(e){
		e.preventDefault();
		that=$(this);
		var id = that.attr('id');
		if(validate_ajax(id)){
			$.ajax({
				url: 'includes/contacto.php',
				type: 'post',
				dataType: 'jsonp',
				jsonp: 'callback',
				data: that.serialize(),
				beforeSend: function(){
					that.find('.form_sending').addClass('active');
					that.find('.ajax_wrapper').removeClass('active');
				},
				error: function(xhr, status, error) {
					alert('error: ' + error);
					that.find('.form_sending').removeClass('active');
					that.find('.ajax_wrapper').addClass('active');
				},
				success: function(data){
					if(data.result == 'success'){
						that.find('.form_sending').html('<h2 style="color:#111; margin:20px 0px 0px 0px;">Gracias por contactarnos</h2><h3 style="font-size:16px; margin:0px;">Nos pondremos en contacto a la brevedad</h3>');
						that.find('.ajax_wrapper').remove();
					}else{
						that.find('.form_sending').removeClass('active');
						that.find('.ajax_wrapper').addClass('active');
					}
				}
			});
		}
		return false;
	});
});

function validate_ajax(id){
	$.validity.start();
	$('#'+id+' #name').require('Campo requerido');
	$('#'+id+' #email').require('Campo requerido').match('email','Debe tener formato de email, ej. nombre@email.com');
	$('#'+id+' #phone').require('Campo requerido');
	//$('#checkbox_aviso').assert( validate_aviso(), 'Debe aceptar el aviso de privacidad para continuar' )
	var result = $.validity.end();
	return result.valid;
}
function validate_aviso(){
	return($('#checkbox_aviso').is(':checked'));
}
