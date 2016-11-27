# @codekit-prepend "../../bower_components/tinycolor/dist/tinycolor-min.js"
# @codekit-prepend "../../bower_components/color-thief/dist/color-thief.min.js"
# @codekit-prepend "../../bower_components/matchHeight/dist/jquery.matchHeight-min.js"
# @--- codekit-prepend "../../bower_components/jquery.longShadow/jquery.longShadow.js"
# @--- codekit-prepend "../../js/kkcountdown.js"

$ = jQuery

class CDNS
  @dev: false
  @window: $(window)
  @body: $('body')

  @log: ->
    if CDNS.dev
      console.log.apply(console, arguments)

  @isMobile: ->
    /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)


class CDNS.GA
  constructor: ->
    ((i, s, o, g, r, a, m) ->
      i['GoogleAnalyticsObject'] = r
      i[r] = i[r] or ->
        (i[r].q = i[r].q or []).push arguments
        return

      i[r].l = 1 * new Date
      a = s.createElement(o)
      m = s.getElementsByTagName(o)[0]
      a.async = 1
      a.src = g
      m.parentNode.insertBefore a, m
      return
    ) window, document, 'script', '//www.cdnasyid.com/analytics.js', 'ga'
    ga 'create', 'UA-73609258-1', 'auto'
    ga 'send', 'pageview'


class CDNS.Search
  constructor: ->
    $(document).on 'keypress.cdns.search', (e) =>
      @keypress e

    $(document).on 'keyup.cdns.search', (e) =>
      # Dismiss overlay on ESC is pressed
      if @isSearchOpen() and e.keyCode == 27
        SWIFT.header.fsSearchToggle()

  isSearchOpen: ->
    CDNS.body.hasClass('fs-search-open')

  keypress: (e) ->
    e = e or event
    nodeName = e.target.nodeName

    if nodeName == 'INPUT' or nodeName == 'TEXTAREA'
      return

    console.log e.which

    # if e.which != 0 and e.charCode != 0 and !e.ctrlKey and !e.metaKey and !e.altKey and e.keyCode != 27 and e.keyCode != 32
    if e.which == 115
      if CDNS.body.hasClass('overlay-menu-open')
        SWIFT.header.overlayMenuToggle()
      if CDNS.body.hasClass('fs-supersearch-open')
        SWIFT.header.fsSuperSearchToggle()

      SWIFT.header.fsSearchToggle()

      $('#fs-search-input').focus() ##.val(String.fromCharCode(e.keyCode | e.charCode))


class CDNS.Forms
  constructor: ->
    @select2()
    @formGroups()

  select2: ->
    # SELECT2
    # if page SHOP or CART
    if ( $().select2 )
      $('select.orderby').select2 { minimumResultsForSearch: Infinity }
      $('.shipping-calculator-form select').select2()
      $('.woocommerce .widget select').select2()

  formGroups: ->
    # BETTER FORM
    $('.form-group input, .form-group textarea').each ->
      $input = $(this)
      $input.focus ->
        $input.closest('.form-group').addClass 'focus'

      $input.blur ->
        $input.closest('.form-group').removeClass 'focus'

    $('.wpcf7-form-control-wrap input').each ->
      $(this).parent().before(this)



class CDNS.Misc
  constructor: ->
    # @mouseAnimation()
    @categoryDescription()
    @searchResultTitle()
    @menuPlainText()
    @productGridArtistWidth()
    # @salesCountdown()
    @others()

  # mouseAnimation: ->
  #   # homepage mouse animation
  #   if !CDNS.isMobile()
  #     $('#home-hero').append $('<div class="mouse"><div class="mouse-icon"><span class="mouse-wheel"></span></div></div>')

  categoryDescription: ->
    # MOVE CATEGORY DESCRIPTION TO FANCY HEADER
    cat_desc = $('.tax-product_cat .term-description')
    if cat_desc.length
      $('.tax-product_cat h1.entry-title').after('<h3>' + cat_desc.html() + '</h3>')

  searchResultTitle: ->
    # TWEAK FOR SEARCH RESULT PAGE
    $('.search-results .heading-text h1.entry-title').each ->
      $(this).data 'orig-text', $(this).text()
      searchTitle = $(this).text().split(/:\s/)
      $(this).text(searchTitle[0]).append $('<h3>For the keyword <em>' + searchTitle[1] + '</em></h3>')

  menuPlainText: ->
    # MENU PLAIN TEXT
    $('.menu .non-link a').each ->
      $(this).closest('li').html($(this).html())

  productGridArtistWidth: ->
    _fn = ->
      $('.woocommerce .products .product').each ->
        product_by = $(this).find('.product-by')
        product_by_by = product_by.find('.product-by-by')
        product_by_artist = product_by.find('.product-by-artist')
        if product_by.length
          product_by_width = product_by.outerWidth()
          product_by_by_width = product_by_by.outerWidth()
          product_by_artist_width = product_by_width - product_by_by_width - 2

          product_by_artist.css { 'max-width': product_by_artist_width + 'px' }

    _fn()
    CDNS.window.smartresize _fn

  # salesCountdown: ->
  #   $(".kkcountdown").kkcountdown()

  others: ->
    # Match Height
    $('#home-latest .spb-column-container').matchHeight()

    # TWEAK FOR SHOP ACTION BUTTONS
    $('figure .cart-overlay .shop-actions > *').addClass('shop-action')

    # LONG SHADOW
    # $('.footer-social-1, .footer-social-2').longShadow {
    #   colorShadow: '#211537'
    #   sizeShadow: 400
    #   directionShadow: 'bottom-right'
    # }

    # TILAWAH MORE LINK
    $('#home-tilawah .woocommerce.product_list_widget').before('<div class="more-link"><a href="/product-category/tilawah">View all</a></div>')


jQuery ($) ->
  new CDNS.Search
  new CDNS.Forms
  new CDNS.Misc


# @codekit-append "cdnasyid-overrides.coffee"
# @codekit-append "cdnasyid-colorthief.coffee"


# @xxxcodekit-append "cdnasyid-niceform.coffee"
