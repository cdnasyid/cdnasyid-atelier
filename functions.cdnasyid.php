<?php


function cdns_uri($relative_uri = "") {
  return get_stylesheet_directory_uri() . $relative_uri;
}

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
  $attribute_names = array( 'pa_artist', 'pa_label', 'pa_book-author', 'pa_publisher' ); // Insert attribute names here
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


add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
