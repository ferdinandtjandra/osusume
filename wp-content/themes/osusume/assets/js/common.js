jQuery(function($){
	var HeaderH;
	/* header */
	$(window).on("load resize",function(){
		HeaderH = $(".header_wrap").outerHeight();
		$(".common_main").css({"padding-top":HeaderH});
	});
  $('a[href^="#"]').on("click",function(){
  	var speed = 500; 
  	var href= $(this).attr("href");
  	var target = $(href == "#" || href == "" ? 'html' : href);
  	if(target.length){
  	  var position = target.offset().top;
  	}
  	$("body,html").animate({scrollTop:position - HeaderH}, speed, 'swing');
  	return false;
  });
  

  $("#MenuOpenBtn").on("click",function(){
	  $(this).toggleClass("active");
	  $("#MenuWindow").toggleClass("active");
  });
  $(".MenuPopBtn").on("click",function(){
	  $(this).toggleClass("active").next().stop().slideToggle();
  });
  
  /* 目次番号 */
  var oddCounter = 1;
  var evenCounter;
  var ListoddNum = $(".ContentsList li:even").length;
  $(".ContentsList li").each(function(i){
	  if(i % 2 == 0) {
		  $(this).find("a").attr("href","#Block"+oddCounter).find(".num").text(oddCounter+".");
		} else {
			evenCounter = oddCounter + ListoddNum;
			$(this).find("a").attr("href","#Block"+evenCounter).find(".num").text(evenCounter+".");
			oddCounter ++;
		}
  });
  
  $(window).scroll(function () {
      const scrollAmount = $(window).scrollTop();
      if(scrollAmount > 0){
	      $("#TopBtn").fadeIn();
	      $(".header_wrap").addClass("active");
      }else{
	      $("#TopBtn").fadeOut();
	      $(".header_wrap").removeClass("active");
      }
  });
  
  $(".ViewBtn").on("click",function(){
	  $(this).hide().parent().prev().addClass("active");
  });
  
  /* detail */
  $(".ContentsBtn").on("click",function(){
	  $(this).toggleClass("active").parent(). next().stop().slideToggle();
  });
  $(".AsideTabItem").on("click",function(){
	  var Target = $(this).data("tab");
	  $(this).addClass("active").siblings().removeClass("active");
	  $("."+Target).addClass("active").siblings().removeClass("active");
  });
 	
});