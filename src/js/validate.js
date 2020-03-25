$(function(){

	console.log('radio:' + $('input[name="register_id"]').prop('checked'));
	$('.js-form').on('change', function(e){
		const errMSG_1 = '入力必須項目です！';
		const errMSG_2 = '数字で入力して下さい';
		const errMSG_3 = '200文字以上で入力して下さい';
		console.log($(e.target).val());
		console.log($(e.target).data('valid'));
		let msg = '';
		console.log(msg);
		if($(e.target).data('valid').indexOf('require') != -1){
			msg = ($(e.target).val()) ? '': errMSG_1;
			console.log('msg:' + msg);
		}
		if($(e.target).data('valid').indexOf('require_radio') != -1){
			msg = ($('input[name='+ e.target.name + ']:checked').val()) ? '': errMSG_1;
			console.log('msg1:' + msg);
		}
		if(msg){
			$(e.target).parent("label").addClass('has_error');
			$(e.target).parent().find(".err").text(msg);
		}else{
			$(e.target).parent("label").removeClass('has_error');
			$(e.target).parent().find(".err").text('');
			if($(e.target).data('valid').indexOf('num') != -1){
				msg = ($(e.target).val().match(/^[0-9]*$/)) ? '': errMSG_2;
			}
			if($(e.target).data('valid').indexOf('min-200') != -1){
				let count = $(e.target).val().length;
				$(e.target).siblings(".text-count").text(count + '文字');
				msg = (count >= 200) ? '': errMSG_3;
			}

			if(msg){
				$(e.target).parent("label").addClass('has_error');
				$(e.target).parent().find(".err").text(msg);
			}
		}

		if($('.js-form[name="course_id"]').val() == "new"){
			console.log('test');
			$otherCouse = $(this).closest(".js-course").siblings(".js-other-course");
			$otherCouse.slideDown(1000);
		}else{
			$otherCouse = $(this).closest(".js-course").siblings(".js-other-course");
			$otherCouse.slideUp(1000);
		}

		if($('.js-form[name="assessment_0"]').val() && $('.js-form[name="score_0"]:checked').val() ){
			console.log('test');
			console.log('score' +$('.js-form[name="score_0"]:checked').val());
			console.log($(this));
			$('.js-form[name="assessment_0"]').closest('.score-form').next('.score-form').removeClass('js-hidden').addClass('u-flex-between');
		}else{
			$('.js-form[name="assessment_0"]').closest('.score-form').next('.score-form').addClass('js-hidden');
		}

		if($('.js-form[name="assessment_1"]').val() && $('.js-form[name="score_1"]:checked').val() ){
			console.log($('.js-form[name="score_1"]:checked').val());
			console.log($(this));
			$('.js-form[name="assessment_1"]').closest('.score-form').next('.score-form').removeClass('js-hidden').addClass('u-flex-between');
		}else{
			$('.js-form[name="assessment_1"]').closest('.score-form').next('.score-form').addClass('js-hidden');
		}


	});
	if($('.js-form[name="course_id"]').val() == "new"){
		console.log($('.js-form[name="course_id"]').val());
		$('.js-form[name="course_id"]').closest(".js-course").siblings(".js-other-course").removeClass('js-hidden');
	}else{
		$('.js-form[name="course_id"]').closest(".js-course").siblings(".js-other-course").addClass('js-hidden');
	}

	if($('.js-form[name="assessment_0"]').val() && $('.js-form[name="score_0"]:checked').val() ){
		console.log('test');
		console.log('score' +$('.js-form[name="score_0"]:checked').val());
		console.log($(this));
		$('.js-form[name="assessment_0"]').closest('.score-form').next('.score-form').removeClass('js-hidden').addClass('u-flex-between');
	}else{
		console.log('test1');
		$('.js-form[name="assessment_0"]').closest('.score-form').next('.score-form').addClass('js-hidden');
	}

	if($('.js-form[name="assessment_1"]').val() && $('.js-form[name="score_1"]:checked').val() ){
		console.log($('.js-form[name="score_1"]:checked').val());
		console.log($(this));
		$('.js-form[name="assessment_1"]').closest('.score-form').next('.score-form').removeClass('js-hidden').addClass('u-flex-between');
	}else{
		$('.js-form[name="assessment_1"]').closest('.score-form').next('.score-form').addClass('js-hidden');
	}



});
