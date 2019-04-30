(function( $ ) {
/* ========================================================================
    Testimonial Carousel
   ========================================================================== */
  var testimonialCarousel = $("#testimonial-carousel");
  testimonialCarousel.owlCarousel({
    autoPlay : 5000,
    stopOnHover : true,
    slideSpeed  :  1000,
    paginationSpeed : 500,
    goToFirstSpeed : 2000,
    singleItem : true,
    responsive : true,
    addClassActive : true,
    navigation: false
  });
  /*Carousel Dicas*/
  $('#myCarousel1').carousel({
    interval:   4000
  });
  /*Livros*/
  $('#myCarousel2').carousel({
      interval: 7000
  })



/* ========================================================================
     Nivo Lightbox
   ========================================================================== */
  $('.portfolio a').nivoLightbox({
    effect: 'fall'
  });
  /* ========================================================================
    Portfolio Filter
   ========================================================================== */
  var container = $('.portfolio-wrapper'); // portfoolio container
  container.isotope({
      itemSelector: '.portfolio-item',
      animationEngine: 'best-available',
      animationOptions: {
          duration: 200,
          queue: false
      },
      layoutMode: 'fitRows'
  });
  // sort items on button click
  $('.filters a').on( 'click', function() {
    $('.filters a').removeClass('active');
    $(this).addClass('active');
    var filterValue = $(this).attr('data-filter');
    container.isotope({
      filter: filterValue
    });
    initIsotope();
    return false;
  });
  // Split columns for different size layout
  function splitColumns() {
      var windowWidth = $(window).width(),
      columnNumber = 1; //  default column number
      if (windowWidth > 1200) {
          columnNumber = 3;
      } else if (windowWidth > 767) {
          columnNumber = 3;
      } else if (windowWidth > 600) {
          columnNumber = 2;
      }
      return columnNumber;
  }
  // Set width for portfolio item
  function setColumns() {
    var windowWidth = $(window).width(),
        columnNumber = splitColumns(),
        postWidth = Math.floor(windowWidth / columnNumber);
    container.find('.portfolio-item').each(function() {
        $(this).css({
            width: postWidth + 'px'
        });
    });
  }
  // initialize isotope
  function initIsotope() {
      setColumns();
      container.isotope('layout');
  }
  /*container.imagesLoaded(function() {
      setColumns();
  });*/
  // $(function() {
  //   $(window).bind('resize', function() {
  //       initIsotope();
  //   });

  //   $(window).load(function(){
  //     initIsotope();
  //   });
  // });
  /**
   * Validar FORMULARIO
   */
    $(document).ready(function(){
        $("input").blur(function(){
            if($(this).val() == "")
            {
                $(this).css({"border-color" : "#F00", "padding": "2px"});
            }
        });
    })
  /*Tumbails Club de Bantagem*/
    $(document).ready(function(){

        $("[rel='tooltip']").tooltip(); 
        
        $('#hover-cap-4col .thumbnail').hover(
            function(){
                $(this).find('.caption').slideDown(250);
            },
            function(){
                $(this).find('.caption').slideUp(250);
            }
            );

        $('#hover-cap-3col .thumbnail').hover(
            function(){
                $(this).find('.caption').fadeIn(250);
            },
            function(){
                $(this).find('.caption').fadeOut(250);
            }
            );
        
        $('#hover-cap-unique .thumbnail').hover(
            function(){
                $(this).find('.caption').slideDown(500);
            },
            function(){
                $(this).find('.caption').slideUp(500);
            }
            );
        
        $('#hover-cap-6col .thumbnail').hover(
            function(){
                $(this).find('.caption').show();
            },
            function(){
                $(this).find('.caption').hide();
            }
            );  
        
    });

})(jQuery);