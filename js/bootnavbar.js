(function($) {
    $.fn.bootnavbar = function() {
        $(this).find('.sub').hover(function() {
            $(this).addClass('show');
            $(this).find('.subdd').first().addClass('show').addClass('animated fadeIn').one('animationend oAnimationEnd mozAnimationEnd webkitAnimationEnd', function () {
            	$(this).removeClass('animated fadeIn');      	
            });
        }, function() {
            $(this).removeClass('show');
            $(this).find('.subdd').first().removeClass('show');
        });
    };    
})(jQuery);