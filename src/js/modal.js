$(function(){
    $('.js-modal-open').on('click', function(){
        if($('#js-overlay')[0]){
            $('#js-overlay').remove();
        }
        
        let target = '#' + $(this).data("target");
        $(this).blur();
        
        $('body').append('<div id="js-overlay"></div>');
        $('#js-overlay').fadeIn('slow');
        $(target).fadeIn('slow');
        
        $('#js-overlay, .modal').on('click', function(e){
            //e.preventDefault();
            e.stopPropagation();
            
            $('.modal').fadeOut();
            $('#js-overlay').fadeOut('slow', function(){
                $('#js-overlay').remove();
            });
        });
    });
});