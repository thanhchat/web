(function($){

        // Slidder home 4
        if($('#slideShopping').length >0){
            var slider = $('#slideShopping').bxSlider({
                nextText:'<i class="fa fa-angle-right"></i>',
                prevText:'<i class="fa fa-angle-left"></i>',
                auto: true,
				pager:false,
                onSliderLoad:function(currentIndex){
                    $('#slideShopping li').find('.caption').each(function(i){
                        $(this).show().addClass('animated zoomIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                            $(this).removeClass('zoomIn animated');
                        });
                    })                      
                },
                onSlideBefore:function(slideElement, oldIndex, newIndex){
                    //slideElement.find('.sl-description').hide();
                    slideElement.find('.caption').each(function(){                    
                       $(this).hide().removeClass('animated zoomIn'); 
                    });                
                },
                onSlideAfter: function(slideElement, oldIndex, newIndex){  
                    //slideElement.find('.sl-description').show();
                    setTimeout(function(){
                        slideElement.find('.caption').each(function(){                    
                           $(this).show().addClass('animated zoomIn').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                                $(this).removeClass('zoomIn animated');
                            }); 
                        });
                    }, 500);
                }
            });
            //slider.reloadSlider();
        }
})(jQuery); // End of use strict