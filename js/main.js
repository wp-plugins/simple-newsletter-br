$ = jQuery;
$(function() {
	$('#submit_simplenewsletter').submit(function( event ) {
		event.preventDefault();
		var posting = $.post( '', $(this).serialize() );
		posting.done(function(e){
			e = $.parseJSON(e);
			if(e.success == '1'){
				message = '<div class="simplenewsletter-success">'+e.message+'</div>';
				showSucess(message);
			}else{
				$("fieldset.simplenewsleter-field span").remove();
				$.each(e.message,function(field, error) {
					$(".simplenewsleter-field-"+field).append('<span class="error">'+error+'</span>');
				});

			}
			
		});
	});
});

function showSucess(message)
{
	var showon = $('.simplenewsletter').data('showon');

	if( showon == 'append'){
		$('.simplenewsletter').append(message);
		return 0;
	}

	if(showon == 'prepend'){
		$('.simplenewsletter').prepend(message);
		return 0;
	}

	if(showon == 'substitute')
	{
		$('.simplenewsletter').html(message);
		return 0;
	}
	
}