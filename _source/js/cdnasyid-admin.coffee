jQuery ($) ->
  $('#wpbody-content').find('.updated, .error').each ->
    content = $(this).html()

    if content.indexOf('WooThemes plugins') > -1
      $(this).hide()

    if content.indexOf('WooCommerce Yoast SEO') > -1
      $(this).hide()
