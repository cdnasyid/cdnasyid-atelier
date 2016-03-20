CDNS = {
  dev: false
  log: ->
    if CDNS.dev
      console.log.apply(console, arguments)
}

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

  # TWEAK FOR SHOP ACTION BUTTONS
  $('figure .cart-overlay .shop-actions > *').addClass('shop-action')

  # SET MAX WIDTH OF ARTISTNAME
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

  # MENU PLAIN TEXT
  $('.menu .non-link a').each ->
    $(this).closest('li').html($(this).html())

  # TILAWAH MORE LINK
  $('#home-tilawah .woocommerce.product_list_widget').before('<div class="more-link"><a href="/product-category/tilawah">View all</a></div>')

  # LONG SHADOW
  $('.footer-social-1, .footer-social-2').longShadow {
    colorShadow: '#211537'
    sizeShadow: 400
    directionShadow: 'bottom-right'
  }
  # $('.footer-social-2').longShadow {
  #   colorShadow: '#703313'
  #   sizeShadow: 400
  #   directionShadow: 'bottom-right'
  # }

# @codekit-append "cdnasyid-overrides.coffee"
# @codekit-append "cdnasyid-colorthief.coffee"
# @xxxcodekit-append "cdnasyid-niceform.coffee"
