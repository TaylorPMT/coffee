
require('./bootstrap');

import $ from 'jquery';
require ('../../node_modules/slick-carousel');
// SLICK 
$(document).ready( function() {
    // BANNER
    $(".content__banner").slick({
        dots: false,
        infinite: true,
        speed: 400,
        slidesToShow: 1,
        variableWidth: false,
        autoplay: true
    });
    // DEAL
    $(".slick-deal").slick({
        dots: false,
        infinite: true,
        speed: 400,
        slidesToShow: 5,
        variableWidth: false,
        autoplay: true,
        centerMode: false,
        arrows:false,
        responsive: [
          {
            breakpoint: 576,
            settings: {
              slidesToShow: 1,
              infinite: true,
              dots: false
            }
          },
          {
            breakpoint: 769,
            settings: {
              slidesToShow: 3,
              infinite: true,
              dots: false
            }
          },
          {
            breakpoint: 1025,
            settings: {
              slidesToShow: 4,
              infinite: true,
              dots: false
            }
          },
        ]
        // lazyLoad: 'ondemand'    
    });
    if ( $(window).width() <= 1024) {
      $('.slick-deal-2').addClass('slick-deal-3');
      $(".slick-deal-3").slick({
        slidesToShow: 5,  
        autoplay: true,
        arrows:false,
        // mobileFirst:true,
        responsive: [
          {
            breakpoint: 480,
              settings: {
                dots: false,
                infinite: true,
                speed: 400,
                slidesToShow: 2,
                slidesToScroll: 1,
                variableWidth: false,
                autoplay: true,
              }
          },
          {
            breakpoint: 576,
              settings: {
                dots: false,
                infinite: true,
                speed: 400,
                slidesToShow: 3,
                slidesToScroll: 1,
                variableWidth: false,
                autoplay: true,
              }
          },
          {
              breakpoint: 769,
              settings: {
                dots: false,
                infinite: true,
                speed: 400,
                slidesToShow: 4,
                slidesToScroll: 1,
                variableWidth: false,
                autoplay: true,
                centerMode: false,
                lazyLoad: 'ondemand'
              }
          },
        ]
        
    });
     }
     else {
      $('.slick-deal-2').remove('slick-deal-3');
     }
    // NEWS
    $(".slick-deal-4").slick({
      dots: false,
      infinite: true,
      speed: 400,
      slidesToShow: 4,
      variableWidth: true,
      autoplay: true
  });
  //PROCDUCT

  $('.slider-single').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: false,
    asNavFor: '.slider-nav'
  });
  $('.slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.slider-single',
    dots: false,
    arrows: false,
    centerMode: false,
    focusOnSelect: true
  });
});

$(document).on("click",".nav-item", function() {
    var $this = $(".tab-loadding");
    $this.css("display","block");
     setTimeout(function() { 
        $this.css("display", "none");
     }, 500);
    console.log($this);
});

// END TAB


// Scroll To Top
// Get the button
var mybutton = document.getElementById("totop");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 800 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "flex";
  } else {
    mybutton.style.display = "none";
  }
}
// // When the user clicks on the button, scroll to the top of the document

mybutton.addEventListener('click', () => window.scrollTo({
  top: 0,
  behavior: 'smooth',
}));
// END SCROLL TO TOP
var btnSearch = document.querySelector('.btn-search');
var modalSearch = document.querySelector('.section__header--search')
// Open Search
// btnSearch.onclick = function() {
//     modalSearch.classList.add('search-active');
// }

// Close Search 
var btnClose = document.querySelector(".btn-close");
btnClose.onclick = function() {
    modalSearch.classList.remove('search-active');
}
const iconNav = document.querySelector(".container-2");
const mobMenu = document.querySelector(".mob__menu")
const pushRight = document.querySelector("#header");
const html = document.querySelector("html");

iconNav.onclick = function() {
    if (iconNav.classList) {
        iconNav.classList.toggle("change");
        mobMenu.classList.toggle("mob-menu-active");
        pushRight.classList.toggle("header-active");
        if(mobMenu.classList.contains("mob-menu-active")) {
          html.style.overflow = "hidden";
        }
        else {
          html.style.overflow = "visible";
        }
    }
} ;


var x = document.querySelector(".btn.btn-link");


x.onclick = function(){
  var y = document.querySelector(".btn.btn-link span");
  console.log(y.style.transform);
  if (y.style.transform == "rotate(0deg)") {
    y.style.transform = "rotate(90deg)";
  }
  else {
    y.style.transform = "rotate(0deg)";
  }
  
}
// var btnSearch = document.querySelector('.btn-search');
// var modalSearch = document.querySelector('.section__header--search')
// Cart
$(function() {
  $(".icon-cart").on("click", function(e) {
    $(".section__cart").toggleClass("cart__active");
    e.stopPropagation()
  });
  $(document).on("click", function(e) {
        if ($(e.target).is(".icon-cart,.section__cart") === false) {
          $(".section__cart").removeClass("cart__active");
        }
      });
  // Search
  $(".btn-search").on("click", function(e) {
    $(".section__header--search").toggleClass("search-active");
    e.stopPropagation();
    $("html").css("overflow","hidden");
  });
  $(document).on("click", function(e) {
        if ($(e.target).is(".btn-search,.section__header--search") === false) {
          $(".section__header--search").removeClass("search-active");
          $("html").css("overflow","visible");
        }
    });
  // End Search
});




