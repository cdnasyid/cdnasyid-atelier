(($) ->

  # WIDGET COLORING
  widget_colors = ['accent', 'turquoise', 'green', 'blue']
  $('.woocommerce .widget').each (index) ->
    $this = $(this)
    $this.addClass('cdnclr-' + widget_colors[index % 4])

  isRTL = $('body').hasClass('rtl')
  $window = $(window)

  # SWIFT.woocommerce._fullWidthShop = SWIFT.woocommerce.fullWidthShop
  # SWIFT.woocommerce.fullWidthShop = ->
  #   shopItems = jQuery('.full-width-shop').find('.products')
  #   itemWidth = shopItems.find('li.product').first().data('width')
  #   shopSidebar = shopItems.find('.sidebar')
  #   if shopSidebar.length > 0
  #     # Full Width Shop Sidebar
  #     SWIFT.woocommerce.fullWidthShopSetSidebarHeight()
  #     $window.smartresize ->
  #       SWIFT.woocommerce.fullWidthShopSetSidebarHeight()
  #       return
  #     shopItems.isotope
  #       itemSelector: '.product'
  #       layoutMode: 'fitRows'
  #       masonry: columnWidth: '.' + itemWidth
  #       isOriginLeft: !isRTL
  #     SWIFT.woocommerce.animateItems shopItems
  #     shopSidebar.stop().animate { 'opacity': 1 }, 500
  #     shopItems.isotope 'stamp', shopSidebar
  #     shopItems.isotope 'layout'
  #     setTimeout (->
  #       shopItems.isotope 'layout'
  #       return
  #     ), 500
  #   else
  #     shopItems.isotope
  #       itemSelector: '.product'
  #       layoutMode: 'fitRows'
  #       isOriginLeft: !isRTL
  #     setTimeout (->
  #       shopItems.isotope 'layout'
  #       return
  #     ), 500
  #     SWIFT.woocommerce.animateItems shopItems
  #   return
  #
  # SWIFT.woocommerce._fullWidthShopSetSidebarHeight = SWIFT.woocommerce.fullWidthShopSetSidebarHeight
  # SWIFT.woocommerce.fullWidthShopSetSidebarHeight = ->
  #   shopItems = jQuery('.full-width-shop').find('.products')
  #   shopSidebar = shopItems.find('div.sidebar')
  #   defaultSidebarHeight = shopSidebar.css('height', '').outerHeight()
  #   newSidebarHeight = 0
  #   sidebarHeightMultiply = 2
  #   columns = 4
  #
  #   productWidth = shopItems.find('li.product').first().data('width')
  #
  #   if productWidth == 'col-sm-3'
  #     columns = 4
  #   else if productWidth == 'col-sm-sf-5'
  #     columns = 5
  #   else if productWidth == 'col-sm-4'
  #     columns = 3
  #   else if productWidth == 'col-sm-6'
  #     columns = 2
  #   else if productWidth == 'col-sm-2'
  #     columns = 6
  #   else if productWidth == 'col-sm-12'
  #     columns = 1
  #
  #   for index in [0..100] by columns
  #     newSidebarHeight += shopItems.find('li.product').eq(index).outerHeight(true)
  #     if newSidebarHeight > defaultSidebarHeight
  #       break
  #
  #   shopSidebar.css 'height', newSidebarHeight

  SWIFT.woocommerce._shopLayoutSwitch = SWIFT.woocommerce.shopLayoutSwitch
  SWIFT.woocommerce.shopLayoutSwitch = ->
    isSwitchingLayout = false

    jQuery(document).on 'click', 'a.layout-opt', (e) ->
      products = jQuery('#products')
      selectedLayout = jQuery(this).data('layout')
      defaultWidth = products.find('.product').first().data('width')
      gridWidth = if jQuery('.inner-page-wrap').hasClass('has-no-sidebar') then 'col-sm-sf-5' else 'col-sm-3'

      if jQuery(this).parent().data('display-type') == 'gallery' or jQuery(this).parent().data('display-type') == 'gallery-bordered'
        gridWidth = 'col-sm-2'

      if isSwitchingLayout
        return

      isSwitchingLayout = true

      products.animate { 'opacity': 0 }, 400

      setTimeout (->
        products.find('.product').removeClass 'product-layout-standard product-layout-list product-layout-grid product-layout-solo'
        products.find('.product').addClass 'product-layout-' + selectedLayout

        if jQuery('.product-grid').length > 0
          jQuery('.product-grid').children().css 'min-height', '0'

          if selectedLayout == 'grid'
            products.find('.product').removeClass(defaultWidth).addClass gridWidth
            products.find('.product').css 'min-height', '0'

          if selectedLayout == 'standard' or selectedLayout == 'solo'
            products.find('.product').removeClass(gridWidth).addClass defaultWidth

          if selectedLayout == 'list'
            products.find('.product').css 'height', 'auto'

          if selectedLayout != 'list' and selectedLayout != 'solo'
            # jQuery('.product-grid').equalHeights()
            jQuery('.product-grid').children().matchHeight {
              target: jQuery('.product-grid').children().first()
            }

        products.isotope 'layout'
        products.animate { 'opacity': 1 }, 400

        isSwitchingLayout = false
      ), 500

      e.preventDefault()
) jQuery
