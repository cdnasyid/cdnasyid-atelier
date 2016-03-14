# @codekit-prepend "cdnasyid-overrides.coffee"

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

  $('figure .cart-overlay .shop-actions > *').addClass('shop-action')

  # # SHORTEN ARTIST NAMES
  # $('.product-details small strong').succinct { size: 25 }

  # PRODUCT THUMNAIL COVER CENTER
  # do ->
  #   figure = $('.products .product .product-transition-fade')
  #   figure_width = figure.innerWidth()
  #   figure_height = figure.innerHeight()
  #
  #   figure.find('.img-wrap').each ->
  #     wrap_width = $(this).innerWidth()
  #     wrap_height = $(this).innerHeight()
  #
  #     console.log figure_width, wrap_width, figure_height, wrap_height
  #
  #     if wrap_width < figure_width
  #       scale = figure_width / wrap_width
  #       $(this).css {
  #         'transform': "scale(#{scale})"
  #         'transform-origin': 'top'
  #       }
  #
  #     else if wrap_height < figure_height
  #       scale = figure_height / wrap_height
  #       $(this).css {
  #         'transform': "scale(#{scale})"
  #         'transform-origin': 'top'
  #       }


  setProductArtistMaxWidth = ->
    $('.woocommerce .products .product').each ->
      product_by = $(this).find('.product-by')
      product_by_by = product_by.find('.product-by-by')
      product_by_artist = product_by.find('.product-by-artist')
      if product_by.length
        product_by_width = product_by.outerWidth()
        product_by_by_width = product_by_by.outerWidth()
        product_by_artist_width = product_by_width - product_by_by_width - 2

        product_by_artist.css { 'max-width': product_by_artist_width + 'px' }

  setProductArtistMaxWidth()
  $(window).smartresize setProductArtistMaxWidth


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

  # Menu plain text
  $('.menu .non-link a').each ->
    $(this).closest('li').html($(this).html())

  # $('a[href^="#"]').on 'click', (e) ->
  #   e.preventDefault()
  #   target = @hash
  #   $target = $(target)
  #   $('html, body').stop().animate { 'scrollTop': $target.offset().top }, 500, 'swing', ->
  #     window.location.hash = target

# @codekit-append "cdnasyid-colorthief.coffee"
# @ codekit-append "cdnasyid-niceform.coffee"
