jQuery ($) ->
  # homepage mouse animation
  if !/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)
    $('#home-hero').append $('<div class="mouse"><div class="mouse-icon"><span class="mouse-wheel"></span></div></div>')

  # SELECT2
  # if page SHOP or CART
  if ( $().select2 )
    $('select.orderby').select2 { minimumResultsForSearch: Infinity }
    $('.shipping-calculator-form select').select2()
    $('.woocommerce .widget select').select2()

  # SHORTEN ARTIST NAMES
  # $('.product-details small strong').succinct { size: 25 }

  # MOVE CATEGORY DESCRIPTION TO FANCY HEADER
  cat_desc = $('.tax-product_cat .term-description')
  if cat_desc.length
    $('.tax-product_cat h1.entry-title').after('<h3>' + cat_desc.html() + '</h3>')

  # TWEAK FOR SEARCH RESULT PAGE
  $('.search-results .heading-text h1.entry-title').each ->
    $(this).data 'orig-text', $(this).text()
    searchTitle = $(this).text().split(/:\s/)
    $(this).text(searchTitle[0]).append $('<h3>For the keyword <em>' + searchTitle[1] + '</em></h3>')

  # BETTER FORM
  $('.form-group input, .form-group textarea').each ->
    $input = $(this)
    $input.focus ->
      $input.closest('.form-group').addClass 'focus'

    $input.blur ->
      $input.closest('.form-group').removeClass 'focus'

  $('.wpcf7-form-control-wrap input').each ->
    $(this).parent().before(this)

  # $('a[href^="#"]').on 'click', (e) ->
  #   e.preventDefault()
  #   target = @hash
  #   $target = $(target)
  #   $('html, body').stop().animate { 'scrollTop': $target.offset().top }, 500, 'swing', ->
  #     window.location.hash = target

# @codekit-append "cdnasyid-colorthief.coffee"
# @ codekit-append "cdnasyid-niceform.coffee"
