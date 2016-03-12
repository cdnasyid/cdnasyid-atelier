jQuery(function($) {
  // homepage mouse animation
  if( !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
    $("#home-hero").append($('<div class="mouse"><div class="mouse-icon"><span class="mouse-wheel"></span></div></div>'));
  }

  // BETTER SELECTBOX

  $('select.orderby').select2({
    minimumResultsForSearch: Infinity
  });
  $('.shipping-calculator-form select').select2();

  // $('select.orderby').chosen({
  //   width: "240px",
  //   disable_search: true,
  //   inherit_select_classes: true
  // });

  // $('.shipping-calculator-form select').chosen({
  //   width: "100% !important",
  //   // disable_search: true,
  //   inherit_select_classes: true
  // });

  // $('span.amount').each(function() {
  // 	var amount = $(this).text().split(/\./);
  // 	$(this).html('<span class="amount-int">' + amount[0] + '</span><span class="amount-dot">.</span><span class="amount-decimal">' + amount[1] + '</span>');
  // });

  // SHORTEN NAMES

  // $('.product-details small strong').each(function() {
  //   $(this).text($(this).text().replace(/Almarhum/g, 'Alm.'));
  //   $(this).text($(this).text().replace(/Ustaz/g, 'Ust.'));
  // });

  $('.home .product-details small strong').succinct({
    size: 35
  });

  $('.search-results .heading-text h1.entry-title').each(function() {
    $(this).data('orig-text', $(this).text());
    var searchTitle = $(this).text().split(/:\s/);
    $(this).text(searchTitle[0]).append($('<h3>For the keyword <em>' + searchTitle[1] + '</em></h3>'));
  });

  // COLOR THEIF

  function rgba(rgb, a) {
    return 'rgba(' + rgb[0] + ', ' + rgb[1] + ', ' + rgb[2] + ', ' + a + ')';
  }
  function rgba2(rgb, a) {
    return 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + a + ')';
  }

  $('.woocommerce .products .product').each(function () {
    var img = $(this).find('.first-image img')[0];
    var details = $(this).find('.product-details');
    var link_title = $(this).find('.product-details h3 a');
    var artist = $(this).find('.product-details h3 a small strong');

    img.addEventListener('load', function() {
      var vibrant = new Vibrant(img);
      var swatches = vibrant.swatches();
      var hex = swatches['DarkVibrant'].getHex();
      var rgb = swatches['DarkVibrant'].getRgb();
      details.css({
        'color': hex
      });
      artist.css('border-color', rgba(rgb, '.7'));
    });
  });

  // BETTER FORM

  $('.form-group input, .form-group textarea').each(function () {
    var $input = $(this);
    $input.focus(function () {
      $input.closest('.form-group').addClass('focus');
    });
    $input.blur(function () {
      $input.closest('.form-group').removeClass('focus');
    });
  });


  // $('.wpcf7-form-control-wrap').each(function () {
  //   $(this).after($(this).html()).remove();
  // });


  // // product cat active
  // (function () {
  //   var categories = [];
  //   $('.sidebar ul.product-categories > li').each(function () {
  //     console.log($(this).attr('class'));
  //     // categories.push();
  //   });
  // })();
});
