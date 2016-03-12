<?php

function cdns_widget_title($title) {
  if ( is_admin() ) return $title;

  return do_shortcode(htmlspecialchars_decode($title));
}
add_filter('widget_title',  'cdns_widget_title');


function cdns_the_title($title, $id = null) {
  if ( is_admin() ) return $title;

  $post_type = get_post_type($id);
  if ('product' == $post_type) {
    $title = preg_replace('/\s+/', ' ', $title);

    if (preg_match('/—|&#8211;|–/', $title)) {
    // if (strpos($title, '&#8211;') !== false) {
      list($artist, $product) = preg_split('/\s+(—|&#8211;|–)\s+/', $title);
      return '<span class="product-title">' . $product . '</span> <small class="product-by"><span class="product-by-by">by </span><strong class="product-by-artist">' . $artist . '</strong></small>';
    }
  }

  return $title;
}
add_filter( 'the_title', 'cdns_the_title', 99999, 2 );



// PRODUCT SINGLES

// function cdns_single_divider() {
//   echo '<hr class="divider">';
// }
// add_action( 'woocommerce_single_product_summary', 'cdns_single_divider', 35 );

add_filter( 'wc_product_enable_dimensions_display', '__return_false' );


function wc_custom_shop_archive_title( $title ) {
  if ( is_shop() ) {
    return str_replace( 'Products Archive', 'Shop', $title );
  }

  return $title;
}
add_filter( 'wp_title', 'wc_custom_shop_archive_title', 99999 );

function sf_woo_breadcrumb_opts() {
  return array(
    'delimiter'   => '<span class="seperator"> / </span>',
    'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
    'wrap_after'  => '</nav>',
    'before'      => '',
    'after'       => '',
    'home'        => _x( 'Home', 'breadcrumb', 'swiftframework' )
  );
}
add_filter ( 'woocommerce_breadcrumb_defaults' , 'sf_woo_breadcrumb_opts' );


function sf_product_short() {
  global $post;
  $product_short_description = sf_get_post_meta( $post->ID, 'sf_product_short_description', true );
  if ( $product_short_description == "" ) {
    $product_short_description = $post->post_excerpt;
  }
  if ( substr( $product_short_description, 0, 4 ) === '[spb' ) {
    $product_short_description = "";
  }

  if ( $product_short_description != "" ) {
    ?>
    <div class="product-short" class="entry-summary">
      <div class="product-short-title"><h3>Tracklist</h3></div>
      <?php echo do_shortcode( sf_add_formatting( $product_short_description ) ); ?>
    </div>
  <?php
  }
}
add_action( 'woocommerce_single_product_summary', 'sf_product_short', 20 );


function cdns_single_brand() {
  echo '<div class="brands clearfix">';
  echo do_shortcode('[product_brand width="100px"]');
  echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'cdns_single_brand', 37 );
remove_action( 'woocommerce_product_meta_end', array( $WC_Brands, 'show_brand' ) );


function cdns_single_whatsapp() {
  echo '<div class="whatsapp-note">';
  echo '<span><i class="fa fa-whatsapp"></i>&nbsp;&nbsp;Order via WhatsApp at <strong>+6011&nbsp;2928&nbsp;4078</strong></span>';
  echo '</div>';
}
add_action( 'woocommerce_single_product_summary', 'cdns_single_whatsapp', 32 );


function cdns_show_attribute_links() {
  global $post;
  $attribute_names = array( 'pa_artist', 'pa_producer', 'pa_book-author', 'pa_book-publisher' ); // Insert attribute names here
  foreach ( $attribute_names as $attribute_name ) {
    $taxonomy = get_taxonomy( $attribute_name );
    if ( $taxonomy && ! is_wp_error( $taxonomy ) ) {
      $terms = wp_get_post_terms( $post->ID, $attribute_name );
      $terms_array = array();
      if ( ! empty( $terms ) ) {
        foreach ( $terms as $term ) {
          $archive_link = get_term_link( $term->slug, $attribute_name );
          $full_line = '<a href="' . $archive_link . '">'. $term->name . '</a>';
          array_push( $terms_array, $full_line );
        }
        echo '<span class="' . $attribute_name . '">' . $taxonomy->labels->name . ' <span>' . implode( $terms_array, ', ' ) . '</span></span>';
      }
    }
  }
}
add_action( 'woocommerce_product_meta_end', 'cdns_show_attribute_links' );


// ASSETS

