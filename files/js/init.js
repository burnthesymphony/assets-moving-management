$(function(){
	
	$('.slider').mobilyslider({
		content: '.sliderContent',
		children: 'div',
		transition: 'horizontal',
		animationSpeed: 300,
		autoplay: false,
		autoplaySpeed: 3000,
		pauseOnHover: true,
		bullets: true,
		animationStart: function(){},
		animationComplete: function(){}
	});
	
});
