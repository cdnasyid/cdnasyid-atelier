jQuery ($) ->
  tinycolor::isHalfDark = ->
    this.getBrightness() < 192

  tinycolor::isHalfLight = ->
    !this.isHalfDark()

  # COLOR THIEF
  sortLightToDark = (colors) ->
    colors.sort((a, b) ->
      a.getLuminance() > b.getLuminance()
    ).reverse()

  getDarkest = (palette) ->
    sorted = sortLightToDark(palette)
    sorted.pop()

  getLightest = (palette) ->
    sortLightToDark(palette)[0]

  getFirstDark = (colors) ->
    darkColor = null
    $.each colors, (index, color) ->
      if color.isDark()
        darkColor = color
        return false
    if (darkColor == null)
      darkColor = getDarkest(colors)
    darkColor

  getFirstLight = (colors) ->
    lightColor = null
    $.each colors, (index, color) ->
      if color.isLight()
        lightColor = color
        return false
    if (lightColor == null)
      lightColor = getLightest(colors)
    lightColor

  getPalette = (img, num) ->
    img.crossOrigin = "anonymous"
    colorThief = new ColorThief()
    colors = colorThief.getPalette(img, num)
    if colors != null
      return colors.map((rgb) -> tinycolor({ r: rgb[0], g: rgb[1], b: rgb[2] }))

    false

  getDarkColor = (palette) ->
    color = palette[0]
    if color.isLight()
      color = getFirstDark(palette)
    color

  getLightColor = (palette) ->
    color = palette[0]
    if color.isDark()
      color = getFirstLight(palette)
    color

  productGrid = ->
    $('#home-tilawah .products .product').addClass('dark')

    $('.woocommerce .products .product').each ->

      $this = $(this)

      is_dark = $this.hasClass('dark')

      img = $this.find('.first-image img')[0]
      if ( !img? ) then return

      $(img).imagesLoaded ->

        details = $this.find('.product-details')
        link_title = $this.find('.product-details h3 a')
        artist = $this.find('.product-details h3 a small strong')

        if ( palette = getPalette(img, 4) )
          colorfulBar = '<div class="colorful-bar clearfix">'
          palette.forEach (color) ->
            colorfulBar += '<div class="col-xs-3" style="background: ' + tinycolor(color).toRgbString() + '"></div>'
          colorfulBar += '</div>'
          details.before colorfulBar

          if ( !is_dark )
            color = getDarkColor(palette)
          else
            color = getLightColor(palette)

          details.css { 'color': color.toRgbString() }
          artist.css { 'border-color': color.setAlpha(.5).toRgbString() }

  productGrid()

  productSingle = ->
    $('.woocommerce.single-product').each ->

      $this = $(this).addClass('product-fw-split')
      img = $this.find('#product-img-slider img:first')[0]

      if ( !img? ) then return

      $(img).imagesLoaded ->

        product_main = $('.product-fw-split .product-main')
        summary = $this.find('.summary')
        product_title = $this.find('h1.product_title')
        product_by = product_title.find('small strong')
        breadcrumb = $this.find('.woocommerce-breadcrumb')

        if ( palette = getPalette(img, 4) )
          colorfulBar = '<div class="colorful-bar clearfix">'
          palette.forEach (color) ->
            colorfulBar += '<div class="col-xs-3" style="background: ' + tinycolor(color).toRgbString() + '"></div>'
          colorfulBar += '</div>'
          summary.prepend colorfulBar

          color = getDarkColor(palette)
          product_main.css {
            'cssText':
              'background-color: ' + palette[0].toRgbString() + ' !important; '
              # + 'background-image: linear-gradient(to right, ' + palette[0].toRgbString() + ', ' + palette[3].toRgbString() + ') !important;'
          }
          summary.css { 'color': color.toRgbString() }
          product_title.css { 'color': color.toRgbString() }
          summary.find('.nav-previous, .nav-next').css { 'border-color': color.lighten(40).toRgbString() }

          summary.addClass 'colored'

  productSingle()