// function sf_enqueue_scripts() {
//   // Variables
//
//   global $sf_options, $post;
//   $enable_rtl = $sf_options['enable_rtl'];
//   $enable_smoothscroll = $sf_options['enable_smoothscroll'];
//   $enable_min_scripts = $sf_options['enable_min_scripts'];
//   $post_type = get_query_var('post_type');
//   $product_zoom = $sf_options['enable_product_zoom'];
//   if (isset($_GET['product_zoom'])) {
//     $product_zoom = true;
//   }
//
//   // Page Content Meta
//
//   $page_has_map = false;
//   if ($post) {
//     $page_has_map = sf_get_post_meta($post->ID, 'sf_page_has_map', true);
//   }
//
//   if (is_page_template('template-directory-submit.php') || (isset($post) && get_post_type($post->ID) == 'directory')) {
//     $page_has_map = true;
//   }
//
//   // Register Scripts
//
//   wp_register_script('sf-bootstrap-js', SF_LOCAL_PATH . '/js/combine/bootstrap.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-isotope', SF_LOCAL_PATH . '/js/combine/jquery.isotope.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-imagesLoaded', SF_LOCAL_PATH . '/js/combine/imagesloaded.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-owlcarousel', SF_LOCAL_PATH . '/js/combine/owl.carousel.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-jquery-ui', SF_LOCAL_PATH . '/js/combine/jquery-ui-1.10.2.custom.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-ilightbox', SF_LOCAL_PATH . '/js/combine/ilightbox.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-maps', '//maps.google.com/maps/api/js?sensor=false', 'jquery', NULL, TRUE);
//   wp_register_script('sf-elevatezoom', SF_LOCAL_PATH . '/js/combine/jquery.elevateZoom.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-infinite-scroll', SF_LOCAL_PATH . '/js/combine/jquery.infinitescroll.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-theme-scripts', SF_LOCAL_PATH . '/js/combine/theme-scripts.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-theme-scripts-min', SF_LOCAL_PATH . '/js/sf-scripts.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('jquery-cookie', SF_LOCAL_PATH . '/js/jquery.cookie.js', 'jquery', NULL, FALSE);
//   wp_register_script('sf-functions', SF_LOCAL_PATH . '/js/functions.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-functions-min', SF_LOCAL_PATH . '/js/functions.min.js', 'jquery', NULL, TRUE);
//   wp_register_script('sf-smoothscroll', SF_LOCAL_PATH . '/js/sscr.js', '', NULL, FALSE);
//
//   // jQuery
//
//   wp_enqueue_script('jquery');
//   wp_enqueue_script('jquery-cookie');
//   if ($enable_smoothscroll) {
//     wp_enqueue_script('sf-smoothscroll');
//   }
//
//   if (!is_admin()) {
//
//     // Theme Scripts
//
//     if ($enable_min_scripts) {
//       wp_enqueue_script('sf-theme-scripts-min');
//       if ($page_has_map) {
//         wp_enqueue_script('sf-maps');
//       }
//
//       wp_enqueue_script('sf-functions-min');
//     }
//     else {
//       wp_enqueue_script('sf-bootstrap-js');
//       wp_enqueue_script('sf-jquery-ui');
//       wp_enqueue_script('sf-owlcarousel');
//       wp_enqueue_script('sf-theme-scripts');
//       wp_enqueue_script('sf-ilightbox');
//       if ($page_has_map) {
//         wp_enqueue_script('sf-maps');
//       }
//
//       wp_enqueue_script('sf-isotope');
//       wp_enqueue_script('sf-imagesLoaded');
//       wp_enqueue_script('sf-infinite-scroll');
//       if ($product_zoom) {
//         wp_enqueue_script('sf-elevatezoom');
//       }
//
//       wp_enqueue_script('sf-functions');
//     }
//   }
// }
// add_action('wp_enqueue_scripts', 'sf_enqueue_scripts', 10);



$asset_version = '1.1.0';

function cdns_stylesheets() {
  global $asset_version;

  if ( is_admin() ) return;

  echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/css/cdnasyid.css?ver=' . $asset_version . '" type="text/css" media="all">';
}
add_action('wp_head', 'cdns_stylesheets', 200);


