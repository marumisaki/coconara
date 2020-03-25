$(function(){
	$('.add-history').on('click', function(e){
		if($('.input[name="history_name0"]').val()){
			console.log($('.js-history[name="history0"]').val());
			console.log($(this));
			$(this).siblings('.history_area1').removeClass('js-hidden');
		}
		if($('.input[name="history_name1"]').val()){
			console.log($('.js-history[name="history1"]').val());
			console.log($(this));
			$(this).siblings('.history_area2').removeClass('js-hidden');
			$('.add-history').addClass('js-hidden');
		}
		if(!($('.history_area2.js-hidden').length)){
			$('.add-history').addClass('js-hidden');
		}
	});
	if(!($('.history_area2.js-hidden').length)){
		$('.add-history').addClass('js-hidden');
	}

	$('.delete-history0').on('click', function(){
  	$("#js-history0").addClass('js-hidden');
		clearForm("#js-history0");
	});
	$('.delete-history1').on('click', function(){
  	$("#js-history1").addClass('js-hidden');
		clearForm("#js-history1");
	});
	$('.delete-history2').on('click', function(){
  	$("#js-history2").addClass('js-hidden');
		clearForm("#js-history2");
	});

	function clearForm (form) {
		$(form)
			.find("input, textarea")
			.val("");
	}
});
