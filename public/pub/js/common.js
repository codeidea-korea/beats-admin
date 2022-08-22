
$(function(){
  var swiper = new Swiper(".slide01", {
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination2",
      type: "fraction",
    },
    loop: true,
    breakpoints: {  
      '780': {
        slidesPerView: 3,
        spaceBetween: 30,}
    },
  });

  $('.menu1').click(function(){
    $('.menu2').slideUp();
    if ($(this).children('.menu2').is(':hidden')){
       $(this).children('.menu2').slideDown().closest('.menu1').addClass('show');
    } else{
       $(this).children('.menu2').slideUp().closest('.menu1').removeClass('show');;
    }
 });


 //sub tap

  const subTap = $('.sub_tap li a');
  const tabCont = $('.tap-con-wrap .tap_con');
  let nowIdx;

  subTap.each(function(){
      $(this).on('click', function(evt){
        nowIdx = $(this).parent('li').index();
        $(this).closest('li').addClass('on').siblings().removeClass('on');
        tabCont.eq(nowIdx).addClass('show').siblings().removeClass('show');
        evt.preventDefault();

        if(tabCont.eq(nowIdx).hasClass('banner-show')){
          $('.tap-btm-banner').css('display','block')
        }else{
          $('.tap-btm-banner').css('display','none')
        }

      });
  });

  const subTap2 = $('.sub_tap_type2 li a');
  const tabCont2 = $('.tap-con-wrap2 .tap_con2');

  let nowIdx2;

  subTap2.each(function(){
      $(this).on('click', function(evt){
        nowIdx2 = $(this).parent('li').index();
        $(this).closest('li').addClass('on').siblings().removeClass('on');
        tabCont2.eq(nowIdx2).addClass('show').siblings().removeClass('show');
        evt.preventDefault();

      });
  });

  // sub tap scroll
  const subScrollTap1 = $('.sub_tap-scroll li:nth-child(1)');
  const subScrollTap2 = $('.sub_tap-scroll li:nth-child(2)');
  const subScrollTap3 = $('.sub_tap-scroll li:nth-child(3)');
  
  subScrollTap1.find('a').on('click', function(evt){
    const scrollCont1 = $('.sub_tit-process').offset().top
    $('html,body').animate({scrollTop: scrollCont1 },300);
    subScrollTap1.addClass('on').siblings().removeClass('on');
    evt.preventDefault();
  });
  
  subScrollTap2.find('a').on('click', function(evt){
    const scrollCont2 = $('.sub_tit-way').offset().top
    $('html,body').animate({scrollTop: scrollCont2 },300);
    subScrollTap2.addClass('on').siblings().removeClass('on');
    evt.preventDefault();
  });
  subScrollTap3.find('a').on('click', function(evt){
    const scrollCont3 = $('.sub_tit-welfare').offset().top
        $('html,body').animate({scrollTop: scrollCont3 },300);
        subScrollTap3.addClass('on').siblings().removeClass('on');
      evt.preventDefault();
  });

  
  // 게시판 배너 슬라이드

  
  var swiper = new Swiper(".mySwiper", {
    pagination: {
      el: ".swiper-pagination",
      type: "fraction",
    },
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    navigation: {
      nextEl: ".swiper-button-next2",
      prevEl: ".swiper-button-prev2",
    },
    breakpoints: {  
      '780': {
        slidesPerView: 3,
        spaceBetween: 42,}
    },
  });


  // help desk

  function inputBlur(){
    const inputItem = $('.help-desk-wrap1 .input_box input')
    const inputItem2 = $('.help-desk-wrap1 .input_box textarea')
    inputItem.bind('keydown', 'ctrl+1', function() {
        $(this).closest('.input_box').addClass('valid');
        if ( $(".input_box input").is(":focus") ) {
          $(".input_box input").trigger('focusout');
        }

    })
    inputItem.on('blur', function(){
        $(this).closest('.input_box').removeClass('valid');
    });
    inputItem2.bind('keydown', 'ctrl+1', function() {
        $(this).closest('.input_box').addClass('valid');
        if ( $(".input_box textarea").is(":focus") ) {
          $(".input_box textarea").trigger('focusout');
        }

    })
    inputItem2.on('blur', function(){
        $(this).closest('.input_box').removeClass('valid');
    });
   
  }
  inputBlur()
      

  //file attach

  $('.file_real').on('change', function() {
    var files = $(this)[0].files[0];
    var fake = $('.file_fake');
    
    fake.val('');
    if ( files !== undefined ) {
      fake.val(files.name);
    }
  });


  // about tsline scroll event
  $(window).scroll(function() {
    if($(window).scrollTop() > $('.tap_con.show .history-wrap').height()*0.5){
      
      $('.history-img img').attr('src','../images/history-icon2.svg');
      $('.history-img-wrap .history-img ul li').removeClass('on');
      $('.history-img-wrap .history-img ul li').eq(1).addClass('on');
    }else{
      $('.history-img img').attr('src','../images/history-icon.svg');
      $('.history-img-wrap .history-img ul li').removeClass('on');
      $('.history-img-wrap .history-img ul li').eq(0).addClass('on');
    }
});


  // nav click -main
  $('.nav_con .menu_btn a').on('click', function(evt){
    $('.nav_con nav').toggleClass('show');
    evt.preventDefault();
  });

  // footer event
  $(window).scroll(function(){
    if($(window).scrollTop() > ($('.footer').offset().top)*0.5){
      $('.footer .btn-gotop').addClass('show');
    }else{
      $('.footer .btn-gotop').removeClass('show');
    }
  });

  $('.footer .btn-gotop').on('click', function(evt){
    evt.preventDefault();
    $("html, body").animate({ scrollTop: 0 });
  });

});