function cdns_scripts() {
  global $asset_version;

  if ( is_admin() ) return;

  // select2
  if ( !is_checkout() ) {
    wp_enqueue_style('select2-style', get_stylesheet_directory_uri() . '/js/select2/css/select2.min.css');
    wp_register_script('select2-script', get_stylesheet_directory_uri() . '/js/select2/js/select2.min.js', array(), $asset_version, true);
    wp_enqueue_script('select2-script');
  }

  // tinycolor
  wp_register_script('tinycolor-script', get_stylesheet_directory_uri() . '/js/tinycolor-min.js', array(), $asset_version, true);
  wp_enqueue_script('tinycolor-script');

  // color-thief
  wp_register_script('color-thief-script', get_stylesheet_directory_uri() . '/js/color-thief.min.js', array(), $asset_version, true);
  wp_enqueue_script('color-thief-script');

  // succint
  wp_register_script('succinct-script', get_stylesheet_directory_uri() . '/js/jquery.succinct.min.js', array(), $asset_version, true);
  wp_enqueue_script('succinct-script');

  // match height
  wp_register_script('matchheight-script', get_stylesheet_directory_uri() . '/js/jquery.matchHeight-min.js', array(), $asset_version, true);
  wp_enqueue_script('matchheight-script');

  wp_register_script('cdnasyid', get_stylesheet_directory_uri() . '/js/cdnasyid.js', array(), $asset_version, true);
  wp_enqueue_script('cdnasyid');
}
add_action( 'wp_enqueue_scripts', 'cdns_scripts', 999 );


function cdns_sale_saving_badge($string, $post, $product) {
  $percent = round(100 - (100 * $product->get_sale_price() / $product->get_regular_price()));
  return '<span class="onsale">Save ' . $percent . '%</span>';
}
add_filter('woocommerce_sale_flash', 'cdns_sale_saving_badge', 10, 3);


function cdns_social_share($atts = null) {
  extract(shortcode_atts(array(
    "center" => '',
  ), $atts));

  global $post;
  $image = wp_get_attachment_url(get_post_thumbnail_id());
  $page_permalink = urlencode(get_the_permalink());
  $page_title = wp_strip_all_tags(get_the_title(), true);
  $page_thumb_id = get_post_thumbnail_id();
  $page_thumb_url = wp_get_attachment_url($page_thumb_id);
  $share_output = "";

  if ($center == "yes") {
    $share_output .= '<div class="sf-share-counts center-share-counts">';
  } else {
    $share_output .= '<div class="sf-share-counts">';
    $share_output .= '<h3 class="share-text">'.__("Share", 'swift-framework-plugin').
    '</h3>';

    $share_output .= '<a href="https://www.facebook.com/sharer/sharer.php?u='.$page_permalink.
    '" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=440,width=660\');return false;" class="sf-share-link sf-share-fb"><i class="fa-facebook"></i><span class="count">0</span></a>';

    $share_output .= '<a href="http://twitter.com/share?text='.$page_title.
    '&url='.$page_permalink.
    '" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=440,width=660\');return false;" class="sf-share-link sf-share-twit"><i class="fa-twitter"></i><span class="count">0</span></a>';

    $share_output .= '<a href="http://pinterest.com/pin/create/button/?url='.$page_permalink.
    '&media='.$page_thumb_url.
    '&description='.$page_title.
    '" onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=690,width=750\');return false;" class="sf-share-link sf-share-pin"><i class="fa-pinterest"></i><span class="count">0</span></a>';
    $share_output .= '</div>';
  }
  return $share_output;
}

add_shortcode('sf_social_share', 'cdns_social_share');


function add_fb_sdk() {
  if ( is_admin() ) return;

  echo '<div id="fb-root"></div><script>!function(e,n,t){var o,c=e.getElementsByTagName(n)[0];e.getElementById(t)||(o=e.createElement(n),o.id=t,o.src="//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1109004049131487",c.parentNode.insertBefore(o,c))}(document,"script","facebook-jssdk");</script>';
}
add_action('sf_before_page_container', 'add_fb_sdk');



// function cdns_before_page_container() {
//   echo '<div id="as-root"></div><script>(function(e,t,n){var r,i=e.getElementsByTagName(t)[0];if(e.getElementById(n))return;r=e.createElement(t);r.id=n;r.src="//button.aftership.com/all.js";i.parentNode.insertBefore(r,i)})(document,"script","aftership-jssdk")</script>';
// }
// add_action('sf_before_page_container', 'cdns_before_page_container');


// function cdns_order_button_html($html) {
//   return str_replace('class="button alt"', 'class="sf-button standard accent"', $html);
// }
// add_filter('woocommerce_order_button_html', 'cdns_order_button_html', 10, 3);

add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
