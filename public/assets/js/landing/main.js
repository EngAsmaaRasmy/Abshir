$(function(){
    'use strict';





 //start popUp
 $('.pop-button').click(function(e){
    e.preventDefault();
    $('.popup').fadeIn(1000);
})
$(".popup .Click").click(function(){
    $(".popup").hide();
   })
//end popUp




//Start scroll to top buttom
    $(window).scroll(function(){

        
        if($(window).scrollTop() >= 580){
            $(".scrolltotop").fadeIn(1500);
        }else{
         $(".scrolltotop").fadeOut(1500);
        }
        //End scroll to top buttom


        
 




    })
    //Start scroll to go up
    $(".scrolltotop").click(function(e){
     e.preventDefault();         //يمنع المعتاد
     $("html,body").animate({
         scrollTop:0
     },500)
    })

    
//Start scroll Top

        $(".copyright .navs li a , .navbar li a").click(function(e){
            e.preventDefault();              //يمنع المعتاد
            $("html,body").animate({
        scrollTop: $("#" + $(this).data("scroll")).offset().top-10
            },1500)
        })

    //End scroll Top
    //loading

    var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 2000);
	};
	loader();
  
   
    $('.owl-carousel').owlCarousel({
        
        loop:true,
        autoplay:true,
        margin:10,
        nav:true,
        responsiveClass:true,
        responsive:true,
        rtl: true,
        navElement:true,
        dots: false,            
        responsive:{
            0:{
                items:1,
                loop:true
                
            },
            600:{
                items:2,
                loop:true
                
            },
            1000:{
                items:3,
                loop:true
                
            }
        }
    })
   
 
  owl.owlCarousel({
     
      
  });











    //loading

    var loader = function() {
		setTimeout(function() { 
			if($('#ftco-loader').length > 0) {
				$('#ftco-loader').removeClass('show');
			}
		}, 2000);
	};
	loader();

});