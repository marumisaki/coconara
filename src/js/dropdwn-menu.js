$(function(){
    $('.nav li').hover(function(){
        $("ul:not(:animated)", this).slideDown();
    }, function(){
        $("ul.nav__list__dropdwn",this).slideUp();
    });
});